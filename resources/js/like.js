'use strict';

    window.addEventListener('DOMContentLoaded',() => {

        //投稿へのいいね機能

        //resourcess->views->layouts->app.blade.phpのcsrf-tokenを取得
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
           item.onclick = (e) => {
                const event = e.currentTarget;
                const post_id = {post_id:event.value};

               if (event.parentNode.classList.contains('postUnlike')) {
                    fetch(`/post/postUnlike`,{
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": token,
                            "Content-type": "application/json"
                        },
                        body: JSON.stringify(post_id)
                    })
                    .then(() => {
                        postLikeCount.textContent = String(parseInt(postLikeCount.textContent) - 1);
                        event.parentNode.classList.toggle('d-none');
                        document.querySelector('.postLike').classList.toggle('d-none');
                    })
                    .catch(e => console.log(e));
               } else {
                   fetch('/post/postLike',{
                       method: "POST",
                       headers: {
                           "X-CSRF-TOKEN": token,
                           "Content-type": "application/json"
                       },
                       body: JSON.stringify(post_id)
                   })
                   .then(() => {
                    postLikeCount.textContent = String(parseInt(postLikeCount.textContent) + 1);
                    event.parentNode.classList.toggle('d-none');
                    document.querySelector('.postUnlike').classList.toggle('d-none');
                   })
                   .catch(e => console.log(e));
               };
            };
        });


        //コメントへのいいね機能

        //投稿にコメントがあるか判定(戻り値:要素 or null)
        const commentNone = document.querySelector('input[name=commentNone]');

        // if (!commentNone) {
            //ログイン中のユーザーがコメントへいいねしているか判定
            const commentExistsLike = document.querySelectorAll('.commentExistsLike');

            //いいね・取消ボタンの取得
            // const commentLike = document.querySelectorAll('.commentlike-toggle');

            //投稿詳細へアクセス時にいいね・取消ボタンの表示を操作
            commentExistsLike.forEach((item) => {
                if (item.value) {
                    item.nextElementSibling.nextElementSibling.classList.add('d-none');
                } else {
                    item.nextElementSibling.classList.add('d-none');
                }
            });

            $(document).on('click','.commentLike-toggle',(e) => {
                const event = e.currentTarget;
                const comment_id = {comment_id: event.value};
                
                if (event.classList.contains('commentUnlike')) {
                    fetch('/post/comment/unlike',{
                        method: 'POST',
                        headers: {
                            "X-CSRF-TOKEN": token,
                            "content-type": "application/json"
                        },
                        body: JSON.stringify(comment_id)
                    })
                    .then(() => {
                        //コメントのいいね数を取得->更新
                        event.parentNode.lastElementChild.firstElementChild.textContent = String(parseInt(event.parentNode.lastElementChild.firstElementChild.textContent) - 1);
                        event.nextElementSibling.classList.toggle('d-none');
                        event.classList.toggle('d-none');
                    })
                    .catch(e => console.log(e));
                } else {
                    fetch ('/post/comment/like',{
                        method: 'POST',
                        headers: {
                            "X-CSRF-TOKEN": token,
                            "content-type": "application/json"
                        },
                        body: JSON.stringify(comment_id)
                    })
                    .then(() => {
                        //コメントのいいね数を取得->更新
                        event.parentNode.lastElementChild.firstElementChild.textContent = String(parseInt(event.parentNode.lastElementChild.firstElementChild.textContent) + 1);
                        event.previousElementSibling.classList.toggle('d-none');
                        event.classList.toggle('d-none');
                    })
                    .catch(e => console.log(e));
                };
            });
        // };

            // commentLike.forEach((item) => {
            //     item.onclick = (e) => {
            //         const event = e.currentTarget;
            //         const comment_id = {comment_id: event.value};
                    
            //         if (event.classList.contains('commentUnlike')) {
            //             fetch('/post/comment/unlike',{
            //                 method: 'POST',
            //                 headers: {
            //                     "X-CSRF-TOKEN": token,
            //                     "content-type": "application/json"
            //                 },
            //                 body: JSON.stringify(comment_id)
            //             })
            //             .then(() => {
            //                 //コメントのいいね数を取得->更新
            //                 event.parentNode.lastElementChild.firstElementChild.textContent = String(parseInt(event.parentNode.lastElementChild.firstElementChild.textContent) - 1);
            //                 event.nextElementSibling.classList.toggle('d-none');
            //                 event.classList.toggle('d-none');
            //             })
            //             .catch(e => console.log(e));
            //         } else {
            //             fetch ('/post/comment/like',{
            //                 method: 'POST',
            //                 headers: {
            //                     "X-CSRF-TOKEN": token,
            //                     "content-type": "application/json"
            //                 },
            //                 body: JSON.stringify(comment_id)
            //             })
            //             .then(() => {
            //                 //コメントのいいね数を取得->更新
            //                 event.parentNode.lastElementChild.firstElementChild.textContent = String(parseInt(event.parentNode.lastElementChild.firstElementChild.textContent) + 1);
            //                 event.previousElementSibling.classList.toggle('d-none');
            //                 event.classList.toggle('d-none');
            //             })
            //             .catch(e => console.log(e));
            //         };
            //     };
            // });
    });