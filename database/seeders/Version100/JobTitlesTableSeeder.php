<?php

namespace Database\Seeders\Version100;

use Illuminate\Database\Seeder;
use Database\TruncateTable;
use Database\DisableForeignKeys;

class JobTitlesTableSeeder extends Seeder
{

    use DisableForeignKeys, TruncateTable;
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        $this->disableForeignKeys('job_title');
        $this->delete('job_title');

        \DB::table('job_titles')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'name' => 'Accountant',
                    'created_at' => '2024-01-10 15:02:11',
                    'updated_at' => NULL,
                    'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            1 =>
                array (
                    'id' => 2,
                    'name' => 'Actor/actress',
                    'created_at' => '2024-01-10 15:02:11',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            2 =>
                array (
                    'id' => 3,
                    'name' => 'Administrator',
                    'created_at' => '2024-01-10 15:02:11',
                    'updated_at' => NULL,
                    'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            3 =>
                array (
                    'id' => 4,
                    'name' => 'Ambassador',
                    'created_at' => '2024-01-10 15:02:11',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            4 =>
                array (
                    'id' => 5,
                    'name' => 'Archaeologist',
                    'created_at' => '2024-01-10 15:02:11',
                    'updated_at' => NULL,
                    'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            5 =>
                array (
                    'id' => 6,
                    'name' => 'Architect',
                    'created_at' => '2024-01-10 15:02:11',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            6 =>
                array (
                    'id' => 7,
                    'name' => 'Artist',
                    'created_at' => '2024-01-10 15:02:11',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            7 =>
                array (
                    'id' => 8,
                    'name' => 'Athlete',
                    'created_at' => '2024-01-10 15:02:11',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            8 =>
                array (
                    'id' => 9,
                    'name' => 'Attorney',
                    'created_at' => '2024-01-10 15:02:11',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            9 =>
                array (
                    'id' => 10,
                    'name' => 'Baker',
                    'created_at' => '2024-01-10 15:02:11',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            10 =>
                array (
                    'id' => 11,
                    'name' => 'Barber',
                    'created_at' => '2024-01-10 15:02:11',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            11 =>
                array (
                    'id' => 12,
                    'name' => 'Bartender',
                    'created_at' => '2024-01-10 15:02:11',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            12 =>
                array (
                    'id' => 13,
                    'name' => 'Beautician',
                    'created_at' => '2024-01-10 15:02:11',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            13 =>
                array (
                    'id' => 14,
                    'name' => 'Biologist',
                    'created_at' => '2024-01-10 15:02:11',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            14 =>
                array (
                    'id' => 15,
                    'name' => 'Business man/Business woman',
                    'created_at' => '2024-01-10 15:02:11',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            15 =>
                array (
                    'id' => 16,
                    'name' => 'Butcher',
                    'created_at' => '2024-01-10 15:02:11',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            16 =>
                array (
                    'id' => 17,
                    'name' => 'Captain',
                    'created_at' => '2024-01-10 15:02:12',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            17 =>
                array (
                    'id' => 18,
                    'name' => 'Carpenter',
                    'created_at' => '2024-01-10 15:02:12',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            18 =>
                array (
                    'id' => 19,
                    'name' => 'Chemist (pharmacist)',
                    'created_at' => '2024-01-10 15:02:12',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            19 =>
                array (
                    'id' => 20,
                    'name' => 'Chemist (scientist)',
                    'created_at' => '2024-01-10 15:02:12',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            20 =>
                array (
                    'id' => 21,
                    'name' => 'Chief executive officer',
                    'created_at' => '2024-01-10 15:02:12',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            21 =>
                array (
                    'id' => 22,
                    'name' => 'Clerk (office worker)',
                    'created_at' => '2024-01-10 15:02:12',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            22 =>
                array (
                    'id' => 23,
                    'name' => 'Clerk (retail worker)',
                    'created_at' => '2024-01-10 15:02:12',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            23 =>
                array (
                    'id' => 24,
                    'name' => 'Coach',
                    'created_at' => '2024-01-10 15:02:12',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            24 =>
                array (
                    'id' => 25,
                    'name' => 'Computer programmer',
                    'created_at' => '2024-01-10 15:02:12',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            25 =>
                array (
                    'id' => 26,
                    'name' => 'Cook',
                    'created_at' => '2024-01-10 15:02:12',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            26 =>
                array (
                    'id' => 27,
                    'name' => 'Dancer',
                    'created_at' => '2024-01-10 15:02:12',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            27 =>
                array (
                    'id' => 28,
                    'name' => 'Dentist',
                    'created_at' => '2024-01-10 15:02:12',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            28 =>
                array (
                    'id' => 29,
                    'name' => 'Doctor physician',
                    'created_at' => '2024-01-10 15:02:12',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            29 =>
                array (
                    'id' => 30,
                    'name' => 'Driver',
                    'created_at' => '2024-01-10 15:02:12',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            30 =>
                array (
                    'id' => 31,
                    'name' => 'Editor',
                    'created_at' => '2024-01-10 15:02:12',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            31 =>
                array (
                    'id' => 32,
                    'name' => 'Electrician',
                    'created_at' => '2024-01-10 15:02:12',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            32 =>
                array (
                    'id' => 33,
                    'name' => 'Engineer',
                    'created_at' => '2024-01-10 15:02:12',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            33 =>
                array (
                    'id' => 34,
                    'name' => 'Farmer',
                    'created_at' => '2024-01-10 15:02:12',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            34 =>
                array (
                    'id' => 35,
                    'name' => 'Firefighter',
                    'created_at' => '2024-01-10 15:02:12',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            35 =>
                array (
                    'id' => 36,
                    'name' => 'Florist',
                    'created_at' => '2024-01-10 15:02:13',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            36 =>
                array (
                    'id' => 37,
                    'name' => 'Geologist',
                    'created_at' => '2024-01-10 15:02:13',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            37 =>
                array (
                    'id' => 38,
                    'name' => 'Guard',
                    'created_at' => '2024-01-10 15:02:13',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            38 =>
                array (
                    'id' => 39,
                    'name' => 'Hotelier innkeeper',
                    'created_at' => '2024-01-10 15:02:13',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            39 =>
                array (
                    'id' => 40,
                    'name' => 'Jeweler',
                    'created_at' => '2024-01-10 15:02:13',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            40 =>
                array (
                    'id' => 41,
                    'name' => 'Journalist',
                    'created_at' => '2024-01-10 15:02:13',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            41 =>
                array (
                    'id' => 42,
                    'name' => 'King/queen',
                    'created_at' => '2024-01-10 15:02:13',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            42 =>
                array (
                    'id' => 43,
                    'name' => 'Landlord',
                    'created_at' => '2024-01-10 15:02:13',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            43 =>
                array (
                    'id' => 44,
                    'name' => 'Lawyer',
                    'created_at' => '2024-01-10 15:02:13',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            44 =>
                array (
                    'id' => 45,
                    'name' => 'Librarian',
                    'created_at' => '2024-01-10 15:02:13',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            45 =>
                array (
                    'id' => 46,
                    'name' => 'Mail carrier',
                    'created_at' => '2024-01-10 15:02:13',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            46 =>
                array (
                    'id' => 47,
                    'name' => 'Mechanic',
                    'created_at' => '2024-01-10 15:02:13',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            47 =>
                array (
                    'id' => 48,
                    'name' => 'Midwife',
                    'created_at' => '2024-01-10 15:02:13',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            48 =>
                array (
                    'id' => 49,
                    'name' => 'Minister (politics)',
                    'created_at' => '2024-01-10 15:02:13',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            49 =>
                array (
                    'id' => 50,
                    'name' => 'Minister (church)',
                    'created_at' => '2024-01-10 15:02:14',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            50 =>
                array (
                    'id' => 51,
                    'name' => 'Model',
                    'created_at' => '2024-01-10 15:02:14',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            51 =>
                array (
                    'id' => 52,
                    'name' => 'Musician',
                    'created_at' => '2024-01-10 15:02:14',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            52 =>
                array (
                    'id' => 53,
                    'name' => 'Nurse',
                    'created_at' => '2024-01-10 15:02:14',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            53 =>
                array (
                    'id' => 54,
                    'name' => 'Optometrist',
                    'created_at' => '2024-01-10 15:02:14',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            54 =>
                array (
                    'id' => 55,
                    'name' => 'Painter',
                    'created_at' => '2024-01-10 15:02:14',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            55 =>
                array (
                    'id' => 56,
                    'name' => 'Pharmacist',
                    'created_at' => '2024-01-10 15:02:14',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            56 =>
                array (
                    'id' => 57,
                    'name' => 'Pilot',
                    'created_at' => '2024-01-10 15:02:14',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            57 =>
                array (
                    'id' => 58,
                    'name' => 'Poet',
                    'created_at' => '2024-01-10 15:02:14',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            58 =>
                array (
                    'id' => 59,
                    'name' => 'President',
                    'created_at' => '2024-01-10 15:02:14',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            59 =>
                array (
                    'id' => 60,
                    'name' => 'Professor',
                    'created_at' => '2024-01-10 15:02:14',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            60 =>
                array (
                    'id' => 61,
                    'name' => 'Psychologist',
                    'created_at' => '2024-01-10 15:02:14',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            61 =>
                array (
                    'id' => 62,
                    'name' => 'Rabbi',
                    'created_at' => '2024-01-10 15:02:14',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            62 =>
                array (
                    'id' => 63,
                    'name' => 'Sailor',
                    'created_at' => '2024-01-10 15:02:14',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            63 =>
                array (
                    'id' => 64,
                    'name' => 'Salesman/saleswoman',
                    'created_at' => '2024-01-10 15:02:14',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            64 =>
                array (
                    'id' => 65,
                    'name' => 'Scientist',
                    'created_at' => '2024-01-10 15:02:14',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            65 =>
                array (
                    'id' => 66,
                    'name' => 'Secretary',
                    'created_at' => '2024-01-10 15:02:14',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            66 =>
                array (
                    'id' => 67,
                    'name' => 'Servant',
                    'created_at' => '2024-01-10 15:02:14',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            67 =>
                array (
                    'id' => 68,
                    'name' => 'Social worker',
                    'created_at' => '2024-01-10 15:02:14',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            68 =>
                array (
                    'id' => 69,
                    'name' => 'Soldier',
                    'created_at' => '2024-01-10 15:02:14',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            69 =>
                array (
                    'id' => 70,
                    'name' => 'Student',
                    'created_at' => '2024-01-10 15:02:15',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            70 =>
                array (
                    'id' => 71,
                    'name' => 'Surgeon',
                    'created_at' => '2024-01-10 15:02:15',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            71 =>
                array (
                    'id' => 72,
                    'name' => 'Teacher',
                    'created_at' => '2024-01-10 15:02:15',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            72 =>
                array (
                    'id' => 73,
                    'name' => 'Therapist',
                    'created_at' => '2024-01-10 15:02:15',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            73 =>
                array (
                    'id' => 74,
                    'name' => 'Veterinarian',
                    'created_at' => '2024-01-10 15:02:15',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            74 =>
                array (
                    'id' => 75,
                    'name' => 'Waiter',
                    'created_at' => '2024-01-10 15:02:15',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            75 =>
                array (
                    'id' => 76,
                    'name' => 'Welder',
                    'created_at' => '2024-01-10 15:02:15',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            76 =>
                array (
                    'id' => 77,
                    'name' => 'Writer',
                    'created_at' => '2024-01-10 15:02:15',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            77 =>
                array (
                    'id' => 78,
                    'name' => 'Others',
                    'created_at' => '2024-01-10 15:02:15',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
            78 =>
                array (
                    'id' => 79,
                    'name' => 'Maintenance Coordinator',
                    'created_at' => '2024-01-10 15:02:15',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
                 79 =>
                array (
                    'id' => 80,
                    'name' => 'Operator',
                    'created_at' => '2020-07-27 14:30:15',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
                 80 =>
                array (
                    'id' => 81,
                    'name' => 'Helper/Labourer',
                    'created_at' => '2020-07-27 14:30:15',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
                81 =>
                array (
                    'id' => 82,
                    'name' => 'Storekeeper',
                    'created_at' => '2020-07-27 14:30:15',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
                 82 =>
                array (
                    'id' => 83,
                    'name' => 'Cleaner',
                    'created_at' => '2020-07-27 14:30:15',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),

                83 =>
                array (
                    'id' => 84,
                    'name' => 'Technician',
                    'created_at' => '2020-07-28 11:30:15',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
                84 =>
                array (
                    'id' => 85,
                    'name' => 'Mason',
                    'created_at' => '2020-07-28 11:30:15',
                    'updated_at' => NULL,
                     'employer_id' => null,
                    'status' => '1',
                    'description' => null,
                    'deleted_at' => null,
                ),
        ));

        $this->enableForeignKeys('job_titles');
    }
}
