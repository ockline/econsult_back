<?php

namespace Database\Seeders\Version100;

use Illuminate\Database\Seeder;
use Database\TruncateTable;
use Database\DisableForeignKeys;

class RankingCreterialsTableSeeder extends Seeder
{

    use DisableForeignKeys, TruncateTable;
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        $this->disableForeignKeys("ranking_creterials");
        $this->delete('ranking_creterials');

        \DB::table('ranking_creterials')->insert(array(
            0 =>
            array(
                'id'  => 1,
                'name' => 'N/A (0)',
                'description' => 'none',
                'rate' => 0,
                'created_at' => '2024-01-11 17:33:33',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            1 =>
            array(
                'id'  => 2,
                'name' => 'Below Average (1)',
                'description' => 'Doesn’t meet Expectation ',
                'rate' => 1,
                'created_at' => '2024-01-11 17:33:33',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            2 =>
            array(
                'id'  => 3,
                'name' => 'Average (2)',
                'description' => 'Below Expectation ',
                'rate' => 2,
                'created_at' => '2024-01-11 17:33:46',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
3 =>
            array(
                'id'  => 4,
                'name' => 'Good (3)',
                'description' => 'Meet Expectation ',
                'rate' => 3,
                'created_at' => '2024-01-11 17:33:46',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
4 =>
            array(
                'id'  => 5,
                'name' => 'V.Good (4)',
                'description' => 'Exceeding expectation',
                'rate' => 4,
                'created_at' => '2024-01-11 17:33:46',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
5 =>
            array(
                'id'  => 6,
                'name' => 'Outstanding (5)',
                'description' => 'Exceeding Expectation as Role Model ',
                'rate' => 5,
                'created_at' => '2024-01-11 17:33:46',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
     ));

        $this->enableForeignKeys("ranking_creterials");
    }
}
