<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use Illuminate\Support\Facades\Auth;
use App\Post;

class LikeController extends Controller
{
    public function like(Request $request) {
        $comment = Comment::find($request->comment_id);
        $comment->likes()->attach(Auth::id());
    }

    public function unlike(Request $request) {
        $comment = Comment::find($request->comment_id);
        $comment->likes()->detach(Auth::id());
    }

    public function postLike(Request $request) {
        $post = Post::find($request->post_id);
        $post->users()->attach(Auth::id());
    } 

    public function postUnlike(Request $request) {
        $post = Post::find($request->post_id);
        $post->users()->detach(Auth::id());
    }
}
