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
        @if ($post->user_id == Auth::id())
            <a href="{{ route('post.edit',$post) }}" class="btn btn-primary">編集</a>
            <a href="{{ route('post.delete', ['post' => $post->id]) }}" class="btn btn-danger">削除</a>
        @endif
        <a href="/post" class="btn btn-success">戻る</a>

        @if ($post->postExistsLike())
            <form class="text-right" action="{{ route('post.Unlike',$post) }}" method="post">
                @csrf
                <button type="submit" class="btn btn-success">取消</button>
            </form>
        @else
            <form class="text-right" action="{{ route('post.Like',$post) }}" method="post">
                @csrf
                <button type="submit" class="btn btn-primary"><i class="fa-regular fas fa-lg fa-thumbs-up"></i> いいね!</button>
            </form>
        @endif
        @if ($post->user_id == Auth::id())
            <form action="{{ route('upload',['post_id' => $post->id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" class="form-control-file">
                <button type="submit" class="my-3 btn btn-sm btn-info">画像を添付する</button>
            </form>
            @forelse ($post->images as $image)
                @if ($image->id)
                    <div class="float-right">
                        <button type="submit" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#imageRemoveModal" data-backdrop="static">画像を削除する</button>
                    </div>
                    @break
                @else
                
                @endif
            
            @empty

            @endforelse
        @endif

        {{-- モーダルウィンドウで画像を削除 --}}
        <div class="modal fade" id="imageRemoveModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" area-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4><div class="modal-title" id="myModalLabel">削除確認画面</div></h4>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('upload.delete',['post_id' => $post->id]) }}" method="post">
                            @csrf
                            削除する画像を選択してください
                            <div class="form-group">
                                <select name="image_id" class="form-control">
                                    @foreach ($post->images as $image)
                                        <option value="{{ $image->id }}">{{ $image->path }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn default" data-dismiss="modal">閉じる</button>
                                <button type="submit" class="btn btn-danger">削除</button>
                            </div>
                        </form>
                    </div>  
                </div>
            </div>
        </div>
        
        @if ($post->user_id == Auth::id())
            
        @endif

        @foreach ($post->images as $image)
            <img src="{{ asset('storage/' . $image->path) }}" class="mb-2">
        @endforeach

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
                                    <button type="submit" class="float-right btn btn-primary btn-sm"><i class="fa-regular fas fa-thumbs-up"> いいね！</i></button>
                                </form>
                            @endif
                            <p>いいねの数:{{ $comment->likes->count() }}</p>
                        </h6>
                        <p class="card-text">
                            {{$comment->message}}
                            @if ($comment->user_id == Auth::id() || $post->user_id == Auth::id())
                                <a href="{{ route('show.delete',$comment) }}" class="mt-1 float-right btn btn-sm btn-danger">削除</a>
                            @endif
                        </p>
                    </div>
                </div>
            @empty

            @endforelse
        </div>
    </div>
@endsection