<?php

namespace DatabaseMigrator\Instances;

/**
 * Class instance of migration, just holding data here
 */
class DBMigration
{
    public $name = null;
    public $query = null;

    public function __construct( $name, $query )
    {
        $this->name = $name;
        $this->query = $query;
    }
}