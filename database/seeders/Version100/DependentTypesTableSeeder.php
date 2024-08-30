<?php

namespace Database\Seeders\Version100;

use Database\TruncateTable;
use Illuminate\Database\Seeder;
use Database\DisableForeignKeys;
use Illuminate\Support\Facades\DB;

class DependentTypesTableSeeder extends Seeder
{

    use DisableForeignKeys, TruncateTable;
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        // $this->disableForeignKeys('dependent_types');
        // $this->delete('dependent_types');

        $data = array(
            0 =>
            array(
                'id' => 1,
                'name' => 'Husband',
                'survivor_pension' => '1',
                'created_at' => '2024-03-05 09:11:29',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            1 =>
            array(
                'id' => 2,
                'name' => 'Wife',
                'survivor_pension' => '1',
                'created_at' => '2024-03-05 09:11:29',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            2 =>
            array(
                'id' => 3,
                'name' => 'Child',
                'survivor_pension' => '1',
                'created_at' => '2024-03-05 09:11:45',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            3 =>
            array(
                'id' => 4,
                'name' => 'Father',
                'survivor_pension' => '1',
                'created_at' => '2024-03-05 09:11:45',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            4 =>
            array(
                'id' => 5,
                'name' => 'Mother',
                'survivor_pension' => '1',
                'created_at' => '2024-03-05 09:12:05',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            5 =>
            array(
                'id' => 6,
                'name' => 'Estate Administrator',
                'survivor_pension' => '0',
                'created_at' => '2024-03-05 09:12:05',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            6 =>
            array(
                'id' => 7,
                'name' => 'Constant Care Assistant',
                'survivor_pension' => '1',
                'created_at' => '2024-03-05 09:12:15',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),

            7 =>
            array(
                'id' => 8,
                'name' => 'Brother',
                'survivor_pension' => '1',
                'created_at' => '2024-03-05 09:12:15',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),

            8 =>
            array(
                'id' => 9,
                'name' => 'Sister',
                'survivor_pension' => '1',
                'created_at' => '2024-03-05 09:12:15',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            9 =>
            array(
                'id' => 10,
                'name' => 'Half Brother',
                'survivor_pension' => '1',
                'created_at' => '2024-03-05 09:12:15',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),

            10 =>
            array(
                'id' => 11,
                'name' => 'Half Sister',
                'survivor_pension' => '1',
                'created_at' => '2024-03-05 09:12:15',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),

            11 =>
            array(
                'id' => 12,
                'name' => 'Grand Parent',
                'survivor_pension' => '1',
                'created_at' => '2024-03-05 09:12:15',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),

            12 =>
            array(
                'id' => 13,
                'name' => 'Grand Child',
                'survivor_pension' => '1',
                'created_at' => '2024-03-05 09:12:15',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            13 =>
            array(
                'id' => 14,
                'name' => 'Nephew and Nieces',
                'survivor_pension' => '0',
                'created_at' => '2024-03-05 09:12:15',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            14 =>
            array(
                'id' => 15,
                'name' => 'cousin',
                'survivor_pension' => '0',
                'created_at' => '2024-03-05 09:12:15',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
15 =>
            array(
                'id' => 16,
                'name' => 'Other',
                'survivor_pension' => '0',
                'created_at' => '2024-03-05 09:12:15',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
        );



$lastRecordCount = $this->getRecordCount("dependent_types");
        $slice = array_slice($data, $lastRecordCount);;
        if (count($slice)) {
            DB::table('dependent_types')->insert($slice);
        }
    }
}
