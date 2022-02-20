@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center">投稿一覧</h2>
    <table class="table">
        @foreach($posts as $post)
            <tr><td>{{$post->getData()}}</td><td><a href="/post/show?post_id={{$post->id}}" class="btn btn-sm btn-primary">詳細</a></td></tr>
        @endforeach
    </table>
    <div>
        <a href="/post/add" class="btn btn-primary">新規投稿</a>
    </div>
</div>
@endsection