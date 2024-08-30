<?php

namespace Database\Seeders\Version100;

use Database\TruncateTable;
use Illuminate\Database\Seeder;
use Database\DisableForeignKeys;
use Illuminate\Support\Facades\DB;

class ShiftsTableSeeder extends Seeder
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
                'name' => 'Day Only',
                'descriptions' => null,
                'alias' => null,
                'created_at' => '2024-01-11 17:33:33',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            1 =>
            array(
                'id'  => 2,
                'name' => 'Night',
                'descriptions' => null,
                'alias' => null,
                'created_at' => '2024-01-11 17:33:33',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            2 =>
            array(
                'id'  => 3,
                'name' => 'Day and Night',
                'descriptions' => null,
                'alias' => null,
                'created_at' => '2024-01-11 17:33:46',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
     );

        // $this->enableForeignKeys("shifts");
         $lastRecordCount = $this->getRecordCount("shifts");
        $slice = array_slice($data, $lastRecordCount);;
        if (count($slice)) {
            DB::table('shifts')->insert($slice);
        }
    }
}
