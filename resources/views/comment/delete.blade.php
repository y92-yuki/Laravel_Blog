@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-center">コメント削除</h2>
        <table class="table">
            <tr><th>投稿者</th><td>{{$comment->user->name}}</td></tr>
            <tr><th>内容</th><td>{{$comment->message}}</td></tr>
        </table>
        <form action="/post/delete" method="post">
            @csrf
            <input type="hidden" name="id" value="{{$comment->id}}">
            <button type="submit" class="btn btn-danger">削除する</button>
            <a href="{{ route('post.show',['post_id' => $comment->post->id]) }}" class="btn btn-success">戻る</a>
        </form>
    </div>
@endsection