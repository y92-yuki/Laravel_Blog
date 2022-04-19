'use strict';

    window.addEventListener('DOMContentLoaded',() => {

        const postExistsLike = document.querySelector('input[name=postExistsLike]').value;
        const token = document.querySelector('meta[name=csrf-token]').content;
        const likeCount = document.querySelector('#likeCount');
        const postLike = document.querySelectorAll('.postLike-toggle')

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
                        likeCount.textContent = String(parseInt(likeCount.textContent) - 1);
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
                    likeCount.textContent = String(parseInt(likeCount.textContent) + 1);
                    event.parentNode.classList.toggle('d-none');
                    document.querySelector('.postUnlike').classList.toggle('d-none');
                   })
                   .catch(e => console.log(e));
               };
            };
        });
    });