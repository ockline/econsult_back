<?php

namespace Database\Seeders\Version100;

use Illuminate\Database\Seeder;
use Database\TruncateTable;
use Database\DisableForeignKeys;

class DocumentGroupsTableSeeder extends Seeder
{

    use DisableForeignKeys, TruncateTable;
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        $this->disableForeignKeys('document_groups');
        $this->delete('document_groups');

        \DB::table('document_groups')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'name' => 'Claim Administrative',
                    'created_at' => '2024-01-10 09:57:52',
                    'updated_at' => NULL,
                    'short' => 'Admin',
                    'deleted_at' => NULL,
                ),
            1 =>
                array (
                    'id' => 2,
                    'name' => 'Claim Administrative Optional',
                    'created_at' => '2024-01-10 07:57:52',
                    'updated_at' => NULL,
                    'short' => NULL,
                    'deleted_at' => NULL,
                ),
     ));

        $this->enableForeignKeys('document_groups');
    }
}
