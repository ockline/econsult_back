<?php

namespace Database\Seeders\Version100;

use Database\TruncateTable;
use Illuminate\Database\Seeder;
use Database\DisableForeignKeys;
use Illuminate\Support\Facades\DB;

class EducationHistoriesTableSeeder extends Seeder
{

    use DisableForeignKeys, TruncateTable;
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        // $this->disableForeignKeys("education_histories");
        // $this->delete('education_histories');

        $data = array(
            0 =>
            array(
                'id'  => 1,
                'name' => 'PHD',
                'description' => 'More than one degree',
                'created_at' => '2024-01-11 17:33:33',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            1 =>
            array(
                'id'  => 2,
                'name' => 'Master Degree',
                'description' => 'First Degree',
                'created_at' => '2024-01-11 17:33:33',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            2 =>
            array(
                'id'  => 3,
                'name' => 'Postgraduate',
                'description' => 'First Degree',
                'created_at' => '2024-01-11 17:33:33',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            3 =>
            array(
                'id'  => 4,
                'name' => 'Bachelor Degree',
                'description' => 'First Degree',
                'created_at' => '2024-01-11 17:33:33',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            4 =>
            array(
                'id'  => 5,
                'name' => 'Post Graduate Diploma',
                'description' => 'First Degree',
                'created_at' => '2024-01-11 17:33:33',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            5 =>
            array(
                'id'  => 6,
                'name' => 'Advance Diploma',
                'description' => 'First Degree',
                'created_at' => '2024-01-11 17:33:33',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            6 =>
            array(
                'id'  => 7,
                'name' => 'Diploma / FTC',
                'description' => 'Diploma / FTC',
                'created_at' => '2024-01-11 17:33:33',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),

            7 =>
            array(
                'id'  => 8,
                'name' => 'Diploma in Technical Ediucation (DSEE)',
                'description' => 'First Degree',
                'created_at' => '2024-01-11 17:33:33',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            8 =>
            array(
                'id'  => 9,
                'name' => 'Diploma in Technical Education  (DTEE)',
                'description' => 'First Degree',
                'created_at' => '2024-01-11 17:33:33',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            9 =>
            array(
                'id'  => 10,
                'name' => 'Full Technician Certificate (FTC)',
                'description' => 'Full Technician Certificate (FTC)',
                'created_at' => '2024-01-11 17:33:33',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            10 =>
            array(
                'id'  => 11,
                'name' => 'Higher Diploma',
                'description' => 'Higher Diploma',
                'created_at' => '2024-01-11 17:33:33',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),

            11 =>
            array(
                'id'  => 12,
                'name' => 'Basic Technician Certificate',
                'description' => 'Basic Technician Certificate',
                'created_at' => '2024-01-11 17:33:33',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),

            12 =>
            array(
                'id'  => 13,
                'name' => 'Certificate',
                'description' => 'certificat',
                'created_at' => '2024-01-11 17:33:33',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            13 =>
            array(
                'id'  => 14,
                'name' => 'Grade A Teachers Certificate (GATCE)',
                'description' => 'certificat',
                'created_at' => '2024-01-11 17:33:33',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),

            14 =>
            array(
                'id'  => 15,
                'name' => 'Grade A Teachers Certificate Special Course(GATSCEE)',
                'description' => 'certificat',
                'created_at' => '2024-01-11 17:33:33',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),

            15 =>
            array(
                'id'  => 16,
                'name' => 'Technician Certificate',
                'description' => 'Technician Certificate',
                'created_at' => '2024-01-11 17:33:46',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),

           16=> array(
                'id'  => 17,
                'name' => 'Advance Level (ACSE)',
                'description' => 'Advance Secondary School',
                'created_at' => '2024-01-11 17:33:46',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            17 =>
            array(
                'id'  => 18,
                'name' => 'Ordinary Level (CSE)',
                'description' => 'Ordinary Secondary School',
                'created_at' => '2024-01-11 17:33:33',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
           18 =>
            array(
                'id'  => 19,
                'name' => 'Primary Level (PE)',
                'description' => 'Primary School',
                'created_at' => '2024-01-11 17:33:33',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),

        );

        // $this->enableForeignKeys("education_histories");
        $lastRecordCount = $this->getRecordCount("education_histories");
        $slice = array_slice($data, $lastRecordCount);;
        if (count($slice)) {
            DB::table('education_histories')->insert($slice);
        }

    }
}
