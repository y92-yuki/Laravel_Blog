<?php
namespace App\Services;

use Exception;

class Geocoding {
    protected $apiKey;
    protected $pref;

    public function __construct($pref, $apiKey) {
        $this->pref = $pref;
        $this->apiKey = $apiKey;

    }

    public function getGeocoding() {
        //地域名から緯度・経度を取得するためのAPI
        $locationURL = "http://api.openweathermap.org/geo/1.0/direct?q={$this->pref},JP&appid={$this->apiKey}";

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
}