<?php
namespace App\Services;

use Image;

class RegisterImage {
    protected $path;
    protected $save_path;

    public function __construct($file_name, $user_id) {
        $this->path = time() . '_' . mt_rand() . '_' . $file_name;
        $this->save_path = storage_path('app/public/' . $user_id . '/' . $this->path);
    }

    public function getPath() {
        return $this->path;
    }

    public function resizeRegisterImage($file,$width) {
        $image = Image::make($file);
        $image->resize($width,null,function($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $image->save($this->save_path);
    }
}