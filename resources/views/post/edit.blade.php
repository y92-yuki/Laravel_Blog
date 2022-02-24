@extends('layouts.app')

@section('content')
    <div class="content">
        <h2 class="text-center">編集</h2>
        <form action="/post/edit" method="post">
            @csrf
            <input type="hidden" name="id" value="{{$post->id}}">
            <div class="col-md-8">
            @error('title')
                <p class="text-danger">*{{$message}}</p>
            @enderror
            @error('message')
                <p class="text-danger">*{{$message}}</p>
            @enderror
                <table class="table">
                    <tr>
                        <th>投稿者</th><td>{{$post->user->name}}</td>
                    </tr>
                    <div class="form-group">
                        <tr>
                            <th>タイトル</th><td><input type="text" name="title"  class="form-control" value="{{$post->title}}"></td>
                        </tr>
                    </div>
                    <div class="form-group">
                        <tr>
                            <th>内容</th><td><textarea type="text" name="message" class="form-control" rows="5">{{$post->message}}</textarea></td>
                        </tr>
                    </div>
                </table>
                <button type="submit" class="btn btn-primary">変更する</button>
                <a href="{{ route('post.show',['post_id' => $post->id]) }}" class="btn btn-success">戻る</a>
            </div>
        </form>
    </div>
@endsection