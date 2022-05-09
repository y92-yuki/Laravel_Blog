<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class ForecastApiController extends Controller
{
    public function getForeCastApi(Request $request) {
        //OpenWeatherのAPI Key
        $apiKey = config('forecast.apikey');
        //ログインユーザーの登録地域
        $pref = $request->locations;
        //地域名から緯度・経度を取得するためのAPI
        $locationURL = "http://api.openweathermap.org/geo/1.0/direct?q={$pref},JP&appid={$apiKey}";
        
        //cURLセッションの初期化
        $ch = curl_init();

        //URLとオプションの指定
        $options = [
            CURLOPT_URL => $locationURL,
            CURLOPT_RETURNTRANSFER => true
        ];

        curl_setopt_array($ch,$options);

        //URLの情報を取得(JSON)
        $locationJson = curl_exec($ch);
        curl_close($ch);

        $location = json_decode($locationJson,true);
        $lat = $location[0]['lat'];
        $long = $location[0]['lon'];


        //取得した緯度・経度情報から天気予報を取得
        $foreCastURL = "https://api.openweathermap.org/data/2.5/weather?lat={$lat}&lon={$long}&appid={$apiKey}&lang=ja&units=metric";

        try {
            $ch = curl_init();

            $options = [
                CURLOPT_URL => $foreCastURL,
                CURLOPT_RETURNTRANSFER => true
            ];

            curl_setopt_array($ch,$options);

            $foreCast = curl_exec($ch);

            curl_close($ch);

            return $foreCast;
        } catch(Exception $e) {
            return json_encode($e->getMessage());
        }
        
    }
}
