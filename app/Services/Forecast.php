<?php

namespace App\Services;

use Exception;

class Forecast {
    protected $lat;
    protected $long;
    protected $apiKey;

    
    public function __construct($prefOffice) {
        $this->apiKey = config('forecast.apikey');
        $res = $this->getGeocoding($prefOffice);
        $this->lat = $res['lat'];
        $this->long = $res['long'];

    }

    protected function getGeocoding($location) {
        //地域名から緯度・経度を取得するためのAPI
        $locationURL = config('forecast.baseurl') . "geo/1.0/direct?q={$location},JP&appid={$this->apiKey}";

        try {
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

            //取得したURLの情報を配列へ変換
            $location = json_decode($locationJson,true);

            return [
                'lat' => $location[0]['lat'],
                'long' => $location[0]['lon'],
            ];
        } catch (Exception $e) {
            return json_encode($e->getMessage());
        }
    }

    public function getForecast() {
        //緯度・経度情報から天気予報を取得
        $foreCastURL = config('forecast.baseurl') . "data/2.5/weather?lat={$this->lat}&lon={$this->long}&appid={$this->apiKey}&lang=ja&units=metric";

        try {
            $ch = curl_init();

            $options = [
                CURLOPT_URL => $foreCastURL,
                CURLOPT_RETURNTRANSFER => true
            ];

            curl_setopt_array($ch,$options);

            $foreCast = curl_exec($ch);

            curl_close($ch);

            return json_decode($foreCast,true);
        } catch(Exception $e) {
            return json_encode($e->getMessage());
        }
    }
}