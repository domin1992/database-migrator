<?php

namespace DatabaseMigrator;

use DatabaseMigrator\Processors\DBMigrationProcessor;

class DBMigrate
{
    /**
     * Command migrate
     * 
     * usage:
     * wp db-migrate migrate
     */
    public function migrate()
    {
        $processor = new DBMigrationProcessor;
        $processor->createMigrationsTable();
        $processor->collectMigrations();
        $processor->process();
    }
}