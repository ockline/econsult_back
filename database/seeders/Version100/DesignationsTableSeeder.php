<?php

namespace Database\Seeders\Version100;

use DB;
use Database\TruncateTable;
use Illuminate\Database\Seeder;
use Database\DisableForeignKeys;

class DesignationsTableSeeder extends Seeder
{

    use DisableForeignKeys, TruncateTable;
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        $this->disableForeignKeys('designations');
        $this->delete('designations');

        DB::table('designations')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'name' => 'Director General',
                    'short_name' => 'DG',
                    'created_at' => '2017-04-18 08:21:51',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'level' => 1,
                ),
            1 =>
                array (
                    'id' => 2,
                    'name' => 'Head',
                    'short_name' => NULL,
                    'created_at' => '2017-04-18 08:21:51',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'level' => 2,
                ),
            2 =>
                array (
                    'id' => 3,
                    'name' => 'Director',
                    'short_name' => NULL,
                    'created_at' => '2017-04-18 08:22:34',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'level' => 2,
                ),
            3 =>
                array (
                    'id' => 4,
                    'name' => 'Officer',
                    'short_name' => NULL,
                    'created_at' => '2017-04-18 08:22:34',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'level' => 6,
                ),
            4 =>
                array (
                    'id' => 5,
                    'name' => 'Manager',
                    'short_name' => NULL,
                    'created_at' => '2017-04-18 08:23:09',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'level' => 3,
                ),
            5 =>
                array (
                    'id' => 6,
                    'name' => 'Principal',
                    'short_name' => NULL,
                    'created_at' => '2017-04-18 08:23:09',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'level' => 4,
                ),
            6 =>
                array (
                    'id' => 7,
                    'name' => 'Senior Officer',
                    'short_name' => NULL,
                    'created_at' => '2017-04-18 08:23:36',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'level' => 5,
                ),
            7 =>
                array (
                    'id' => 8,
                    'name' => 'Supervisor',
                    'short_name' => NULL,
                    'created_at' => '2017-04-18 08:23:36',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'level' => 6,
                ),
            8 =>
                array (
                    'id' => 9,
                    'name' => 'Initiator/Scheduled Officer',
                    'short_name' => NULL,
                    'created_at' => '2017-04-18 08:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'level' => 6,
                ),
            9 =>
                array (
                    'id' => 10,
                    'name' => 'Online Employer',
                    'short_name' => NULL,
                    'created_at' => '2017-04-18 08:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'level' => 6,
                ),
            10 =>
                array (
                    'id' => 11,
                    'name' => 'Call Centre Officer',
                    'short_name' => NULL,
                    'created_at' => '2017-04-18 08:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'level' => 6,
                ),
            11 =>
                array (
                    'id' => 12,
                    'name' => 'Intern',
                    'short_name' => NULL,
                    'created_at' => '2017-04-18 08:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'level' => 6,
                ),
            12 =>
                array (
                    'id' => 13,
                    'name' => 'Secretary',
                    'short_name' => NULL,
                    'created_at' => '2017-04-18 08:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'level' => 6,
                ),
            13 =>
                array (
                    'id' => 14,
                    'name' => 'Front Desk',
                    'short_name' => NULL,
                    'created_at' => '2017-04-18 08:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'level' => 6,
                ),
        ));

        $this->enableForeignKeys('designations');
    }
}
