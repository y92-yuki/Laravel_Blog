@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-center">削除</h2>
        <table class="table">
            <tr><th>投稿者</th><td>{{$post->user->name}}</td></tr>
            <tr><th>投稿時間</th><td>{{$date}}</td></tr>
            @unless ($date == $updated)
                <tr><th>(編集時間)</th><td>({{$updated}})</td></tr>
            @endunless
            <tr><th>タイトル</th><td>{{$post->title}}</td></tr>
            <tr><th>内容</th><td>{{$post->message}}</td></tr>
        </table>
        <form action="/post/delete" method="post">
            @csrf
            <input type="hidden" name="id" value="{{$post->id}}">
            <button type="submit" class="btn btn-danger">削除する</button>
            <a href="{{ route('post.show',['post_id' => $post->id]) }}" class="btn btn-success">戻る</a>
        </form>
    </div>
@endsection