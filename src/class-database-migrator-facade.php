<?php

namespace DatabaseMigrator;

use DatabaseMigrator\Instances\DB_Migration;

class Database_Migrator_Facade
{
    public static function cli_init()
    {
        \WP_CLI::add_command( 'db-migrate', DB_Migrate::class );
    }

    public static function add_migration( $name, $query )
    {
        add_filter( 'db_migrator_migration', function( $migrations ) use ($name, $query) {
            array_merge(
                $migrations,
                new DB_Migration(
                    $name,
                    $query
                )
            );
        } );
    }
}