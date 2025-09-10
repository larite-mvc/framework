<?php

namespace Lumite\Foundation;

use Lumite\Support\DBQuery;
use Lumite\Support\Mailer;
use Lumite\Support\Routing\Router;
use Lumite\Support\Validation\Validation;

class Binding
{
    /**
     * @return void
     */
    public static function facades()
    {
        // Bind route facade
        app()->singleton('router', new Router());

        // Bind DB facade
        app()->singleton('db', new DBQuery());

        // Bind mail facade
        app()->singleton('mailer', new Mailer());

        // Bind validation facade
        app()->singleton('validator', new Validation());

    }
}