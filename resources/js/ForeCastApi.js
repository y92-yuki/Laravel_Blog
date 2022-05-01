'use strict';

window.addEventListener('DOMContentLoaded',() => {
    //CSRFトークン
    const token = document.querySelector('meta[name=csrf-token]').content;
    //ログインユーザーの都道府県名
    const pref = document.querySelector('input[name=pref]').value;
    //県庁所在地
    const prefofficeLocation = document.querySelector('input[name=prefofficeLocation]').value;
    const data = {
        locations: prefofficeLocation
    };

    fetch ('/getForeCast',{
        method:"POST",
        headers: {
            "Content-type": "application/json",
            "X-CSRF-TOKEN": token,
        },
        body: JSON.stringify(data)
    })
    .then (res => res.json())
    .then(res => {
        //天気データを取得した時間
        const time = new Date(res.dt * 1000);
        const week = ['日','月','火','水','木','金','土'];
        const currentTime = {
            month: time.getMonth() + 1,
            date: time.getDate(),
            day: week[time.getDay()],
            hour: time.getHours(),
            min: String(time.getMinutes()).padStart(2,'0'),
        };

        //成型した時間データを挿入
        document.querySelector('.weatherTime').textContent = `${currentTime.month}月${currentTime.date}日(${currentTime.day})${currentTime.hour}時${currentTime.min}分現在：${pref}の天気`;

        //天気アイコン
        const weatherIcon = document.querySelector('.weatherIcon');
        weatherIcon.src = `weatherIcons/${res.weather[0].icon}.svg`;
        weatherIcon.style.width = '45px';

        //天気の説明
        document.querySelector('.description').textContent = res.weather[0].description;
        const tempIcon = document.querySelector('.tempIcon');

        //気温アイコン
        tempIcon.src = 'weatherIcons/thermometer.svg';
        tempIcon.style.width = '30px';

        //最高温度
        document.querySelector('.tempMax').textContent = `${Math.round(res.main.temp_max)}℃`;

        //最低温度
        document.querySelector('.tempMin').textContent = `${Math.round(res.main.temp_min)}℃`;
    })
    .catch(e => {
        console.error(e);
        const weatherInfo = document.querySelector('.weatherInfo');
        weatherInfo.textContent = '*天気データの取得に失敗しました';
        weatherInfo.classList.add('h5','text-danger');
    });
});