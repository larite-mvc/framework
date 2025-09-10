<?php

namespace Lumite\Database\Traits\Builder;

use Lumite\Database\ORMQueryBuilder;
use Lumite\Exception\Handlers\DBException;

trait StaticForwarding
{
    /**
     * @param $method
     * @param $parameters
     * @return mixed
     * @throws DBException
     */
    public static function __callStatic($method, $parameters)
    {
        $instance = new static();
        $builder = new ORMQueryBuilder($instance->table, $instance->hidden, static::class);

        if (method_exists($builder, $method)) {
            return $builder->$method(...$parameters);
        }

        throw new \Exception("Method {$method} does not exist on ORMQueryBuilder.");
    }
} 