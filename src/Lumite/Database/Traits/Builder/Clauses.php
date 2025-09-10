<?php

namespace Lumite\Database\Traits\Builder;

use Lumite\Database\Contracts\QueryBuilderContract;
use Lumite\Database\ORMQueryBuilder;
use Lumite\Exception\Handlers\DBException;

trait Clauses
{
    /**
     * @param $column
     * @param null $operator
     * @param null $value
     * @return QueryBuilderContract
     * @throws DBException
     */
    public static function where($column, $operator = null, $value = null): QueryBuilderContract
    {
        $instance = new static();
        return (new ORMQueryBuilder($instance->table, $instance->hidden, static::class))->where(...func_get_args());
    }

    /**
     * @param $column
     * @param null $operator
     * @param null $value
     * @return QueryBuilderContract
     * @throws DBException
     */
    public static function orWhere($column, $operator = null, $value = null): QueryBuilderContract
    {
        $instance = new static();
        return (new ORMQueryBuilder($instance->table, $instance->hidden, static::class))->orWhere(...func_get_args());
    }

    /**
     * @param $column
     * @param $value
     * @return QueryBuilderContract
     * @throws DBException
     */
    public static function whereIn($column, $value): QueryBuilderContract
    {
        $instance = new static();
        return (new ORMQueryBuilder($instance->table, $instance->hidden, static::class))->whereIn($column, $value);
    }

    /**
     * @param $column
     * @return QueryBuilderContract
     * @throws DBException
     */
    public static function whereNull($column): QueryBuilderContract
    {
        $instance = new static();
        return (new ORMQueryBuilder($instance->table, $instance->hidden, static::class))->whereNull($column);
    }

    /**
     * @param $column
     * @return QueryBuilderContract
     * @throws DBException
     */
    public static function whereNotNull($column): QueryBuilderContract
    {
        $instance = new static();
        return (new ORMQueryBuilder($instance->table, $instance->hidden, static::class))->whereNotNull($column);
    }

    /**
     * @param $column
     * @param $operator
     * @param $date
     * @return QueryBuilderContract
     * @throws DBException
     */
    public static function whereDate($column, $operator = null, $date = null): QueryBuilderContract
    {
        $instance = new static();
        return (new ORMQueryBuilder($instance->table, $instance->hidden, static::class))->whereDate(...func_get_args());
    }

    /**
     * @param $column
     * @param $operator
     * @param $value
     * @return QueryBuilderContract
     * @throws DBException
     */
    public static function orWhereDate($column, $operator = null, $value = null): QueryBuilderContract
    {
        $instance = new static();
        return (new ORMQueryBuilder($instance->table, $instance->hidden, static::class))->orWhereDate(...func_get_args());
    }

    /**
     * @param $column
     * @param $operator
     * @param $day
     * @return ORMQueryBuilder
     * @throws DBException
     */
    public static function whereDay($column, $operator = null, $day = null): ORMQueryBuilder
    {
        $instance = new static();
        return (new ORMQueryBuilder($instance->table, $instance->hidden, static::class))->whereDay(...func_get_args());
    }

    /**
     * @param $column
     * @param $operator
     * @param $day
     * @return ORMQueryBuilder
     * @throws DBException
     */
    public static function whereDayOfWeek($column, $operator = null, $day = null): ORMQueryBuilder
    {
        $instance = new static();
        return (new ORMQueryBuilder($instance->table, $instance->hidden, static::class))->whereDayOfWeek(...func_get_args());
    }

    /**
     * @param $column
     * @param $operator
     * @param $time
     * @return ORMQueryBuilder
     * @throws DBException
     */
    public static function whereTime($column, $operator = null, $time = null): ORMQueryBuilder
    {
        $instance = new static();
        return (new ORMQueryBuilder($instance->table, $instance->hidden, static::class))->whereTime(...func_get_args());
    }

    /**
     * @param $column
     * @param $operator
     * @param $month
     * @return QueryBuilderContract
     * @throws DBException
     */
    public static function whereMonth($column, $operator = null, $month = null): QueryBuilderContract
    {
        $instance = new static();
        return (new ORMQueryBuilder($instance->table, $instance->hidden, static::class))->whereMonth(...func_get_args());
    }

    /**
     * @param $column
     * @param $operator
     * @param $year
     * @return QueryBuilderContract
     * @throws DBException
     */
    public static function whereYear($column, $operator = null, $year = null): QueryBuilderContract
    {
        $instance = new static();
        return (new ORMQueryBuilder($instance->table, $instance->hidden, static::class))->whereYear(...func_get_args());
    }

    /**
     * @param $column
     * @param $values
     * @return QueryBuilderContract
     * @throws DBException
     */
    public static function whereBetween($column, $values): QueryBuilderContract
    {
        $instance = new static();
        return (new ORMQueryBuilder($instance->table, $instance->hidden, static::class))->whereBetween(...func_get_args());
    }

    /**
     * @param $column
     * @param $values
     * @return QueryBuilderContract
     * @throws DBException
     */
    public static function whereNotBetween($column, $values): QueryBuilderContract
    {
        $instance = new static();
        return (new ORMQueryBuilder($instance->table, $instance->hidden, static::class))->whereNotBetween(...func_get_args());
    }

    /**
     * @param $column
     * @param $values
     * @return QueryBuilderContract
     * @throws DBException
     */
    public static function orWhereBetween($column, $values): QueryBuilderContract
    {
        $instance = new static();
        return (new ORMQueryBuilder($instance->table, $instance->hidden, static::class))->orWhereBetween(...func_get_args());
    }

    /**
     * @param $column
     * @param $values
     * @return QueryBuilderContract
     * @throws DBException
     */
    public static function orWhereNotBetween($column, $values): QueryBuilderContract
    {
        $instance = new static();
        return (new ORMQueryBuilder($instance->table, $instance->hidden, static::class))->orWhereNotBetween(...func_get_args());
    }

    /**
     * @param $column
     * @param $condition
     * @param $value
     * @return QueryBuilderContract
     * @throws DBException
     */
    public static function having($column, $condition, $value): QueryBuilderContract
    {
        $instance = new static();
        return (new ORMQueryBuilder($instance->table, $instance->hidden, static::class))->having($column, $condition, $value);
    }
}