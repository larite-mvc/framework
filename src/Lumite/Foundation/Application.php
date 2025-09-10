<?php

namespace Lumite\Foundation;

use App\Exceptions\Handler;
use Lumite\Support\AssetsNotFound;
use Lumite\Support\LoadEnv;
use Lumite\Support\Facades\Route;
use Lumite\Support\Routing\RegisterAllRoutes;
use Lumite\Support\Container\App as Container;
use Lumite\Exception\Handlers\MiddlewareException;
use Lumite\Exception\Handlers\RouteNotFoundException;
use Lumite\Exception\Log;
use Lumite\Exception\Whoops;
use Lumite\Utils\RouteExist;

class Application
{
    const VERSION = '4.0.0';
    const FRAMEWORK = 'Larite';

    protected Container $container;

    protected array $configFiles = [
        'common' => [
            'app',
        ],
        'http' => [
            'mail',
        ],
        'cli' => [],
    ];

    protected array $notFound = [
        'routeExist' => RouteExist::class,
    ];

    public function __construct(Container $container = null)
    {
        $this->container = $container ?? new Container();
    }

    public static function version(): string
    {
        return static::VERSION;
    }

    public static function framework(): string
    {
        return static::FRAMEWORK;
    }

    public function get($key)
    {
        return $this->container->make($key);
    }

    public function boot(): void
    {
        $this->registerSingletons();

        if (config('app.app_env') !== 'production') {
            $this->registerExceptionHandler();
        }
    }

    protected function getConfigFiles(): array
    {
        $files = $this->configFiles['common'];
        if ($this->isCli()) {
            $files = array_merge($files, $this->configFiles['cli']);
        } else {
            $files = array_merge($files, $this->configFiles['http']);
        }
        return array_map(fn($file) => __DIR__ . '/../config/' . $file . '.php', $files);
    }

    protected function registerSingletons(): void
    {
        if (!file_exists( ROOT_PATH .'/.env')) {
            $this->registerBootstrapSingleton('whoops', [Whoops::class, 'handler']);
            $this->registerBootstrapSingleton('dotenv', LoadEnv::class, [ROOT_PATH]);
        } else {
            $this->registerBootstrapSingleton('dotenv', LoadEnv::class, [ROOT_PATH]);
            $this->registerBootstrapSingleton('whoops', [Whoops::class, 'handler']);
        }

        if (!$this->isCli()) {
            $this->registerBootstrapSingleton('assetsNotFound', [AssetsNotFound::class, 'run']);
        }
    }

    protected function isCli(): bool
    {
        return PHP_SAPI === 'cli';
    }

    protected function registerBootstrapSingleton(string $key, mixed $concrete, array $args = [])
    {
        $instance = null;
        if (is_array($concrete) && isset($concrete[0], $concrete[1])) {
            $class = $concrete[0];
            $method = $concrete[1];
            $instance = $class::$method(...$args);
        } elseif (is_string($concrete) && class_exists($concrete)) {
            $reflection = new \ReflectionClass($concrete);
            $instance = $reflection->newInstanceArgs($args);
        } else {
            $instance = $concrete;
        }
        $this->container->singleton($key, $instance);
    }

    public function init($commander = null): bool
    {
        Binding::facades();
        $this->registerServiceProviders();
        RegisterAllRoutes::loadAll();

        $commander?->run();

        $routeMatched = false;
        try {
            $routeMatched = Route::executeRoutes();
        } catch (MiddlewareException | RouteNotFoundException $e) {
            Log::error($e, "Not Found Exception");
            throw new MiddlewareException($e->getMessage());
        }

        if (!$routeMatched) {
            $routeExistClass = $this->notFound['routeExist'];
            (new $routeExistClass())->handle();
        }

        return true;
    }

    protected function registerExceptionHandler(): void
    {
        $handler = new Handler(!(config('app.app_env') === 'production'));
        set_exception_handler([$handler, 'handle']);
    }

    protected function registerServiceProviders(): void
    {
        $providers = config('providers');
        foreach ($providers as $providerClass) {
            $provider = new $providerClass($this->container);
            if (method_exists($provider, 'register')) {
                $provider->register();
            }
            if (method_exists($provider, 'boot')) {
                $provider->boot();
            }
        }
    }
}
