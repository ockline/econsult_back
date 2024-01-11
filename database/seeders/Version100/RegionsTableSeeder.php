<?php

namespace Database\Seeders\Version100;

use Illuminate\Database\Seeder;
use Database\TruncateTable;
use Database\DisableForeignKeys;

class RegionsTableSeeder extends Seeder
{

    use DisableForeignKeys, TruncateTable;
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        $this->disableForeignKeys('regions');
        $this->delete('regions');

        \DB::table('regions')->insert(array (
            0 =>
                array (
                    'id' => '1',
                    'name' => 'Dar es Salaam',
                    'country_id' => '1',
                    'office_zone_id' => '2',
                    'created_at' => '2024-01-11 10:28:50',
                    'updated_at' => NULL,

                ),
            1 =>
                array (
                    'id' => '2',
                    'name' => 'Mwanza',
                    'country_id' => '1',
                    'office_zone_id' => '6',
                    'created_at' => '2024-01-11 10:28:50',
                    'updated_at' => NULL,

                ),
            2 =>
                array (
                    'id' => '3',
                    'name' => 'Arusha',
                    'country_id' => '1',
                    'office_zone_id' => '3',
                    'created_at' => '2024-01-11 10:28:50',
                    'updated_at' => NULL,

                ),
            3 =>
                array (
                    'id' => '4',
                    'name' => 'Dodoma',
                    'country_id' => '1',
                    'office_zone_id' => '5',
                    'created_at' => '2024-01-11 10:28:50',
                    'updated_at' => NULL,

                ),
            4 =>
                array (
                    'id' => '5',
                    'name' => 'Geita ',
                    'country_id' => '1',
                    'office_zone_id' => '1',
                    'created_at' => '2024-01-11 10:28:50',
                    'updated_at' => NULL,

                ),
            5 =>
                array (
                    'id' => '6',
                    'name' => 'Iringa',
                    'country_id' => '1',
                    'office_zone_id' => '7',
                    'created_at' => '2024-01-11 10:28:50',
                    'updated_at' => NULL,

                ),
            6 =>
                array (
                    'id' => '7',
                    'name' => 'Kagera',
                    'country_id' => '1',
                    'office_zone_id' => '1',
                    'created_at' => '2024-01-11 10:28:50',
                    'updated_at' => NULL,

                ),
            7 =>
                array (
                    'id' => '8',
                    'name' => 'Katavi',
                    'country_id' => '1',
                    'office_zone_id' => '7',
                    'created_at' => '2024-01-11 10:28:50',
                    'updated_at' => NULL,

                ),
            8 =>
                array (
                    'id' => '9',
                    'name' => 'Kigoma',
                    'country_id' => '1',
                    'office_zone_id' => '9',
                    'created_at' => '2024-01-11 10:28:50',
                    'updated_at' => NULL,

                ),
            9 =>
                array (
                    'id' => '10',
                    'name' => 'Kilimanjaro',
                    'country_id' => '1',
                    'office_zone_id' => '3',
                    'created_at' => '2024-01-11 10:28:50',
                    'updated_at' => NULL,

                ),
            10 =>
                array (
                    'id' => '11',
                    'name' => 'Lindi',
                    'country_id' => '1',
                    'office_zone_id' => '8',
                    'created_at' => '2024-01-11 10:28:50',
                    'updated_at' => NULL,

                ),
            11 =>
                array (
                    'id' => '12',
                    'name' => 'Manyara',
                    'country_id' => '1',
                    'office_zone_id' => '3',
                    'created_at' => '2024-01-11 10:28:50',
                    'updated_at' => NULL,

                ),
            12 =>
                array (
                    'id' => '13',
                    'name' => 'Mara',
                    'country_id' => '1',
                    'office_zone_id' => '6',
                    'created_at' => '2024-01-11 10:28:50',
                    'updated_at' => NULL,

                ),
            13 =>
                array (
                    'id' => '14',
                    'name' => 'Mbeya',
                    'country_id' => '1',
                    'office_zone_id' => '7',
                    'created_at' => '2024-01-11 10:28:50',
                    'updated_at' => NULL,

                ),
            14 =>
                array (
                    'id' => '15',
                    'name' => 'Morogoro',
                    'country_id' => '1',
                    'office_zone_id' => '4',
                    'created_at' => '2024-01-11 10:28:50',
                    'updated_at' => NULL,

                ),
            15 =>
                array (
                    'id' => '16',
                    'name' => 'Mtwara',
                    'country_id' => '1',
                    'office_zone_id' => '8',
                    'created_at' => '2024-01-11 10:28:50',
                    'updated_at' => NULL,

                ),
            16 =>
                array (
                    'id' => '18',
                    'name' => 'Njombe ',
                    'country_id' => '1',
                    'office_zone_id' => '7',
                    'created_at' => '2024-01-11 10:28:50',
                    'updated_at' => NULL,

                ),
            17 =>
                array (
                    'id' => '19',
                    'name' => 'Kaskazini Pemba ',
                    'country_id' => '1',
                    'office_zone_id' => 0,
                    'created_at' => '2024-01-11 10:28:50',
                    'updated_at' => NULL,

                ),
            18 =>
                array (
                    'id' => '20',
                    'name' => 'Kusini Pemba',
                    'country_id' => '1',
                    'office_zone_id' => 0,
                    'created_at' => '2024-01-11 10:28:50',
                    'updated_at' => NULL,

                ),
            19 =>
                array (
                    'id' => '21',
                    'name' => 'Pwani',
                    'country_id' => '1',
                    'office_zone_id' => '2',
                    'created_at' => '2024-01-11 10:28:50',
                    'updated_at' => NULL,

                ),
            20 =>
                array (
                    'id' => '22',
                    'name' => 'Rukwa',
                    'country_id' => '1',
                    'office_zone_id' => '7',
                    'created_at' => '2024-01-11 10:28:50',
                    'updated_at' => NULL,

                ),
            21 =>
                array (
                    'id' => '23',
                    'name' => 'Ruvuma',
                    'country_id' => '1',
                    'office_zone_id' => '8',
                    'created_at' => '2024-01-11 10:28:50',
                    'updated_at' => NULL,

                ),
            22 =>
                array (
                    'id' => '24',
                    'name' => 'Simiyu',
                    'country_id' => '1',
                    'office_zone_id' => '6',
                    'created_at' => '2024-01-11 10:28:50',
                    'updated_at' => NULL,

                ),
            23 =>
                array (
                    'id' => '25',
                    'name' => 'Singida',
                    'country_id' => '1',
                    'office_zone_id' => '5',
                    'created_at' => '2024-01-11 10:28:50',
                    'updated_at' => NULL,

                ),
            24 =>
                array (
                    'id' => '26',
                    'name' => 'Tabora',
                    'country_id' => '1',
                    'office_zone_id' => '9',
                    'created_at' => '2024-01-11 10:28:50',
                    'updated_at' => NULL,

                ),
            25 =>
                array (
                    'id' => '27',
                    'name' => 'Tanga',
                    'country_id' => '1',
                    'office_zone_id' => '3',
                    'created_at' => '2024-01-11 10:28:50',
                    'updated_at' => NULL,

                ),
            26 =>
                array (
                    'id' => '28',
                    'name' => 'Kaskazini Unguja',
                    'country_id' => '1',
                    'office_zone_id' => 0,
                    'created_at' => '2024-01-11 10:28:50',
                    'updated_at' => NULL,

                ),
            27 =>
                array (
                    'id' => '29',
                    'name' => 'Kusini Unguja',
                    'country_id' => '1',
                    'office_zone_id' => 0,
                    'created_at' => '2024-01-11 10:28:50',
                    'updated_at' => NULL,

                ),
            28 =>
                array (
                    'id' => '30',
                    'name' => 'Mjini Magharibi',
                    'country_id' => '1',
                    'office_zone_id' => 0,
                    'created_at' => '2024-01-11 10:28:50',
                    'updated_at' => NULL,

                ),
            29 =>
                array (
                    'id' => '31',
                    'name' => 'Zanzibar Urban West',
                    'country_id' => '1',
                    'office_zone_id' => 0,
                    'created_at' => '2024-01-11 10:28:50',
                    'updated_at' => NULL,

                ),
            30 =>
                array (
                    'id' => '32',
                    'name' => 'Shinyanga',
                    'country_id' => '1',
                    'office_zone_id' => '6',
                    'created_at' => '2024-01-11 10:28:50',
                    'updated_at' => NULL,

                ),
            31 =>
                array (
                    'id' => '33',
                    'name' => 'Songwe',
                    'country_id' => '1',
                    'office_zone_id' => '7',
                    'created_at' => '2024-01-11 10:28:50',
                    'updated_at' => NULL,

                ),
        ));

        $this->enableForeignKeys('regions');
    }
}
