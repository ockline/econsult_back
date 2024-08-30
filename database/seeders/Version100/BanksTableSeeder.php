<?php

namespace Database\Seeders\Version100;

use Illuminate\Database\Seeder;
// use Database\TruncateTable;
require_once base_path('database/TruncateTable.php');

use Database\DisableForeignKeys;
use Illuminate\Support\Facades\DB;

class BanksTableSeeder extends Seeder
{

    use DisableForeignKeys;
    use \Database\TruncateTable;
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        // $this->disableForeignKeys("banks");
        // $this->delete('banks');

        $data = array(
            0 =>
            array(
                'id' => 1,
                'name' => 'STANDARD CHARTERED',
                'created_at' => '2024-01-11 11:51:47',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'descriptions' => NULL,
                'alias' => 'STANCHART',
            ),
            1 =>
            array(
                'id' => 2,
                'name' => 'POST GIRO',
                'created_at' => '2024-01-11 11:51:47',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'descriptions' => NULL,
                'alias' => '',
            ),
            2 =>
            array(
                'id' => 3,
                'name' => 'NMB',
                'created_at' => '2024-01-11 11:51:47',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'descriptions' => NULL,
                'alias' => 'NMB',
            ),
            3 =>
            array(
                'id' => 4,
                'name' => 'CRDB',
                'created_at' => '2024-01-11 11:51:47',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'descriptions' => NULL,
                'alias' => 'CRDB',
            ),
            4 =>
            array(
                'id' => 5,
                'name' => 'NOT_APPLICABLE',
                'created_at' => '2024-01-11 11:51:47',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'descriptions' => NULL,
                'alias' => '',
            ),
            5 =>
            array(
                'id' => 6,
                'name' => 'WITHDRAWAL',
                'created_at' => '2024-01-11 11:51:47',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'descriptions' => NULL,
                'alias' => '',
            ),
            6 =>
            array(
                'id' => 7,
                'name' => 'BARCLAYS',
                'created_at' => '2024-01-11 11:51:47',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'descriptions' => NULL,
                'alias' => 'BARCLAYS',
            ),
            7 =>
            array(
                'id' => 8,
                'name' => 'TANZANIA COMMERCIAL BANK',
                'created_at' => '2024-01-11 11:51:47',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'descriptions' => NULL,
                'alias' => 'TCB'
            ),
            8 =>
            array(
                'id' => 9,
                'name' => 'NATIONAL BANK OF COMMERCE',
                'created_at' => '2024-01-11 14:33:47',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'descriptions' => NULL,
                'alias' => 'NBC',
            ),
            9 =>
            array(
                'id' => 10,
                'name' => 'ABSA BANK TANZANIA LIMITED',
                'created_at' => '2024-01-09 14:33:47',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'descriptions' => NULL,
                'alias' => 'ABSA',
            ),
            10 =>
            array(
                'id' => 11,
                'name' => 'ACCESS BANK (TANZANIA) LIMITED',
                'created_at' => '2024-01-09 14:33:47',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'descriptions' => NULL,
                'alias' => 'ACCESS',
            ),
            11 =>
            array(
                'id' => 12,
                'name' => 'AKIBA COMMERCIAL BANK PLC',
                'created_at' => '2024-01-09 14:33:47',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'descriptions' => NULL,
                'alias' => 'AKIBA',
            ),
            12 =>
            array(
                'id' => 13,
                'name' => 'AMANA BANK LIMITED',
                'created_at' => '2024-01-09 14:33:47',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'descriptions' => NULL,
                'alias' => 'AMANA',
            ),
            13 =>
            array(
                'id' => 14,
                'name' => 'AZANIA BANK LIMITED',
                'created_at' => '2024-01-09 14:33:47',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'descriptions' => NULL,
                'alias' => 'AZANIA',
            ),
            14 =>
            array(
                'id' => 15,
                'name' => 'BANK OF BARODA TANZANIA LIMITED',
                'created_at' => '2024-01-09 14:33:47',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'descriptions' => NULL,
                'alias' => 'BARODA',
            ),
            15 =>
            array(
                'id' => 16,
                'name' => 'BANK OF INDIA TANZANIA LIMITED',
                'created_at' => '2024-01-09 14:33:47',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'descriptions' => NULL,
                'alias' => 'BOI',
            ),
            16 =>
            array(
                'id' => 17,
                'name' => 'CITIBANK TANZANIA LIMITED',
                'created_at' => '2024-01-09 14:33:47',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'descriptions' => NULL,
                'alias' => '670801',
            ),
            17 =>
            array(
                'id' => 18,
                'name' => 'DCB COMMERCIAL BANK PLC',
                'created_at' => '2024-01-09 14:33:47',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'descriptions' => NULL,
                'alias' => 'DCB',
            ),
            18 =>
            array(
                'id' => 19,
                'name' => 'DIAMOND TRUST BANK TANZANIA LIMITED',
                'created_at' => '2024-01-09 14:33:47',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'descriptions' => NULL,
                'alias' => 'DTB',
            ),
            19 =>
            array(
                'id' => 20,
                'name' => 'ECOBANK TANZANIA LIMITED',
                'created_at' => '2024-01-09 14:33:47',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'descriptions' => NULL,
                'alias' => 'ECOBANK',
            ),
            20 =>
            array(
                'id' => 21,
                'name' => 'EQUITY BANK TANZANIA LIMITED',
                'created_at' => '2024-01-09 14:33:47',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'descriptions' => NULL,
                'alias' => 'EQUITY',
            ),
            21 =>
            array(
                'id' => 22,
                'name' => 'EXIM BANK TANZANIA LIMITED',
                'created_at' => '2024-01-09 14:33:47',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'descriptions' => NULL,
                'alias' => 'EXIM',
            ),
            22 =>
            array(
                'id' => 23,
                'name' => 'I & M BANK TANZANIA LIMITED',
                'created_at' => '2024-01-09 14:33:47',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'descriptions' => NULL,
                'alias' => 'I&M',
            ),
            23 =>
            array(
                'id' => 24,
                'name' => 'MKOMBOZI COMMERCIAL BANK PLC',
                'created_at' => '2024-01-09 14:33:47',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'descriptions' => NULL,
                'alias' => 'MKOMBOZI',

            ),
            24 =>
            array(
                'id' => 25,
                'name' => 'MWALIMU COMMERCIAL BANK PLC',
                'created_at' => '2024-01-09 14:33:47',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'descriptions' => NULL,
                'alias' => 'MWALIMU',
            ),
            25 =>
            array(
                'id' => 26,
                'name' => 'PEOPLES BANK OF ZANZIBAR LIMITED',
                'created_at' => '2024-01-09 14:33:47',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'descriptions' => NULL,
                'alias' => 'PBZ',
            ),
            26 =>
            array(
                'id' => 27,
                'name' => 'STANBIC BANK TANZANIA LTD',
                'created_at' => '2024-01-09 14:33:47',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'descriptions' => NULL,
                'alias' => 'STANBIC',
            ),
            27 =>
            array(
                'id' => 28,
                'name' => 'TIB DEVELOPMENT BANK LIMITED',
                'created_at' => '2024-01-09 14:33:47',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'descriptions' => NULL,
                'alias' => 'TAPBTZTZ',
            ),
            28 =>
            array(
                'id' => 29,
                'name' => 'BANK OF TANZANIA',
                'created_at' => '2024-01-09 14:33:47',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'descriptions' => NULL,
                'alias' => 'BOT',
            ),
            29 =>
            array(
                'id' => 30,
                'name' => 'TRUST BANK (TANZANIA) KIMITED',
                'created_at' => '2024-01-09 14:33:47',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'descriptions' => NULL,
                'alias' => '',
            ),
            30 =>
            array(
                'id' => 31,
                'name' => 'ADVANS BANK TANZANIA',
                'created_at' => '2024-01-09 14:33:47',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'descriptions' => NULL,
                'alias' => '',
            ),
            31 =>
            array(
                'id' => 32,
                'name' => 'BOA BANK TANZANIA',
                'created_at' => '2024-01-09 14:33:47',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'descriptions' => NULL,
                'alias' => 'BOA',
            ),
            32 =>
            array(
                'id' => 33,
                'name' => 'EAST AFRICAN DEVELOPMENT BANK',
                'created_at' => '2024-01-09 14:33:47',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'descriptions' => NULL,
                'alias' => '',
            ),
            33 =>
            array(
                'id' => 34,
                'name' => 'GUARANTY TRUST BANK TANZANIA LTD',
                'created_at' => '2024-01-09 14:33:47',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'descriptions' => NULL,
                'alias' => 'GTBITZTZ',
            ),
            34 =>
            array(
                'id' => 35,
                'name' => 'HABIB AFRICAN BANK',
                'created_at' => '2024-01-09 14:33:47',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'descriptions' => NULL,
                'alias' => 'HABIB',
            ),
            35 =>
            array(
                'id' => 36,
                'name' => 'INTERNATIONAL COMMERCIAL BANK (TANZANIA) LIMITED',
                'created_at' => '2024-01-09 14:33:47',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'descriptions' => NULL,
                'alias' => 'ICB',
            ),
            36 =>
            array(
                'id' => 37,
                'name' => 'KCB BANK TANZANIA LIMITED',
                'created_at' => '2024-01-09 14:33:47',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'descriptions' => NULL,
                'alias' => 'KCB',
            ),
            37 =>
            array(
                'id' => 38,
                'name' => 'MAENDELEO BANK LTD',
                'created_at' => '2024-01-09 14:33:47',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'descriptions' => NULL,
                'alias' => 'MAENDELEO',
            ),
            38 =>
            array(
                'id' => 39,
                'name' => 'NCBA BANK (TANZANIA) LIMITED',
                'created_at' => '2024-01-09 14:33:47',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'descriptions' => NULL,
                'alias' => 'CBA',
            ),
            39 =>
            array(
                'id' => 40,
                'name' => 'UNITED BANK FOR AFRICA (TANZANIA) LIMITED',
                'created_at' => '2024-01-09 14:33:47',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'descriptions' => NULL,
                'alias' => 'UBA',
            ),

            40 =>
            array(
                'id' => 41,
                'name' => 'BANK OF AFRICA',
                'created_at' => '2024-01-09 14:33:47',
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'descriptions' => NULL,
                'alias' => 'BOA',
            ),


        );

        // $this->enableForeignKeys("banks");
        $lastRecordCount = $this->getRecordCount("banks");
        $slice = array_slice($data, $lastRecordCount);;
        if (count($slice)) {
            DB::table('banks')->insert($slice);
        }
    }
}
