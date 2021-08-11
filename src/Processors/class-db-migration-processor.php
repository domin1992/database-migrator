<?php

namespace DatabaseMigrator\Processors;

class DB_Migration_Processor
{
    const DB_MIGRATIONS_TABLE = 'db_migrations';
    public $migrations = [];

    /**
     * Creates migration table if not exists
     */
    public function create_migrations_table()
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

    public function collect_migrations()
    {
        $this->migrations = apply_filters( 'db_migrator_migration', $this->migrations );
    }

    public function process()
    {
        global $wpdb;

        foreach ( $this->migrations as $migration ) {
            if ( !$wpdb->get_row( "select * from {$wpdb->prefix}" . self::DB_MIGRATIONS_TABLE . " where migration = '{$migration->name}'" ) ) {
                $query = str_replace( '[prefix]', $wpdb->prefix, $migration->query );
                $result = $wpdb->query( $query );

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