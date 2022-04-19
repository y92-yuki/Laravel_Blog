<?php
namespace App\Services;

use Image;

class RegisterImage {

    public static function resizeRegisterImage($file,$width,$save_path) {
        $image = Image::make($file);
        $image->resize($width,null,function($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $image->save($save_path);
    }
}