<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostRequest;
use App\Models\Image as Upload;
use Illuminate\Support\Facades\Storage;
use App\Services\RegisterImage;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    //ログイン直後の投稿一覧表示
    public function index(Request $request) {
        $user = Auth::user();
        //ユーザーの居住地を取得
        $pref = $user->prefInfo->pref;
        $prefOffice = $user->prefInfo->prefOffice;
        $param = ['pref' => $pref,'prefOffice' => $prefOffice];

        //検索されていなければ全投稿を取得
        if (empty($request->search_value)) {
            $posts = Post::orderBy('id','desc')->paginate(5);
            $param += ['posts' => $posts,'search' => false];
            return view('post.index',$param);

        //検索窓で指定された値を取得
        } else {
            $search = $request->search_value;
            $posts = Post::where('title','like',"%{$search}%")->orWhere('message','like',"%{$search}%")->orderBy('id','desc')->paginate(5);
            $param += ['posts' => $posts,'search' => $search];
            return view('post.index',$param);
        }
    }

    //新規投稿画面
    public function create() {
        $user_id = Auth::id();
        return view('post.create',compact('user_id'));
    }

    public function store(PostRequest $request) {

        try {
            DB::beginTransaction();

            //投稿を保存
            $post = new Post;
            $post_data = $request->except(['_token']);
            $post->fill($post_data)->save();
            
            //投稿に画像が存在するか判定
            if ($request->file) {
                $file_name = $request->file->getClientOriginalName();
                
                //画像を保存するためのパスを作成
                $registerimage = new RegisterImage($file_name, Auth::id());

                //画像を保存するためのフォルダが存在するか判定
                if (!Storage::disk('public')->exists(Auth::id())) {
                    Storage::disk('public')->makeDirectory(Auth::id());
                }

                //カラムに画像の情報を保存
                Upload::create([
                    'post_id' => $post->id, 
                    'user_id' => Auth::id(), 
                    'path' => $registerimage->getPath()
                ]);

                //画像をフォルダに保存
                $registerimage->resizeRegisterImage($request->file, 600);
            }
            session()->flash('success_message','投稿が完了しました');
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error_message','投稿に失敗しました');
        }

        return redirect('/post');
    }

    //投稿詳細画面
    public function show(Request $request) {

        //投稿を取得
        $post = Post::with(['user','images'])->find($request->post_id);

        //投稿に対するコメントを取得
        $comments = Comment::with(['user','likes'])->where('post_id',$request->post_id)->orderBy('created_at','desc')->get()->toArray();
        return view('post.show',compact('post','comments'));
    }

    //投稿編集画面
    public function edit(Post $post) {
        if ($post->user_id == Auth::id()) {
            return view('post.edit',['post' => $post]);
        } else {
            return redirect('/post');
        }
    }

    //投稿編集処理
    public function update(PostRequest $request) {
        try {
            $post = Post::find($request->id);
            $post_data = $request->only('title','message');
            $post->fill($post_data)->save();

            session()->flash('success_message','投稿の編集が完了しました');
        } catch (\Exception $e) {
            session()->flash('error_message','投稿の編集に失敗しました');
        }

        return redirect('/post');
    }

    //投稿削除画面
    public function deleteConfirm(Post $post) {
        if ($post->user_id == Auth::id()) {
            return view('post.deleteConfirm',['post' => $post]);
        } else {
            return redirect('/post');
        }
    }

    //投稿削除処理
    public function delete(Request $request) {
        try {
            DB::beginTransaction();

            //削除する投稿とリレーションされているコメントと画像を取得
            $post = Post::with(['comment','images'])->find($request->id);

            //投稿に対するコメントのいいねを削除
            foreach ($post->comments as $comment) {
                $comment->likes()->detach();
            }
            //投稿に対するいいねを削除
            $post->users()->detach();

            //投稿の画像を削除
            foreach ($post->images as $image) {
                $remove_image = $post->user_id . '/' . $image->path;
                $image->delete();
                Storage::disk('public')->delete($remove_image);
            }
            //投稿の画像パスを削除
            $post->delete();

            session()->flash('success_message','投稿の削除が完了しました');

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error_message','投稿の削除に失敗しました');
        }

        return redirect('/post');
    }
}
