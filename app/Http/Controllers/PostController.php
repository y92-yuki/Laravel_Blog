<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Comment;
use App\User;
use Illuminate\Foundation\Console\Presets\React;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{
    public function index(Request $request) {
        if (empty($request->search_name)) {
            $posts = Post::orderBy('id','desc')->paginate(5);
            return view('post.index',['posts' => $posts]);
        } else {
            $search = "%".$request->search_name."%";
            $user_search = User::where('name',"LIKE",$search)->first();
            $posts = Post::where('user_id',$user_search->id)->orderBy('id','desc')->paginate(5);
            return view('post.index',['posts' => $posts,'search' => $search]);
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
        $date = date('Y年m月d日 H時i分s秒',strtotime($post->created_at));
        $updated = date('Y年m月d日 H時i分s秒',strtotime($post->updated_at));
        $auth_id = Auth::id();
        $param = ['post' => $post,'date' => $date,'updated' => $updated, 'auth_id' => $auth_id];
        return view('post.show',$param);
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
        $date = date('Y年m月d日 H時i分s秒',strtotime($post->created_at));
        $updated = date('Y年m月d日 H時i分s秒',strtotime($post->updated_at));
        $param = ['post' => $post, 'date' => $date, 'updated' => $updated];
        return view('post.delete',$param);
    }

    public function remove(Request $request) {
        Post::find($request->id)->delete();
        return redirect('/post');
    }
}
