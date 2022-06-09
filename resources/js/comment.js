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

//コメントの新規投稿処理
const addComment = (formData,message) => {
    fetch('/post/show',{
        method: 'POST',
        headers: {
            "X-CSRF-TOKEN": formData.get('_token')
        },
        body: formData
    })
    .then(res => res.text())
    .then(res => {

        //CommentController.phpで例外が発生した場合はnullが戻り値
        if (!res) {
            return Promise.reject('error is CommentController.php');
        }
        
        //テキストエリアを初期化
        message.value = '';

        //コメント投稿後にバリデーションメッセージを削除
        document.querySelectorAll('.validateMessage').forEach ((item) => {
            if (item) {
                item.remove();
            }
        });
        message.classList.remove('is-invalid');

        //コメント成功メッセージを表示
        successMessage();

        //新規投稿したコメントを挿入
        document.querySelector('.viewComments').insertAdjacentHTML('afterbegin',res)
    })

    //コメントの取消ボタンを非表示
    .then(() => document.querySelector('button.commentUnlike').classList.add('d-none'))
    .catch(e => {
        console.error(e);
        dangerMessage();
    });
}

//バリデーションメッセージの挿入
const addValidateMessage = (message,messagePosition,messageType = null) => {
    const validateMessage = document.createElement('p');
    validateMessage.textContent = message;
    validateMessage.classList.add('text-danger','validateMessage',messageType);
    messagePosition.before(validateMessage);
    messagePosition.classList.add('is-invalid');
}

window.addEventListener('DOMContentLoaded',() => {

    //ユーザーがログインしているかおよびログイン中のユーザーが投稿にいいね済か取得
    const postExistsLike = document.querySelector('.postExistsLike');

    if (postExistsLike.dataset.not_logged_in != 'not_logged_in') {
        //コメントの新規投稿処理
        document.querySelector('#commentSubmit').onsubmit = (e) => {
            e.preventDefault();
            const formData = new FormData(document.forms.commentSubmit);
            const message = document.querySelector('textarea[name=message]');

            if (!message.value) {
                if (!document.querySelector('.blankMessage')) {
                    addValidateMessage('*コメントを入力してください',message,'blankMessage');
                }
            } else if (message.value.length >= 20) {
                if (!document.querySelector('.max20Message')) {
                    addValidateMessage('*コメントは20文字以内で入力してください',message,'max20Message');
                }
            } else {
                addComment(formData,message);
            }
        }
    }
});