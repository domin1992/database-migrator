<?php

namespace DatabaseMigrator\Processors;

class DBMigrationProcessor
{
    const DB_MIGRATIONS_TABLE = 'db_migrations';
    public $migrations = [];

    /**
     * Creates migration table if not exists
     */
    public function createMigrationsTable()
    {
        global $wpdb;
    
        $wpdb->query( "
            create table if not exists {$wpdb->prefix}" . self::DB_MIGRATIONS_TABLE . " (
                ID int unsigned auto_increment primary key,
                migration varchar(512) not null,
                created_at datetime not null
            )
        " );
    }

    /**
     * Collects all migrations from wordpress
     * 
     * If you want to add migration check Database_Migrator_Facade::add_migration()
     */
    public function collectMigrations()
    {
        $this->migrations = apply_filters( 'db_migrator_migration', $this->migrations );
    }

    /**
     * Process migrations
     * 
     * Adds new migrations to database
     */
    public function process()
    {
        global $wpdb;

        foreach ( $this->migrations as $migration ) {
            // Do not process when name or query empty
            if ( !$migration->name || !$migration->query ) continue;

            // Check if migration exists
            if ( !$wpdb->get_row( "select * from {$wpdb->prefix}" . self::DB_MIGRATIONS_TABLE . " where migration = '{$migration->name}'" ) ) {
                // Replaces prefix with proper wpdb prefix
                $query = str_replace( '[prefix]', $wpdb->prefix, $migration->query );

                // Migrate
                $result = $wpdb->query( $query );

                // Save migration if succeed ☝️
                if ( $result ) {
                    $wpdb->insert(
                        $wpdb->prefix . self::DB_MIGRATIONS_TABLE,
                        [
                            'migration' => $migration->name,
                            'created_at' => date( 'Y-m-d H:i:s' ),
                        ],
                        [
                            '$s',
                            '$s',
                        ]
                    );
                }
            }
        }
    }
}