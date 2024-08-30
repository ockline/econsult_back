<?php

namespace Database\Seeders\Version100;

use Database\TruncateTable;
use Illuminate\Database\Seeder;
use Database\DisableForeignKeys;
use Illuminate\Support\Facades\DB;

class CompetenciesTableSeeder extends Seeder
{

    use DisableForeignKeys, TruncateTable;
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        // $this->disableForeignKeys("competencies");
        // $this->delete('competencies');



         $data =array(
            0 =>
            array(
                'id'  => 1,
                'name' => 'Core Competencies',
                'description' => 'Competencie',
                'created_at' => '2024-01-11 17:33:33',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            1 =>
            array(
                'id'  => 2,
                'name' => 'Functional Competencie',
                'description' => 'Competencie',
                'created_at' => '2024-01-11 17:33:33',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            2 =>
            array(
                'id'  => 3,
                'name' => 'Managerial Competencies Mid Senior Mngt. Level',
                'description' => 'Applied for Personnel ID application',
                'created_at' => '2024-01-11 17:33:46',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
3 =>
            array(
                'id'  => 4,
                'name' => 'Managerial Competencies Top Mngt. Level',
                'description' => 'Managerial Competencies top Mngt. Level',
                'created_at' => '2024-01-11 17:33:46',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),

     );
         $lastRecordCount = $this->getRecordCount("competencies");
        $slice = array_slice($data, $lastRecordCount);;
        if (count($slice)) {
            DB::table('competencies')->insert($slice);
        }
    }
}
