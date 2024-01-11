<?php

namespace Database\Seeders\Version100;

use Illuminate\Database\Seeder;
use Database\TruncateTable;
use Database\DisableForeignKeys;

class CompetencySubjectsTableSeeder extends Seeder
{

    use DisableForeignKeys, TruncateTable;
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        $this->disableForeignKeys("competencies_subjects");
        $this->delete('competencies_subjects');

        \DB::table('competencies_subjects')->insert(array(
            0 =>
            array(
                'id'  => 1,
                'name' => 'Core Competencies',
                'competency_id' => 1,
                'description' => 'Competencie',
                'created_at' => '2024-01-11 17:33:33',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            1 =>
            array(
                'id'  => 2,
                'name' => 'Accountability',
                'competency_id' => 1,
                'description' => '  core Competencie',
                'created_at' => '2024-01-11 17:33:33',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            2 =>
            array(
                'id'  => 3,
                'name' => 'Work Excellence  ',
                'competency_id' => 1,
                'description' => 'Applied for Personnel ID application',
                'created_at' => '2024-01-11 17:33:46',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            4 =>
            array(
                'id'  => 5,
                'name' => 'Planning & Organizing',
                'competency_id' => 2,
                'description' => ' Competencies ',
                'created_at' => '2024-01-11 17:33:46',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
 5 =>
            array(
                'id'  => 6,
                'name' => 'Problem Solving',
                'competency_id' => 2,
                'description' => ' Competencies ',
                'created_at' => '2024-01-11 17:33:46',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
 6 =>
            array(
                'id'  => 7,
                'name' => 'Analytical Ability',
                'competency_id' => 2,
                'description' => 'Functional Competencies ',
                'created_at' => '2024-01-11 17:33:46',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
  7=>
            array(
                'id'  => 8,
                'name' => 'Attention to Details',
                'competency_id' => 2,
                'description' => ' Competencies ',
                'created_at' => '2024-01-11 17:33:46',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
 8 =>
            array(
                'id'  => 9,
                'name' => 'Initiative',
                'competency_id' => 2,
                'description' => ' Competencies ',
                'created_at' => '2024-01-11 17:33:46',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
  9=>
            array(
                'id'  => 10,
                'name' => 'Multi-Tasking',
                'competency_id' => 2,
                'description' => ' Competencies ',
                'created_at' => '2024-01-11 17:33:46',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
  10=>
            array(
                'id'  => 11,
                'name' => 'Continuous Improvement',
                'competency_id' => 2,
                'description' => ' Competencies ',
                'created_at' => '2024-01-11 17:33:46',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
  11=>
            array(
                'id'  => 12,
                'name' => 'Compliance',
                'competency_id' => 2,
                'description' => ' Competencies ',
                'created_at' => '2024-01-11 17:33:46',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
  12=>
            array(
                'id'  => 13,
                'name' => 'Creativity & Innovation',
                'competency_id' => 2,
                'description' => ' Competencies ',
                'created_at' => '2024-01-11 17:33:46',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
  13 =>
            array(
                'id'  => 14,
                'name' => 'Negotiation',
                'competency_id' => 2,
                'description' => ' Competencies ',
                'created_at' => '2024-01-11 17:33:46',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
  14 =>
            array(
                'id'  => 15,
                'name' => 'Team Work',
                'competency_id' => 2,
                'description' => ' Competencies ',
                'created_at' => '2024-01-11 17:33:46',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
 15 =>
            array(
                'id'  => 16,
                'name' => 'Adaptability/Flexibility',
                'competency_id' => 2,
                'description' => 'Functional Competencies ',
                'created_at' => '2024-01-11 17:33:46',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
 16 =>
            array(
                'id'  => 17,
                'name' => 'Leadership',
                'competency_id' => 3,
                'description' => 'Managerial Competencies ',
                'created_at' => '2024-01-11 17:33:46',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
 17 =>
            array(
                'id'  => 18,
                'name' => 'Delegating, Managing',
                'competency_id' => 3,
                'description' => 'Managerial Competencies ',
                'created_at' => '2024-01-11 17:33:46',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
      18 =>
            array(
                'id'  => 19,
                'name' => 'Managing Change',
                'competency_id' => 4,
                'description' => 'Managerial Competencies ',
                'created_at' => '2024-01-11 17:33:46',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            19 =>
            array(
                'id'  => 20,
                'name' => 'Strategic Conceptual Thinking',
                'competency_id' => 4,
                'description' => 'Managerial Competencies ',
                'created_at' => '2024-01-11 17:33:46',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
     ));
        $this->enableForeignKeys("competencies_subjects");
    }
}
