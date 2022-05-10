<?php
namespace App\Services;

use Illuminate\Support\Str;

Class Subtitle {

    public static function getSubtitles($value, $limitNum) {

        //$valueが配列ならforeachで全て加工
        if (is_array($value)) {
            $modifiedChar = [];
            foreach ($value as $val) {
                array_push($modifiedChar,Str::limit($val,$limitNum));
            }
            //変数なら通常通り加工
        } else {
            $modifiedChar = Str::limit($value,$limitNum);
        }
        
        return $modifiedChar;
    }
}