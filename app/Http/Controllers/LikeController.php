<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use Illuminate\Support\Facades\Auth;
use App\Post;

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

    public function postLike(Post $post) {
        $post->users()->attach(Auth::id());
        return redirect(route('post.show',['post_id' => $post->id]));
    } 

    public function postUnlike(Post $post) {
        $post->users()->detach(Auth::id());
        return redirect(route('post.show',['post_id' => $post->id]));
    }
}
