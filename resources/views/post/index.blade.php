@extends('layouts.app')

@section('content')
@if (session()->has('success_message'))
        <div class="alert alert-success text-center">
            {{ session('success_message') }}
        </div>
@endif
@if (session()->has('error_message'))
        <div class="alert alert-danger text-center">
            {{ session('error_message') }}
        </div>
@endif

<div class="container">
    <form action="/post" method="get" class="float-right">
        <div class="form-inline">
            <div class="form-group mr-2">
                <input type="text" class="form-control" name="search_value" placeholder="タイトルと内容で検索">
            </div>
            <button type="submit" class="btn btn-success">検索</button>
        </div>
    </form>
    <div class="weatherInfo">
        <input type="hidden" name="pref" value="{{ $pref }}">
        <input type="hidden" name="prefofficeLocation" value="{{ $prefofficeLocation }}">
        <p class="weatherTime h5"></p>
        <img class="weatherIcon">
        <p class="description d-inline"></p>
        <img class="tempIcon ml-3">
        <p class="tempMax d-inline h5 text-danger"></p>
        <p class="tempMin d-inline h5 text-primary ml-3"></p>
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
                    <td style="width: 30%;">{{ $post->index_title }}</td>
                    <td class="text-center" style="width: 30%;">{{ $post->getPostMessage() }}</td>
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

<script src="{{ mix('js/flashMessageControl.js') }}"></script>
<script src="{{ mix('js/ForeCastApi.js') }}"></script>