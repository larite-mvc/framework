<?php

namespace Lumite\Console;

use Symfony\Component\Console\Application as SymfonyApp;
use Lumite\Foundation\Application;
use Lumite\Commands\Executor\Commander;

class ConsoleKernel
{
    protected Application $app;

    public function __construct(Application $app)
    {
        $this->app = $app;

        require_once __DIR__ . '/../Utils/helpers.php';
        require_once __DIR__ . '/../Migrations/Migrate.php';
        require_once __DIR__ . '/../Migrations/Blueprint.php';
    }

    public function handle(): int
    {
        $symfony = new SymfonyApp(
            "Welcome to " . Application::framework() .
            " by Kashif Sohail, Version: " . Application::version()
        );

        // Register all commands
        $commander = new Commander($symfony);
        $command   = $commander->register();

        // Important: still call init() but via kernel
        $this->app->init($command);

        return $symfony->run();
    }
}
