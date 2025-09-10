<?php

namespace Lumite\Support\Routing;

use App\Providers\RouteServiceProvider;

class RegisterAllRoutes
{
    /**
     * Since all service providers are loading in Application.php on init
     * so now need to re load here
     * @return void
     */
    public static function loadAll()
    {
        $routeFiles = app('routes'); // now resolves successfully
        foreach ($routeFiles as $file) {
            require_once ROOT_PATH . '/' . $file;
        }
    }
} 