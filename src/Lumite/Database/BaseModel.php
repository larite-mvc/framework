<?php
namespace Lumite\Database;

use Lumite\Database\Traits\Builder\Arrayable;
use Lumite\Database\Traits\Builder\ORMBuilder;
use Lumite\Database\Traits\Builder\OrmMethods;
use Lumite\Database\Traits\Builder\Relational;
use Lumite\Database\Traits\Builder\StaticForwarding;
use Lumite\Database\Traits\Timestampable;

/**
 * Base ORM Model
 *
 * @property int $id
 */
class BaseModel
{
    use ORMBuilder,
        StaticForwarding,
        OrmMethods,
        Relational,
        Arrayable,
        Timestampable;
}