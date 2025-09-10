<?php

namespace Lumite\Console;

use Lumite\Scheduling\Schedule;

class BaseKernel
{
    protected array $commands = [];

    public function getCommands(): array
    {
        return $this->commands;
    }

    public function schedule(Schedule $schedule): void
    {
        // App\Console\Kernel can override this
    }
}


