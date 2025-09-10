<?php

use Lumite\Migrations\Blueprint;
use Lumite\Migrations\Migrate;

class migrationname extends Migrate
{
    public function up()
    {
         Migrate::create('table_name', function (Blueprint $table) {
             $table->increments('id');
             $table->timestamps();
         });
    }

    public function down()
    {
        Migrate::drop('table_name');
    }
} 