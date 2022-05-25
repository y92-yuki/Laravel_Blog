'use strict';

window.addEventListener('DOMContentLoaded',() => {

    fetch ('/getForeCast')
    .then (res => res.text())
    .then(res => document.querySelector('#weatherInfo').insertAdjacentHTML('afterbegin',res))
    .catch(e => {
        console.error(e);
        const weatherInfo = document.querySelector('#weatherInfo');
        weatherInfo.textContent = '*天気データの取得に失敗しました';
        weatherInfo.classList.add('h5','text-danger');
    });
});