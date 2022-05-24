<div class="card my-2" style="width: 18rem">
    <div class="card-body">
        <h6 class="card-title">
            {{ $comment['user']['name'] }}({{ $comment['created_at'] }})
            <input type="hidden" name="commentExistsLike" class="commentExistsLike" value='{{ $comment['is_like_by_login_user'] }}'>
            <button type="button" class="float-right btn btn-success btn-sm commentLike-toggle commentUnlike" value='{{ $comment['id'] }}'>取消</button>
            <button type="button" class="float-right btn btn-primary btn-sm commentLike-toggle commentLike" value='{{ $comment['id'] }}'><i class="fa-regular fas fa-thumbs-up"> いいね！</i></button>
            <p>いいねの数:<span class="commentLikeCount">{{ count($comment['likes']) }}</span></p>
        </h6>
        <p class="card-text">
            {{ $comment['message'] }}
            <a href="/post/show/delete/{{ $comment['id'] }}" class="mt-1 float-right btn btn-sm btn-danger">削除</a>
        </p>
    </div>
</div>