<?php

namespace Database\Seeders\Version100;

use Database\TruncateTable;
use Illuminate\Database\Seeder;
use Database\DisableForeignKeys;
use Illuminate\Support\Facades\DB;

class LocationTypesTableSeeder extends Seeder
{

    use DisableForeignKeys, TruncateTable;
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        $data = array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Surveyed',
                'created_at' => '2024-01-11 10:37:06',
                'updated_at' => NULL,
                'description' => 'none',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'Unsurveyed',
                'created_at' => '2024-01-11 10:37:06',
                'updated_at' => NULL,
                 'description' => 'none',
            ),
        );

        // $this->enableForeignKeys('location_types');

   $lastRecordCount = $this->getRecordCount("location_types");
        $slice = array_slice($data, $lastRecordCount);;
        if (count($slice)) {
            DB::table('location_types')->insert($slice);
        }
    }
}
