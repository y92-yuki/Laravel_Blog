@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">メールアドレスを変更</div>
                <div class="card-body">
                    <div class="col-md-6">
                        <p>現在のメールアドレス：{{ $user->email }}</p>
                    </div>
                    <form action="{{ route('send.email') }}" method="post">
                        @csrf
                        <div class="col-md-6">
                            <span class="h5">新しいメールアドレス</span>
                            <div class="text-danger">
                                @error ('new_email')
                                    {{ $message }}
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="text" name="new_email" class="form-control @error('new_email') is-invalid @enderror">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <span class="h5">確認</span>
                            <div class="form-group">
                                <input type="text" name="new_email_confirmation" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">変更</button>
                            <a href="{{ route('myPage') }}" class="btn btn-success">戻る</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection