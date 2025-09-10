<?php

namespace Lumite\Support\Facades;

/**
 * @method static \Lumite\Support\Facades\DB table($table): QueryBuilder
 * @method static \Lumite\Support\Facades\DB rawQuery($sql)
 * @method static \Lumite\Support\Facades\DB paginate($limit)
 * @method static \Lumite\Support\Facades\DB simplePaginate($limit)
 * @method static \Lumite\Support\Facades\DB get()
 * @method static \Lumite\Support\Facades\DB all()
 * @method static \Lumite\Support\Facades\DB first()
 * @method static \Lumite\Support\Facades\DB value(string $column)
 * @method static \Lumite\Support\Facades\DB firstOrFail()
 * @method static \Lumite\Support\Facades\DB find($id)
 * @method static \Lumite\Support\Facades\DB pluck($columns)
 * @method static \Lumite\Support\Facades\DB increment($column, int|string $value = 1)
 * @method static \Lumite\Support\Facades\DB decrement($column, int|string $value = 1)
 * @method static \Lumite\Support\Facades\DB exists()
 * @method static \Lumite\Support\Facades\DB count(string $column = "*")
 * @method static \Lumite\Support\Facades\DB sum($column)
 * @method static \Lumite\Support\Facades\DB max($column)
 * @method static \Lumite\Support\Facades\DB min($column)
 * @method static \Lumite\Support\Facades\DB create(array $data)
 * @method static \Lumite\Support\Facades\DB insert($data)
 * @method static \Lumite\Support\Facades\DB insertGetId($data)
 * @method static \Lumite\Support\Facades\DB updateOrCreate(array $attributes, array $values)
 * @method static \Lumite\Support\Facades\DB update($fields)
 * @method static \Lumite\Support\Facades\DB delete()
 * @method static \Lumite\Support\Facades\DB truncate()
 * @method static \Lumite\Support\Facades\DB join($table, $column, $equal, $second_column)
 * @method static \Lumite\Support\Facades\DB leftJoin($table, $column, $equal, $second_column)
 * @method static \Lumite\Support\Facades\DB rightJoin($table, $column, $equal, $second_column)
 * @method static \Lumite\Support\Facades\DB fullOuterJoin($table, $column, $equal, $second_column)
 * @method static \Lumite\Support\Facades\DB select()
 * @method static \Lumite\Support\Facades\DB orderBy($field, string $order = 'ASC')
 * @method static \Lumite\Support\Facades\DB orderByDesc($field)
 * @method static \Lumite\Support\Facades\DB limit($limit)
 * @method static \Lumite\Support\Facades\DB latest($column)
 * @method static \Lumite\Support\Facades\DB oldest($column)
 * @method static \Lumite\Support\Facades\DB groupBy($fields)
 * @method static \Lumite\Support\Facades\DB take($take)
 * @method static \Lumite\Support\Facades\DB offset($offset)
 * @method static \Lumite\Support\Facades\DB where($column, $operator = null, $value = null)
 * @method static \Lumite\Support\Facades\DB orWhere($column, $operator, $value)
 * @method static \Lumite\Support\Facades\DB whereIn($column, array $values)
 * @method static \Lumite\Support\Facades\DB whereNull($column)
 * @method static \Lumite\Support\Facades\DB whereNotNull($column)
 * @method static \Lumite\Support\Facades\DB  having($column, $operator, $value)
 */

class DB extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'db';
    }
}