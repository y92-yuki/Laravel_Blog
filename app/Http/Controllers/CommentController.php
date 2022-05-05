<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class CommentController extends Controller
{
    public function addComment(CommentRequest $request) {
        try {
            $comment = new Comment;
            $form = $request->except('_token');
            $comment->fill($form)->save();

            session()->flash('success_message','コメントの投稿が完了しました');
        } catch (\Exception $e) {
            session()->flash('error_message','コメントの投稿に失敗しました');
        }

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

        try {
            DB::beginTransaction();

            $comment = Comment::find($request->id);
            $post_id = $comment->post_id;
            $comment->likes()->detach();
            $comment->delete();

            session()->flash('success_message','コメントの削除が完了しました');

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error_message','コメントの削除に失敗しました');
        }
        
        return redirect(route('post.show',['post_id' => $post_id]));
    }
}
