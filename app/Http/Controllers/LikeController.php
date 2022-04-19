<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use Illuminate\Support\Facades\Auth;
use App\Post;
use PHPUnit\Util\Json;

class LikeController extends Controller
{
    public function like(Comment $comment) {
        $comment->likes()->attach(Auth::id());
        return redirect(route('post.show',['post_id' => $comment->post->id]));
    }

    public function unlike(Comment $comment) {
        $comment->likes()->detach(Auth::id());
        return redirect(route('post.show',['post_id' => $comment->post->id]));
    }

    public function postLike(Request $request) {
        $post = Post::find($request->post_id);
        $post->users()->attach(Auth::id());
        $post_id = ['post_id' => $post->id,'user' => Auth::id()];
        // return response()->json($post_id);
    } 

    public function postUnlike(Request $request) {
        $post = Post::find($request->post_id);
        $post->users()->detach(Auth::id());
        $post_id = ['post_id' => $post->id,'user' => Auth::id()];
        // return response()->json($post_id);
    }
}
