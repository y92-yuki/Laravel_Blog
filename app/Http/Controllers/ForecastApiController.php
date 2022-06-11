<?php

namespace App\Http\Controllers;

use App\Services\Forecast;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ForecastApiController extends Controller
{
    //現在の天気情報を取得
    public function getForeCastApi(Request $request) {
        
        try {
            //ユーザーの登録した都道府県(県庁所在地)から現在の天気情報を取得してviewを返却(App\Services\Forecast)
            $weather = new Forecast($request->pref_office);
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
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return null;
        }
    }
}