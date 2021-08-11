<?php

namespace DatabaseMigrator;

use DatabaseMigrator\Instances\DBMigration;

class DatabaseMigratorFacade
{
    /**
     * Initializes Database Migrator
     * 
     * simply add to your functions.php:
     * add_action( 'cli_init', [\DatabaseMigrator\DatabaseMigratorFacade::class, 'cliInit'] );
     */
    public static function cliInit()
    {
        \WP_CLI::add_command( 'db-migrate', DBMigrate::class );
    }

    /**
     * Adds migration
     * 
     * @param string $name name of migration
     * @param string $query the mysql query of new or modified table
     * 
     * @return boolean
     */
    public static function addMigration( $name, $query )
    {
        add_filter( 'db_migrator_migration', function( $migrations ) use ($name, $query) {
            array_merge(
                $migrations,
                new DBMigration(
                    $name,
                    $query
                )
            );
        } );

        return true;
    }
}