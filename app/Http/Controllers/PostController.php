<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Comment;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Console\Presets\React;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostRequest;
use App\Image as Upload;
use Image;

class PostController extends Controller
{
    public function index(Request $request) {
        if (empty($request->search_value)) {
            $posts = Post::orderBy('id','desc')->paginate(5);
            return view('post.index',['posts' => $posts]);
        } else {
            $search = "%".$request->search_value."%";
            $posts = Post::where('title','like',$search)->orWhere('message','like',$search)->orderBy('id','desc')->paginate(5);
            $param = ['posts' => $posts,'search' => $search];
            return view('post.index',$param);
        }
    }

    // create
    public function add(Request $request) {
        return view('post.add',['user_id' => Auth::id()]);
    }

    // store register
    public function create(PostRequest $request) {
        $post = new Post;
        // $form = $request->all();
        // $post_data = $request->only(['hoge', 'hoge']);
        $post_data = $request->except(['_token']);
        // unset($form['_token']);
        $post->fill($post_data)->save();

        if ($request->file) {
            // unset($form['_token'],$form['file']);
            // $post->fill($form)->save();
            
            $path = $request->file('file')->getClientOriginalName();
            $save_path = storage_path() . '/app/public/' .$path;
            $image = Image::make($request->file);
            $image->resize(600,null,function($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $image->save($save_path);
            Upload::create(['post_id' => $post->id, 'user_id' => Auth::id(), 'path' => $path]);
        }


        return redirect('/post');
    }

    public function show(Request $request) {
        $post = Post::find($request->post_id);
        return view('post.show',['post' => $post]);
    }

    public function edit(Post $post) {
        if ($post->user_id == Auth::id()) {
            return view('post.edit',['post' => $post]);
        } else {
            return redirect('/post');
        }
    }

    public function update(PostRequest $request) {
        $post = Post::find($request->id);
        $post->title = $request->title;
        $post->message = $request->message;
        $post->save();
        return redirect('/post');
    }

    // deleteConfirm
    public function delete(Post $post, Request $request) {
        if ($post->user_id == Auth::id()) {
            return view('post.delete',['post' => $post]);
        } else {
            return redirect('/post');
        }
    }

    // delete
    public function remove(Request $request) {
        $post = Post::find($request->id);
        $comments = Comment::where('post_id',$post->id)->get();

        // transaction
        // transaction start

        // transaction commit

        // transaction rollback

        foreach ($comments as $comment) {
            $comment->likes()->detach();
        }
        $post->users()->detach();
        $post->delete();


        return redirect('/post');
    }
}
