<?php

namespace Lumite\Support;

use Lumite\Database\Doctrine;

/**
 * Class ModelFactory
 *
 * Factory for loading and instantiating models, returning Doctrine instances.
 *
 * @package Lumite\Support
 */
class ModelFactory
{
    /**
     * Load and instantiate a model, returning a Doctrine instance.
     *
     * @param string $model The model name (e.g., 'User')
     * @return Doctrine
     */
    public static function make(string $model): Doctrine
    {
        $base = __DIR__ . '/../../';
        require_once($base . "app/models/" . $model . ".php");
        $model_array = explode('/', $model);
        $class = end($model_array);

        $model = new $class();
        return new Doctrine($model->table());
    }
} 