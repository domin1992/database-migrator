<?php

namespace DatabaseMigrator;

use DatabaseMigrator\Instances\DB_Migration;

class Database_Migrator_Facade
{
    /**
     * Initializes Database Migrator
     * 
     * simply add to your functions.php:
     * add_action( 'cli_init', [\DatabaseMigrator\Database_Migrator_Facade::class, 'cli_init'] );
     */
    public static function cli_init()
    {
        \WP_CLI::add_command( 'db-migrate', DB_Migrate::class );
    }

    /**
     * Adds migration
     * 
     * @param string $name name of migration
     * @param string $query the mysql query of new or modified table
     * 
     * @return boolean
     */
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

        return true;
    }
}