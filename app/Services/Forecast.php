<?php

namespace App\Services;

use Exception;
use GuzzleHttp\Client;

class Forecast {
    protected $api_key;
    protected $client;
    protected $lat;
    protected $long;

    
    public function __construct($pref_office) {
        $this->api_key = config('forecast.apikey');
        $this->client = new Client([
            'base_uri' => config('forecast.baseurl')
        ]);
        $res = $this->getGeocoding($pref_office);
        $this->lat = $res['lat'];
        $this->long = $res['long'];

    }

    protected function getGeocoding($location) {
        //地域名から緯度・経度を取得するためのAPI
        $location_URL = "geo/1.0/direct?q={$location},JP&appid={$this->api_key}";

        try {
            //URLとmethodの指定
            $response = $this->client->get($location_URL);

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
        $foreCast_URL = "data/2.5/weather?lat={$this->lat}&lon={$this->long}&appid={$this->api_key}&lang=ja&units=metric";

        try {
            $response = $this->client->get($foreCast_URL);
            
            return json_decode($response->getBody(),true);
        } catch(Exception $e) {
            return json_encode($e->getMessage());
        }
    }
}