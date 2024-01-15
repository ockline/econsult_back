<?php

namespace Database\Seeders\Version100;

use Illuminate\Database\Seeder;
use Database\TruncateTable;
use Database\DisableForeignKeys;

class PracticalTestsTableSeeder extends Seeder
{

    use DisableForeignKeys, TruncateTable;
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        $this->disableForeignKeys("practical_tests");
        $this->delete('practical_tests');

        \DB::table('practical_tests')->insert(array(
            0 =>
            array(
                'id'  => 1,
                'name' => 'Test 1',
                'description' => 'Test One',
                'created_at' => '2024-01-11 17:33:33',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            1 =>
            array(
                'id'  => 2,
                'name' => 'Test 2',
                'description' => 'Test two',
                'created_at' => '2024-01-11 17:33:33',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            2 =>
            array(
                'id'  => 3,
                'name' => 'Test 3',
                'description' => 'Test three',
                'created_at' => '2024-01-11 17:33:46',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            3 =>
            array(
                'id'  => 4,
                'name' => 'Test 4',
                'description' => 'Test four',
                'created_at' => '2024-01-11 17:33:33',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),


     ));

        $this->enableForeignKeys("practical_tests");
    }
}
