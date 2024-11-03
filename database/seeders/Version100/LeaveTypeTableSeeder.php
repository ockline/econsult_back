<?php

namespace Database\Seeders\Version100;

use Database\TruncateTable;
use Illuminate\Database\Seeder;
use Database\DisableForeignKeys;
use Illuminate\Support\Facades\DB;

class LeaveTypeTableSeeder extends Seeder
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
                'name' => 'Paid Leave',
                'description' => 'Annual Paid Leave',
                'created_at' => '2024-10-21 10:33:33',
                'updated_at' => NULL,
            ),
            1 =>
            array(
                'id'  => 2,
                'name' => 'Un Paid Leave',
                'description' => 'Annual Un Paid Leave',
                'created_at' => '2024-10-21 10:33:33',
                'updated_at' => NULL,
            ),
            2 =>
            array(
                'id'  => 3,
                'name' => 'Maternity',
                'description' => 'Martenity Leave',
                'created_at' => '2024-10-21 10:33:33',
                'updated_at' => NULL,
            ),
3 =>
            array(
                'id'  => 4,
                'name' => 'Partenity',
                'description' => 'Partenity Leave',
                'created_at' => '2024-10-21 10:33:33',
                'updated_at' => NULL,
            ),
4 =>
            array(
                'id'  => 5,
                'name' => 'Sick Full Paid',
                'description' => 'Sick Full Paid',
                'created_at' => '2024-10-21 10:33:33',
                'updated_at' => NULL,
            ),
5 =>
            array(
                'id'  => 6,
                'name' => 'Sick Half Paid',
                'description' => 'Sick Half Paid',
                'created_at' => '2024-10-21 10:33:33',
                'updated_at' => NULL,
            ),
6 =>
            array(
                'id'  => 7,
                'name' => 'Sick UnPaid',
                'description' => 'Sick UnPaid',
                'created_at' => '2024-10-21 10:33:33',
                'updated_at' => NULL,
            ),
7 =>
            array(
                'id'  => 8,
                'name' => 'Compassionate ',
                'description' => 'Compassionate Leave',
                'created_at' => '2024-10-21 10:33:33',
                'updated_at' => NULL,
            ),
     );

 $lastRecordCount = $this->getRecordCount("leave_types");
        $slice = array_slice($data, $lastRecordCount);;
        if (count($slice)) {
            DB::table('leave_types')->insert($slice);
        }
    }
}
