@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">地域を変更</div>
                <div class="card-body">
                    <div class="col-md-6">
                        <p>現在の地域：{{ $user->prefInfo->pref }}</p>
                    </div>
                    <form action="{{ route('edit.pref',$user) }}" method="post">
                        @csrf
                        <div class="col-md-6">
                            <span class="h5">新しい地域</span>
                            <div class="text-danger">
                                @error ('pref')
                                    {{ $message }}
                                @enderror
                            </div>
                            <div class="form-group">
                                <select name="pref" class="form-control @error('pref') is-invalid @enderror">
                                    <option value="0">選択してください</option>
                                    @foreach($prefs as $pref)
                                        @if($user->prefInfo->pref == $pref->pref)
                                            @continue
                                        @else
                                            <option value="{{ $pref->id }}" @if($pref->id == old('pref')) selected @endif>{{ $pref->pref }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <span class="h5">パスワード</span>
                            <div class="text-danger">
                                @error('password')
                                    {{ $message }}
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
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