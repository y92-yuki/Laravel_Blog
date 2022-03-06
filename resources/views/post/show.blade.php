@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-center">投稿詳細</h2>
        <table class="table">
            <tr><th>投稿者</th><td>{{$post->user->name}}</td></tr>
            <tr><th>いいねの数</th><td>{{ $post->users()->count() }}</td></tr>
            <tr><th>投稿時間</th><td>{{$post->created_at->format('Y年n月j日 H時i分s秒')}}</td></tr>
            @unless ($post->created_at == $post->updated_at)
                <tr><th>編集時間</th><td>{{$post->updated_at->format('Y年n月j日 H時i分s秒')}}</td></tr>
            @endunless
            <tr><th>タイトル</th><td>{{$post->title}}</td></tr>
            <tr><th>内容</th><td>{!!nl2br($post->message)!!}</td></tr>
        </table>
        <a href="{{ route('post.edit',['post_id' => $post->id]) }}" class="btn btn-primary">編集</a>
        <a href="{{ route('post.delete',['post_id' => $post->id]) }}" class="btn btn-danger">削除</a>
        <a href="/post" class="btn btn-success">戻る</a>

        @if ($post->postExistsLike())
            <form class="text-right" action="{{ route('post.Unlike',$post) }}" method="post">
                @csrf
                <button type="submit" class="btn btn-success">取消</button>
            </form>
        @else
            <form class="text-right" action="{{ route('post.Like',$post) }}" method="post">
                @csrf
                <button type="submit" class="btn btn-primary">いいね</button>
            </form>
        @endif

        <h4 class="my-5">コメントを残す</h4>
        <div class="col-5">
            <form action="/post/show" method="post">
                @csrf
                <input type="hidden" name="user_id" value="{{Auth::id()}}">
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
                            @if ($comment->existsLike())
                                <form action="{{ route('unlike',$comment) }}" method="post">
                                    @csrf
                                    <button type="submit" class="float-right btn btn-success btn-sm">取消</button>
                                </form>
                            @else
                                <form action="{{ route('like',$comment) }}" method="post">
                                    @csrf
                                    <button type="submit" class="float-right btn btn-primary btn-sm">いいね</button>
                                </form>
                            @endif
                            <p>いいね数:{{ $comment->likes->count() }}</p>
                        </h6>
                        <p class="card-text">
                            {{$comment->message}}
                            <a href="{{ route('show.delete',['comment_id' => $comment->id]) }}" class="mt-1 float-right btn btn-sm btn-danger">削除</a>
                        </p>
                    </div>
                </div>
            @empty

            @endforelse
        </div>
    </div>
@endsection