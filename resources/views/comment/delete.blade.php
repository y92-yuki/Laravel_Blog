@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-center">コメントした投稿</h2>
        <table class="table">
            <tr><th>投稿者</th><td>{{$comment->post->user->name}}</td></tr>
            <tr><th>タイトル</th><td>{{$comment->post->title}}</td></tr>
            <tr><th>内容</th><td>{{$comment->post->message}}</td></tr>
        </table>
        <h3 class="text-center mt-5">削除するコメント</h3>
        <div class="card my-4 col-5">
            <div class="card-body">
                <div class="card-title">{{ $comment->user->name }}({{ $comment->created_at }})</div>
                <div class="card-text">
                    {{$comment->message}}
                </div>
            </div>
        </div>
        <form action="/post/show/delete" method="post">
            @csrf
            <input type="hidden" name="id" value="{{$comment->id}}">
            <button type="submit" class="btn btn-danger">削除する</button>
            <a href="{{ route('post.show',['post_id' => $comment->post->id]) }}" class="btn btn-success">戻る</a>
        </form>
    </div>
@endsection