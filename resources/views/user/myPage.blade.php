@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
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
            <div class="card-title text-center" style="font-size: 20px;"><h2 class="text-center">{{ $user->name }} さんのマイページ</h2></div>
            <div class="card-text">
                <h4 class="my-3">メールアドレス: {{ $user->email }}</h4>
                <h4 class="my-3">地域: {{ $prefs[$user->prefNum] }}</h4>
            </div>
            <ul>
                <li><a href="{{ route('edit.password',$user) }}">パスワード変更</a></li>
                <li><a href="{{ route('edit.email',$user) }}">メールアドレス変更</a></li>
                <li><a href="{{ route('edit.pref',$user) }}">地域を変更</a></li>
            </ul>
        </div>
    </div>

    <div class="card-group">
        <div class="card">
            <div class="card-body">
                <div class="card-title"><h4 class="text-center">投稿一覧({{ $user['posts']->count() }})</h4></div>
                <div class="card-text">
                    <ul>
                        @forelse ($user['posts'] as $post)
                            <li>{{ $post->IdTitle['id'] }}.<a href="{{ route('post.show',['post_id' => $post->id]) }}">{{ $post->IdTitle['title'] }}</a> (いいね:{{ $post->users->count() }})</li>
                        @empty
                            <h5>まだ投稿がありません</h5>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="card-title"><h4 class="text-center">コメントした投稿一覧({{ $user['comment']->count() }})</h4></div>
                <div class="card-text">
                    <ul>
                        @forelse ($user['comment'] as $comment)
                            <li><a href="{{ route('post.show',['post_id' => $comment->post_id]) }}">{{ $comment->CommentPostuser['title'] }}</a>
                                 [ {{ $comment->CommentPostuser['postUserName'] }} => {{ $comment->CommentPostuser['message'] }} ](いいね:{{ $comment->likes->count() }})</li>
                        @empty
                            <h5>まだコメントしていません</h5>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="card-group">
        <div class="card">
            <div class="card-body">
                <div class="card-title"><h4 class="text-center">いいねした投稿一覧</h4></div>
                <div class="card-text">
                    <ul>
                        @forelse ($user['postLikes'] as $postLikes)
                            <li><a href="{{ route('post.show',['post_id' => $postLikes->id]) }}">{{ $postLikes->title }}</a></li>
                        @empty
                            <h5>まだ投稿へいいねしていません</h5>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="card-title"><h4 class="text-center">いいねしたコメント一覧</h4></div>
                <div class="card-text">
                    <ul>
                        @forelse ($user['comments'] as $commentLikes)
                            <li><a href="{{ route('post.show',['post_id' => $commentLikes->post_id]) }}">{{ $commentLikes->message }}</a></li>
                        @empty
                            <h5>まだコメントへいいねしていません</h5>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <a href="{{ route('post') }}" class="btn btn-success mt-3">戻る</a>
</div>

@endsection

<script src="{{ mix('js/flashMessageControl.js') }}"></script>