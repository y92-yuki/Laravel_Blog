@extends('layouts.app')

@section('content')
<div class="container">
    <form action="/post" method="get" class="float-right">
        <div class="form-inline">
            <div class="form-group mr-2">
                <input type="text" class="form-control" name="search_value" placeholder="タイトルと内容で検索">
            </div>
            <button type="submit" class="btn btn-success">検索</button>
        </div>
    </form>
    <div id="weatherInfo">
        
    </div>
    <h2 class="text-center">投稿一覧</h2>
        @forelse($posts as $post)
            <table class="table">
                @if ($loop->first)
                    <thead>
                        <tr>
                            <th style="width: 30%;">タイトル(投稿者名)</th>
                            <th class="text-center" style="width: 30%;">本文</th>
                            <th></th>
                        </tr>
                    </thead>
                @endif
                <tr>
                    <td style="width: 30%;">{{ $post->index_post['id'] }} . {{ $post->index_post['title'] }}({{ $post->index_post['userName'] }})</td>
                    <td class="text-center" style="width: 30%;">{{ $post->IndexPost['message'] }}</td>
                    <td><a href="{{ route('post.show', ['post_id' => $post->id]) }}" class="btn btn-sm btn-primary">詳細</a></td>
                </tr>
            </table>
        @empty
            @if ($search)
                <div class="d-flex align-items-center justify-content-center border-buttom" style="height:300px;">
                    <h2 style="border-bottom: solid 2px;">" {{ str_replace('%','',$search) }} " を含む投稿は見つかりませんでした</h2>
                </div>
            @else
                <div class="d-flex align-items-center justify-content-center border-buttom" style="height:300px;">
                    <h2 style="border-bottom: solid 2px;">まだ投稿がありません</h2>
                </div>
            @endif
        @endforelse
        {{$posts->appends(request()->query())->links()}}
    <div>
        <a href="{{ route('post.create') }}" class="btn btn-primary">新規投稿</a>
        @if($search)
            <a href="{{ route('post') }}" class="btn btn-success">一覧へ戻る</a>
        @endif
    </div>
</div>
@endsection

<script src="{{ mix('js/ForeCastApi.js') }}"></script>