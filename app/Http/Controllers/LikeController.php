<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\Post;

class LikeController extends Controller
{
    //コメントへのいいね
    public function like(Request $request) {
        $comment = Comment::find($request->comment_id);
        $comment->likes()->attach(Auth::id());
    }

    //コメントのいいね取り消し
    public function unlike(Request $request) {
        $comment = Comment::find($request->comment_id);
        $comment->likes()->detach(Auth::id());
    }

    //投稿へのいいね
    public function postLike(Request $request) {
        $post = Post::find($request->post_id);
        $post->users()->attach(Auth::id());
    } 

    //投稿へのいいね取り消し
    public function postUnlike(Request $request) {
        $post = Post::find($request->post_id);
        $post->users()->detach(Auth::id());
    }
}
