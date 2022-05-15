<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeEmailRequest;
use Illuminate\Http\Request;
use App\User;
use App\EmailReset;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ChangePasswordRequest;
use App\Mail\SendEmailReset;
use Illuminate\Support\Facades\Hash;
use App\Services\TokenCreate;
use Illuminate\Support\Facades\DB;
use Mail;
use App\Http\Requests\ChangePrefectureRequest;
use App\Prefecture;
use Carbon\Carbon;

class UserController extends Controller
{
    //ユーザーのマイページ
    public function info(Request $request) {
        $user = User::with(['posts','comments','postLikes','commentLikes','prefInfo'])->find(Auth::id());
        return view('user.myPage',compact('user'));
    }

    //ログイン中のパスワード変更画面
    public function editPassword(User $user) {
        if ($user->id == Auth::id()) {
            return view('user.editPassword',compact('user'));
        } else {
            return redirect(route('myPage'));
        }
    }

    //パスワード変更->実行
    public function updatePassword(ChangePasswordRequest $request, User $user) {
        try {
            $newPassword = Hash::make($request->newPassword);
            $user->password = $newPassword;
            $user->save();

            session()->flash('success_message','パスワードの変更が完了しました');
        } catch (\Exception $e) {
            session()->flash('error_message','パスワードの変更に失敗しました');
        }
        

        return redirect(route('myPage'));
    }


    public function editEmail(User $user) {
        if ($user->id == Auth::id()) {
            return view('user.editEmail',compact('user'));
        } else {
            return redirect(route('myPage'));
        }
    }

    public function sendChangeEmailLink(ChangeEmailRequest $request) {
        $new_email = $request->new_email;

        //メール認証用のトークンを生成
        $tokenCreate = new TokenCreate(40,$new_email);
        $token = $tokenCreate->getToken();
        
        //有効期限を生成
        $expired = new Carbon('+60 minutes');

        //トークンと変更後のemailをDBに保存して、確認メールを送信
       try {
           DB::beginTransaction();

           $param = [
               'user_id' => Auth::id(),
               'new_email' => $new_email,
               'token' => $token,
               'expired_at' => $expired
           ];

           $email_reset = new EmailReset();
           $email_reset->fill($param)->save();

           Mail::to($new_email)->send(new SendEmailReset($token));

           session()->flash('success_message','メールの送信に成功しました');

           DB::commit();
       } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error_message','メールの送信に失敗しました');
        }

       return redirect(route('myPage'));
    }

    public function reset($token) {
        //有効期限内で発行したトークンと一致するデータを検索
        $email_reset = EmailReset::where('token',$token)->where('expired_at', '>', Carbon::now())->first();

        if ($email_reset) {
            try {
                DB::beginTransaction();

                $user = User::find($email_reset->user_id);
                $user->email = $email_reset->new_email;
                $user->save();

                $email_reset->delete();

                session()->flash('success_message','メールアドレスの変更が完了しました');

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();

                session()->flash('error_message','メールアドレスの変更に失敗しました');
            }
        } else {
            session()->flash('error_message','アクセスしたURLは無効です');
        }
        return redirect(route('myPage'));
    }

    public function editPrefectures(User $user) {
        $prefs = Prefecture::all();

        if ($user->id == Auth::id()) {
            return view('user.editPrefectures',compact('prefs','user'));
        } else {
            return redirect(route('myPage'));
        }
    }

    public function updatePrefectures(ChangePrefectureRequest $request, User $user) {
        try {
            $user->prefecture_id = $request->pref;
            $user->save();
            
            session()->flash('success_message','地域の変更が完了しました');
        } catch(Exeption $e) {
            session()->flash('error_message','地域の更新に失敗しました');
        }
        return redirect(route('myPage'));
    }
}
