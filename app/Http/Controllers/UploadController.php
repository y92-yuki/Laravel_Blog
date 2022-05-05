<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image as Upload;
use Illuminate\Support\Facades\Auth;
use Image;
use App\Post;
use Illuminate\Support\Facades\Storage;
use App\Services\RegisterImage;
use Illuminate\Support\Facades\DB;

class UploadController extends Controller
{
    public function store(Request $request) {    
    
        //ファイルを選択せずにアップロードボタンを選択した場合は元の投稿詳細画面へリダイレクト

        $post_id = $request->post_id;

        try {
            DB::beginTransaction();

            if ($request->file) {
                $path = time() . '_' . mt_rand() . '_' . $request->file->getClientOriginalName();
                $save_path = storage_path('app/public/' . Auth::id() . '/' . $path);
                if (!Storage::disk('public')->exists(Auth::id())) {
                    Storage::disk('public')->makeDirectory(Auth::id());
                }
                Upload::create(['post_id' => $post_id, 'user_id' => Auth::id(), 'path' => $path]);

                RegisterImage::resizeRegisterImage($request->file, 600, $save_path);

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
            session()->flash('success_message','投稿が完了しました');

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error_message','投稿に失敗しました');
        }
        
        return redirect(route('post.show',compact('post_id')));
    }
}
