<?php

namespace Lumite\Support;

use Closure;
use Lumite\Mailer\Exception;
use Lumite\Support\Mailing\SendMail;

class Mailer
{
    /**
     * @param $view
     * @param $data
     * @param Closure $closure
     * @return bool
     * @throws Exception
     */
    public static function send($view, $data, Closure $closure): bool
    {
        $mail = new SendMail (
            $view,
            $data
        );
         $closure (
             $mail
         );

        return $mail->sendMail();
    }

}