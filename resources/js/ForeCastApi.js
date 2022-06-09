'use strict';

window.addEventListener('DOMContentLoaded',() => {

    const prefInfo = document.querySelector('#weatherInfo').dataset;

    if (prefInfo.pref && prefInfo.pref_office) {
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
        .then(res => {

            //ForecastApiController.phpで例外が発生した場合はnullが戻り値
            if (!res) {
                return Promise.reject('error is ForcastApiController.php');
            }

            //天気情報の入ったviewを挿入
            document.querySelector('#weatherInfo').insertAdjacentHTML('afterbegin',res)
        })
        .catch(e => {
            console.error(e);
            const weatherInfo = document.querySelector('#weatherInfo');
            weatherInfo.textContent = '*天気データの取得に失敗しました';
            weatherInfo.classList.add('h5','text-danger');
        });
    } else {
        const weatherInfo = document.querySelector('#weatherInfo');
        weatherInfo.textContent = 'ログインするとここに登録地域の天気情報が表示されます';
        weatherInfo.classList.add('h5','mb-5','text-secondary');
    }
});