<?php

namespace Database\Seeders\Version100;

use Database\TruncateTable;
use Illuminate\Database\Seeder;
use Database\DisableForeignKeys;
use Illuminate\Support\Facades\DB;

class DesignationsTableSeeder extends Seeder
{

    use DisableForeignKeys, TruncateTable;
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        // $this->disableForeignKeys('designations');
        // $this->delete('designations');

        $data = array (
            0 =>
                array (
                    'id' => 1,
                    'name' => 'Managing Director',
                    'short_name' => 'MD',
                    'created_at' => '2024-01-13 05:21:51',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 1,
                ),
            1 =>
                array (
                    'id' => 2,
                    'name' => 'Head',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:21:51',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 2,
                ),
            2 =>
                array (
                    'id' => 3,
                    'name' => 'Director',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:22:34',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 2,
                ),
            3 =>
                array (
                    'id' => 4,
                    'name' => 'Officer',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:22:34',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 6,
                ),
            4 =>
                array (
                    'id' => 5,
                    'name' => 'Manager',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:09',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 3,
                ),
            5 =>
                array (
                    'id' => 6,
                    'name' => 'Principal',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:09',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 4,
                ),
            6 =>
                array (
                    'id' => 7,
                    'name' => 'Senior Officer',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:36',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 5,
                ),
            7 =>
                array (
                    'id' => 8,
                    'name' => 'Supervisor',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:36',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 6,
                ),
            8 =>
                array (
                    'id' => 9,
                    'name' => 'Initiator/Scheduled Officer',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 6,
                ),
            9 =>
                array (
                    'id' => 10,
                    'name' => 'Online Employer',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 6,
                ),
            10 =>
                array (
                    'id' => 11,
                    'name' => 'Call Centre Officer',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 6,
                ),
            11 =>
                array (
                    'id' => 12,
                    'name' => 'Intern',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 6,
                ),
            12 =>
                array (
                    'id' => 13,
                    'name' => 'Secretary',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 6,
                ),
            13 =>
                array (
                    'id' => 14,
                    'name' => 'Front Desk',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 6,
                ),
 14 =>
                array (
                    'id' => 15,
                    'name' => 'Assistant Human Resource Manager',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 3,
                ),
 15 =>
                array (
                    'id' => 16,
                    'name' => 'Project Manager',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 3,
                ),
 16 =>
                array (
                    'id' => 17,
                    'name' => 'Transferred Scope Department Manager',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 3,
                ),
 17 =>
                array (
                    'id' => 18,
                    'name' => 'Transferred Scope Package manager',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 3,
                ),
 18 =>
                array (
                    'id' => 19,
                    'name' => 'Permanent Roads Department Manager',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 3,
                ),
 19 =>
                array (
                    'id' => 20,
                    'name' => 'Permanent Roads Package manager',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 3,
                ),
 20 =>
                array (
                    'id' => 21,
                    'name' => 'JV Management Department Manager',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 3,
                ),
 21 =>
                array (
                    'id' => 22,
                    'name' => 'Security Manager',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 3,
                ),
 22 =>
                array (
                    'id' => 23,
                    'name' => 'HSE Manager',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 3,
                ),
 23 =>
                array (
                    'id' => 24,
                    'name' => 'Accommodation and Offices Management Department manager',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 3,
                ),
 24 =>
                array (
                    'id' => 25,
                    'name' => 'Accommodation and Offices Management Package Manager',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 3,
                ),
 25 =>
                array (
                    'id' => 26,
                    'name' => 'Concrete Batch Plant Manager',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 3,
                ),
 26 =>
                array (
                    'id' => 27,
                    'name' => 'Concrete Batch Department Manager',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 3,
                ),
 27 =>
                array (
                    'id' => 28,
                    'name' => 'Construction Equipment Department Manager',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 3,
                ),
 28 =>
                array (
                    'id' => 29,
                    'name' => 'Construction Equipment Package Manager',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 3,
                ),
 29 =>
                array (
                    'id' => 30,
                    'name' => 'Crusher Plant Department Manager',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 3,
                ),
 30 =>
                array (
                    'id' => 31,
                    'name' => 'Crusher Plant Package manager',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 3,
                ),
 31 =>
                array (
                    'id' => 32,
                    'name' => 'Emergency Spillway Department Manager',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 3,
                ),
 32 =>
                array (
                    'id' => 33,
                    'name' => 'Emergency Spillway Package manager',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 3,
                ),
 33 =>
                array (
                    'id' => 34,
                    'name' => 'JV Management Package manager',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 3,
                ),
 34 =>
                array (
                    'id' => 35,
                    'name' => 'Main Dam E-M Department Manager',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 3,
                ),
 35 =>
                array (
                    'id' => 36,
                    'name' => 'Main Dam E-M Project Manager',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 3,
                ),
 36 =>
                array (
                    'id' => 37,
                    'name' => 'Power House - Civil Scope Department Manager',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 3,
                ),
 37 =>
                array (
                    'id' => 38,
                    'name' => 'Power House - Civil Scope Package manager',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 3,
                ),
 38 =>
                array (
                    'id' => 39,
                    'name' => 'Power House - Cofferdam Department Manager',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 3,
                ),
 39 =>
                array (
                    'id' => 40,
                    'name' => 'Power House - Cofferdam Package manager',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 3,
                ),
 40 =>
                array (
                    'id' => 41,
                    'name' => 'Power House - EM Scope Department Manager',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 3,
                ),
 41 =>
                array (
                    'id' => 42,
                    'name' => 'Power House - EM Scope Package manager',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 3,
                ),
 42 =>
                array (
                    'id' => 43,
                    'name' => 'Power House - Excavation Works Department Manager',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 3,
                ),
 43 =>
                array (
                    'id' => 44,
                    'name' => 'Power House - Excavation Works Package manager',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 3,
                ),
 44 =>
                array (
                    'id' => 45,
                    'name' => 'project Facilities and transportations Department Manager',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 3,
                ),
 45 =>
                array (
                    'id' => 46,
                    'name' => 'Project Facilities and transportations Package manager',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 3,
                ),
 46 =>
                array (
                    'id' => 47,
                    'name' => 'Saddle Dams 2-3-4 Department Manager',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 3,
                ),
 47 =>
                array (
                    'id' => 48,
                    'name' => 'Saddle Dams 2-3-4 Package manager',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 3,
                ),
 48 =>
                array (
                    'id' => 49,
                    'name' => 'SHC Main Dam SC Department Manager',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 3,
                ),
 49 =>
                array (
                    'id' => 50,
                    'name' => 'SHC Main Dam SC Package manager',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 3,
                ),
 50 =>
                array (
                    'id' => 51,
                    'name' => 'Switchyard 400KV AIS Department Manager',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 3,
                ),
 51 =>
                array (
                    'id' => 52,
                    'name' => 'Switchyard 400KV AIS Package manager',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 3,
                ),
 52 =>
                array (
                    'id' => 53,
                    'name' => 'Work Out of Scope Department Manager',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 3,
                ),
 53 =>
                array (
                    'id' => 54,
                    'name' => 'Work Out of Scope Package manager',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => null,
                    'level' => 3,
                ),
 54 =>
                array (
                    'id' => 55,
                    'name' => 'Doctor',
                    'short_name' => NULL,
                    'created_at' => '2024-01-13 05:23:47',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'status' =>  1,
                    'description' => 'Doctor Medical Doctor Doctor of Medicine',
                    'level' => 3,
                ),
//  55 =>
//                 array (
//                     'id' => 56,
//                     'name' => '',
//                     'short_name' => NULL,
//                     'created_at' => '2024-01-13 05:23:47',
//                     'updated_at' => NULL,
//                     'deleted_at' => NULL,
//                     'status' =>  1,
//                     'description' => null,
//                     'level' => 3,
//                 ),
//  56 =>
//                 array (
//                     'id' => 57,
//                     'name' => '',
//                     'short_name' => NULL,
//                     'created_at' => '2024-01-13 05:23:47',
//                     'updated_at' => NULL,
//                     'deleted_at' => NULL,
//                     'status' =>  1,
//                     'description' => null,
//                     'level' => 3,
//                 ),
//  57 =>
//                 array (
//                     'id' => 58,
//                     'name' => '',
//                     'short_name' => NULL,
//                     'created_at' => '2024-01-13 05:23:47',
//                     'updated_at' => NULL,
//                     'deleted_at' => NULL,
//                     'status' =>  1,
//                     'description' => null,
//                     'level' => 3,
//                 ),
//  58 =>
//                 array (
//                     'id' => 59,
//                     'name' => '',
//                     'short_name' => NULL,
//                     'created_at' => '2024-01-13 05:23:47',
//                     'updated_at' => NULL,
//                     'deleted_at' => NULL,
//                     'status' =>  1,
//                     'description' => null,
//                     'level' => 3,
//                 ),
//  59 =>
//                 array (
//                     'id' => 60,
//                     'name' => '',
//                     'short_name' => NULL,
//                     'created_at' => '2024-01-13 05:23:47',
//                     'updated_at' => NULL,
//                     'deleted_at' => NULL,
//                     'status' =>  1,
//                     'description' => null,
//                     'level' => 3,
//                 ),
//  60 =>
//                 array (
//                     'id' => 61,
//                     'name' => '',
//                     'short_name' => NULL,
//                     'created_at' => '2024-01-13 05:23:47',
//                     'updated_at' => NULL,
//                     'deleted_at' => NULL,
//                     'status' =>  1,
//                     'description' => null,
//                     'level' => 3,
//                 ),
//  61 =>
//                 array (
//                     'id' => 62,
//                     'name' => '',
//                     'short_name' => NULL,
//                     'created_at' => '2024-01-13 05:23:47',
//                     'updated_at' => NULL,
//                     'deleted_at' => NULL,
//                     'status' =>  1,
//                     'description' => null,
//                     'level' => 3,
//                 ),
//  62 =>
//                 array (
//                     'id' => 63,
//                     'name' => '',
//                     'short_name' => NULL,
//                     'created_at' => '2024-01-13 05:23:47',
//                     'updated_at' => NULL,
//                     'deleted_at' => NULL,
//                     'status' =>  1,
//                     'description' => null,
//                     'level' => 3,
//                 ),
//  63 =>
//                 array (
//                     'id' => 64,
//                     'name' => '',
//                     'short_name' => NULL,
//                     'created_at' => '2024-01-13 05:23:47',
//                     'updated_at' => NULL,
//                     'deleted_at' => NULL,
//                     'status' =>  1,
//                     'description' => null,
//                     'level' => 3,
//                 ),
//  64 =>
//                 array (
//                     'id' => 65,
//                     'name' => '',
//                     'short_name' => NULL,
//                     'created_at' => '2024-01-13 05:23:47',
//                     'updated_at' => NULL,
//                     'deleted_at' => NULL,
//                     'status' =>  1,
//                     'description' => null,
//                     'level' => 3,
//                 ),
//  65 =>
//                 array (
//                     'id' => 66,
//                     'name' => '',
//                     'short_name' => NULL,
//                     'created_at' => '2024-01-13 05:23:47',
//                     'updated_at' => NULL,
//                     'deleted_at' => NULL,
//                     'status' =>  1,
//                     'description' => null,
//                     'level' => 3,
//                 ),
//  66 =>
//                 array (
//                     'id' => 67,
//                     'name' => '',
//                     'short_name' => NULL,
//                     'created_at' => '2024-01-13 05:23:47',
//                     'updated_at' => NULL,
//                     'deleted_at' => NULL,
//                     'status' =>  1,
//                     'description' => null,
//                     'level' => 3,
//                 ),
// 67 =>
//                 array (
//                     'id' => 68,
//                     'name' => '',
//                     'short_name' => NULL,
//                     'created_at' => '2024-01-13 05:23:47',
//                     'updated_at' => NULL,
//                     'deleted_at' => NULL,
//                     'status' =>  1,
//                     'description' => null,
//                     'level' => 3,
//                 ),
//  68 =>
//                 array (
//                     'id' => 69,
//                     'name' => '',
//                     'short_name' => NULL,
//                     'created_at' => '2024-01-13 05:23:47',
//                     'updated_at' => NULL,
//                     'deleted_at' => NULL,
//                     'status' =>  1,
//                     'description' => null,
//                     'level' => 3,
//                 ),
//  69 =>
//                 array (
//                     'id' => 70,
//                     'name' => '',
//                     'short_name' => NULL,
//                     'created_at' => '2024-01-13 05:23:47',
//                     'updated_at' => NULL,
//                     'deleted_at' => NULL,
//                     'status' =>  1,
//                     'description' => null,
//                     'level' => 3,
//                 ),
//  70 =>
//                 array (
//                     'id' => 71,
//                     'name' => '',
//                     'short_name' => NULL,
//                     'created_at' => '2024-01-13 05:23:47',
//                     'updated_at' => NULL,
//                     'deleted_at' => NULL,
//                     'status' =>  1,
//                     'description' => null,
//                     'level' => 3,
//                 ),

        );

        // $this->enableForeignKeys('designations');

$lastRecordCount = $this->getRecordCount("designations");
        $slice = array_slice($data, $lastRecordCount);;
        if (count($slice)) {
            DB::table('designations')->insert($slice);
        }
    }
}
