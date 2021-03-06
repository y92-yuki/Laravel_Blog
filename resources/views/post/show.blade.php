@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-center">投稿詳細</h2>
        <table class="table">
            <tr><th>投稿者</th><td>{{$post->user->name}}</td></tr>
            <tr><th>いいねの数</th><td id="postLikeCount">{{ $post->users()->count() }}</td></tr>
            <tr><th>投稿時間</th><td>{{$post->created_at->format('Y年n月j日 H時i分s秒')}}</td></tr>
            @unless ($post->created_at == $post->updated_at)
                <tr><th>編集時間</th><td>{{$post->updated_at->format('Y年n月j日 H時i分s秒')}}</td></tr>
            @endunless
            <tr><th>タイトル</th><td>{{$post->title}}</td></tr>
            <tr><th>内容</th><td>{!!nl2br($post->message)!!}</td></tr>
        </table>
        @if ($post->user_id == Auth::id())
            <a href="{{ route('post.edit',$post) }}" class="btn btn-primary">編集</a>
            <a href="{{ route('post.deleteConfirm', ['post' => $post->id]) }}" class="btn btn-danger">削除</a>
        @endif
        <a href="/post" class="btn btn-success">戻る</a>

        {{-- 投稿へのいいね --}}
        @if (Auth::check())
            <input type="hidden" class="postExistsLike" value="{{ $post->postExistsLike() }}">
            <div class="text-right postUnlike">
                <button type="button" class="btn btn-success postLike-toggle" value="{{ $post->id }}">取消</button>
            </div>
            <div class="text-right postLike">
                <button type="button" class="btn btn-primary postLike-toggle" value="{{ $post->id }}"><i class="fa-regular fas fa-lg fa-thumbs-up"></i> いいね!</button>
            </div>
        @else
            <div class="postExistsLike" data-not_logged_in="not_logged_in"></div>
        @endif

        @if ($post->user_id == Auth::id())
            <form action="{{ route('upload',['post_id' => $post->id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" class="form-control-file">
                <button type="submit" class="my-3 btn btn-sm btn-info">画像を添付する</button>
            </form>
            @forelse ($post->images as $image)
                @if ($image->id)
                    <div class="float-right">
                        <button type="submit" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#imageRemoveModal" data-backdrop="static">画像を削除する</button>
                    </div>
                    @break
                @else
                
                @endif
            
            @empty

            @endforelse
        @endif

        {{-- モーダルウィンドウで画像を削除 --}}
        <div class="modal fade" id="imageRemoveModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" area-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4><div class="modal-title" id="myModalLabel">削除確認画面</div></h4>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('upload.delete',$post) }}" method="post">
                            @csrf
                            削除する画像を選択してください
                            <div class="form-group">
                                <select name="image_id" class="form-control">
                                    @foreach ($post->images as $image)
                                        <option value="{{ $image->id }}">{{ $image->path }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn default" data-dismiss="modal">閉じる</button>
                                <button type="submit" class="btn btn-danger">削除</button>
                            </div>
                        </form>
                    </div>  
                </div>
            </div>
        </div>
        
        @foreach ($post->images as $image)
            <img src="{{ asset('storage/' . $post->user_id . '/' .$image->path) }}" class="mb-2">
        @endforeach

        @if (Auth::check())
            <h4 class="my-5">コメントを残す</h4>
            <div class="alert alert-success text-center" style="display: none">
                コメントの投稿が完了しました
            </div>
            <div class="alert alert-danger text-center" style="display: none">
                コメントの投稿に失敗しました
            </div>
            <form action="/post/show" method="post" id="commentSubmit" class="col-5">
                @csrf
                <input type="hidden" name="user_id" value="{{Auth::id()}}">
                <input type="hidden" name="post_id" value="{{$post->id}}">
                <div class="form-group">
                    <textarea name="message" class="form-control" rows="3" placeholder="コメントは20文字以内で入力してください"></textarea>
                </div>
                <button type="submit"class="btn btn-primary mb-5">コメントする</button>
            </form>
        @endif
        <div class="viewComments"></div>
        @foreach ($comments as $comment)
            @if ($comment['user_id'] != Auth::id())
                <input type="hidden" name="not_delete" value="not_delete">
            @endif
            @include('components.comments', ['comment', $comment])
        @endforeach
    </div>
@endsection

<script src="{{ mix('js/like.js') }}"></script>
<script src="{{ mix('js/comment.js') }}"></script>