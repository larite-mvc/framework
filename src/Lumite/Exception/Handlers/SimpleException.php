<?php

namespace Lumite\Exception\Handlers;

use Exception;
use Throwable;

class SimpleException extends Exception
{
    protected string $shortMessage;
    protected string $file;
    protected int $line;
    protected string $trace;

    public function __construct(Throwable $e)
    {
        $this->shortMessage = $e->getMessage();
        $this->file = $e->getFile();
        $this->line = $e->getLine();
        $this->trace = $e->getTraceAsString();

        parent::__construct($this->shortMessage, (int) $e->getCode(), $e);
    }

    /**
     * Format the file path to remove vendor/root prefix
     * and keep only "Namespace/Path/File.php"
     */
    protected function formatPath(string $path): string
    {
        // Normalize slashes for cross-platform
        $path = str_replace('\\', '/', $path);

        // Look for "Lumite/" or "App/" or other namespaces
        $namespaces = ['Lumite/', 'App/'];
        foreach ($namespaces as $ns) {
            if (($pos = strpos($path, $ns)) !== false) {
                return substr($path, $pos);
            }
        }

        // Default: return original
        return $path;
    }

    public function __toString(): string
    {
        return sprintf(
            "Exception: %s\nFile: %s\nLine: %d\n",
            $this->getMessage(),
            $this->formatPath($this->getFile()),
            $this->getLine()
        );
    }
}
