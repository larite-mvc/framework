<?php

namespace Lumite\Exception;

use Closure;
use Lumite\Exception\Handlers\SimpleException;
use Exception;
use Throwable;

trait ExceptionDispatcher
{
    protected array $handlers = [];

    protected bool $debug;

    public function __construct(bool $debug = false)
    {
        $this->debug = $debug;
    }

    /**
     * @throws Exception
     */
    public function render(Throwable $e, Closure $closure)
    {
        if (!$this->exception) {
            return $closure($e);
        }

        throw new SimpleException($e);
    }

    /**
     * @param Throwable $e
     * @return void
     */
    public function handle(Throwable $e): void
    {
        if ($this->debug) {
            $response = $this->dispatch($e);
            if ($response === null) {
                $this->renderDefault($e);
            }
        } else {
            $this->renderJson("Something went wrong.", 500);
        }
    }

    /**
     * @param Throwable $e
     * @return mixed
     */
    protected function dispatch(Throwable $e): mixed
    {
        foreach ($this->handlers as $class => $handler) {
            if ($e instanceof $class) {
                return $handler($e);
            }
        }

        return null;
    }

    /**
     * @param Throwable $e
     * @return void
     */
    protected function renderDefault(Throwable $e): void
    {
        http_response_code($e->getCode() >= 400 ? $e->getCode() : 500);

        echo "<h1>" . get_class($e) . "</h1>";
        echo "<p>" . $e->getMessage() . "</p>";
        echo "<pre>" . $e->getTraceAsString() . "</pre>";
    }

    /**
     * @param $message
     * @param int $code
     * @return void
     */
    protected function renderJson($message, int $code): void
    {
        header('Content-Type: application/json', true, $code);

        echo json_encode([
            'message' => $message,
            'status' => $code,
        ]);

        exit;
    }
}
