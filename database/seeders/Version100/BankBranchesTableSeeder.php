<?php

namespace Database\Seeders\Version100;

use DB;
use Database\TruncateTable;
use Illuminate\Database\Seeder;
use Database\DisableForeignKeys;

class BankBranchesTableSeeder extends Seeder
{

    use DisableForeignKeys, TruncateTable;
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        $this->disableForeignKeys('bank_branches');
        $this->delete('bank_branches');

        DB::table('bank_branches')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'bank_id' => 1,
                    'name' => 'MOSHI',
                    'created_at' => '2024-01-09 11:53:09',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            1 =>
                array (
                    'id' => 2,
                    'bank_id' => 2,
                    'name' => 'ARUSHA',
                    'created_at' => '2024-01-09 11:53:09',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            2 =>
                array (
                    'id' => 3,
                    'bank_id' => 4,
                    'name' => 'ARUSHA',
                    'created_at' => '2024-01-09 11:53:09',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            3 =>
                array (
                    'id' => 4,
                    'bank_id' => 8,
                    'name' => 'KARIAKOO',
                    'created_at' => '2024-01-09 11:53:09',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            4 =>
                array (
                    'id' => 5,
                    'bank_id' => 1,
                    'name' => 'NIC LIFEHOUSE',
                    'created_at' => '2024-01-09 11:53:09',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            5 =>
                array (
                    'id' => 6,
                    'bank_id' => 2,
                    'name' => 'AZIKIWE',
                    'created_at' => '2024-01-09 11:53:09',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            6 =>
                array (
                    'id' => 7,
                    'bank_id' => 4,
                    'name' => 'AZIKIWE',
                    'created_at' => '2024-01-09 11:53:09',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            7 =>
                array (
                    'id' => 8,
                    'bank_id' => 2,
                    'name' => 'CHUNYA',
                    'created_at' => '2024-01-09 11:53:09',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            8 =>
                array (
                    'id' => 9,
                    'bank_id' => 4,
                    'name' => 'DODOMA',
                    'created_at' => '2024-01-09 11:53:09',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            9 =>
                array (
                    'id' => 10,
                    'bank_id' => 1,
                    'name' => 'SHOPPERSPLAZA',
                    'created_at' => '2024-01-09 11:53:09',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            10 =>
                array (
                    'id' => 11,
                    'bank_id' => 2,
                    'name' => 'DAR ES SALAAM',
                    'created_at' => '2024-01-09 11:53:09',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            11 =>
                array (
                    'id' => 12,
                    'bank_id' => 4,
                    'name' => 'HOLLAND',
                    'created_at' => '2024-01-09 11:53:09',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            12 =>
                array (
                    'id' => 13,
                    'bank_id' => 7,
                    'name' => 'SLIPWAY',
                    'created_at' => '2024-01-09 11:53:09',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            13 =>
                array (
                    'id' => 14,
                    'bank_id' => 1,
                    'name' => 'STANDARD CHARTERED',
                    'created_at' => '2024-01-09 11:53:10',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            14 =>
                array (
                    'id' => 15,
                    'bank_id' => 4,
                    'name' => 'KAHAMA',
                    'created_at' => '2024-01-09 11:53:10',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            15 =>
                array (
                    'id' => 16,
                    'bank_id' => 2,
                    'name' => 'IGUNGA',
                    'created_at' => '2024-01-09 11:53:10',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            16 =>
                array (
                    'id' => 17,
                    'bank_id' => 4,
                    'name' => 'KENYATTA',
                    'created_at' => '2024-01-09 11:53:10',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            17 =>
                array (
                    'id' => 18,
                    'bank_id' => 2,
                    'name' => 'MANGULA',
                    'created_at' => '2024-01-09 11:53:10',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            18 =>
                array (
                    'id' => 19,
                    'bank_id' => 4,
                    'name' => 'KIJITONYAMA',
                    'created_at' => '2024-01-09 11:53:10',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            19 =>
                array (
                    'id' => 20,
                    'bank_id' => 7,
                    'name' => 'BARCLAYS',
                    'created_at' => '2024-01-09 11:53:10',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            20 =>
                array (
                    'id' => 21,
                    'bank_id' => 2,
                    'name' => 'MANG\'ULA',
                    'created_at' => '2024-01-09 11:53:10',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            21 =>
                array (
                    'id' => 22,
                    'bank_id' => 4,
                    'name' => 'LINDI',
                    'created_at' => '2024-01-09 11:53:10',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            22 =>
                array (
                    'id' => 23,
                    'bank_id' => 7,
                    'name' => 'OHIO',
                    'created_at' => '2024-01-09 11:53:10',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            23 =>
                array (
                    'id' => 24,
                    'bank_id' => 1,
                    'name' => 'INTERNATIONAL HOUSE',
                    'created_at' => '2024-01-09 11:53:10',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            24 =>
                array (
                    'id' => 25,
                    'bank_id' => 2,
                    'name' => 'MANZESE',
                    'created_at' => '2024-01-09 11:53:10',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            25 =>
                array (
                    'id' => 26,
                    'bank_id' => 4,
                    'name' => 'LUMUMBA',
                    'created_at' => '2024-01-09 11:53:10',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            26 =>
                array (
                    'id' => 27,
                    'bank_id' => 7,
                    'name' => 'UKONGA',
                    'created_at' => '2024-01-09 11:53:10',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            27 =>
                array (
                    'id' => 28,
                    'bank_id' => 1,
                    'name' => 'ARUSHA',
                    'created_at' => '2024-01-09 11:53:10',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            28 =>
                array (
                    'id' => 29,
                    'bank_id' => 2,
                    'name' => 'MASASI',
                    'created_at' => '2024-01-09 11:53:10',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            29 =>
                array (
                    'id' => 30,
                    'bank_id' => 4,
                    'name' => 'MANDELA',
                    'created_at' => '2024-01-09 11:53:10',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            30 =>
                array (
                    'id' => 31,
                    'bank_id' => 7,
                    'name' => 'MUSOMA',
                    'created_at' => '2024-01-09 11:53:10',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            31 =>
                array (
                    'id' => 32,
                    'bank_id' => 2,
                    'name' => 'MOROGORO',
                    'created_at' => '2024-01-09 11:53:10',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            32 =>
                array (
                    'id' => 33,
                    'bank_id' => 4,
                    'name' => 'MOROGORO',
                    'created_at' => '2024-01-09 11:53:10',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            33 =>
                array (
                    'id' => 34,
                    'bank_id' => 7,
                    'name' => 'DODOMA',
                    'created_at' => '2024-01-09 11:53:10',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            34 =>
                array (
                    'id' => 35,
                    'bank_id' => 4,
                    'name' => 'MTWARA',
                    'created_at' => '2024-01-09 11:53:10',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            35 =>
                array (
                    'id' => 36,
                    'bank_id' => 7,
                    'name' => 'MWANZA',
                    'created_at' => '2024-01-09 11:53:10',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            36 =>
                array (
                    'id' => 37,
                    'bank_id' => 2,
                    'name' => 'MULEBA',
                    'created_at' => '2024-01-09 11:53:10',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            37 =>
                array (
                    'id' => 38,
                    'bank_id' => 4,
                    'name' => 'MUSOMA',
                    'created_at' => '2024-01-09 11:53:10',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            38 =>
                array (
                    'id' => 39,
                    'bank_id' => 2,
                    'name' => 'MWANZA',
                    'created_at' => '2024-01-09 11:53:10',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            39 =>
                array (
                    'id' => 40,
                    'bank_id' => 4,
                    'name' => 'MWANZA',
                    'created_at' => '2024-01-09 11:53:10',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            40 =>
                array (
                    'id' => 41,
                    'bank_id' => 2,
                    'name' => 'NKASI',
                    'created_at' => '2024-01-09 11:53:10',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            41 =>
                array (
                    'id' => 42,
                    'bank_id' => 3,
                    'name' => 'DODOMA',
                    'created_at' => '2024-01-09 11:53:10',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            42 =>
                array (
                    'id' => 43,
                    'bank_id' => 4,
                    'name' => 'TANGA',
                    'created_at' => '2024-01-09 11:53:11',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            43 =>
                array (
                    'id' => 44,
                    'bank_id' => 2,
                    'name' => 'SHINYANGA',
                    'created_at' => '2024-01-09 11:53:11',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            44 =>
                array (
                    'id' => 45,
                    'bank_id' => 4,
                    'name' => 'VIJANA',
                    'created_at' => '2024-01-09 11:53:11',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            45 =>
                array (
                    'id' => 46,
                    'bank_id' => 4,
                    'name' => 'ARUSHA',
                    'created_at' => '2024-01-09 11:53:11',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            46 =>
                array (
                    'id' => 47,
                    'bank_id' => 2,
                    'name' => 'TABORA',
                    'created_at' => '2024-01-09 11:53:11',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            47 =>
                array (
                    'id' => 48,
                    'bank_id' => 4,
                    'name' => 'AZIKIWE',
                    'created_at' => '2024-01-09 11:53:11',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            48 =>
                array (
                    'id' => 49,
                    'bank_id' => 4,
                    'name' => 'BUGANDO',
                    'created_at' => '2024-01-09 11:53:11',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            49 =>
                array (
                    'id' => 50,
                    'bank_id' => 2,
                    'name' => 'TUKUYU',
                    'created_at' => '2024-01-09 11:53:11',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            50 =>
                array (
                    'id' => 51,
                    'bank_id' => 2,
                    'name' => 'ZANZIBAR',
                    'created_at' => '2024-01-09 11:53:11',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            51 =>
                array (
                    'id' => 52,
                    'bank_id' => 2,
                    'name' => 'HANDENI',
                    'created_at' => '2024-01-09 11:53:11',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            52 =>
                array (
                    'id' => 53,
                    'bank_id' => 4,
                    'name' => 'DODOMA',
                    'created_at' => '2024-01-09 11:53:11',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            53 =>
                array (
                    'id' => 54,
                    'bank_id' => 2,
                    'name' => 'TANGA',
                    'created_at' => '2024-01-09 11:53:11',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            54 =>
                array (
                    'id' => 55,
                    'bank_id' => 3,
                    'name' => 'IRAMBA',
                    'created_at' => '2024-01-09 11:53:11',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            55 =>
                array (
                    'id' => 56,
                    'bank_id' => 4,
                    'name' => 'HAI',
                    'created_at' => '2024-01-09 11:53:11',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            56 =>
                array (
                    'id' => 57,
                    'bank_id' => 2,
                    'name' => 'MUGUMU',
                    'created_at' => '2024-01-09 11:53:11',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            57 =>
                array (
                    'id' => 58,
                    'bank_id' => 3,
                    'name' => 'IRINGA',
                    'created_at' => '2024-01-09 11:53:11',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            58 =>
                array (
                    'id' => 59,
                    'bank_id' => 4,
                    'name' => 'HOLLAND',
                    'created_at' => '2024-01-09 11:53:11',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            59 =>
                array (
                    'id' => 60,
                    'bank_id' => 2,
                    'name' => 'SUMBAWANGA',
                    'created_at' => '2024-01-09 11:53:11',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            60 =>
                array (
                    'id' => 61,
                    'bank_id' => 4,
                    'name' => 'IRINGA',
                    'created_at' => '2024-01-09 11:53:11',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            61 =>
                array (
                    'id' => 62,
                    'bank_id' => 2,
                    'name' => 'KURASINI',
                    'created_at' => '2024-01-09 11:53:11',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            62 =>
                array (
                    'id' => 63,
                    'bank_id' => 3,
                    'name' => 'KARAGWE',
                    'created_at' => '2024-01-09 11:53:11',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            63 =>
                array (
                    'id' => 64,
                    'bank_id' => 4,
                    'name' => 'KAHAMA',
                    'created_at' => '2024-01-09 11:53:11',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            64 =>
                array (
                    'id' => 65,
                    'bank_id' => 4,
                    'name' => 'KARAGWE',
                    'created_at' => '2024-01-09 11:53:11',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            65 =>
                array (
                    'id' => 66,
                    'bank_id' => 4,
                    'name' => 'KIGOMA',
                    'created_at' => '2024-01-09 11:53:12',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            66 =>
                array (
                    'id' => 67,
                    'bank_id' => 4,
                    'name' => 'KIJITONYAMA',
                    'created_at' => '2024-01-09 11:53:12',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            67 =>
                array (
                    'id' => 68,
                    'bank_id' => 4,
                    'name' => 'LINDI',
                    'created_at' => '2024-01-09 11:53:12',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            68 =>
                array (
                    'id' => 69,
                    'bank_id' => 3,
                    'name' => 'KHATESH',
                    'created_at' => '2024-01-09 11:53:12',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            69 =>
                array (
                    'id' => 70,
                    'bank_id' => 4,
                    'name' => 'LUMUMBA',
                    'created_at' => '2024-01-09 11:53:12',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            70 =>
                array (
                    'id' => 71,
                    'bank_id' => 4,
                    'name' => 'MBEYA',
                    'created_at' => '2024-01-09 11:53:12',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            71 =>
                array (
                    'id' => 72,
                    'bank_id' => 4,
                    'name' => 'MERU',
                    'created_at' => '2024-01-09 11:53:12',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            72 =>
                array (
                    'id' => 73,
                    'bank_id' => 3,
                    'name' => 'KIBO',
                    'created_at' => '2024-01-09 11:53:12',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            73 =>
                array (
                    'id' => 74,
                    'bank_id' => 4,
                    'name' => 'MOROGORO',
                    'created_at' => '2024-01-09 11:53:12',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            74 =>
                array (
                    'id' => 75,
                    'bank_id' => 4,
                    'name' => 'MOSHI',
                    'created_at' => '2024-01-09 11:53:12',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            75 =>
                array (
                    'id' => 76,
                    'bank_id' => 4,
                    'name' => 'MTWARA',
                    'created_at' => '2024-01-09 11:53:12',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            76 =>
                array (
                    'id' => 77,
                    'bank_id' => 4,
                    'name' => 'MWANZA',
                    'created_at' => '2024-01-09 11:53:12',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            77 =>
                array (
                    'id' => 78,
                    'bank_id' => 4,
                    'name' => 'MZUMBE',
                    'created_at' => '2024-01-09 11:53:12',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            78 =>
                array (
                    'id' => 79,
                    'bank_id' => 4,
                    'name' => 'NYERERE ROAD',
                    'created_at' => '2024-01-09 11:53:12',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            79 =>
                array (
                    'id' => 80,
                    'bank_id' => 4,
                    'name' => 'REGIONAL DRIVE',
                    'created_at' => '2024-01-09 11:53:12',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            80 =>
                array (
                    'id' => 81,
                    'bank_id' => 4,
                    'name' => 'SHINYANGA',
                    'created_at' => '2024-01-09 11:53:13',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            81 =>
                array (
                    'id' => 82,
                    'bank_id' => 4,
                    'name' => 'SINGIDA',
                    'created_at' => '2024-01-09 11:53:13',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            82 =>
                array (
                    'id' => 83,
                    'bank_id' => 4,
                    'name' => 'SONGEA',
                    'created_at' => '2024-01-09 11:53:13',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            83 =>
                array (
                    'id' => 84,
                    'bank_id' => 3,
                    'name' => 'KUU STREET',
                    'created_at' => '2024-01-09 11:53:13',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            84 =>
                array (
                    'id' => 85,
                    'bank_id' => 4,
                    'name' => 'SUA',
                    'created_at' => '2024-01-09 11:53:13',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            85 =>
                array (
                    'id' => 86,
                    'bank_id' => 3,
                    'name' => 'KWIMBA',
                    'created_at' => '2024-01-09 11:53:13',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            86 =>
                array (
                    'id' => 87,
                    'bank_id' => 4,
                    'name' => 'TABORA',
                    'created_at' => '2024-01-09 11:53:13',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            87 =>
                array (
                    'id' => 88,
                    'bank_id' => 4,
                    'name' => 'TANGA',
                    'created_at' => '2024-01-09 11:53:13',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            88 =>
                array (
                    'id' => 89,
                    'bank_id' => 4,
                    'name' => 'TOWER',
                    'created_at' => '2024-01-09 11:53:13',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            89 =>
                array (
                    'id' => 90,
                    'bank_id' => 4,
                    'name' => 'UDSM',
                    'created_at' => '2024-01-09 11:53:13',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            90 =>
                array (
                    'id' => 91,
                    'bank_id' => 4,
                    'name' => 'VIJANA',
                    'created_at' => '2024-01-09 11:53:13',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            91 =>
                array (
                    'id' => 92,
                    'bank_id' => 3,
                    'name' => 'LUMUMBA',
                    'created_at' => '2024-01-09 11:53:13',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            92 =>
                array (
                    'id' => 93,
                    'bank_id' => 4,
                    'name' => 'MLIMANI CITY',
                    'created_at' => '2024-01-09 11:53:13',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            93 =>
                array (
                    'id' => 94,
                    'bank_id' => 4,
                    'name' => 'WATER FRONT',
                    'created_at' => '2024-01-09 11:53:14',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            94 =>
                array (
                    'id' => 95,
                    'bank_id' => 4,
                    'name' => 'KIBAHA',
                    'created_at' => '2024-01-09 11:53:14',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            95 =>
                array (
                    'id' => 96,
                    'bank_id' => 4,
                    'name' => 'MANDELA',
                    'created_at' => '2024-01-09 11:53:14',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            96 =>
                array (
                    'id' => 97,
                    'bank_id' => 4,
                    'name' => 'CLOCK TOWER',
                    'created_at' => '2024-01-09 11:53:14',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            97 =>
                array (
                    'id' => 98,
                    'bank_id' => 4,
                    'name' => 'MUSOMA',
                    'created_at' => '2024-01-09 11:53:14',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            98 =>
                array (
                    'id' => 99,
                    'bank_id' => 4,
                    'name' => 'KENYATTA',
                    'created_at' => '2024-01-09 11:53:14',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            99 =>
                array (
                    'id' => 100,
                    'bank_id' => 4,
                    'name' => 'BUKOBA',
                    'created_at' => '2024-01-09 11:53:14',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            100 =>
                array (
                    'id' => 101,
                    'bank_id' => 4,
                    'name' => 'SUMBAWANGA',
                    'created_at' => '2024-01-09 11:53:14',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            101 =>
                array (
                    'id' => 102,
                    'bank_id' => 4,
                    'name' => 'MAZIMBU',
                    'created_at' => '2024-01-09 11:53:14',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            102 =>
                array (
                    'id' => 103,
                    'bank_id' => 4,
                    'name' => 'AZIKIWE PREMIER',
                    'created_at' => '2024-01-09 11:53:14',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            103 =>
                array (
                    'id' => 104,
                    'bank_id' => 4,
                    'name' => 'BIHARAMULO',
                    'created_at' => '2024-01-09 11:53:14',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            104 =>
                array (
                    'id' => 105,
                    'bank_id' => 4,
                    'name' => 'BUNDA',
                    'created_at' => '2024-01-09 11:53:14',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            105 =>
                array (
                    'id' => 106,
                    'bank_id' => 3,
                    'name' => 'BOMA NGOMBE',
                    'created_at' => '2024-01-09 11:53:14',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            106 =>
                array (
                    'id' => 107,
                    'bank_id' => 4,
                    'name' => 'GEITA',
                    'created_at' => '2024-01-09 11:53:15',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            107 =>
                array (
                    'id' => 108,
                    'bank_id' => 3,
                    'name' => 'BUKOMBE',
                    'created_at' => '2024-01-09 11:53:15',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            108 =>
                array (
                    'id' => 109,
                    'bank_id' => 4,
                    'name' => 'KAYANGA',
                    'created_at' => '2024-01-09 11:53:15',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            109 =>
                array (
                    'id' => 110,
                    'bank_id' => 3,
                    'name' => 'ITUMBA',
                    'created_at' => '2024-01-09 11:53:15',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            110 =>
                array (
                    'id' => 111,
                    'bank_id' => 4,
                    'name' => 'MAGU',
                    'created_at' => '2024-01-09 11:53:15',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            111 =>
                array (
                    'id' => 112,
                    'bank_id' => 3,
                    'name' => 'KILINDI',
                    'created_at' => '2024-01-09 11:53:15',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            112 =>
                array (
                    'id' => 113,
                    'bank_id' => 4,
                    'name' => 'MBAGALA',
                    'created_at' => '2024-01-09 11:53:15',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            113 =>
                array (
                    'id' => 114,
                    'bank_id' => 3,
                    'name' => 'MISSENYI',
                    'created_at' => '2024-01-09 11:53:15',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            114 =>
                array (
                    'id' => 115,
                    'bank_id' => 4,
                    'name' => 'MBINGA',
                    'created_at' => '2024-01-09 11:53:15',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            115 =>
                array (
                    'id' => 116,
                    'bank_id' => 4,
                    'name' => 'MBOZI',
                    'created_at' => '2024-01-09 11:53:15',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            116 =>
                array (
                    'id' => 117,
                    'bank_id' => 3,
                    'name' => 'MBEYA',
                    'created_at' => '2024-01-09 11:53:15',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            117 =>
                array (
                    'id' => 118,
                    'bank_id' => 4,
                    'name' => 'MULEBA',
                    'created_at' => '2024-01-09 11:53:15',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            118 =>
                array (
                    'id' => 119,
                    'bank_id' => 3,
                    'name' => 'KILOLO',
                    'created_at' => '2024-01-09 11:53:16',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            119 =>
                array (
                    'id' => 120,
                    'bank_id' => 4,
                    'name' => 'RUAHA',
                    'created_at' => '2024-01-09 11:53:16',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            120 =>
                array (
                    'id' => 121,
                    'bank_id' => 3,
                    'name' => 'MKURANGA',
                    'created_at' => '2024-01-09 11:53:16',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            121 =>
                array (
                    'id' => 122,
                    'bank_id' => 4,
                    'name' => 'TARIME',
                    'created_at' => '2024-01-09 11:53:16',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            122 =>
                array (
                    'id' => 123,
                    'bank_id' => 3,
                    'name' => 'NAMTUMBO',
                    'created_at' => '2024-01-09 11:53:16',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            123 =>
                array (
                    'id' => 124,
                    'bank_id' => 4,
                    'name' => 'USA RIVER',
                    'created_at' => '2024-01-09 11:53:16',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            124 =>
                array (
                    'id' => 125,
                    'bank_id' => 3,
                    'name' => 'MEATU',
                    'created_at' => '2024-01-09 11:53:16',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            125 =>
                array (
                    'id' => 126,
                    'bank_id' => 4,
                    'name' => 'MBEZI BEACH',
                    'created_at' => '2024-01-09 11:53:16',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            126 =>
                array (
                    'id' => 127,
                    'bank_id' => 4,
                    'name' => 'SIMANJIRO',
                    'created_at' => '2024-01-09 11:53:16',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            127 =>
                array (
                    'id' => 128,
                    'bank_id' => 3,
                    'name' => 'MWADUI',
                    'created_at' => '2024-01-09 11:53:16',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            128 =>
                array (
                    'id' => 129,
                    'bank_id' => 4,
                    'name' => 'MAPATO',
                    'created_at' => '2024-01-09 11:53:16',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            129 =>
                array (
                    'id' => 130,
                    'bank_id' => 3,
                    'name' => 'MKUU ROMBO',
                    'created_at' => '2024-01-09 11:53:16',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            130 =>
                array (
                    'id' => 131,
                    'bank_id' => 4,
                    'name' => 'NYANZA',
                    'created_at' => '2024-01-09 11:53:16',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            131 =>
                array (
                    'id' => 132,
                    'bank_id' => 3,
                    'name' => 'MKUU STREET',
                    'created_at' => '2024-01-09 11:53:16',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            132 =>
                array (
                    'id' => 133,
                    'bank_id' => 4,
                    'name' => 'MLIMANI',
                    'created_at' => '2024-01-09 11:53:16',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            133 =>
                array (
                    'id' => 134,
                    'bank_id' => 3,
                    'name' => 'RUANGWA',
                    'created_at' => '2024-01-09 11:53:16',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            134 =>
                array (
                    'id' => 135,
                    'bank_id' => 3,
                    'name' => 'TANDAHIMBA',
                    'created_at' => '2024-01-09 11:53:16',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            135 =>
                array (
                    'id' => 136,
                    'bank_id' => 3,
                    'name' => 'CHATO',
                    'created_at' => '2024-01-09 11:53:16',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            136 =>
                array (
                    'id' => 137,
                    'bank_id' => 3,
                    'name' => 'MOSHI',
                    'created_at' => '2024-01-09 11:53:16',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            137 =>
                array (
                    'id' => 138,
                    'bank_id' => 3,
                    'name' => 'NMB HOUSE',
                    'created_at' => '2024-01-09 11:53:16',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            138 =>
                array (
                    'id' => 139,
                    'bank_id' => 3,
                    'name' => 'MAZENGO',
                    'created_at' => '2024-01-09 11:53:16',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            139 =>
                array (
                    'id' => 140,
                    'bank_id' => 3,
                    'name' => 'AIRPORT',
                    'created_at' => '2024-01-09 11:53:16',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            140 =>
                array (
                    'id' => 141,
                    'bank_id' => 3,
                    'name' => 'AZIMIO',
                    'created_at' => '2024-01-09 11:53:16',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            141 =>
                array (
                    'id' => 142,
                    'bank_id' => 4,
                    'name' => 'MBAMBA BAY',
                    'created_at' => '2024-01-09 11:53:16',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            142 =>
                array (
                    'id' => 143,
                    'bank_id' => 3,
                    'name' => 'SHIRATI',
                    'created_at' => '2024-01-09 11:53:16',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            143 =>
                array (
                    'id' => 144,
                    'bank_id' => 4,
                    'name' => 'MWIKA',
                    'created_at' => '2024-01-09 11:53:16',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            144 =>
                array (
                    'id' => 145,
                    'bank_id' => 3,
                    'name' => 'KITETO',
                    'created_at' => '2024-01-09 11:53:16',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            145 =>
                array (
                    'id' => 146,
                    'bank_id' => 4,
                    'name' => 'KARIAKOO',
                    'created_at' => '2024-01-09 11:53:16',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            146 =>
                array (
                    'id' => 147,
                    'bank_id' => 4,
                    'name' => 'KILOMBERO',
                    'created_at' => '2024-01-09 11:53:16',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            147 =>
                array (
                    'id' => 148,
                    'bank_id' => 3,
                    'name' => 'MWANZA',
                    'created_at' => '2024-01-09 11:53:16',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            148 =>
                array (
                    'id' => 149,
                    'bank_id' => 4,
                    'name' => 'KOROGWE',
                    'created_at' => '2024-01-09 11:53:16',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            149 =>
                array (
                    'id' => 150,
                    'bank_id' => 3,
                    'name' => 'MWNJELWA',
                    'created_at' => '2024-01-09 11:53:16',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            150 =>
                array (
                    'id' => 151,
                    'bank_id' => 7,
                    'name' => 'MWANJELWA',
                    'created_at' => '2024-01-09 11:53:16',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            151 =>
                array (
                    'id' => 152,
                    'bank_id' => 7,
                    'name' => 'KINONDONI',
                    'created_at' => '2024-01-09 11:53:16',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            152 =>
                array (
                    'id' => 153,
                    'bank_id' => 3,
                    'name' => 'GAIRO',
                    'created_at' => '2024-01-09 11:53:16',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            153 =>
                array (
                    'id' => 154,
                    'bank_id' => 4,
                    'name' => 'KATORO',
                    'created_at' => '2024-01-09 11:53:16',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            154 =>
                array (
                    'id' => 155,
                    'bank_id' => 4,
                    'name' => 'MPWAPWA',
                    'created_at' => '2024-01-09 11:53:16',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            155 =>
                array (
                    'id' => 156,
                    'bank_id' => 3,
                    'name' => 'NOT_SEEN',
                    'created_at' => '2024-01-09 11:53:16',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            156 =>
                array (
                    'id' => 157,
                    'bank_id' => 3,
                    'name' => 'PEMBA',
                    'created_at' => '2024-01-09 11:53:16',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            157 =>
                array (
                    'id' => 158,
                    'bank_id' => 3,
                    'name' => 'POSTAL BANKILAL',
                    'created_at' => '2024-01-09 11:53:16',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            158 =>
                array (
                    'id' => 159,
                    'bank_id' => 3,
                    'name' => 'RUAHA',
                    'created_at' => '2024-01-09 11:53:16',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            159 =>
                array (
                    'id' => 160,
                    'bank_id' => 3,
                    'name' => 'RUJEWA',
                    'created_at' => '2024-01-09 11:53:17',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            160 =>
                array (
                    'id' => 161,
                    'bank_id' => 3,
                    'name' => 'SHINYANGA',
                    'created_at' => '2024-01-09 11:53:17',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            161 =>
                array (
                    'id' => 162,
                    'bank_id' => 3,
                    'name' => 'TABORA',
                    'created_at' => '2024-01-09 11:53:17',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            162 =>
                array (
                    'id' => 163,
                    'bank_id' => 3,
                    'name' => 'TANGA',
                    'created_at' => '2024-01-09 11:53:17',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            163 =>
                array (
                    'id' => 164,
                    'bank_id' => 3,
                    'name' => 'TUMBI',
                    'created_at' => '2024-01-09 11:53:17',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            164 =>
                array (
                    'id' => 165,
                    'bank_id' => 3,
                    'name' => 'URAMBO',
                    'created_at' => '2024-01-09 11:53:17',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            165 =>
                array (
                    'id' => 166,
                    'bank_id' => 3,
                    'name' => 'VWAWA',
                    'created_at' => '2024-01-09 11:53:17',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            166 =>
                array (
                    'id' => 167,
                    'bank_id' => 3,
                    'name' => 'WETE',
                    'created_at' => '2024-01-09 11:53:17',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            167 =>
                array (
                    'id' => 168,
                    'bank_id' => 5,
                    'name' => 'NOT_SEEN',
                    'created_at' => '2024-01-09 11:53:17',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            168 =>
                array (
                    'id' => 169,
                    'bank_id' => 6,
                    'name' => 'WITHDRAWAL',
                    'created_at' => '2024-01-09 11:53:17',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            169 =>
                array (
                    'id' => 170,
                    'bank_id' => 4,
                    'name' => 'TEGETA',
                    'created_at' => '2024-01-09 11:53:17',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            170 =>
                array (
                    'id' => 171,
                    'bank_id' => 3,
                    'name' => 'UDOM',
                    'created_at' => '2024-01-09 11:53:17',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            171 =>
                array (
                    'id' => 172,
                    'bank_id' => 4,
                    'name' => 'MUHEZA',
                    'created_at' => '2024-01-09 11:53:17',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            172 =>
                array (
                    'id' => 173,
                    'bank_id' => 4,
                    'name' => 'SIKONGE',
                    'created_at' => '2024-01-09 11:53:17',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            173 =>
                array (
                    'id' => 174,
                    'bank_id' => 4,
                    'name' => 'NZEGA',
                    'created_at' => '2024-01-09 11:53:17',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            174 =>
                array (
                    'id' => 175,
                    'bank_id' => 4,
                    'name' => 'URAMBO',
                    'created_at' => '2024-01-09 11:53:17',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            175 =>
                array (
                    'id' => 176,
                    'bank_id' => 4,
                    'name' => 'ZANZIBAR',
                    'created_at' => '2024-01-09 11:53:17',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            176 =>
                array (
                    'id' => 177,
                    'bank_id' => 4,
                    'name' => 'MABIBO HOSTEL',
                    'created_at' => '2024-01-09 11:53:17',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            177 =>
                array (
                    'id' => 178,
                    'bank_id' => 4,
                    'name' => 'QUALITY CENTRE',
                    'created_at' => '2024-01-09 11:53:17',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            178 =>
                array (
                    'id' => 179,
                    'bank_id' => 4,
                    'name' => 'MBEZI MWISHO',
                    'created_at' => '2024-01-09 11:53:17',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            179 =>
                array (
                    'id' => 180,
                    'bank_id' => 4,
                    'name' => 'TFA',
                    'created_at' => '2024-01-09 11:53:17',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            180 =>
                array (
                    'id' => 181,
                    'bank_id' => 3,
                    'name' => 'KIBAHA',
                    'created_at' => '2024-01-09 11:53:17',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            181 =>
                array (
                    'id' => 182,
                    'bank_id' => 4,
                    'name' => 'UBUNGO',
                    'created_at' => '2024-01-09 11:53:17',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            182 =>
                array (
                    'id' => 183,
                    'bank_id' => 4,
                    'name' => 'KONDOA',
                    'created_at' => '2024-01-09 11:53:17',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            183 =>
                array (
                    'id' => 184,
                    'bank_id' => 3,
                    'name' => 'ZANZIBAR',
                    'created_at' => '2024-01-09 11:53:17',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            184 =>
                array (
                    'id' => 185,
                    'bank_id' => 3,
                    'name' => 'RORYA',
                    'created_at' => '2024-01-09 11:53:17',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            185 =>
                array (
                    'id' => 186,
                    'bank_id' => 3,
                    'name' => 'SIHA',
                    'created_at' => '2024-01-09 11:53:17',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            186 =>
                array (
                    'id' => 187,
                    'bank_id' => 4,
                    'name' => 'TEMEKE',
                    'created_at' => '2024-01-09 11:53:17',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            187 =>
                array (
                    'id' => 188,
                    'bank_id' => 4,
                    'name' => 'KILOSA',
                    'created_at' => '2024-01-09 11:53:17',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            188 =>
                array (
                    'id' => 189,
                    'bank_id' => 4,
                    'name' => 'MKWAWA',
                    'created_at' => '2024-01-09 11:53:17',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            189 =>
                array (
                    'id' => 190,
                    'bank_id' => 3,
                    'name' => 'MBAGALA',
                    'created_at' => '2024-01-09 11:53:17',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            190 =>
                array (
                    'id' => 191,
                    'bank_id' => 4,
                    'name' => 'NJOMBE',
                    'created_at' => '2024-01-09 11:53:17',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            191 =>
                array (
                    'id' => 192,
                    'bank_id' => 4,
                    'name' => 'MONDULI',
                    'created_at' => '2024-01-09 11:53:17',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            192 =>
                array (
                    'id' => 193,
                    'bank_id' => 4,
                    'name' => 'MBALIZI',
                    'created_at' => '2024-01-09 11:53:17',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            193 =>
                array (
                    'id' => 194,
                    'bank_id' => 4,
                    'name' => 'TABATA',
                    'created_at' => '2024-01-09 11:53:17',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            194 =>
                array (
                    'id' => 195,
                    'bank_id' => 4,
                    'name' => 'BAGAMOYO',
                    'created_at' => '2024-01-09 11:53:17',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            195 =>
                array (
                    'id' => 196,
                    'bank_id' => 3,
                    'name' => 'MVOMERO',
                    'created_at' => '2024-01-09 11:53:17',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            196 =>
                array (
                    'id' => 197,
                    'bank_id' => 3,
                    'name' => 'MAGUMU',
                    'created_at' => '2024-01-09 11:53:18',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            197 =>
                array (
                    'id' => 198,
                    'bank_id' => 4,
                    'name' => 'PUGU ROAD',
                    'created_at' => '2024-01-09 11:53:18',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            198 =>
                array (
                    'id' => 199,
                    'bank_id' => 4,
                    'name' => 'MARANGU',
                    'created_at' => '2024-01-09 11:53:18',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            199 =>
                array (
                    'id' => 200,
                    'bank_id' => 4,
                    'name' => 'AZIKIWE PREMIUM',
                    'created_at' => '2024-01-09 11:53:18',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            200 =>
                array (
                    'id' => 201,
                    'bank_id' => 4,
                    'name' => 'IFAKARA',
                    'created_at' => '2024-01-09 11:53:18',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            201 =>
                array (
                    'id' => 202,
                    'bank_id' => 4,
                    'name' => 'KYELA',
                    'created_at' => '2024-01-09 11:53:18',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            202 =>
                array (
                    'id' => 203,
                    'bank_id' => 4,
                    'name' => 'KIBONDO',
                    'created_at' => '2024-01-09 11:53:18',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            203 =>
                array (
                    'id' => 204,
                    'bank_id' => 7,
                    'name' => 'MPWAPWA',
                    'created_at' => '2024-01-09 11:53:18',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            204 =>
                array (
                    'id' => 205,
                    'bank_id' => 4,
                    'name' => 'MASIKA',
                    'created_at' => '2024-01-09 11:53:18',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            205 =>
                array (
                    'id' => 206,
                    'bank_id' => 3,
                    'name' => 'MLIMANI CITY',
                    'created_at' => '2024-01-09 11:53:18',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            206 =>
                array (
                    'id' => 207,
                    'bank_id' => 3,
                    'name' => 'HIMO',
                    'created_at' => '2024-01-09 11:53:18',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            207 =>
                array (
                    'id' => 208,
                    'bank_id' => 3,
                    'name' => 'USONGWE',
                    'created_at' => '2024-01-09 11:53:18',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            208 =>
                array (
                    'id' => 209,
                    'bank_id' => 4,
                    'name' => 'NGARAMTONI',
                    'created_at' => '2024-01-09 11:53:18',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            209 =>
                array (
                    'id' => 210,
                    'bank_id' => 3,
                    'name' => 'USER-RIVER',
                    'created_at' => '2024-01-09 11:53:18',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            210 =>
                array (
                    'id' => 211,
                    'bank_id' => 4,
                    'name' => 'MWANJELWA',
                    'created_at' => '2024-01-09 11:53:18',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            211 =>
                array (
                    'id' => 212,
                    'bank_id' => 4,
                    'name' => 'CHUNYA',
                    'created_at' => '2024-01-09 11:53:18',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            212 =>
                array (
                    'id' => 213,
                    'bank_id' => 4,
                    'name' => 'UDOM',
                    'created_at' => '2024-01-09 11:53:18',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            213 =>
                array (
                    'id' => 214,
                    'bank_id' => 4,
                    'name' => 'BARIADI',
                    'created_at' => '2024-01-09 11:53:18',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            214 =>
                array (
                    'id' => 215,
                    'bank_id' => 4,
                    'name' => 'PREMIER',
                    'created_at' => '2024-01-09 11:53:18',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            215 =>
                array (
                    'id' => 216,
                    'bank_id' => 4,
                    'name' => 'MIKOCHENI',
                    'created_at' => '2024-01-09 11:53:18',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            216 =>
                array (
                    'id' => 217,
                    'bank_id' => 4,
                    'name' => 'MASASI',
                    'created_at' => '2024-01-09 11:53:18',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            217 =>
                array (
                    'id' => 218,
                    'bank_id' => 4,
                    'name' => 'MPANDA',
                    'created_at' => '2024-01-09 11:53:18',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            218 =>
                array (
                    'id' => 219,
                    'bank_id' => 4,
                    'name' => 'MWALONI',
                    'created_at' => '2024-01-09 11:53:18',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            219 =>
                array (
                    'id' => 220,
                    'bank_id' => 4,
                    'name' => 'CHAMWINO',
                    'created_at' => '2024-01-09 11:53:18',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            220 =>
                array (
                    'id' => 221,
                    'bank_id' => 3,
                    'name' => 'LIWALE',
                    'created_at' => '2024-01-09 11:53:18',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            221 =>
                array (
                    'id' => 222,
                    'bank_id' => 3,
                    'name' => 'SONGWE',
                    'created_at' => '2024-01-09 11:53:18',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            222 =>
                array (
                    'id' => 223,
                    'bank_id' => 7,
                    'name' => 'BUGURUNI',
                    'created_at' => '2024-01-09 11:53:18',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            223 =>
                array (
                    'id' => 224,
                    'bank_id' => 4,
                    'name' => 'OYSTERBAY',
                    'created_at' => '2024-01-09 11:53:18',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            224 =>
                array (
                    'id' => 225,
                    'bank_id' => 3,
                    'name' => 'KILWA MASOKO',
                    'created_at' => '2024-01-09 11:53:18',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            225 =>
                array (
                    'id' => 226,
                    'bank_id' => 3,
                    'name' => 'LINDI',
                    'created_at' => '2024-01-09 11:53:18',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            226 =>
                array (
                    'id' => 227,
                    'bank_id' => 3,
                    'name' => 'NACHINGWEA',
                    'created_at' => '2024-01-09 11:53:18',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            227 =>
                array (
                    'id' => 228,
                    'bank_id' => 3,
                    'name' => 'MASASI',
                    'created_at' => '2024-01-09 11:53:18',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            228 =>
                array (
                    'id' => 229,
                    'bank_id' => 3,
                    'name' => 'MTWARA',
                    'created_at' => '2024-01-09 11:53:18',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            229 =>
                array (
                    'id' => 230,
                    'bank_id' => 3,
                    'name' => 'NDANDA',
                    'created_at' => '2024-01-09 11:53:18',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            230 =>
                array (
                    'id' => 231,
                    'bank_id' => 3,
                    'name' => 'NEWALA',
                    'created_at' => '2024-01-09 11:53:18',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            231 =>
                array (
                    'id' => 232,
                    'bank_id' => 3,
                    'name' => 'HANDENI',
                    'created_at' => '2024-01-09 11:53:18',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            232 =>
                array (
                    'id' => 233,
                    'bank_id' => 3,
                    'name' => 'KOROGWE',
                    'created_at' => '2024-01-09 11:53:19',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            233 =>
                array (
                    'id' => 234,
                    'bank_id' => 3,
                    'name' => 'LUSHOTO',
                    'created_at' => '2024-01-09 11:53:19',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            234 =>
                array (
                    'id' => 235,
                    'bank_id' => 3,
                    'name' => 'MADARAKA',
                    'created_at' => '2024-01-09 11:53:19',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            235 =>
                array (
                    'id' => 236,
                    'bank_id' => 3,
                    'name' => 'MOMBO',
                    'created_at' => '2024-01-09 11:53:19',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            236 =>
                array (
                    'id' => 237,
                    'bank_id' => 3,
                    'name' => 'MUHEZA',
                    'created_at' => '2024-01-09 11:53:19',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            237 =>
                array (
                    'id' => 238,
                    'bank_id' => 3,
                    'name' => 'PANGANI',
                    'created_at' => '2024-01-09 11:53:19',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            238 =>
                array (
                    'id' => 239,
                    'bank_id' => 3,
                    'name' => 'MKWAKWANI',
                    'created_at' => '2024-01-09 11:53:19',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            239 =>
                array (
                    'id' => 240,
                    'bank_id' => 3,
                    'name' => 'MAWENZI',
                    'created_at' => '2024-01-09 11:53:19',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            240 =>
                array (
                    'id' => 241,
                    'bank_id' => 3,
                    'name' => 'TUNDURU',
                    'created_at' => '2024-01-09 11:53:19',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            241 =>
                array (
                    'id' => 242,
                    'bank_id' => 3,
                    'name' => 'BANK HOUSE',
                    'created_at' => '2024-01-09 11:53:19',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            242 =>
                array (
                    'id' => 243,
                    'bank_id' => 3,
                    'name' => 'CHAKE CHAKE',
                    'created_at' => '2024-01-09 11:53:19',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            243 =>
                array (
                    'id' => 244,
                    'bank_id' => 3,
                    'name' => 'ILALA',
                    'created_at' => '2024-01-09 11:53:19',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            244 =>
                array (
                    'id' => 245,
                    'bank_id' => 3,
                    'name' => 'KARIAKOO',
                    'created_at' => '2024-01-09 11:53:19',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            245 =>
                array (
                    'id' => 246,
                    'bank_id' => 3,
                    'name' => 'MAGOMENI',
                    'created_at' => '2024-01-09 11:53:19',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            246 =>
                array (
                    'id' => 247,
                    'bank_id' => 3,
                    'name' => 'MOROGORO ROAD',
                    'created_at' => '2024-01-09 11:53:19',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            247 =>
                array (
                    'id' => 248,
                    'bank_id' => 3,
                    'name' => 'TEMEKE',
                    'created_at' => '2024-01-09 11:53:19',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            248 =>
                array (
                    'id' => 249,
                    'bank_id' => 3,
                    'name' => 'MUHIMBILI',
                    'created_at' => '2024-01-09 11:53:19',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            249 =>
                array (
                    'id' => 250,
                    'bank_id' => 3,
                    'name' => 'BAGAMOYO',
                    'created_at' => '2024-01-09 11:53:19',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            250 =>
                array (
                    'id' => 251,
                    'bank_id' => 3,
                    'name' => 'CHALINZE',
                    'created_at' => '2024-01-09 11:53:19',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            251 =>
                array (
                    'id' => 252,
                    'bank_id' => 3,
                    'name' => 'KIBAHA',
                    'created_at' => '2024-01-09 11:53:19',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            252 =>
                array (
                    'id' => 253,
                    'bank_id' => 3,
                    'name' => 'KIBITI',
                    'created_at' => '2024-01-09 11:53:19',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            253 =>
                array (
                    'id' => 254,
                    'bank_id' => 3,
                    'name' => 'KISARAWE',
                    'created_at' => '2024-01-09 11:53:19',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            254 =>
                array (
                    'id' => 255,
                    'bank_id' => 3,
                    'name' => 'MAFIA',
                    'created_at' => '2024-01-09 11:53:19',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            255 =>
                array (
                    'id' => 256,
                    'bank_id' => 3,
                    'name' => 'IFAKARA',
                    'created_at' => '2024-01-09 11:53:20',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            256 =>
                array (
                    'id' => 257,
                    'bank_id' => 3,
                    'name' => 'KILOMBERO',
                    'created_at' => '2024-01-09 11:53:20',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            257 =>
                array (
                    'id' => 258,
                    'bank_id' => 3,
                    'name' => 'KILOSA',
                    'created_at' => '2024-01-09 11:53:20',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            258 =>
                array (
                    'id' => 259,
                    'bank_id' => 3,
                    'name' => 'MAHENGE',
                    'created_at' => '2024-01-09 11:53:20',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            259 =>
                array (
                    'id' => 260,
                    'bank_id' => 3,
                    'name' => 'TURIANI',
                    'created_at' => '2024-01-09 11:53:20',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            260 =>
                array (
                    'id' => 261,
                    'bank_id' => 3,
                    'name' => 'WAMI',
                    'created_at' => '2024-01-09 11:53:20',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            261 =>
                array (
                    'id' => 262,
                    'bank_id' => 3,
                    'name' => 'MWENGE',
                    'created_at' => '2024-01-09 11:53:20',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            262 =>
                array (
                    'id' => 263,
                    'bank_id' => 3,
                    'name' => 'MSASANI',
                    'created_at' => '2024-01-09 11:53:20',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            263 =>
                array (
                    'id' => 264,
                    'bank_id' => 3,
                    'name' => 'KIBAYA',
                    'created_at' => '2024-01-09 11:53:20',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            264 =>
                array (
                    'id' => 265,
                    'bank_id' => 3,
                    'name' => 'KONGWA',
                    'created_at' => '2024-01-09 11:53:20',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            265 =>
                array (
                    'id' => 266,
                    'bank_id' => 3,
                    'name' => 'MPWAPWA',
                    'created_at' => '2024-01-09 11:53:20',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            266 =>
                array (
                    'id' => 267,
                    'bank_id' => 3,
                    'name' => 'MTENDENI',
                    'created_at' => '2024-01-09 11:53:20',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            267 =>
                array (
                    'id' => 268,
                    'bank_id' => 3,
                    'name' => 'KASULU',
                    'created_at' => '2024-01-09 11:53:20',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            268 =>
                array (
                    'id' => 269,
                    'bank_id' => 3,
                    'name' => 'KIBONDO',
                    'created_at' => '2024-01-09 11:53:20',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            269 =>
                array (
                    'id' => 270,
                    'bank_id' => 3,
                    'name' => 'KIGOMA',
                    'created_at' => '2024-01-09 11:53:20',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            270 =>
                array (
                    'id' => 271,
                    'bank_id' => 3,
                    'name' => 'KONDOA',
                    'created_at' => '2024-01-09 11:53:20',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            271 =>
                array (
                    'id' => 272,
                    'bank_id' => 3,
                    'name' => 'HAI',
                    'created_at' => '2024-01-09 11:53:20',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            272 =>
                array (
                    'id' => 273,
                    'bank_id' => 3,
                    'name' => 'MWANGA',
                    'created_at' => '2024-01-09 11:53:20',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            273 =>
                array (
                    'id' => 274,
                    'bank_id' => 3,
                    'name' => 'NELSON MANDELA',
                    'created_at' => '2024-01-09 11:53:20',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            274 =>
                array (
                    'id' => 275,
                    'bank_id' => 3,
                    'name' => 'ROMBO',
                    'created_at' => '2024-01-09 11:53:20',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            275 =>
                array (
                    'id' => 276,
                    'bank_id' => 3,
                    'name' => 'SAME',
                    'created_at' => '2024-01-09 11:53:20',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            276 =>
                array (
                    'id' => 277,
                    'bank_id' => 3,
                    'name' => 'TARAKEA',
                    'created_at' => '2024-01-09 11:53:20',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            277 =>
                array (
                    'id' => 278,
                    'bank_id' => 3,
                    'name' => 'BABATI',
                    'created_at' => '2024-01-09 11:53:20',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            278 =>
                array (
                    'id' => 279,
                    'bank_id' => 3,
                    'name' => 'CLOCK TOWER',
                    'created_at' => '2024-01-09 11:53:20',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            279 =>
                array (
                    'id' => 280,
                    'bank_id' => 3,
                    'name' => 'KARATU',
                    'created_at' => '2024-01-09 11:53:20',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            280 =>
                array (
                    'id' => 281,
                    'bank_id' => 3,
                    'name' => 'LOLIONDO',
                    'created_at' => '2024-01-09 11:53:20',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            281 =>
                array (
                    'id' => 282,
                    'bank_id' => 3,
                    'name' => 'MBULU',
                    'created_at' => '2024-01-09 11:53:21',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            282 =>
                array (
                    'id' => 283,
                    'bank_id' => 3,
                    'name' => 'MONDULI',
                    'created_at' => '2024-01-09 11:53:21',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            283 =>
                array (
                    'id' => 284,
                    'bank_id' => 3,
                    'name' => 'NGARENARO',
                    'created_at' => '2024-01-09 11:53:21',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            284 =>
                array (
                    'id' => 285,
                    'bank_id' => 3,
                    'name' => 'KATESH',
                    'created_at' => '2024-01-09 11:53:21',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            285 =>
                array (
                    'id' => 286,
                    'bank_id' => 3,
                    'name' => 'KIOMBOI',
                    'created_at' => '2024-01-09 11:53:21',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            286 =>
                array (
                    'id' => 287,
                    'bank_id' => 3,
                    'name' => 'MANYONI',
                    'created_at' => '2024-01-09 11:53:21',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            287 =>
                array (
                    'id' => 288,
                    'bank_id' => 3,
                    'name' => 'SINGIDA',
                    'created_at' => '2024-01-09 11:53:21',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            288 =>
                array (
                    'id' => 289,
                    'bank_id' => 3,
                    'name' => 'IGUNGA',
                    'created_at' => '2024-01-09 11:53:21',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            289 =>
                array (
                    'id' => 290,
                    'bank_id' => 3,
                    'name' => 'MIHAYO',
                    'created_at' => '2024-01-09 11:53:21',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            290 =>
                array (
                    'id' => 291,
                    'bank_id' => 3,
                    'name' => 'NZEGA',
                    'created_at' => '2024-01-09 11:53:21',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            291 =>
                array (
                    'id' => 292,
                    'bank_id' => 3,
                    'name' => 'SIKONGE',
                    'created_at' => '2024-01-09 11:53:21',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            292 =>
                array (
                    'id' => 293,
                    'bank_id' => 3,
                    'name' => 'BUNDA',
                    'created_at' => '2024-01-09 11:53:21',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            293 =>
                array (
                    'id' => 294,
                    'bank_id' => 3,
                    'name' => 'MUGUMU',
                    'created_at' => '2024-01-09 11:53:21',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            294 =>
                array (
                    'id' => 295,
                    'bank_id' => 3,
                    'name' => 'MUSOMA',
                    'created_at' => '2024-01-09 11:53:21',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            295 =>
                array (
                    'id' => 296,
                    'bank_id' => 3,
                    'name' => 'TARIME',
                    'created_at' => '2024-01-09 11:53:21',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            296 =>
                array (
                    'id' => 297,
                    'bank_id' => 3,
                    'name' => 'BARIADI',
                    'created_at' => '2024-01-09 11:53:21',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            297 =>
                array (
                    'id' => 298,
                    'bank_id' => 3,
                    'name' => 'KAHAMA',
                    'created_at' => '2024-01-09 11:53:21',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            298 =>
                array (
                    'id' => 299,
                    'bank_id' => 3,
                    'name' => 'MANONGA',
                    'created_at' => '2024-01-09 11:53:21',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            299 =>
                array (
                    'id' => 300,
                    'bank_id' => 3,
                    'name' => 'MASWA',
                    'created_at' => '2024-01-09 11:53:21',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            300 =>
                array (
                    'id' => 301,
                    'bank_id' => 3,
                    'name' => 'MWANHUZI',
                    'created_at' => '2024-01-09 11:53:21',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            301 =>
                array (
                    'id' => 302,
                    'bank_id' => 3,
                    'name' => 'GEITA',
                    'created_at' => '2024-01-09 11:53:21',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            302 =>
                array (
                    'id' => 303,
                    'bank_id' => 3,
                    'name' => 'KENYATTA ROAD',
                    'created_at' => '2024-01-09 11:53:21',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            303 =>
                array (
                    'id' => 304,
                    'bank_id' => 3,
                    'name' => 'MAGU',
                    'created_at' => '2024-01-09 11:53:21',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            304 =>
                array (
                    'id' => 305,
                    'bank_id' => 3,
                    'name' => 'MISUNGWI',
                    'created_at' => '2024-01-09 11:53:21',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            305 =>
                array (
                    'id' => 306,
                    'bank_id' => 3,
                    'name' => 'NANSIO',
                    'created_at' => '2024-01-09 11:53:21',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            306 =>
                array (
                    'id' => 307,
                    'bank_id' => 3,
                    'name' => 'NGUDU',
                    'created_at' => '2024-01-09 11:53:21',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            307 =>
                array (
                    'id' => 308,
                    'bank_id' => 3,
                    'name' => 'SENGEREMA',
                    'created_at' => '2024-01-09 11:53:21',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            308 =>
                array (
                    'id' => 309,
                    'bank_id' => 3,
                    'name' => 'BIHARAMULO',
                    'created_at' => '2024-01-09 11:53:21',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            309 =>
                array (
                    'id' => 310,
                    'bank_id' => 3,
                    'name' => 'BUKOBA',
                    'created_at' => '2024-01-09 11:53:21',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            310 =>
                array (
                    'id' => 311,
                    'bank_id' => 3,
                    'name' => 'KAYANGA',
                    'created_at' => '2024-01-09 11:53:21',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            311 =>
                array (
                    'id' => 312,
                    'bank_id' => 3,
                    'name' => 'MULEBA',
                    'created_at' => '2024-01-09 11:53:21',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            312 =>
                array (
                    'id' => 313,
                    'bank_id' => 3,
                    'name' => 'NGARA',
                    'created_at' => '2024-01-09 11:53:21',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            313 =>
                array (
                    'id' => 314,
                    'bank_id' => 3,
                    'name' => 'REGIONAL DRIVE',
                    'created_at' => '2024-01-09 11:53:21',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            314 =>
                array (
                    'id' => 315,
                    'bank_id' => 3,
                    'name' => 'LUDEWA',
                    'created_at' => '2024-01-09 11:53:21',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            315 =>
                array (
                    'id' => 316,
                    'bank_id' => 4,
                    'name' => 'MAFINGA',
                    'created_at' => '2024-01-09 11:53:21',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            316 =>
                array (
                    'id' => 317,
                    'bank_id' => 3,
                    'name' => 'MAKAMBAKO',
                    'created_at' => '2024-01-09 11:53:21',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            317 =>
                array (
                    'id' => 318,
                    'bank_id' => 3,
                    'name' => 'MAKETE',
                    'created_at' => '2024-01-09 11:53:21',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            318 =>
                array (
                    'id' => 319,
                    'bank_id' => 3,
                    'name' => 'MKWAWA',
                    'created_at' => '2024-01-09 11:53:22',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            319 =>
                array (
                    'id' => 320,
                    'bank_id' => 3,
                    'name' => 'NJOMBE',
                    'created_at' => '2024-01-09 11:53:22',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            320 =>
                array (
                    'id' => 321,
                    'bank_id' => 3,
                    'name' => 'CHUNYA',
                    'created_at' => '2024-01-09 11:53:22',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            321 =>
                array (
                    'id' => 322,
                    'bank_id' => 3,
                    'name' => 'ILEJE',
                    'created_at' => '2024-01-09 11:53:22',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            322 =>
                array (
                    'id' => 323,
                    'bank_id' => 3,
                    'name' => 'KYELA',
                    'created_at' => '2024-01-09 11:53:22',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            323 =>
                array (
                    'id' => 324,
                    'bank_id' => 3,
                    'name' => 'MBALIZI ROAD',
                    'created_at' => '2024-01-09 11:53:22',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            324 =>
                array (
                    'id' => 325,
                    'bank_id' => 3,
                    'name' => 'MBARALI',
                    'created_at' => '2024-01-09 11:53:22',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            325 =>
                array (
                    'id' => 326,
                    'bank_id' => 3,
                    'name' => 'MBOZI',
                    'created_at' => '2024-01-09 11:53:22',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            326 =>
                array (
                    'id' => 327,
                    'bank_id' => 3,
                    'name' => 'MWANJELWA',
                    'created_at' => '2024-01-09 11:53:22',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            327 =>
                array (
                    'id' => 328,
                    'bank_id' => 3,
                    'name' => 'TUKUYU',
                    'created_at' => '2024-01-09 11:53:22',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            328 =>
                array (
                    'id' => 329,
                    'bank_id' => 3,
                    'name' => 'TUNDUMA',
                    'created_at' => '2024-01-09 11:53:22',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            329 =>
                array (
                    'id' => 330,
                    'bank_id' => 3,
                    'name' => 'LITEMBO',
                    'created_at' => '2024-01-09 11:53:22',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            330 =>
                array (
                    'id' => 331,
                    'bank_id' => 3,
                    'name' => 'MBINGA',
                    'created_at' => '2024-01-09 11:53:23',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            331 =>
                array (
                    'id' => 332,
                    'bank_id' => 3,
                    'name' => 'SONGEA',
                    'created_at' => '2024-01-09 11:53:23',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            332 =>
                array (
                    'id' => 333,
                    'bank_id' => 3,
                    'name' => 'MPANDA',
                    'created_at' => '2024-01-09 11:53:23',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            333 =>
                array (
                    'id' => 334,
                    'bank_id' => 3,
                    'name' => 'NKASI',
                    'created_at' => '2024-01-09 11:53:23',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            334 =>
                array (
                    'id' => 335,
                    'bank_id' => 3,
                    'name' => 'SUMBAWANGA',
                    'created_at' => '2024-01-09 11:53:23',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            335 =>
                array (
                    'id' => 336,
                    'bank_id' => 3,
                    'name' => 'MOUNT LOLEZA',
                    'created_at' => '2024-01-09 11:53:23',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            336 =>
                array (
                    'id' => 337,
                    'bank_id' => 3,
                    'name' => 'UNIVERSITY',
                    'created_at' => '2024-01-09 11:53:23',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            337 =>
                array (
                    'id' => 338,
                    'bank_id' => 7,
                    'name' => 'IRINGA',
                    'created_at' => '2024-01-09 11:53:23',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            338 =>
                array (
                    'id' => 339,
                    'bank_id' => 3,
                    'name' => 'LINDI',
                    'created_at' => '2024-01-09 11:53:23',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            339 =>
                array (
                    'id' => 340,
                    'bank_id' => 3,
                    'name' => 'MANDELA',
                    'created_at' => '2024-01-09 11:53:23',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            340 =>
                array (
                    'id' => 341,
                    'bank_id' => 3,
                    'name' => 'NAMANGA',
                    'created_at' => '2024-01-09 11:53:23',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            341 =>
                array (
                    'id' => 342,
                    'bank_id' => 3,
                    'name' => 'NANYUMBU',
                    'created_at' => '2024-01-09 11:53:23',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            342 =>
                array (
                    'id' => 343,
                    'bank_id' => 3,
                    'name' => 'MOUNT ULUGURU',
                    'created_at' => '2024-01-09 11:53:23',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            343 =>
                array (
                    'id' => 344,
                    'bank_id' => 3,
                    'name' => 'BUZURUGA',
                    'created_at' => '2024-01-09 11:53:23',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            344 =>
                array (
                    'id' => 345,
                    'bank_id' => 4,
                    'name' => 'NACHINGWEA',
                    'created_at' => '2024-01-09 11:53:24',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            345 =>
                array (
                    'id' => 346,
                    'bank_id' => 3,
                    'name' => 'SIMANJIRO',
                    'created_at' => '2024-01-09 11:53:24',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            346 =>
                array (
                    'id' => 347,
                    'bank_id' => 3,
                    'name' => 'ARUSHA MARKET',
                    'created_at' => '2024-01-09 11:53:24',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            347 =>
                array (
                    'id' => 348,
                    'bank_id' => 3,
                    'name' => 'MBEZI BEACH',
                    'created_at' => '2024-01-09 11:53:24',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            348 =>
                array (
                    'id' => 349,
                    'bank_id' => 3,
                    'name' => 'TEGETA',
                    'created_at' => '2024-01-09 11:53:24',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            349 =>
                array (
                    'id' => 350,
                    'bank_id' => 4,
                    'name' => 'UHURU ROAD',
                    'created_at' => '2024-01-09 11:53:24',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            350 =>
                array (
                    'id' => 351,
                    'bank_id' => 3,
                    'name' => 'ITIGI',
                    'created_at' => '2024-01-09 11:53:24',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            351 =>
                array (
                    'id' => 352,
                    'bank_id' => 3,
                    'name' => 'KIGAMBONI',
                    'created_at' => '2024-01-09 11:53:24',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            352 =>
                array (
                    'id' => 353,
                    'bank_id' => 4,
                    'name' => 'MAHENGE',
                    'created_at' => '2024-01-09 11:53:24',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            353 =>
                array (
                    'id' => 354,
                    'bank_id' => 4,
                    'name' => 'MBARALI',
                    'created_at' => '2024-01-09 11:53:24',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            354 =>
                array (
                    'id' => 355,
                    'bank_id' => 4,
                    'name' => 'CHATO',
                    'created_at' => '2024-01-09 11:53:24',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            355 =>
                array (
                    'id' => 356,
                    'bank_id' => 4,
                    'name' => 'MAKAMBAKO',
                    'created_at' => '2024-01-09 11:53:24',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            356 =>
                array (
                    'id' => 357,
                    'bank_id' => 3,
                    'name' => 'MAFINGA',
                    'created_at' => '2024-01-09 11:53:24',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            357 =>
                array (
                    'id' => 358,
                    'bank_id' => 4,
                    'name' => 'BABATI',
                    'created_at' => '2024-01-09 11:53:24',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            358 =>
                array (
                    'id' => 359,
                    'bank_id' => 4,
                    'name' => 'SENGEREMA',
                    'created_at' => '2024-01-09 11:53:24',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            359 =>
                array (
                    'id' => 360,
                    'bank_id' => 4,
                    'name' => 'GAIRO',
                    'created_at' => '2024-01-09 11:53:24',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            360 =>
                array (
                    'id' => 361,
                    'bank_id' => 1,
                    'name' => 'LIFE HOUSE',
                    'created_at' => '2024-01-09 11:53:24',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            361 =>
                array (
                    'id' => 362,
                    'bank_id' => 3,
                    'name' => 'KATORO',
                    'created_at' => '2024-01-09 11:53:25',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            362 =>
                array (
                    'id' => 363,
                    'bank_id' => 7,
                    'name' => 'SOPA',
                    'created_at' => '2024-01-09 11:53:25',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            363 =>
                array (
                    'id' => 364,
                    'bank_id' => 3,
                    'name' => 'KAKONKO',
                    'created_at' => '2024-01-09 11:53:25',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            364 =>
                array (
                    'id' => 365,
                    'bank_id' => 4,
                    'name' => 'BANANA',
                    'created_at' => '2024-01-09 11:53:25',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            365 =>
                array (
                    'id' => 366,
                    'bank_id' => 4,
                    'name' => 'HANDENI',
                    'created_at' => '2024-01-09 11:53:25',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            366 =>
                array (
                    'id' => 367,
                    'bank_id' => 7,
                    'name' => 'MIKOCHENI',
                    'created_at' => '2024-01-09 11:53:25',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            367 =>
                array (
                    'id' => 368,
                    'bank_id' => 3,
                    'name' => 'KALIUA',
                    'created_at' => '2024-01-09 11:53:25',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            368 =>
                array (
                    'id' => 369,
                    'bank_id' => 4,
                    'name' => 'MASWA',
                    'created_at' => '2024-01-09 11:53:25',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            369 =>
                array (
                    'id' => 370,
                    'bank_id' => 3,
                    'name' => 'MLANDIZI',
                    'created_at' => '2024-01-09 11:53:25',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            370 =>
                array (
                    'id' => 371,
                    'bank_id' => 3,
                    'name' => 'MWANAKWEREKWE',
                    'created_at' => '2024-01-09 11:53:25',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            371 =>
                array (
                    'id' => 372,
                    'bank_id' => 3,
                    'name' => 'GONGO LA MBOTO',
                    'created_at' => '2024-01-09 11:53:25',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
            372 =>
                array (
                    'id' => 373,
                    'bank_id' => 3,
                    'name' => 'BANANA',
                    'created_at' => '2024-01-09 11:53:25',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
                373 =>
                array (
                    'id' => 374,
                    'bank_id' => 9,
                    'name' => 'NATIONAL BANK OF COMMERCE',
                    'created_at' => '2021-02-18 14:36:25',
                    'updated_at' => NULL,
                    'alias' => NULL,
                    'descriptions' => NULL,
                ),
        ));

        $this->enableForeignKeys('bank_branches');
    }
}
