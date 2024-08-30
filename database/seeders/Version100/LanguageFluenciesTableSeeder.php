<?php

namespace Database\Seeders\Version100;

use Database\TruncateTable;
use Illuminate\Database\Seeder;
use Database\DisableForeignKeys;
use Illuminate\Support\Facades\DB;

class LanguageFluenciesTableSeeder extends Seeder
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
                'name' => 'English',
                'description' => 'United Kingdom',
                'created_at' => '2024-01-11 17:33:33',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            1 =>
            array(
                'id'  => 2,
                'name' => 'Swahili',
                'description' => 'United state Of Tanzania',
                'created_at' => '2024-01-11 17:33:33',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            2 =>
            array(
                'id'  => 3,
                'name' => 'Arab',
                'description' => 'U.A.E',
                'created_at' => '2024-01-11 17:33:46',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
     );

        // $this->enableForeignKeys("language_fluences");
          $lastRecordCount = $this->getRecordCount("language_fluences");
        $slice = array_slice($data, $lastRecordCount);;
        if (count($slice)) {
            DB::table('language_fluences')->insert($slice);
        }
    }
}
