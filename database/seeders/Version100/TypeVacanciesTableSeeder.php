<?php

namespace Database\Seeders\Version100;

use Database\TruncateTable;
use Illuminate\Database\Seeder;
use Database\DisableForeignKeys;
use Illuminate\Support\Facades\DB;

class TypeVacanciesTableSeeder extends Seeder
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
                'name' => 'New Position',
                'description' => null,
                'status' => null,
                'created_at' => '2024-01-11 17:33:33',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            1 =>
            array(
                'id'  => 2,
                'name' => 'Replacement',
                'description' => null,
                'status' => null,
                'created_at' => '2024-01-11 17:33:33',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            2 =>
            array(
                'id'  => 3,
                'name' => 'New Comer',
                'description' => 'Applied for Personnel ID application',
                'status' => 2,
                'created_at' => '2024-01-11 17:33:46',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
3 =>
            array(
                'id'  => 4,
                'name' => 'Change Job',
                'description' => 'Applied for Personnel ID application',
                'status' => 2,
                'created_at' => '2024-01-11 17:33:46',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
4 =>
            array(
                'id'  => 5,
                'name' => 'Vistor',
                'description' => 'Applied for Personnel ID application',
                'status' => 2,
                'created_at' => '2024-01-11 17:33:46',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
5 =>
            array(
                'id'  => 6,
                'name' => 'Transfer',
                'description' => 'Applied for Personnel ID application',
                'status' => 2,
                'created_at' => '2024-01-11 17:33:46',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
     );

        // $this->enableForeignKeys("type_vacancies");

 $lastRecordCount = $this->getRecordCount("type_vacancies");
        $slice = array_slice($data, $lastRecordCount);;
        if (count($slice)) {
            DB::table('type_vacancies')->insert($slice);
        }
    }
}
