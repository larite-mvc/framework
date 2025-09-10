<?php

namespace Lumite\Support;

class Captcha
{

    public static function verify($captcha){
       return verifyCaptcha($captcha);
    }

    public static function get(){
        return captcha();
    }

}