@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-center">投稿詳細</h2>
        <table class="table">
            <tr><th>投稿者</th><td>{{$post->user->name}}</td></tr>
            <tr><th>投稿時間</th><td>{{$date}}</td></tr>
            @unless ($updated == $date)
                <tr><th>(編集時間)</th><td>({{$updated}})</td></tr>
            @endunless
            <tr><th>タイトル</th><td>{{$post->title}}</td></tr>
            <tr><th>内容</th><td>{{$post->message}}</td></tr>
        </table>
        <a href="{{ route('post.edit',['post_id' => $post->id]) }}" class="btn btn-primary">編集</a>
        <a href="{{ route('post.delete',['post_id' => $post->id]) }}" class="btn btn-danger">削除</a>
        <a href="/post" class="btn btn-success">戻る</a>

        <h4 class="my-5">コメントを残す</h4>
        <div class="col-5">
            <form action="/post/show" method="post">
                @csrf
                <input type="hidden" name="user_id" value="{{$auth_id}}">
                <input type="hidden" name="post_id" value="{{$post->id}}">
                <div class="form-group">
                    <div class="text-danger">
                        @error('message')
                            *{{$message}}
                        @enderror
                    </div>
                    <textarea name="message" class="form-control" placeholder="コメントは20文字以内で入力してください"></textarea>
                </div>
                <button type="submit" class="btn btn-primary mb-5">コメントする</button>
            </form>
        
            @forelse ($post->comment as $comment)
                <div class="card my-2" style="width: 18rem">
                    <div class="card-body">
                        <h6 class="card-title">
                            {{$comment->user->name}}({{$comment->created_at}})
                        </h6>
                        <p class="card-text">
                            {{$comment->message}}
                            <a href="{{ route('show.delete',['comment_id' => $comment->id]) }}" class="float-right btn btn-sm btn-danger">削除</a>
                        </p>
                    </div>
                </div>
            @empty

            @endforelse
        </div>
    </div>
@endsection