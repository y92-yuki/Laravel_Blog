@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">パスワードを変更</div>
                <div class="card-body">
                        <form action="{{ route('edit.password',$user) }}" method="post">
                            @csrf
                            <div class="col-md-6">
                                <span class="h5">現在のパスワード</span>
                                <div class="text-danger">
                                    @error ('currentPassword')
                                        *{{ $message }}
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="password" name="currentPassword" class="form-control @error('currentPassword') is-invalid @enderror">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <span class="h5">新しいパスワード</span>
                                <div class="text-danger">
                                    @error ('newPassword')
                                        *{{ $message }}
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="password" name="newPassword" class="form-control @error('newPassword') is-invalid @enderror">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <span class="h5">確認</span>
                                <div class="form-group">
                                    <input type="password" name="newPassword_confirmation" class="form-control ">
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