<?php

namespace Database\Seeders\Version100;

use Illuminate\Database\Seeder;
use Database\TruncateTable;
use Database\DisableForeignKeys;

class UnitsTableSeeder extends Seeder
{

    use DisableForeignKeys, TruncateTable;
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        $this->disableForeignKeys('units');
        $this->delete('units');

        \DB::table('units')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'name' => 'Blasting',
                    'created_at' => '2024-01-10 15:02:11',
                    'updated_at' => NULL,
                    'department_id' => 3,
                    'status' => '1',
                    'alias' => null,
                    'description' => 'Construction - Blasting',
                    'deleted_at' => null,
                ),
            1 =>
                array (
                    'id' => 2,
                    'name' => 'Electrical',
                    'created_at' => '2024-01-10 15:02:11',
                    'updated_at' => NULL,
                     'department_id' => 3,
                    'status' => '1',
                    'alias' => null,
                    'description' => 'Construction - Electrical',
                    'deleted_at' => null,
                ),
            2 =>
                array (
                    'id' => 3,
                    'name' => 'PH Civil',
                    'created_at' => '2024-01-10 15:02:11',
                    'updated_at' => NULL,
                    'department_id' => 3,
                    'status' => '1',
                    'alias' => null,
                    'description' => 'Construction - PH Civil',
                    'deleted_at' => null,
                ),
            3 =>
                array (
                    'id' => 4,
                    'name' => 'PH EM',
                    'created_at' => '2024-01-10 15:02:11',
                    'updated_at' => NULL,
                     'department_id' => 3,
                    'status' => '1',
                    'alias' => null,
                    'description' => 'Construction - PH EM',
                    'deleted_at' => null,
                ),
            4 =>
                array (
                    'id' => 5,
                    'name' => 'Roads',
                    'created_at' => '2024-01-10 15:02:11',
                    'updated_at' => NULL,
                    'department_id' => 3,
                    'status' => '1',
                    'alias' => null,
                    'description' => 'Construction - Roads',
                    'deleted_at' => null,
                ),
            5 =>
                array (
                    'id' => 6,
                    'name' => 'Saddle Dam',
                    'created_at' => '2024-01-10 15:02:11',
                    'updated_at' => NULL,
                     'department_id' => 3,
                    'status' => '1',
                    'alias' => null,
                    'description' => 'Construction - Saddle Dam',
                    'deleted_at' => null,
                ),
            6 =>
                array (
                    'id' => 7,
                    'name' => 'Switch Yard',
                    'created_at' => '2024-01-10 15:02:11',
                    'updated_at' => NULL,
                     'department_id' => 3,
                    'status' => '1',
                    'alias' => null,
                    'description' => 'Construction - Switch Yard',
                    'deleted_at' => null,
                ),
            7 =>
                array (
                    'id' => 8,
                    'name' => 'Cost Control',
                    'created_at' => '2024-01-10 15:02:11',
                    'updated_at' => NULL,
                     'department_id' => 4,
                    'status' => '1',
                    'alias' => null,
                    'description' => 'Cost Control',
                    'deleted_at' => null,
                ),
            8 =>
                array (
                    'id' => 9,
                    'name' => 'Document Control',
                    'created_at' => '2024-01-10 15:02:11',
                    'updated_at' => NULL,
                     'department_id' => 4,
                    'status' => '1',
                    'alias' => null,
                    'description' => 'Document Control',
                    'deleted_at' => null,
                ),
            9 =>
                array (
                    'id' => 10,
                    'name' => 'Material Control',
                    'created_at' => '2024-01-10 15:02:11',
                    'updated_at' => NULL,
                     'department_id' => 4,
                    'status' => '1',
                    'alias' => null,
                    'description' => 'Material Control',
                    'deleted_at' => null,
                ),
            10 =>
                array (
                    'id' => 11,
                    'name' => 'Quality Control',
                    'created_at' => '2024-01-10 15:02:11',
                    'updated_at' => NULL,
                     'department_id' => 4,
                    'status' => '1',
                    'alias' => null,
                    'description' => 'Quality Control',
                    'deleted_at' => null,
                ),
            11 =>
                array (
                    'id' => 12,
                    'name' => 'Quality Control',
                    'created_at' => '2024-01-10 15:02:11',
                    'updated_at' => NULL,
                     'department_id' => 4,
                    'status' => '1',
                    'alias' => null,
                    'description' => 'Quality Control',
                    'deleted_at' => null,
                ),
            12 =>
                array (
                    'id' => 13,
                    'name' => 'Quantity Survey',
                    'created_at' => '2024-01-10 15:02:11',
                    'updated_at' => NULL,
                     'department_id' => 4,
                    'status' => '1',
                    'alias' => null,
                    'description' => 'Quantity Survey',
                    'deleted_at' => null,
                ),
            13 =>
                array (
                    'id' => 14,
                    'name' => 'Batch plant',
                    'created_at' => '2024-01-10 15:02:11',
                    'updated_at' => NULL,
                     'department_id' => 7,
                    'status' => '1',
                    'alias' => null,
                    'description' => 'Equipment - Batch plant',
                    'deleted_at' => null,
                ),
            14 =>
                array (
                    'id' => 15,
                    'name' => 'Crusher Area',
                    'created_at' => '2024-01-10 15:02:11',
                    'updated_at' => NULL,
                     'department_id' => 7,
                    'status' => '1',
                    'alias' => null,
                    'description' => 'Equipment - Crusher Area',
                    'deleted_at' => null,
                ),
            15 =>
                array (
                    'id' => 16,
                    'name' => 'Saddle Dam',
                    'created_at' => '2024-01-10 15:02:11',
                    'updated_at' => NULL,
                     'department_id' => 7,
                    'status' => '1',
                    'alias' => null,
                    'description' => 'Equipment - Saddle Dam',
                    'deleted_at' => null,
                ),
            16 =>
                array (
                    'id' => 17,
                    'name' => 'Switch Yar',
                    'created_at' => '2024-01-10 15:02:12',
                    'updated_at' => NULL,
                     'department_id' => 7,
                    'status' => '1',
                    'alias' => null,
                    'description' => 'Equipment- Switch Yar',
                    'deleted_at' => null,
                ),
            17 =>
                array (
                    'id' => 18,
                    'name' => 'HSE - Civil',
                    'created_at' => '2024-01-10 15:02:12',
                    'updated_at' => NULL,
                     'department_id' => 9,
                    'status' => '1',
                    'alias' => null,
                    'description' => 'HSE - Civil',
                    'deleted_at' => null,
                ),
            18 =>
                array (
                    'id' => 19,
                    'name' => 'Logistics',
                    'created_at' => '2024-01-10 15:02:12',
                    'updated_at' => NULL,
                     'department_id' => 12,
                    'status' => '1',
                    'alias' => null,
                    'description' => null,
                    'deleted_at' => null,
                ),
            // 19 =>
            //     array (
            //         'id' => 20,
            //         'name' => 'Chemist (scientist)',
            //         'created_at' => '2024-01-10 15:02:12',
            //         'updated_at' => NULL,
            //          'department_id' => 2,
            //         'status' => '1',
            //         'alias' => null,
            //         'description' => null,
            //         'deleted_at' => null,
            //     ),
            // 20 =>
            //     array (
            //         'id' => 21,
            //         'name' => 'Chief executive officer',
            //         'created_at' => '2024-01-10 15:02:12',
            //         'updated_at' => NULL,
            //          'department_id' => 2,
            //         'status' => '1',
            //         'alias' => null,
            //         'description' => null,
            //         'deleted_at' => null,
            //     ),
            // 21 =>
            //     array (
            //         'id' => 22,
            //         'name' => 'Clerk (office worker)',
            //         'created_at' => '2024-01-10 15:02:12',
            //         'updated_at' => NULL,
            //          'department_id' => 2,
            //         'status' => '1',
            //         'alias' => null,
            //         'description' => null,
            //         'deleted_at' => null,
            //     ),
            // 22 =>
            //     array (
            //         'id' => 23,
            //         'name' => 'Clerk (retail worker)',
            //         'created_at' => '2024-01-10 15:02:12',
            //         'updated_at' => NULL,
            //          'department_id' => 2,
            //         'status' => '1',
            //         'alias' => null,
            //         'description' => null,
            //         'deleted_at' => null,
            //     ),
            // 23 =>
            //     array (
            //         'id' => 24,
            //         'name' => 'Coach',
            //         'created_at' => '2024-01-10 15:02:12',
            //         'updated_at' => NULL,
            //          'department_id' => 2,
            //         'status' => '1',
            //         'alias' => null,
            //         'description' => null,
            //         'deleted_at' => null,
            //     ),
            // 24 =>
            //     array (
            //         'id' => 25,
            //         'name' => 'Computer programmer',
            //         'created_at' => '2024-01-10 15:02:12',
            //         'updated_at' => NULL,
            //          'department_id' => 2,
            //         'status' => '1',
            //         'alias' => null,
            //         'description' => null,
            //         'deleted_at' => null,
            //     ),
            // 25 =>
            //     array (
            //         'id' => 26,
            //         'name' => 'Cook',
            //         'created_at' => '2024-01-10 15:02:12',
            //         'updated_at' => NULL,
            //          'department_id' => 2,
            //         'status' => '1',
            //         'alias' => null,
            //         'description' => null,
            //         'deleted_at' => null,
            //     ),
            // 26 =>
            //     array (
            //         'id' => 27,
            //         'name' => 'Dancer',
            //         'created_at' => '2024-01-10 15:02:12',
            //         'updated_at' => NULL,
            //          'department_id' => 2,
            //         'status' => '1',
            //         'alias' => null,
            //         'description' => null,
            //         'deleted_at' => null,
            //     ),
            // 27 =>
            //     array (
            //         'id' => 28,
            //         'name' => 'Dentist',
            //         'created_at' => '2024-01-10 15:02:12',
            //         'updated_at' => NULL,
            //          'department_id' => 2,
            //         'status' => '1',
            //         'alias' => null,
            //         'description' => null,
            //         'deleted_at' => null,
            //     ),
            // 28 =>
            //     array (
            //         'id' => 29,
            //         'name' => 'Doctor physician',
            //         'created_at' => '2024-01-10 15:02:12',
            //         'updated_at' => NULL,
            //          'department_id' => 2,
            //         'status' => '1',
            //         'alias' => null,
            //         'description' => null,
            //         'deleted_at' => null,
            //     ),
            // 29 =>
            //     array (
            //         'id' => 30,
            //         'name' => 'Driver',
            //         'created_at' => '2024-01-10 15:02:12',
            //         'updated_at' => NULL,
            //          'department_id' => 2,
            //         'status' => '1',
            //         'alias' => null,
            //         'description' => null,
            //         'deleted_at' => null,
            //     ),
            // 30 =>
            //     array (
            //         'id' => 31,
            //         'name' => 'Editor',
            //         'created_at' => '2024-01-10 15:02:12',
            //         'updated_at' => NULL,
            //          'department_id' => 2,
            //         'status' => '1',
            //         'alias' => null,
            //         'description' => null,
            //         'deleted_at' => null,
            //     ),
            // 31 =>
            //     array (
            //         'id' => 32,
            //         'name' => 'Electrician',
            //         'created_at' => '2024-01-10 15:02:12',
            //         'updated_at' => NULL,
            //          'department_id' => 2,
            //         'status' => '1',
            //         'alias' => null,
            //         'description' => null,
            //         'deleted_at' => null,
            //     ),
            // 32 =>
            //     array (
            //         'id' => 33,
            //         'name' => 'Engineer',
            //         'created_at' => '2024-01-10 15:02:12',
            //         'updated_at' => NULL,
            //          'department_id' => 2,
            //         'status' => '1',
            //         'alias' => null,
            //         'description' => null,
            //         'deleted_at' => null,
            //     ),
            // 33 =>
            //     array (
            //         'id' => 34,
            //         'name' => 'Farmer',
            //         'created_at' => '2024-01-10 15:02:12',
            //         'updated_at' => NULL,
            //          'department_id' => 2,
            //         'status' => '1',
            //         'alias' => null,
            //         'description' => null,
            //         'deleted_at' => null,
            //     ),
            // 34 =>
            //     array (
            //         'id' => 35,
            //         'name' => 'Firefighter',
            //         'created_at' => '2024-01-10 15:02:12',
            //         'updated_at' => NULL,
            //          'department_id' => 2,
            //         'status' => '1',
            //         'alias' => null,
            //         'description' => null,
            //         'deleted_at' => null,
            //     ),
            // 35 =>
            //     array (
            //         'id' => 36,
            //         'name' => 'Florist',
            //         'created_at' => '2024-01-10 15:02:13',
            //         'updated_at' => NULL,
            //          'department_id' => 2,
            //         'status' => '1',
            //         'alias' => null,
            //         'description' => null,
            //         'deleted_at' => null,
            //     ),
            // 36 =>
            //     array (
            //         'id' => 37,
            //         'name' => 'Geologist',
            //         'created_at' => '2024-01-10 15:02:13',
            //         'updated_at' => NULL,
            //          'department_id' => 2,
            //         'status' => '1',
            //         'alias' => null,
            //         'description' => null,
            //         'deleted_at' => null,
            //     ),
            // 37 =>
            //     array (
            //         'id' => 38,
            //         'name' => 'Guard',
            //         'created_at' => '2024-01-10 15:02:13',
            //         'updated_at' => NULL,
            //          'department_id' => 2,
            //         'status' => '1',
            //         'alias' => null,
            //         'description' => null,
            //         'deleted_at' => null,
            //     ),
            // 38 =>
            //     array (
            //         'id' => 39,
            //         'name' => 'Hotelier innkeeper',
            //         'created_at' => '2024-01-10 15:02:13',
            //         'updated_at' => NULL,
            //          'department_id' => 2,
            //         'status' => '1',
            //         'alias' => null,
            //         'description' => null,
            //         'deleted_at' => null,
            //     ),
            // 39 =>
            //     array (
            //         'id' => 40,
            //         'name' => 'Jeweler',
            //         'created_at' => '2024-01-10 15:02:13',
            //         'updated_at' => NULL,
            //          'department_id' => 2,
            //         'status' => '1',
            //         'alias' => null,
            //         'description' => null,
            //         'deleted_at' => null,
            //     ),
            // 40 =>
            //     array (
            //         'id' => 41,
            //         'name' => 'Journalist',
            //         'created_at' => '2024-01-10 15:02:13',
            //         'updated_at' => NULL,
            //          'department_id' => 2,
            //         'status' => '1',
            //         'alias' => null,
            //         'description' => null,
            //         'deleted_at' => null,
            //     ),
            // 41 =>
            //     array (
            //         'id' => 42,
            //         'name' => 'King/queen',
            //         'created_at' => '2024-01-10 15:02:13',
            //         'updated_at' => NULL,
            //          'department_id' => 2,
            //         'status' => '1',
            //         'alias' => null,
            //         'description' => null,
            //         'deleted_at' => null,
            //     ),
            // 42 =>
            //     array (
            //         'id' => 43,
            //         'name' => 'Landlord',
            //         'created_at' => '2024-01-10 15:02:13',
            //         'updated_at' => NULL,
            //          'department_id' => 2,
            //         'status' => '1',
            //         'alias' => null,
            //         'description' => null,
            //         'deleted_at' => null,
            //     ),
            // 43 =>
            //     array (
            //         'id' => 44,
            //         'name' => 'Lawyer',
            //         'created_at' => '2024-01-10 15:02:13',
            //         'updated_at' => NULL,
            //          'department_id' => 2,
            //         'status' => '1',
            //         'alias' => null,
            //         'description' => null,
            //         'deleted_at' => null,
            //     ),
            // 44 =>
            //     array (
            //         'id' => 45,
            //         'name' => 'Librarian',
            //         'created_at' => '2024-01-10 15:02:13',
            //         'updated_at' => NULL,
            //          'department_id' => 2,
            //         'status' => '1',
            //         'alias' => null,
            //         'description' => null,
            //         'deleted_at' => null,
            //     ),
            // 45 =>
            //     array (
            //         'id' => 46,
            //         'name' => 'Mail carrier',
            //         'created_at' => '2024-01-10 15:02:13',
            //         'updated_at' => NULL,
            //          'department_id' => 2,
            //         'status' => '1',
            //         'alias' => null,
            //         'description' => null,
            //         'deleted_at' => null,
            //     ),
        ));

        $this->enableForeignKeys('units');
    }
}
