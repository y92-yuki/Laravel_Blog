<?php

namespace App\Services;

use Exception;
use GuzzleHttp\Client;

class Forecast {
    protected $apiKey;
    protected $client;
    protected $lat;
    protected $long;

    
    public function __construct($prefOffice) {
        $this->apiKey = config('forecast.apikey');
        $this->client = new Client([
            'base_uri' => config('forecast.baseurl')
        ]);
        $res = $this->getGeocoding($prefOffice);
        $this->lat = $res['lat'];
        $this->long = $res['long'];

    }

    protected function getGeocoding($location) {
        //地域名から緯度・経度を取得するためのAPI
        $locationURL = "geo/1.0/direct?q={$location},JP&appid={$this->apiKey}";

        try {
            //URLとmethodの指定
            $response = $this->client->get($locationURL);

            //URLの情報を取得して配列へ変換
            $location = json_decode($response->getBody(),true);
            
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
        $foreCastURL = "data/2.5/weather?lat={$this->lat}&lon={$this->long}&appid={$this->apiKey}&lang=ja&units=metric";

        try {
            $response = $this->client->get($foreCastURL);
            
            return json_decode($response->getBody(),true);
        } catch(Exception $e) {
            return json_encode($e->getMessage());
        }
    }
}