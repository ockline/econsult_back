<?php

namespace Database\Seeders\Version100;

use Illuminate\Database\Seeder;
use Database\TruncateTable;
use Database\DisableForeignKeys;

class LocationTypesTableSeeder extends Seeder
{

    use DisableForeignKeys, TruncateTable;
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        $this->disableForeignKeys('location_types');
        $this->delete('location_types');

        \DB::table('location_types')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Surveyed',
                'created_at' => '2024-01-11 10:37:06',
                'updated_at' => NULL,
                'description' => 'none',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'Unsurveyed',
                'created_at' => '2024-01-11 10:37:06',
                'updated_at' => NULL,
                 'description' => 'none',
            ),
        ));

        $this->enableForeignKeys('location_types');
    }
}
