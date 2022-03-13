<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function addComment(CommentRequest $request) {
        $comment = new Comment;
        $form = $request->all();
        unset($form['_token']);
        $comment->fill($form)->save();
        return redirect(route('post.show',['post_id' => $request->post_id]));
    }

    public function delete(Comment $comment) {
        if ($comment->user_id == Auth::id() || $comment->post->user_id == Auth::id()) {
            return view('comment.delete',['comment' => $comment]);
        } else {
            return redirect('/post');
        }
        
    }

    public function remove(Request $request) {
        $comment = Comment::find($request->id);
        $post_id = $comment->post_id;
        $comment->likes()->detach();
        $comment->delete();
        return redirect(route('post.show',['post_id' => $post_id]));
    }
}
