<?php

namespace Lumite\Foundation;

use Lumite\Support\Blade\Compiler;
use Lumite\Support\Constants;
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

        // Bind blade facade
        app()->singleton('blade', function () {
            return new Compiler(Constants::BLADE_VIEW, Constants::STORAGE_VIEW);
        });

    }
}