<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Comment;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Console\Presets\React;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostRequest;

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

    public function add(React $request) {
        return view('post.add',['user_id' => Auth::id()]);
    }

    public function create(PostRequest $request) {
        $post = new Post;
        $form = $request->all();
        unset($form['_token']);
        $post->fill($form)->save();
        return redirect('/post');
    }

    public function show(Request $request) {
        $post = Post::find($request->post_id);
        return view('post.show',['post' => $post]);
    }

    public function edit(Request $request) {
        $post = Post::find($request->post_id);
        return view('post.edit',['post' => $post]);
    }

    public function update(PostRequest $request) {
        $post = Post::find($request->id);
        $post->title = $request->title;
        $post->message = $request->message;
        $post->save();
        return redirect('/post');
    }

    public function delete(Request $request) {
        $post = Post::find($request->post_id);
        return view('post.delete',['post' => $post]);
    }

    public function remove(Request $request) {
        $post = Post::find($request->id);
        $comments = Comment::where('post_id',$post->id)->get();
        foreach ($comments as $comment) {
            $comment->likes()->detach();
        }
        $post->users()->detach();
        $post->delete();
        return redirect('/post');
    }
}
