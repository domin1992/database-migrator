<?php

namespace DatabaseMigrator\Instances;

class DB_Migration
{
    public $name = null;
    public $query = null;

    public function __construct( $name, $query )
    {
        $this->name = $name;
        $this->query = $query;
    }
}