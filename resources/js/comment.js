'use strict';


window.addEventListener('DOMContentLoaded',() => {
    const successMessage = () => {
        $('.alert-success').fadeIn();
        
        setTimeout(() => {
            $('.alert-success').fadeOut(5000);
        },2000);
    }

    const dangerMessage = () => {
        $('.alert-danger').fadeIn();
        
        setTimeout(() => {
            $('.alert-danger').fadeOut(5000);
        },2000);
    }

    document.querySelector('#commentSubmit').onsubmit = (e) => {
        e.preventDefault();
        const formData = new FormData(document.forms.commentSubmit);
        const token = formData.get('_token');
        formData.delete('_token');
        const message = document.querySelector('textarea[name=message]');

        const newComment = (userName,year,month,date,hour,min,sec,message,comment) => {
            document.querySelector('#commentArea').insertAdjacentHTML('beforeend',`
                <div class="card my-2" style="width: 18rem">
                    <div class="card-body">
                        <h6 class="card-title">
                            ${userName}(${year}-${month}-${date} ${hour}:${min}:${sec})
                            <input type="hidden" class="commentExistsLike" value="0">
                            <button type="button" class="float-right btn btn-success btn-sm commentLike-toggle commentUnlike d-none" value="${comment}">取消</button>
                            <button type="button" class="float-right btn btn-primary btn-sm commentLike-toggle commentLike" value="${comment}"><i class="fa-regular fas fa-thumbs-up"> いいね！</i></button>
                            <p>いいねの数:<span class="commentLikeCount">0</span></p>
                        </h6>
                        <p class="card-text">
                            ${message}
                            <a href="/post/show/delete/${comment}" class="mt-1 float-right btn btn-sm btn-danger">削除</a>
                        </p>
                    </div>
                </div>
            `)
        }

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
                const time = new Date(res.created_at);
                const year = time.getFullYear();
                const month = time.getMonth() + 1;
                const date = time.getDate();
                const hour = time.getHours();
                const min = time.getMinutes();
                const sec = time.getSeconds();
                message.value = '';

                document.querySelectorAll('.validateMessage').forEach ((item) => {
                    if (item) {
                        item.remove();
                    }
                });
                message.classList.remove('is-invalid');
    
                newComment(res.userName,year,month,date,hour,min,sec,res.message,res.commentId);
                successMessage();
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