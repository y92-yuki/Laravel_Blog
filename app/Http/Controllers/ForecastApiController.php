<?php

namespace App\Http\Controllers;

use App\Services\Geocoding;
use App\Services\Forecast;
use Illuminate\Http\Request;

class ForecastApiController extends Controller
{
    //現在の天気情報を取得
    public function getForeCastApi(Request $request) {
        
        //ユーザーの登録した都道府県の緯度・経度を取得(App\Services\Geocoding)
        $geocoding = new Geocoding($request->locations, config('forecast.apikey'));
        $location = $geocoding->getGeocoding();

        //緯度・経度から現在の天気情報を取得(App\Services\Forecast)
        $forecast = new Forecast($location['lat'], $location['long'], config('forecast.apikey'));
        return $forecast->getForecast();
    }
}
