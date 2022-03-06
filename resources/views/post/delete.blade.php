@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-center">削除</h2>
        <table class="table">
            <tr><th>投稿者</th><td>{{$post->user->name}}</td></tr>
            <tr><th>投稿時間</th><td>{{$post->created_at->format('Y年n月j日 H時i分s秒')}}</td></tr>
            @unless ($post->created_at == $post->updated_at)
                <tr><th>編集時間</th><td>{{$post->updated_at->format('Y年n月j日 H時i分s秒')}}</td></tr>
            @endunless
            <tr><th>タイトル</th><td>{{$post->title}}</td></tr>
            <tr><th>内容</th><td>{{$post->message}}</td></tr>
        </table>
        
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#removeModal" data-backdrop="static">削除する</button>
            <a href="{{ route('post.show',['post_id' => $post->id]) }}" class="btn btn-success">戻る</a>

        <!-- モーダルウィンドウで削除 -->
        <div class="modal fade" id="removeModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4><div class="modal-title" id="myModalLabel">削除確認画面</div></h4>
                    </div>
                    <div class="modal-body">
                        投稿を削除しますか？
                    </div>
                    <div class="modal-footer">
                        <form action="/post/delete" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{$post->id}}">
                            <button type="button" class="btn default" data-dismiss="modal">閉じる</button>
                            <button type="submit" class="btn btn-danger">削除</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>
    

@endsection