<?php

namespace Lumite\Support\Blade;

class Runtime
{
    private static ?string $extends = null;
    private static array $sections = [];
    private static array $sectionStack = [];
    private static array $stacks = [];
    private static array $pushStack = [];

    public static function reset(): void
    {
        self::$extends = null;
        self::$sections = [];
        self::$sectionStack = [];
        self::$stacks = [];
        self::$pushStack = [];
    }

    public static function setExtends(string $view): void
    {
        self::$extends = trim($view, "'\"");
    }

    public static function getExtends(): ?string
    {
        return self::$extends;
    }

    public static function startSection(string $name): void
    {
        self::$sectionStack[] = $name;
        ob_start();
    }

    public static function endSection(): void
    {
        $content = ob_get_clean();
        $name = array_pop(self::$sectionStack);
        if ($name !== null) {
            self::$sections[$name] = $content;
        }
    }

    public static function section(string $name, string $default = ''): string
    {
        return self::$sections[$name] ?? $default;
    }

    public static function setSection(string $name, string $content): void
    {
        self::$sections[$name] = $content;
    }

    public static function push(string $name): void
    {
        self::$pushStack[] = $name;
        ob_start();
    }

    public static function endPush(): void
    {
        $content = ob_get_clean();
        $name = array_pop(self::$pushStack);
        if ($name !== null) {
            self::$stacks[$name][] = $content;
        }
    }

    public static function stack(string $name): string
    {
        if (!isset(self::$stacks[$name])) {
            return '';
        }
        return implode('', self::$stacks[$name]);
    }
}


