<?php

namespace Database\Seeders\Version100;

use Database\TruncateTable;
use Illuminate\Database\Seeder;
use Database\DisableForeignKeys;
use Illuminate\Support\Facades\DB;

class DocumentGroupsTableSeeder extends Seeder
{

    use DisableForeignKeys;
// TruncateTable;
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
                'name' => 'Administrative',
                'created_at' => '2024-01-11 01:07:52',
                'updated_at' => NULL,
                'short' => 'Admin',
                'status' =>  1,
                'deleted_at' => NULL,
            ),
            1 =>
            array(
                'id' => 2,
                'name' => 'Administrative Optional',
                'created_at' => '2024-01-11 01:07:52',
                'updated_at' => NULL,
                'short' => NULL,
                'status' =>  1,
                'deleted_at' => NULL,
            ),
            2 =>
            array(
                'id' => 3,
                'name' => 'Job Vacancies',
                'created_at' => '2024-01-11 01:07:52',
                'updated_at' => NULL,
                'short' => 'Vacancy',
                'status' =>  1,
                'deleted_at' => NULL,
            ),
            3 =>
            array(
                'id' => 4,
                'name' => 'Technical Interview',
                'created_at' => '2024-01-11 01:07:52',
                'updated_at' => NULL,
                'short' => 'Technical',
                'status' =>  1,
                'deleted_at' => NULL,
            ),
            4 =>
            array(
                'id' => 5,
                'name' => 'HR Interview',
                'created_at' => '2024-01-11 01:07:52',
                'updated_at' => NULL,
                'short' => 'HR',
                'status' =>  1,
                'deleted_at' => NULL,
            ),
            5 =>
            array(
                'id' => 6,
                'name' => 'Employer',
                'created_at' => '2024-01-11 01:07:52',
                'updated_at' => NULL,
                'short' => 'Client',
                'status' =>  1,
                'deleted_at' => NULL,
            ),
            6 =>
            array(
                'id' => 7,
                'name' => 'Employee Particular',
                'created_at' => '2024-01-11 01:07:52',
                'updated_at' => NULL,
                'short' => 'Employee',
                'status' =>  1,
                'deleted_at' => NULL,
            ),
            7 =>
            array(
                'id' => 8,
                'name' => 'Social Records',
                'created_at' => '2024-01-11 01:07:52',
                'updated_at' => NULL,
                'short' => 'Social',
                'status' =>  1,
                'deleted_at' => NULL,
            ),
            8 =>
            array(
                'id' => 9,
                'name' => 'Induction Training',
                'created_at' => '2024-01-11 01:07:52',
                'updated_at' => NULL,
                'short' => 'Induction',
                'status' =>  1,
                'deleted_at' => NULL,
            ),
            9 =>
            array(
                'id' => 10,
                'name' => 'Personal Id Application',
                'created_at' => '2024-01-11 01:07:52',
                'updated_at' => NULL,
                'short' => 'ID',
                'status' =>  1,
                'deleted_at' => NULL,
            ),
       10 =>
            array(
                'id' => 11,
                'name' => 'Contracts Generation',
                'created_at' => '2024-01-11 01:07:52',
                'updated_at' => NULL,
                'short' => NULL,
                'status' =>  1,
                'deleted_at' => NULL,
            ),
            11 =>
            array(
                'id' => 12,
                'name' => 'Performance Review',
                'created_at' => '2024-01-11 01:07:52',
                'updated_at' => NULL,
                'short' => NULL,
                'status' =>  1,
                'deleted_at' => NULL,
            ),
            12 =>
            array(
                'id' => 13,
                'name' => 'Disciplinary',
                'created_at' => '2024-01-11 01:07:52',
                'updated_at' => NULL,
                'short' => NULL,
                'status' =>  1,
                'deleted_at' => NULL,
            ),
          13 =>
            array(
                'id' => 14,
                'name' => 'Exit',
                'created_at' => '2024-01-11 01:07:52',
                'updated_at' => NULL,
                'short' => NULL,
                'status' =>  1,
                'deleted_at' => NULL,
            ),
        14 =>
            array(
                'id' => 15,
                'name' => 'Grievance',
                'created_at' => '2025-04-11 01:07:52',
                'updated_at' => NULL,
                'short' => NULL,
                'status' =>  1,
                'deleted_at' => NULL,
            ),
        15 =>
            array(
                'id' => 16,
                'name' => 'Misconduct',
                'created_at' => '2025-05-01 01:07:52',
                'updated_at' => NULL,
                'short' => NULL,
                'status' =>  1,
                'deleted_at' => NULL,
            ),
        );

$lastRecordCount = $this->getRecordCount("document_groups");
        $slice = array_slice($data, $lastRecordCount);;
        if (count($slice)) {
            DB::table('document_groups')->insert($slice);
        }
    }
 protected function getRecordCount($table): int
    {
        return DB::table($table)->count();
    }
}
