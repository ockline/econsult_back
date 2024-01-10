<?php

namespace Database\Seeders\Version100;

use Illuminate\Database\Seeder;
use Database\TruncateTable;
use Database\DisableForeignKeys;

class DocumentsTableSeeder extends Seeder
{

    use DisableForeignKeys, TruncateTable;
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        $this->disableForeignKeys('documents');
        $this->delete('documents');

        \DB::table('documents')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'name' => 'Employee\'s Employment Identity Card',
                    'document_group_id' => '9',
                    'description' => NULL,
                    'isrecurring' => '0',
                    'ismandatory' => '1',
                    'isactive' => '1',
                    'created_at' => '2023-01-10 08:18:07',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'anysource' => 1,
                    'isother' => 0,
                    'document_order'=>NULL,
                ),
            1 =>
                array (
                    'id' => 2,
                    'name' => 'Employee Identification Letter',
                    'document_group_id' => '9',
                    'description' => NULL,
                    'isrecurring' => '0',
                    'ismandatory' => '1',
                    'isactive' => '1',
                    'created_at' => '2023-01-10 08:18:07',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                    'anysource' => 1,
                    'isother' => 0,
                    'document_order' =>NULL,
                ),
     ));


        $this->enableForeignKeys('documents');
    }
}
