<?php

namespace Database\Seeders\Version100;

use Illuminate\Database\Seeder;
use Database\TruncateTable;
use Database\DisableForeignKeys;

class OfficesTableSeeder extends Seeder
{

    use DisableForeignKeys, TruncateTable;
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        $this->disableForeignKeys('offices');
        $this->delete('offices');

        \DB::table('offices')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'name' => 'DSM Office',
                    'parent_id' => NULL,
                    'external_id' => NULL,
                    'opening_date' => NULL,
                    'region_id' => 1,
                    'created_at' => '2024-01-11 11:13:21',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'isactive' => 1,
                ),
            1 =>
                array (
                    'id' => 2,
                    'name' => 'Arusha Office',
                    'parent_id' => 1,
                    'external_id' => NULL,
                    'opening_date' => NULL,
                    'region_id' => 3,
                    'created_at' => '2024-01-11 11:13:21',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'isactive' => 1,
                ),
            2 =>
                array (
                    'id' => 3,
                    'name' => 'Mwanza Office',
                    'parent_id' => 1,
                    'external_id' => NULL,
                    'opening_date' => NULL,
                    'region_id' => 2,
                    'created_at' => '2024-01-11 11:13:21',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'isactive' => 1,
                ),
            3 =>
                array (
                    'id' => 4,
                    'name' => 'Dodoma Office',
                    'parent_id' => 1,
                    'external_id' => NULL,
                    'opening_date' => NULL,
                    'region_id' => 4,
                    'created_at' => '2024-01-11 11:13:21',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'isactive' => 1,
                ),

            4 =>
                array (
                    'id' => 5,
                    'name' => 'Mbeya Office',
                    'parent_id' => 1,
                    'external_id' => NULL,
                    'opening_date' => NULL,
                    'region_id' => 14,
                    'created_at' => '2024-01-11 11:13:21',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'isactive' => 1,
                ),

            5 =>
                array (
                    'id' => 6,
                    'name' => 'Morogoro Office',
                    'parent_id' => 1,
                    'external_id' => NULL,
                    'opening_date' => NULL,
                    'region_id' => 15,
                    'created_at' => '2024-01-11 11:13:21',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'isactive' => 1,
                ),

            6 =>
                array (
                    'id' => 7,
                    'name' => 'Geita Office',
                    'parent_id' => 1,
                    'external_id' => NULL,
                    'opening_date' => NULL,
                    'region_id' => 5,
                    'created_at' => '2024-01-11 11:13:21',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'isactive' => 0,
                ),

            7 =>
                array (
                    'id' => 8,
                    'name' => 'Mtwara Office',
                    'parent_id' => 1,
                    'external_id' => NULL,
                    'opening_date' => NULL,
                    'region_id' => 16,
                    'created_at' => '2024-01-11 11:13:21',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'isactive' => 1,
                ),


            8 =>
                array (
                    'id' => 9,
                    'name' => 'Tabora Office',
                    'parent_id' => 1,
                    'external_id' => NULL,
                    'opening_date' => NULL,
                    'region_id' => 26,
                    'created_at' => '2024-01-11 11:13:21',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'isactive' => 0,
                ),
            9 =>
                array (
                    'id' => 10,
                    'name' => 'Kigoma',
                    'parent_id' => 1,
                    'external_id' => NULL,
                    'opening_date' => NULL,
                    'region_id' => 18,
                    'created_at' => '2022-08-02 11:13:21',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'isactive' => 1,
                ),

        ));

        $this->enableForeignKeys('offices');
    }
}
