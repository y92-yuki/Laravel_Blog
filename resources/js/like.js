'use strict';

    window.addEventListener('DOMContentLoaded',() => {

        //いいね取り消し機能
        const unLikeExecute = (url,id,unLike,like,likeCount) => {
            fetch(url,{
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": token,
                    "Content-type": "application/json"
                },
                body: JSON.stringify(id)
            })
            .then(() => {
                likeCount.textContent = String(parseInt(likeCount.textContent) - 1);
                unLike.classList.toggle('d-none');
                like.classList.toggle('d-none');
            })
            .catch(e => console.error(e));
        }

        //良いね機能
        const likeExecute = (url,id,like,unLike,likeCount) => {
            fetch(url,{
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": token,
                    "Content-type": "application/json"
                },
                body: JSON.stringify(id)
            })
            .then(() => {
             likeCount.textContent = String(parseInt(likeCount.textContent) + 1);
             like.classList.toggle('d-none');
             unLike.classList.toggle('d-none');
            })
            .catch(e => console.error(e));
        }

        //投稿へのいいね機能

        //resourcess/views/layouts/app.blade.phpのcsrf-tokenを取得
        const token = document.querySelector('meta[name=csrf-token]').content;

        //ログイン中のユーザーがいいねをしているか判定(戻り値:0 or 1)
        const postExistsLike = document.querySelector('input[name=postExistsLike]').value;
        
        //投稿へのいいね数の要素を取得
        const postLikeCount = document.querySelector('#postLikeCount');

        //いいね・取消ボタンを取得
        const postLike = document.querySelectorAll('.postLike-toggle');

        //投稿詳細へアクセス時にいいね・取消ボタンの表示を操作
        if (postExistsLike) {
            document.querySelector('.postLike').classList.add('d-none');
        } else {
            document.querySelector('.postUnlike').classList.add('d-none');
        }

        postLike.forEach ((item) => {

            //いいね・取消ボタンのどちらかがクリックされたら処理開始
           item.onclick = (e) => {
                const event = e.currentTarget;

                //POSTで送信する値(いいね・取消共通)
                const post_id = {post_id: event.value};

                //クリックされた要素がpostUnLikeクラスを持っていたら取消ボタン
               if (event.parentNode.classList.contains('postUnlike')) {
                const url = '/post/postUnlike';
                const unLike = event.parentNode;
                const like = document.querySelector('.postLike');

                //いいね取消を実行
                unLikeExecute(url,post_id,unLike,like,postLikeCount);
               } else {
                const url = '/post/postLike';
                const like = event.parentNode;
                const unLike = document.querySelector('.postUnlike');

                //いいねを実行
                likeExecute(url,post_id,like,unLike,postLikeCount);
               };
            };
        });


        //コメントへのいいね機能

        // ログイン中のユーザーがコメントへいいねしているか
        const liked = document.querySelectorAll('.commentExistsLike');
        for (let p of liked) {
            if (p.value) {
                p.nextElementSibling.nextElementSibling.classList.add('d-none')
            } else {
                p.nextElementSibling.classList.add('d-none');
            }
        }

        //いいね・取消ボタンのクリックイベントを取得
        $(document).on('click','.commentLike-toggle',(e) => {
            const event = e.currentTarget;
            const comment_id = {comment_id: event.value};
            const commentLikeCount = event.parentNode.lastElementChild.firstElementChild;

            //クリックされた要素がcommentUnlikeクラスを持っていたら取消ボタン
            if (event.classList.contains('commentUnlike')) {
                const url = '/post/comment/unlike';
                const unLike = event;
                const like = event.nextElementSibling;

                //いいね取消を実行
                unLikeExecute(url,comment_id,unLike,like,commentLikeCount);
            } else {
                const url = '/post/comment/like';
                const like = event;
                const unLike = event.previousElementSibling;

                //いいねを実行
                likeExecute(url,comment_id,like,unLike,commentLikeCount);
            };
        });
    });