<?php

namespace Database;

use Illuminate\Support\Facades\DB;

/**
 * Class TruncateTable.
 */
trait TruncateTable
{
    /**
     * @param $table
     *
     * @return bool
     */
    protected function truncate($table)
    {
        switch (DB::getDriverName()) {
            case 'mysql':
                return DB::table($table)->truncate();

            case 'pgsql':
                return  DB::statement('TRUNCATE TABLE ONLY '.$table.' RESTART IDENTITY');

            case 'sqlite':
                return DB::statement('DELETE FROM '.$table);
        }

        return false;
    }

    /**
     * @param $table
     * @return mixed
     */
    protected function delete($table)
    {
        return DB::statement('DELETE FROM '.$table);
    }

    /**
     * @param array $tables
     */
    protected function truncateMultiple(array $tables)
    {
        foreach ($tables as $table) {
            $this->truncate($table);
        }
    }

    /**
     * @param $table
     * @return int
     */
    protected function getRecordCount($table): int
    {
        return DB::table($table)->count();
    }

}
