<?php

namespace Lumite\Support\Traits;

use Lumite\Support\ModelFactory;

trait Modelable
{
    public function model($model)
    {
        return ModelFactory::make($model);
    }
}