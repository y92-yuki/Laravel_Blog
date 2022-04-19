<a href="{{ config('app.url') }}">{{ config('app.name') }}</a>

<p>下記のURLをクリックして新しいメールアドレスを認証してください。<br></p>

<p>
    メールアドレス変更: <a href="{{ url('reset/' . $token)}}">{{ url('reset/' . $token) }}</a>
</p>

<p>※URLの有効期限は一時間以内です。有効期限が切れた場合は、お手数ですがもう一度最初からお手続きを行ってください。</p>