<?php
namespace Lumite\Database\Traits\Builder;

use Lumite\Database\QueryBuilder;
use Lumite\Exception\Handlers\DBException;
use Lumite\Support\Facades\DB;

/**
 * Trait OrmMethods
 * Provides model hydration helpers for ORM.
 */
trait OrmMethods
{
    /**
     * Hydrate a stdClass or array as a model instance
     */
    public static function hydrate($data)
    {
        if (empty($data)) {
            return null;
        }
        $model = new static();
        $model->attributes = (array) $data;
        $model->original = (array) $data;
        return $model;
    }

    /**
     * Hydrate an array of stdClass/array as model instances
     */
    public static function hydrateMany($rows)
    {
        $models = [];
        foreach ($rows as $row) {
            $models[] = static::hydrate($row);
        }
        return $models;
    }

    /**
     * Define a hasOne relationship.
     * @param mixed $related Related model class
     * @param string $foreignKey Foreign key on related model
     * @param string $localKey Local key on this model
     * @return QueryBuilder
     * @throws DBException
     */
    public function hasOne(mixed $related, string $foreignKey, string $localKey = 'id'): QueryBuilder
    {
        $instance = new $related();
        return (new QueryBuilder($instance->table, $instance->hidden, $related))
            ->where($foreignKey, '=', $this->$localKey);
    }

    /**
     * Define a hasMany relationship.
     * @param mixed $related Related model class
     * @param string $foreignKey Foreign key on related model
     * @param string $localKey Local key on this model
     * @return QueryBuilder
     * @throws DBException
     */
    public function hasMany(mixed $related, string $foreignKey, string $localKey = 'id')
    {
        $instance = new $related();
        return (new QueryBuilder($instance->table, $instance->hidden, $related))
            ->where($foreignKey, '=', $this->$localKey);
    }

    /**
     * Define a belongsTo relationship.
     * @param mixed $related Related model class
     * @param string $foreignKey Foreign key on this model
     * @param string $ownerKey Key on related model
     * @return QueryBuilder
     * @throws DBException
     */
    public function belongsTo(mixed $related, string $foreignKey, string $ownerKey = 'id')
    {
        $instance = new $related();
        return (new QueryBuilder($instance->table, $instance->hidden, $related))
            ->where($ownerKey, '=', $this->$foreignKey);
    }

    /**
     * Define a belongsToMany relationship (pivot table).
     * @param mixed $related Related model class
     * @param string $pivot Pivot table name
     * @param string $foreignPivotKey Foreign key on pivot table for this model
     * @param string $relatedPivotKey Foreign key on pivot table for related model
     * @param string $localKey Local key on this model
     * @param string $relatedKey Local key on related model
     * @return array Array of related model instances
     * @throws DBException
     */
    public function belongsToMany(mixed $related, string $pivot, string $foreignPivotKey, string $relatedPivotKey, string $localKey = 'id', string $relatedKey = 'id')
    {
        $instance = new $related();
        $pivotRows = DB::table($pivot)->where($foreignPivotKey, '=', $this->$localKey)->get();
        $relatedIds = array_map(function($row) use ($relatedPivotKey) { return $row->$relatedPivotKey; }, $pivotRows);
        if (empty($relatedIds)) return [];
        return (new QueryBuilder($instance->table, $instance->hidden, $related))
            ->whereIn($relatedKey, $relatedIds)
            ->get();
    }

}
