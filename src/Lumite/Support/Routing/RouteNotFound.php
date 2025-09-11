<?php

namespace Lumite\Support\Routing;

use Lumite\Exception\Handlers\RouteNotFoundException;
use function abort;
use function config;

class RouteNotFound
{

    /**
     * @throws RouteNotFoundException
     */
    public static function check() {

        if (config("app.app_env") != "production") {
            throw new RouteNotFoundException("Your given route did not match");
        } else {
            abort(404);
        }
    }

}