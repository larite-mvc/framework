<?php

namespace Lumite\Support\Routing;

use Lumite\Exception\Handlers\CsrfException;
use Lumite\Exception\Handlers\MiddlewareException;
use Lumite\Exception\Handlers\RouteNotFoundException;
use Lumite\Support\IsRoute;
use Lumite\Support\Traits\Csrf\CsrfToken;
use Lumite\Support\Traits\Middleware;

class RouteExecutor
{
    use CsrfToken, Middleware;

    /**
     * @param $incomingMethod
     * @param $currentAction
     * @param $routeHandlers
     * @param $dynamicRoutes
     * @param $routeMiddleware
     * @return bool
     * @throws \Exception
     */
    public static function execute($incomingMethod, $currentAction, $routeHandlers, $dynamicRoutes, $routeMiddleware): bool
    {
        // Get the actual HTTP method (handles _method parameter for PUT, PATCH, DELETE)
        $actualMethod = static::getActualMethod($incomingMethod);
        $routeKey = $actualMethod . ':' . $currentAction;

        if (isset($routeHandlers[$routeKey])) {
            return static::handleStaticRoute($routeHandlers[$routeKey], $routeKey, $actualMethod, $routeMiddleware);
        }

        // To check if route method is not exists (wrong method)
        MethodChecker::check($actualMethod, $currentAction, $routeHandlers);

        return static::handleDynamicRoutes($actualMethod, $currentAction, $dynamicRoutes[$actualMethod] ?? []);
    }

    /**
     * Get the actual HTTP method, handling _method parameter for PUT, PATCH, DELETE
     * @param string $incomingMethod
     * @return string
     */
    private static function getActualMethod(string $incomingMethod): string
    {
        // If it's a POST request, check for _method parameter
        if ($incomingMethod === 'POST' && isset($_POST['_method'])) {
            $method = strtoupper($_POST['_method']);
            if (in_array($method, ['PUT', 'PATCH', 'DELETE'])) {
                return $method;
            }
        }

        return $incomingMethod;
    }

    /**
     * @param array $handler
     * @param string $routeKey
     * @param string $incomingMethod
     * @param array $routeMiddleware
     * @return bool
     * @throws CsrfException
     * @throws RouteNotFoundException
     * @throws MiddlewareException|\ReflectionException
     */
    private static function handleStaticRoute(array $handler, string $routeKey, string $incomingMethod, array $routeMiddleware): bool
    {
        $mwResult = static::runMiddlewareChecks($handler['middleware'] ?? [], $routeMiddleware[$routeKey] ?? []);
        if ($mwResult !== true) {
            // If middleware returned a response-like value, emit/echo if stringable, else assume it already handled output
            if (is_string($mwResult)) {
                echo $mwResult;
            }
            return true;
        }

        if ($incomingMethod === 'POST' || $incomingMethod === 'PUT' || $incomingMethod === 'PATCH' || $incomingMethod === 'DELETE') {
            static::checkCsrf();
        }

        if (isset($handler['controller']['closure'])) {
            echo $handler['controller']['closure']();
        } else {
            static::invokeController($handler['namespace'], $handler['controller']);
        }

        IsRoute::checkRoute(true);
        return true;
    }

    /**
     * @param string $incomingMethod
     * @param string $currentAction
     * @param array $routes
     * @return bool
     * @throws CsrfException
     * @throws RouteNotFoundException
     * @throws MiddlewareException|\ReflectionException
     */
    private static function handleDynamicRoutes(string $incomingMethod, string $currentAction, array $routes): bool
    {
        foreach ($routes as $route) {
            if (preg_match($route['regex'], $currentAction, $matches)) {
                array_shift($matches);

                $mwResult = static::runMiddlewareChecks($route['middleware'] ?? []);
                if ($mwResult !== true) {
                    if (is_string($mwResult)) {
                        echo $mwResult;
                    }
                    return true;
                }

                if ($incomingMethod === 'POST' || $incomingMethod === 'PUT' || $incomingMethod === 'PATCH' || $incomingMethod === 'DELETE') {
                    static::checkCsrf();
                }

                static::invokeController($route['namespace'], $route['controller'], $matches);
                IsRoute::checkRoute(true);
                return true;
            }
        }

        return false;
    }

    /**
     * @param array|string $handlerMiddleware
     * @param array $routeMiddleware
     * @return bool
     * @throws MiddlewareException
     */
    private static function runMiddlewareChecks(array|string $handlerMiddleware = [], array $routeMiddleware = [])
    {
        $res1 = static::getMiddleware($handlerMiddleware);
        if ($res1 !== true) {
            return $res1;
        }
        $res2 = static::getMiddleware($routeMiddleware);
        return $res2;
    }

    /**
     * @param string|null $namespace
     * @param array $controller
     * @param array $params
     * @return void
     * @throws RouteNotFoundException
     * @throws \ReflectionException
     */
    private static function invokeController(?string $namespace, array $controller, array $params = []): void
    {
        [$controllerClass, $methodName] = $controller;
        if (!$methodName) {
            throw new RouteNotFoundException("Please specify a method.");
        }

        $fqcn = $namespace ? $namespace . '\\' . $controllerClass : $controllerClass;

        RouteCaller::call($fqcn, $methodName, $params);
    }

}

