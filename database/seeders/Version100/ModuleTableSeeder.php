<?php

namespace Database\Seeders\Version100;

use Database\TruncateTable;
use Illuminate\Database\Seeder;
use Database\DisableForeignKeys;
use Illuminate\Support\Facades\DB;

class ModuleTableSeeder extends Seeder
{

    use DisableForeignKeys;
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
                'name' => 'All Module',
                'shortname' => 'ALL',
                'created_at' => '2025-11-01 17:33:33',
                'updated_at' => NULL,

            ),
  1 =>
            array(
                'id'  => 2,
                'name' => 'Employer/ Client Management',
                'shortname' => 'ECM',
                'created_at' => '2025-11-01 17:33:33',
                'updated_at' => NULL,

            ),
            2 =>
            array(
                'id'  => 3,
                'name' => 'Hiring Management',
                'shortname' => 'HM',
                'created_at' => '2025-11-01 17:33:33',
                'updated_at' => NULL,

            ),
            3 =>
            array(
                'id'  => 4,
                'name' => 'Employee Management',
                'shortname' => 'ERM',
                'created_at' => '2025-11-01 17:33:46',
                'updated_at' => NULL,

            ),
            4 =>
            array(
                'id'  => 5,
                'name' => 'Contract Management',
                'shortname' => 'CTM',
                'created_at' => '2025-11-01 17:33:46',
                'updated_at' => NULL,

            ),
            5 =>
            array(
                'id'  => 6,
                'name' => 'Attendance Management',
                'shortname' => 'ATM',
                'created_at' => '2025-11-01 17:33:54',
                'updated_at' => NULL,

            ),
            6 =>
            array(
                'id'  => 7,
                'name' => 'Leave Management',
                'shortname' => 'LVM',
                'created_at' => '2025-11-01 17:33:54',
                'updated_at' => NULL,

            ),
            7 =>
            array(
                'id'  => 8,
                'name' => 'Industial Relationship Management',
                'shortname' => "IRM",
                'created_at' => '2025-11-01 17:33:54',
                'updated_at' => NULL,

            ),
            8 =>
            array(
                'id'  => 9,
                'name' => 'Exit Management',
                'shortname' => 'ETM',
                'created_at' => '2025-11-01 17:33:54',
                'updated_at' => NULL,

            ),
 9 =>
            array(
                'id'  => 10,
                'name' => 'General Compliance Management',
                'shortname' => 'GCM',
                'created_at' => '2025-11-01 17:33:54',
                'updated_at' => NULL,

            ),
            10 =>
            array(
                'id'  => 11,
                'name' => 'Payroll Management',
                'shortname' => 'PRM',
                'created_at' => '2025-11-01 17:33:54',
                'updated_at' => NULL,

            ),
            11 =>
            array(
                'id'  => 12,
                'name' => 'Report Management',
                'shortname' => 'RTM',
                'created_at' => '2025-11-01 17:33:54',
                'updated_at' => NULL,

            ),
        );



        $lastRecordCount = $this->getRecordCount("modules");
        $slice = array_slice($data, $lastRecordCount);;
        if (count($slice)) {
            DB::table('modules')->insert($slice);
        }
    }
 protected function getRecordCount($table): int
    {
        return DB::table($table)->count();
    }
}
