@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-center">新規投稿</h2>
        <form action="/post/create" method="post" enctype="multipart/form-data">
            @csrf
            <div class="col-md-8">
                <input type="hidden" name="user_id" value="{{$user_id}}">
                <div class="form-group">
                    <label>タイトル</label>
                    <div class="text-danger">
                        @error('title')
                            *{{$message}}
                        @enderror
                    </div>
                    <input type="text" name="title" value="{{old('title')}}" class="form-control @error('title') is-invalid @enderror" placeholder="タイトルを20文字以内で入力してください">
                </div>
                <div class="form-group">
                    <label>内容</label>
                    <div class="text-danger">
                        @error('message')
                            *{{$message}}
                        @enderror
                    </div>
                    <textarea class="form-control @error('message') is-invalid @enderror" name="message" placeholder="内容を入力してください" rows="5" >{{ old('message') }}</textarea>
                </div>
                <div class="form-group">
                    <input type="file" name="file" class="form-control-file" >
                </div>
                <button type="submit" class="btn btn-primary">作成する</button>
                <a href="/post" class="btn btn-success">戻る</a>
            </div>
        </form>
    </div>
@endsection