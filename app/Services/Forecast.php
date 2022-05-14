<?php
namespace App\Services;

use Exception;

class Forecast {
    protected $lat;
    protected $long;
    protected $apiKey;

    public function __construct($lat, $long, $apiKey) {
        $this->lat = $lat;
        $this->long = $long;
        $this->apiKey = $apiKey;
    }

    public function getForecast() {
        //緯度・経度情報から天気予報を取得
        $foreCastURL = "https://api.openweathermap.org/data/2.5/weather?lat={$this->lat}&lon={$this->long}&appid={$this->apiKey}&lang=ja&units=metric";

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