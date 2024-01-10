<?php

namespace Database\Seeders\Version100;

use Illuminate\Database\Seeder;
use Database\TruncateTable;
use Database\DisableForeignKeys;

class MaritalStatusesTableSeeder extends Seeder
{

    use DisableForeignKeys, TruncateTable;
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        $this->disableForeignKeys();
        $this->truncate('marital_statuses');

        \DB::table('marital_statuses')->insert(array (
            0 =>
            array (
                'name' => 'Married',
                'created_at' => '2017-04-18 17:33:33',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            1 =>
            array (
                'name' => 'Widowed',
                'created_at' => '2017-04-18 17:33:33',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            2 =>
            array (
                'name' => 'Separated',
                'created_at' => '2017-04-18 17:33:46',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            3 =>
            array (
                'name' => 'Divorced',
                'created_at' => '2017-04-18 17:33:46',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            4 =>
            array (
                'name' => 'Single',
                'created_at' => '2017-04-18 17:33:54',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
        ));

        $this->enableForeignKeys();
    }
}
