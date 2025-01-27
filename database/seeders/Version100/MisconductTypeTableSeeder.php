<?php

namespace Database\Seeders\Version100;

use Database\TruncateTable;
use Illuminate\Database\Seeder;
use Database\DisableForeignKeys;
use Illuminate\Support\Facades\DB;

class MisconductTypeTableSeeder extends Seeder
{

    use DisableForeignKeys, TruncateTable;
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        $data = array(
           0 => array(
        'id' => 1,
        'name' => 'Negligence/ uzembe',
        'created_at' => '2024-12-11 17:33:33',
        'updated_at' => NULL,
        'deleted_at' => NULL,
    ),
    1 => array(
        'id' => 2,
        'name' => 'Gross negligence/ uzembe uliopindukia',
        'created_at' => '2024-12-11 17:33:33',
        'updated_at' => NULL,
        'deleted_at' => NULL,
    ),
    2 => array(
        'id' => 3,
        'name' => 'Insubordination/ kutotii maelekezo',
        'created_at' => '2024-12-11 17:33:33',
        'updated_at' => NULL,
        'deleted_at' => NULL,
    ),
    3 => array(
        'id' => 4,
        'name' => 'Gross insubordination/ Kutotii maelekezo kulikopindukia',
        'created_at' => '2024-12-11 17:33:33',
        'updated_at' => NULL,
        'deleted_at' => NULL,
    ),
    4 => array(
        'id' => 5,
        'name' => 'Dishonest/ udanganyifu',
        'created_at' => '2024-12-11 17:33:33',
        'updated_at' => NULL,
        'deleted_at' => NULL,
    ),
    5 => array(
        'id' => 6,
        'name' => 'Gross Dishonest/ udanganyifu uliopindukia',
        'created_at' => '2024-12-11 17:33:33',
        'updated_at' => NULL,
        'deleted_at' => NULL,
    ),
    6 => array(
        'id' => 7,
        'name' => 'Utoro kazini/ absenteeism',
        'created_at' => '2024-12-11 17:33:33',
        'updated_at' => NULL,
        'deleted_at' => NULL,
    ),
    7 => array(
        'id' => 8,
        'name' => 'Utoro kazini kwa siku zaidi ya tano mfululizo /absent for more than five working days consecutively',
        'created_at' => '2024-12-11 17:33:33',
        'updated_at' => NULL,
        'deleted_at' => NULL,
    ),
    8 => array(
        'id' => 9,
        'name' => 'willful damage of employer\'s property/ Uharibifu wa mali ya mwajiri kwa makusudi',
        'created_at' => '2024-12-11 17:33:33',
        'updated_at' => NULL,
        'deleted_at' => NULL,
    ),
    9 => array(
        'id' => 10,
        'name' => 'Endangering safety of your fellow employee/ kuhatarisha usalama wa mfanyakazi mwenzako',
        'created_at' => '2024-12-11 17:33:33',
        'updated_at' => NULL,
        'deleted_at' => NULL,
    ),
    10 => array(
        'id' => 11,
        'name' => 'Shambulizi la maneno dhidi ya mfanyakazi mwenzako/ verbal assault',
        'created_at' => '2024-12-11 17:33:33',
        'updated_at' => NULL,
        'deleted_at' => NULL,
    ),
    11 => array(
        'id' => 12,
        'name' => 'Kuzua taharuki eneo la kazi ( makazi ya mwajiri)/ causing chaos at workplace (employer\'s premises)',
        'created_at' => '2024-12-11 17:33:33',
        'updated_at' => NULL,
        'deleted_at' => NULL,
    ),
    12 => array(
        'id' => 13,
        'name' => 'Kuvunja kanuni za usalama mahala pa kazi/ violation of the safety rules at workplace',
        'created_at' => '2024-12-11 17:33:33',
        'updated_at' => NULL,
        'deleted_at' => NULL,
    ),
    13 => array(
        'id' => 14,
        'name' => 'Uvunjaji mkubwa wa kanuni za usalama mahala pa kazi/ serious violation of the safety rules',
        'created_at' => '2024-12-11 17:33:33',
        'updated_at' => NULL,
        'deleted_at' => NULL,
    ),
    14 => array(
        'id' => 15,
        'name' => 'Matumizi ya pombe wakati wa kazi/ being under influence of alcohol during working hours',
        'created_at' => '2024-12-11 17:33:33',
        'updated_at' => NULL,
        'deleted_at' => NULL,
    ),
        );

        // $this->enableForeignKeys("marital_statuses");
 $lastRecordCount = $this->getRecordCount("misconduct_types");
        $slice = array_slice($data, $lastRecordCount);;
        if (count($slice)) {
            DB::table('misconduct_types')->insert($slice);
        }
    }
}
