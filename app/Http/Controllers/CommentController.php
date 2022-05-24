<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class CommentController extends Controller
{
    //コメント投稿
    public function addComment(Request $request) {
        try {
            $comment = new Comment;
            $form = $request->all();
            $comment->fill($form)->save();

            return  view('components.comments',compact('comment'));
        } catch (\Exception $e) {

        }
    }

    //コメント削除画面
    public function delete(Comment $comment) {
        if ($comment->user_id == Auth::id() || $comment->post->user_id == Auth::id()) {
            return view('comment.delete',['comment' => $comment]);
        } else {
            return redirect('/post');
        }
        
    }

    //コメント削除実行
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
