<?php

namespace Lumite\Support\Facades;

use Closure;

/**
 * @method static \Lumite\Support\Routing\RouteBuilder get(string $uri, \Closure|array|string|null $action = null)
 * @method static \Lumite\Support\Routing\RouteBuilder post(string $uri, \Closure|array|string|null $action = null)
 * @method static \Lumite\Support\Routing\RouteBuilder put(string $uri, \Closure|array|string|null $action = null)
 * @method static \Lumite\Support\Routing\RouteBuilder delete(string $uri, \Closure|array|string|null $action = null)
 * @method static \Lumite\Support\Routing\RouteBuilder patch(string $uri, \Closure|array|string|null $action = null)
 * @method static mixed group($options, Closure $callback)
 * @method static mixed prefix($prefix)
 * @method static mixed middleware($middleware)
 * @method static mixed namespace($namespace)
 * @method static void authenticate(array $disable = null)
 * @method static bool checkMethodNotAllowed()
 * @method static bool executeRoutes()
 * @method static void addRouteMiddleware($routeKey, $middleware)
 * @method static void resource(string $name, string $controller, array $options = [])
 * @method static string getNamedRoute(string $name, array $parameters = [])
 * @method static array getNamedRoutes()
 *
 * @see \Lumite\Support\Routing\Router
 */
class Route extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'router';
    }
}