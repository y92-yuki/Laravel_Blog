'use strict';

//非同期処理のトーストメッセージ(success)
const successMessage = () => {
    $('.alert-success').fadeIn();
    
    setTimeout(() => {
        $('.alert-success').fadeOut(5000);
    },2000);
}

//非同期処理のトーストメッセージ(fail)
const dangerMessage = () => {
    $('.alert-danger').fadeIn();
    
    setTimeout(() => {
        $('.alert-danger').fadeOut(5000);
    },2000);
}

//コメントの投稿時間を取得
const getCreated_at = (created_at) => {
    const time = new Date(created_at);
    const year = time.getFullYear();
    const month = time.getMonth() + 1;
    const date = time.getDate();
    const hour = time.getHours();
    const min = time.getMinutes();
    const sec = time.getSeconds();
    const getPadstart = num => String(num).padStart(2,'0');

    return `${year}-${getPadstart(month)}-${getPadstart(date)} ${getPadstart(hour)}:${getPadstart(min)}:${getPadstart(sec)}`;
}

//コメントを挿入するためのフォーマット
const comment = (userName,timed,message,comment_id,commentExistsLike,likeNum) => {
    document.querySelector('.viewComments').insertAdjacentHTML('afterbegin',`
        <div class="card my-2" style="width: 18rem">
            <div class="card-body">
                <h6 class="card-title">
                    ${userName}(${timed})
                    <input type="hidden" class="commentExistsLike" value="${commentExistsLike}">
                    <button type="button" id="commentUnlike" class="float-right btn btn-success btn-sm commentLike-toggle commentUnlike" value="${comment_id}">取消</button>
                    <button type="button" class="float-right btn btn-primary btn-sm commentLike-toggle commentLike" value="${comment_id}"><i class="fa-regular fas fa-thumbs-up"> いいね！</i></button>
                    <p>いいねの数:<span class="commentLikeCount">${likeNum}</span></p>
                </h6>
                <p class="card-text">
                    ${message}
                    <a href="/post/show/delete/${comment_id}" class="mt-1 float-right btn btn-sm btn-danger">削除</a>
                </p>
            </div>
        </div>
    `)
}

window.addEventListener('DOMContentLoaded',() => {
    const post_id = document.querySelector('input[name=post_id]');

    //投稿済みのコメントを取得
    fetch(`/post/show/getcomment/${post_id.value}`)
    .then(res => res.json())
    .then(res => {
        for (let p of res) {
            comment(p.user.name,getCreated_at(p.created_at),p.message,p.id,p.is_like_by_login_user,p.likes.length);
        }
    })
    .then(() => {
        const liked = document.querySelectorAll('.commentExistsLike');
        for (let p of liked) {
            if (JSON.parse(p.value)) {
                p.nextElementSibling.nextElementSibling.classList.add('d-none')
            } else {
                p.nextElementSibling.classList.add('d-none');
            }
        }
    })
    .catch(e => console.log(e));

    //コメントの新規投稿処理
    document.querySelector('#commentSubmit').onsubmit = (e) => {
        e.preventDefault();
        const formData = new FormData(document.forms.commentSubmit);
        const token = formData.get('_token');
        formData.delete('_token');
        const message = document.querySelector('textarea[name=message]');

        if (message.value && message.value.length <= 20) {
            fetch('/post/show',{
                method: 'POST',
                headers: {
                    "X-CSRF-TOKEN": token
                },
                body: formData
            })
            .then((res) => res.json())
            .then(res => {                
                message.value = '';

                document.querySelectorAll('.validateMessage').forEach ((item) => {
                    if (item) {
                        item.remove();
                    }
                });
                message.classList.remove('is-invalid');
                successMessage();
                comment(res.userName,getCreated_at(res.created_at),res.message,res.commentId,0,0);
                document.querySelector('#commentUnlike').classList.add('d-none');
            })
            .catch(e => {
                console.log(e);
                dangerMessage();
            });
        } else if (!message.value) {
            if (!document.querySelector('.blankMessage')) {
                const validateMessage = document.createElement('p');
                validateMessage.textContent = '*コメントを入力してください';
                validateMessage.classList.add('text-danger','blankMessage','validateMessage');
                message.before(validateMessage);
                message.classList.add('is-invalid');
            }
        } else {
            if (!document.querySelector('.max20Message')) {
                const validateMessage = document.createElement('p');
                validateMessage.textContent = '*コメントは20文字以内で入力してください';
                validateMessage.classList.add('text-danger','max20Message','validateMessage');
                message.before(validateMessage);
                message.classList.add('is-invalid');
            }
        }
    }
});