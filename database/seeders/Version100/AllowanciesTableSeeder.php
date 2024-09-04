<?php

namespace Database\Seeders\Version100;

use Database\TruncateTable;
use Illuminate\Database\Seeder;
use Database\DisableForeignKeys;
use Illuminate\Support\Facades\DB;

class AllowanciesTableSeeder extends Seeder
{

    use DisableForeignKeys, TruncateTable;
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {



        $data = array(
            0 =>
            array(
                'id'  => 1,
                'name' => 'House',
                'descriptions' => null,
                'status' => null,
                'created_at' => '2024-01-11 17:33:33',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            1 =>
            array(
                'id'  => 2,
                'name' => 'Meal',
                'descriptions' => null,
                'status' => null,
                'created_at' => '2024-01-11 17:33:33',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            2 =>
            array(
                'id'  => 3,
                'name' => 'Bush',
                'descriptions' => null,
                'status' => null,
                'created_at' => '2024-01-11 17:33:46',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            3 =>
            array(
                'id'  => 4,
                'name' => 'Transport',
                'descriptions' => null,
                'status' => null,
                'created_at' => '2024-01-11 17:33:46',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            4 =>
            array(
                'id'  => 5,
                'name' => 'none',
                'descriptions' => null,
                'status' => null,
                'created_at' => '2024-01-11 17:33:54',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            5 =>
            array(
                'id'  => 6,
                'name' => 'Other allowance',
                'descriptions' => null,
                'status' => null,
                'created_at' => '2024-01-11 17:33:54',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
        );



   $lastRecordCount = $this->getRecordCount("allowances");
        $slice = array_slice($data, $lastRecordCount);;
        if (count($slice)) {
            DB::table('allowances')->insert($slice);
        }
    }
}
