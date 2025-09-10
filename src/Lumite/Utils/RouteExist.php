<?php

namespace Lumite\Utils;

use Lumite\Support\IsRoute;
use Lumite\Support\Routing\RouteNotFount;

class RouteExist
{
    public function handle(): void
    {
        $route = IsRoute::verifyRoute();
        $uri = $_SERVER['REQUEST_URI'] ?? '';

        if (preg_match('#\.(css|js|png|jpg|jpeg|gif|svg|ico|woff|woff2|ttf|eot)$#i', $uri)) {
            // Skip not found logic for asset requests
            return;
        }

        if (!$route) {
            RouteNotFount::check();
        }
    }
}