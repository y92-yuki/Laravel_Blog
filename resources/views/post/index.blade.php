@extends('layouts.app')

@section('content')
<div class="container">
    <form action="/post" method="get" class="float-right">
        <div class="form-inline">
            <div class="form-group mr-2">
                <input type="text" class="form-control" name="search_name" placeholder="名前で検索">
            </div>
            <button type="submit" class="btn btn-success">検索</button>
        </div>
    </form>
    <h2 class="text-center">投稿一覧</h2>
    <table class="table">
        @foreach($posts as $post)
            <tr><td>{{$post->getData()}}</td>
            <td><a href="{{ route('post.show', ['post_id' => $post->id]) }}" class="btn btn-sm btn-primary">詳細</a></td></tr>
        @endforeach
    </table>
    {{$posts->appends(request()->query())->links()}}
    <div>
        <a href="{{ route('post.add') }}" class="btn btn-primary">新規投稿</a>
    </div>
</div>
@endsection