<?php

namespace Database\Seeders\Version100;

use Illuminate\Database\Seeder;
use Database\TruncateTable;
use Database\DisableForeignKeys;

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

        $this->disableForeignKeys("education_histories");
        $this->delete('education_histories');

        \DB::table('education_histories')->insert(array(
            0 =>
            array(
                'id'  => 1,
                'name' => 'Postgraduate',
                'description' => 'More than one degree',
                'created_at' => '2024-01-11 17:33:33',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            1 =>
            array(
                'id'  => 2,
                'name' => 'Bachelor Degree',
                'description' => 'First Degree',
                'created_at' => '2024-01-11 17:33:33',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            2 =>
            array(
                'id'  => 3,
                'name' => 'Higher Advanced Diploma',
                'description' => 'Advanced Diploma (NTA 07)',
                'created_at' => '2024-01-11 17:33:46',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            3 =>
            array(
                'id'  => 4,
                'name' => 'Diploma',
                'description' => 'diploma',
                'created_at' => '2024-01-11 17:33:33',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            4 =>
            array(
                'id'  => 5,
                'name' => 'Advance Secondary School',
                'description' => 'A-level',
                'created_at' => '2024-01-11 17:33:46',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
          5 =>
            array(
                'id'  => 6,
                'name' => 'Ordinary Secondary School',
                'description' => '0-level',
                'created_at' => '2024-01-11 17:33:33',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),

     ));

        $this->enableForeignKeys("education_histories");
    }
}
