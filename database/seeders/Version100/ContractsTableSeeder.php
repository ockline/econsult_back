<?php

namespace Database\Seeders\Version100;

use Database\TruncateTable;
use Illuminate\Database\Seeder;
use Database\DisableForeignKeys;
use Illuminate\Support\Facades\DB;

class ContractsTableSeeder extends Seeder
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
                'id' => 1,
                'name' => 'Fixed Term Contract',
                'created_at' => '2024-03-11 17:37:06',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'description' => 'Fixed Term Contract',
            ),
            1 =>
            array(
                'id' => 2,
                'name' => 'Specific Task Contract',
                'created_at' => '2024-03-11 17:37:06',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'description' => 'Specific Task Contract',
            ),
            2 =>
            array(
                'id' => 3,
                'name' => 'Unspecified Contract',
                'created_at' => '2024-03-11 17:37:06',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'description' => 'Unspecified Contract (until retired)',
            ),
        );



 $lastRecordCount = $this->getRecordCount("contracts");
        $slice = array_slice($data, $lastRecordCount);;
        if (count($slice)) {
            DB::table('contracts')->insert($slice);
        }
    }
}
