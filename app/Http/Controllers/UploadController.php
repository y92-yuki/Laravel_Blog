<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image as Upload;
use Illuminate\Support\Facades\Auth;
use App\Post;
use Illuminate\Support\Facades\Storage;
use App\Services\RegisterImage;
use Illuminate\Support\Facades\DB;

class UploadController extends Controller
{
    public function store(Request $request) {    
        $post_id = $request->post_id;

        try {
            DB::beginTransaction();

            //ファイルを選択せずにアップロードボタンを選択した場合は元の投稿詳細画面へリダイレクト
            if ($request->file) {
                $file_name = $request->file->getClientOriginalName();
                
                //画像を保存するためのパスを作成
                $registerImage = new RegisterImage($file_name, Auth::id());

                //画像を保存するためのフォルダが存在するか判定
                if (!Storage::disk('public')->exists(Auth::id())) {
                    Storage::disk('public')->makeDirectory(Auth::id());
                }

                //カラムに画像の情報を保存
                Upload::create([
                    'post_id' => $post_id,
                    'user_id' => Auth::id(),
                    'path' => $registerImage->getPath()
                ]);
                //画像をフォルダに保存
                $registerImage->resizeRegisterImage($request->file, 600);

                session()->flash('success_message','画像の添付が完了しました');

                DB::commit();
            } else {
                session()->flash('error_message','画像ファイルを選択してください');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error_message','画像の添付に失敗しました');
        }            
            return redirect(route('post.show',compact('post_id')));
    }

    public function delete(Post $post, Request $request) {
        try {
            DB::beginTransaction();

            $post_id = $post->id;
            $image = Upload::find($request->image_id);
            $remove_image = $post->user_id . '/' . $image->path;
            $image->delete();
            Storage::disk('public')->delete($remove_image);
            session()->flash('success_message','画像の削除が完了しました');

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error_message','画像の削除に失敗しました');
        }
        
        return redirect(route('post.show',compact('post_id')));
    }
}
