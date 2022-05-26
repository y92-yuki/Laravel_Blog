<?php

namespace App\Http\Controllers;

use App\Services\Forecast;
use Illuminate\Http\Request;

class ForecastApiController extends Controller
{
    //現在の天気情報を取得
    public function getForeCastApi(Request $request) {
        
        //ユーザーの登録した都道府県(県庁所在地)から現在の天気情報を取得してviewを返却(App\Services\Forecast)
        $weather = new Forecast($request->prefOffice);
        $forecasts = $weather->getForecast();
        $week = ['日','月','火','水','木','金','土'];
        $forecast = [
            'date' => date('Y年m月d日 H時i分',$forecasts['dt']),
            'week' => $week[date('w',$forecasts['dt'])],
            'pref' => $request->pref,
            'icon' => $forecasts['weather'][0]['icon'],
            'description' => $forecasts['weather'][0]['description'],
            'temp_max' => round($forecasts['main']['temp_max']),
            'temp_min' => round($forecasts['main']['temp_min'])
        ];

        return view('components.forecast',compact('forecast'));
    }
}
