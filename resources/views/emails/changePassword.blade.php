<a href="{{ config('app.url') }}">{{ config('app.name') }}</a>

<p>下記のURLをクリックして新しいパスワードを認証してください。<br></p>

<p>
    パスワード変更: <a href="{{ url('reset/password/' . $token)}}">{{ url('reset/password/' . $token) }}</a>
</p>

<p>※URLの有効期限は一時間以内です。有効期限が切れた場合は、お手数ですがもう一度最初からお手続きを行ってください。</p>