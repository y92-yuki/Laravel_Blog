'use strict';

window.addEventListener('DOMContentLoaded',() => {

    const prefInfo = document.querySelector('#weatherInfo').dataset;
    const data = {
        pref_office: prefInfo.pref_office,
        pref: prefInfo.pref
    }
    fetch ('api/getForeCast',{
        method: "POST",
        headers: {
            "Content-Type": "application/json;"
        },
        body: JSON.stringify(data)
    })
    .then (res => res.text())
    .then(res => document.querySelector('#weatherInfo').insertAdjacentHTML('afterbegin',res))
    .catch(e => {
        console.error(e);
        const weatherInfo = document.querySelector('#weatherInfo');
        weatherInfo.textContent = '*天気データの取得に失敗しました';
        weatherInfo.classList.add('h5','text-danger');
    });
});