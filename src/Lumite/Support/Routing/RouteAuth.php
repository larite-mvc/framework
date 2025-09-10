<?php

namespace Lumite\Support\Routing;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Lumite\Support\Facades\Route;

class RouteAuth
{
    public static function load(array $disable = null)
    {
        // Stop access if user logged-in
        Route::group(['middleware' => 'guest'], function () use ($disable) {

            Route::get('login', [LoginController::class, 'index']);
            Route::post('login', [LoginController::class, 'login']);

            if (!($disable['register'] ?? false)) {
                Route::get('register', [RegisterController::class, 'register']);
                Route::post('register', [RegisterController::class, 'save']);
            }
        });

        // Open to call
        Route::get('logout', [LoginController::class, 'logout']);
    }

}

