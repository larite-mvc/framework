<?php

namespace Lumite\Database\Traits\Builder;

use Lumite\Database\Contracts\QueryBuilderContract;
use Lumite\Database\ORMQueryBuilder;
use Lumite\Exception\Handlers\DBException;

trait Joins
{
    /**
     * @param $table
     * @param $column
     * @param $equal
     * @param $second_column
     * @return QueryBuilderContract
     * @throws DBException
     */
    public static function join($table, $column, $equal, $second_column): QueryBuilderContract
    {
        $instance = new static();
        return (new ORMQueryBuilder($instance->table, $instance->hidden))->join($table, $column, $equal, $second_column);
    }

    /**
     * @param $table
     * @param $column
     * @param $equal
     * @param $second_column
     * @return QueryBuilderContract
     * @throws DBException
     */
    public static function leftJoin($table, $column, $equal, $second_column): QueryBuilderContract
    {
        $instance = new static();
        return (new ORMQueryBuilder($instance->table, $instance->hidden))->leftJoin($table, $column, $equal, $second_column);
    }

    /**
     * @param $table
     * @param $column
     * @param $equal
     * @param $second_column
     * @return QueryBuilderContract
     * @throws DBException
     */
    public static function rightJoin($table, $column, $equal, $second_column): QueryBuilderContract
    {
        $instance = new static();
        return (new ORMQueryBuilder($instance->table, $instance->hidden))->rightJoin($table, $column, $equal, $second_column);
    }

    /**
     * @param $table
     * @param $column
     * @param $equal
     * @param $second_column
     * @return QueryBuilderContract
     * @throws DBException
     */
    public static function fullOuterJoin($table, $column, $equal, $second_column): QueryBuilderContract
    {
        $instance = new static();
        return (new ORMQueryBuilder($instance->table, $instance->hidden))->fullOuterJoin($table, $column, $equal, $second_column);
    }
}