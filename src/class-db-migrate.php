<?php

namespace DatabaseMigrator;

use DatabaseMigrator\Processors\DB_Migration_Processor;

class DB_Migrate
{
    public function migrate()
    {
        $processor = new DB_Migration_Processor;
        $processor->create_migrations_table();
        $processor->collect_migrations();
        $processor->process();
    }
}