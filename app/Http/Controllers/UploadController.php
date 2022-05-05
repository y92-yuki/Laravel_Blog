<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image as Upload;
use Illuminate\Support\Facades\Auth;
use Image;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function store(Request $request) {    
        
        //ファイルを選択せずにアップロードボタンを選択した場合は元の投稿詳細画面へリダイレクト
        if (empty($request->file)) {
            $post_id = $request->post_id;
            return redirect(route('post.show',compact('post_id')));
        } else {

            // リサイズ関連の処理をservice化してメソッドを呼び出す

            //画像をRe sizeして保存
            $post_id = $request->post_id;
            $path = $request->file->getClientOriginalName();
            $save_path = storage_path() . '/app/public/' . $path;
            $image = Image::make($request->file);

            $image->resize(600,null,function($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
                }
            );
            $image->save($save_path);

            Upload::create(['post_id' => $post_id,'user_id' => Auth::id(),'path' => $path]);
            return redirect(route('post.show',compact('post_id')));
        }
    }

    public function remove(Request $request) {
        $post_id = $request->post_id;
        $image = Upload::find($request->image_id);
        $remove_image = 'public/' . $image->path;
        // Storage::disk('local')->makeDirectory('public/1');
        Storage::makeDirectory('public/1');
        // Storage::delete($remove_image);
        // $image->delete();
        return redirect(route('post.show',compact('post_id')));
    }
}
