<?php

namespace Lumite\Support;

use Lumite\Dotenv\Dotenv;

class LoadEnv
{
    public function __construct($path)
    {
        $dotenv = new Dotenv($path);
        $dotenv->load();
    }
}
