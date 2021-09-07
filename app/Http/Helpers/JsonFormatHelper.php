<?php

namespace App\Http\Helpers;

class JsonFormatHelper
{
    public static function removeSlashes(string $input){
        if($input)
            return str_replace("\\", "", $input);
        else return "";
    }
}
