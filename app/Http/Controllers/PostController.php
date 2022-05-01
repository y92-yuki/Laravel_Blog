<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostRequest;
use App\Image as Upload;
use Illuminate\Support\Facades\Storage;
use App\Services\RegisterImage;
use Illuminate\Support\Facades\DB;
use App\User;

class PostController extends Controller
{
    public function index(Request $request) {
        $user = Auth::user();
        $prefecturesNum = $user->prefecturesNum;
        $pref = User::$prefs[$prefecturesNum];
        $prefOfficeLocation = User::$prefOfficeLocation[$prefecturesNum];
        $param = ['pref' => $pref,'prefofficeLocation' => $prefOfficeLocation];

        if (empty($request->search_value)) {
            $posts = Post::orderBy('id','desc')->paginate(5);
            $param += ['posts' => $posts,'search' => false];
            return view('post.index',$param);
        } else {
            $search = "%".$request->search_value."%";
            $posts = Post::where('title','like',$search)->orWhere('message','like',$search)->orderBy('id','desc')->paginate(5);
            $param += ['posts' => $posts,'search' => $search];
            return view('post.index',$param);
        }
    }

    public function create(Request $request) {
        return view('post.create',['user_id' => Auth::id()]);
    }

    public function store(PostRequest $request) {

        try {
            DB::beginTransaction();

            $post = new Post;
            $post_data = $request->except(['_token']);
            $post->fill($post_data)->save();
            
            if ($request->file) {

                $path = time() . '_' . mt_rand() . '_' . $request->file->getClientOriginalName();
                $save_path = storage_path('app/public/' . Auth::id() . '/' . $path);

                if (!Storage::disk('public')->exists(Auth::id())) {
                    Storage::disk('public')->makeDirectory(Auth::id());
                }

                Upload::create([
                    'post_id' => $post->id, 
                    'user_id' => Auth::id(), 
                    'path' => $path
                ]);

                RegisterImage::resizeRegisterImage($request->file, 600, $save_path);
            }
            session()->flash('success_message','投稿が完了しました');
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error_message','投稿に失敗しました');
        }

        return redirect('/post');
    }

    public function show(Request $request) {
        $post = Post::find($request->post_id);
        return view('post.show',compact('post'));
    }

    public function edit(Post $post) {
        if ($post->user_id == Auth::id()) {
            return view('post.edit',['post' => $post]);
        } else {
            return redirect('/post');
        }
    }

    public function update(PostRequest $request) {
        try {
            $post = Post::find($request->id);
            $post_data = $request->only('title','message');
            $post->fill($post_data)->save();

            session()->flash('success_message','投稿の編集が完了しました');
        } catch (\Exception $e) {
            session()->flash('error_message','投稿の編集に失敗しました');
        }

        return redirect('/post');
    }


    public function deleteConfirm(Post $post) {
        if ($post->user_id == Auth::id()) {
            return view('post.deleteConfirm',['post' => $post]);
        } else {
            return redirect('/post');
        }
    }


    public function delete(Request $request) {
        $post = Post::with('comment')->find($request->id);
        $images = $post->images;

        try {
            DB::beginTransaction();

            foreach ($post['comment'] as $comment) {
                $comment->likes()->detach();
            }
            $post->users()->detach();

            foreach ($images as $image) {
                $remove_image = $post->user_id . '/' . $image->path;
                $image->delete();
                Storage::disk('public')->delete($remove_image);
            }
            $post->delete();

            session()->flash('success_message','投稿の削除が完了しました');

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error_message','投稿の削除に失敗しました');
        }

        return redirect('/post');
    }
}
