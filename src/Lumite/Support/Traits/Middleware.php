<?php

namespace Lumite\Support\Traits;

use App\Http\Kernel;
use Lumite\Exception\Handlers\MiddlewareException;
use Lumite\Support\Request;

trait Middleware
{
    /**
     * @param $middlewares
     * @return bool
     * @throws MiddlewareException
     */

    public static function getMiddleware($middlewares): bool
    {
        $kernel = new Kernel();
        $request = new Request();

        $middlewares = is_array($middlewares) ? $middlewares : [$middlewares];

        $pipeline = array_reverse($middlewares); // reversed so next() works properly

        $next = function ($req) {
            return true;
        };

        foreach ($pipeline as $middlewareKey) {

            if (!isset($kernel->routeMiddleware[$middlewareKey])) {
                throw new MiddlewareException("Your given middleware did not match: $middlewareKey");
            }

            $middlewareClass = new $kernel->routeMiddleware[$middlewareKey]();

            $currentNext = $next;
            $next = function ($req) use ($middlewareClass, $currentNext) {
                return $middlewareClass->handle($req, $currentNext);
            };
        }

        $result = $next($request);

        // If middleware returned a Redirect/Response or any non-true value, bubble it up
        if ($result === true) {
            return true;
        }

        return $result;
    }

    /**
     * @param $middlewares
     * @return void
     * @throws MiddlewareException
     */
    public function middleware($middlewares)
    {
        try {
            if (!static::getMiddleware($middlewares)) {
                exit;
            }
        } catch (MiddlewareException $e) {
            throw $e;
        }
    }

}