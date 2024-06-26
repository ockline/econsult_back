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

        $this->disableForeignKeys("marital_statuses");
        $this->delete('marital_statuses');

        \DB::table('marital_statuses')->insert(array(
            0 =>
            array(
                'id'  => 1,
                'name' => 'Married',
                'created_at' => '2024-01-11 17:33:33',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            1 =>
            array(
                'id'  => 2,
                'name' => 'Widowed',
                'created_at' => '2024-01-11 17:33:33',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            2 =>
            array(
                'id'  => 3,
                'name' => 'Separated',
                'created_at' => '2024-01-11 17:33:46',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            3 =>
            array(
                'id'  => 4,
                'name' => 'Divorced',
                'created_at' => '2024-01-11 17:33:46',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            4 =>
            array(
                'id'  => 5,
                'name' => 'Single',
                'created_at' => '2024-01-11 17:33:54',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
        ));

        $this->enableForeignKeys("marital_statuses");
    }
}
