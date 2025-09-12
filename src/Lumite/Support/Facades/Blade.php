<?php

namespace Lumite\Support\Facades;

use Closure;

/**
 * @method static \Lumite\Support\Facades\Blade directive(string $name, callable $compiler)
 */
class Blade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'blade';
    }
}