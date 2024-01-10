<?php

namespace Database\Seeders\Version100;

use Illuminate\Database\Seeder;
use Database\TruncateTable;
use Database\DisableForeignKeys;

class DistrictsTableSeeder extends Seeder
{

    use DisableForeignKeys, TruncateTable;
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        $this->disableForeignKeys('districts');
        $this->delete('districts');

        \DB::table('districts')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'name' => 'Meru',
                    'region_id' => 3,
                    'created_at' => '2024-01-10 09:55:35',
                    'postcode' => 233,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            1 =>
                array (
                    'id' => 2,
                    'name' => 'Arusha City',
                    'region_id' => 3,
                    'created_at' => '2024-01-10 09:55:35',
                    'postcode' => 231,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            2 =>
                array (
                    'id' => 3,
                    'name' => 'Arusha District',
                    'region_id' => 3,
                    'created_at' => '2024-01-10 09:57:02',
                    'postcode' => 231,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            3 =>
                array (
                    'id' => 4,
                    'name' => 'Karatu',
                    'region_id' => 3,
                    'created_at' => '2024-01-10 09:57:02',
                    'postcode' => 236,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            4 =>
                array (
                    'id' => 5,
                    'name' => 'Longido',
                    'region_id' => 3,
                    'created_at' => '2024-01-10 09:57:02',
                    'postcode' => 235,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            5 =>
                array (
                    'id' => 6,
                    'name' => 'Monduli',
                    'region_id' => 3,
                    'created_at' => '2024-01-10 09:57:47',
                    'postcode' => 234,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            6 =>
                array (
                    'id' => 7,
                    'name' => 'Ngorongoro',
                    'region_id' => 3,
                    'created_at' => '2024-01-10 09:57:47',
                    'postcode' => 237,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            7 =>
                array (
                    'id' => 8,
                    'name' => 'Ilala',
                    'region_id' => 1,
                    'created_at' => '2024-01-10 09:00:15',
                    'postcode' => 11,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            8 =>
                array (
                    'id' => 9,
                    'name' => 'Kinondoni',
                    'region_id' => 1,
                    'created_at' => '2024-01-10 09:00:15',
                    'postcode' => 14,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            9 =>
                array (
                    'id' => 10,
                    'name' => 'Temeke',
                    'region_id' => 1,
                    'created_at' => '2024-01-10 09:00:15',
                    'postcode' => 15,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            10 =>
                array (
                    'id' => 11,
                    'name' => 'Kigamboni',
                    'region_id' => 1,
                    'created_at' => '2024-01-10 09:00:15',
                    'postcode' => 17,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            11 =>
                array (
                    'id' => 12,
                    'name' => 'Ubungo',
                    'region_id' => 1,
                    'created_at' => '2024-01-10 09:00:15',
                    'postcode' => 16,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            12 =>
                array (
                    'id' => 13,
                    'name' => 'Bahi',
                    'region_id' => 4,
                    'created_at' => '2024-01-10 09:04:49',
                    'postcode' => 413,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            13 =>
                array (
                    'id' => 14,
                    'name' => 'Chamwino',
                    'region_id' => 4,
                    'created_at' => '2024-01-10 09:04:49',
                    'postcode' => 414,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            14 =>
                array (
                    'id' => 15,
                    'name' => 'Chemba',
                    'region_id' => 4,
                    'created_at' => '2024-01-10 09:04:49',
                    'postcode' => 418,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            15 =>
                array (
                    'id' => 16,
                    'name' => 'Dodoma Municipal',
                    'region_id' => 4,
                    'created_at' => '2024-01-10 09:04:49',
                    'postcode' => 411,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            16 =>
                array (
                    'id' => 17,
                    'name' => 'Kondoa',
                    'region_id' => 4,
                    'created_at' => '2024-01-10 09:04:49',
                    'postcode' => 417,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            17 =>
                array (
                    'id' => 18,
                    'name' => 'Kongwa',
                    'region_id' => 4,
                    'created_at' => '2024-01-10 09:05:41',
                    'postcode' => 415,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            18 =>
                array (
                    'id' => 19,
                    'name' => 'Mpwapwa',
                    'region_id' => 4,
                    'created_at' => '2024-01-10 09:05:41',
                    'postcode' => 416,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            19 =>
                array (
                    'id' => 20,
                    'name' => 'Bukombe',
                    'region_id' => 5,
                    'created_at' => '2024-01-10 09:07:29',
                    'postcode' => 305,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            20 =>
                array (
                    'id' => 21,
                    'name' => 'Chato',
                    'region_id' => 5,
                    'created_at' => '2024-01-10 09:07:29',
                    'postcode' => 303,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            21 =>
                array (
                    'id' => 22,
                    'name' => 'Geita Town Council & Geita District Council',
                    'region_id' => 5,
                    'created_at' => '2024-01-10 09:07:29',
                    'postcode' => 301,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            22 =>
                array (
                    'id' => 23,
                    'name' => 'Mbogwe',
                    'region_id' => 5,
                    'created_at' => '2024-01-10 09:07:29',
                    'postcode' => 304,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            23 =>
                array (
                    'id' => 24,
                    'name' => 'Nyang\'hwale',
                    'region_id' => 5,
                    'created_at' => '2024-01-10 09:07:29',
                    'postcode' => 302,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            24 =>
                array (
                    'id' => 25,
                    'name' => 'Iringa District',
                    'region_id' => 6,
                    'created_at' => '2024-01-10 09:09:42',
                    'postcode' => 512,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            25 =>
                array (
                    'id' => 26,
                    'name' => 'Iringa Municipal',
                    'region_id' => 6,
                    'created_at' => '2024-01-10 09:09:42',
                    'postcode' => 511,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            26 =>
                array (
                    'id' => 27,
                    'name' => 'Kilolo',
                    'region_id' => 6,
                    'created_at' => '2024-01-10 09:09:42',
                    'postcode' => 513,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            27 =>
                array (
                    'id' => 28,
                    'name' => 'Mafinga Town',
                    'region_id' => 6,
                    'created_at' => '2024-01-10 09:09:42',
                    'postcode' => 514,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            28 =>
                array (
                    'id' => 29,
                    'name' => 'Mufindi',
                    'region_id' => 6,
                    'created_at' => '2024-01-10 09:09:42',
                    'postcode' => 514,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            29 =>
                array (
                    'id' => 30,
                    'name' => 'Biharamulo',
                    'region_id' => 7,
                    'created_at' => '2024-01-10 09:14:28',
                    'postcode' => 356,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            30 =>
                array (
                    'id' => 31,
                    'name' => 'Bukoba',
                    'region_id' => 7,
                    'created_at' => '2024-01-10 09:14:28',
                    'postcode' => 352,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            31 =>
                array (
                    'id' => 32,
                    'name' => 'Bukoba Municipal',
                    'region_id' => 7,
                    'created_at' => '2024-01-10 09:14:28',
                    'postcode' => 351,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            32 =>
                array (
                    'id' => 33,
                    'name' => 'Karagwe',
                    'region_id' => 7,
                    'created_at' => '2024-01-10 09:14:28',
                    'postcode' => 354,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            33 =>
                array (
                    'id' => 34,
                    'name' => 'Kyerwa',
                    'region_id' => 7,
                    'created_at' => '2024-01-10 09:14:28',
                    'postcode' => 358,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            34 =>
                array (
                    'id' => 35,
                    'name' => 'Missenyi',
                    'region_id' => 7,
                    'created_at' => '2024-01-10 09:15:35',
                    'postcode' => 353,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            35 =>
                array (
                    'id' => 36,
                    'name' => 'Muleba',
                    'region_id' => 7,
                    'created_at' => '2024-01-10 09:15:35',
                    'postcode' => 355,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            36 =>
                array (
                    'id' => 37,
                    'name' => 'Ngara',
                    'region_id' => 7,
                    'created_at' => '2024-01-10 09:15:52',
                    'postcode' => 357,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            37 =>
                array (
                    'id' => 42,
                    'name' => 'Mlele',
                    'region_id' => 8,
                    'created_at' => '2024-01-10 09:20:28',
                    'postcode' => 503,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            38 =>
                array (
                    'id' => 43,
                    'name' => 'Tanganyika',
                    'region_id' => 8,
                    'created_at' => '2024-01-10 09:20:28',
                    'postcode' => 502,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            39 =>
                array (
                    'id' => 44,
                    'name' => 'Mpanda Town',
                    'region_id' => 8,
                    'created_at' => '2024-01-10 09:22:45',
                    'postcode' => 501,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            40 =>
                array (
                    'id' => 45,
                    'name' => 'Buhigwe',
                    'region_id' => 9,
                    'created_at' => '2024-01-10 09:26:15',
                    'postcode' => 475,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            41 =>
                array (
                    'id' => 46,
                    'name' => 'Kakonko',
                    'region_id' => 9,
                    'created_at' => '2024-01-10 09:26:15',
                    'postcode' => 477,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            42 =>
                array (
                    'id' => 47,
                    'name' => 'Kasulu District',
                    'region_id' => 9,
                    'created_at' => '2024-01-10 09:26:15',
                    'postcode' => 473,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            43 =>
                array (
                    'id' => 48,
                    'name' => 'Kasulu Town',
                    'region_id' => 9,
                    'created_at' => '2024-01-10 09:26:15',
                    'postcode' => 473,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            44 =>
                array (
                    'id' => 49,
                    'name' => 'Kibondo',
                    'region_id' => 9,
                    'created_at' => '2024-01-10 09:26:15',
                    'postcode' => 474,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            45 =>
                array (
                    'id' => 50,
                    'name' => 'Kigoma-Ujiji Municipal',
                    'region_id' => 9,
                    'created_at' => '2024-01-10 09:28:07',
                    'postcode' => 471,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            46 =>
                array (
                    'id' => 51,
                    'name' => 'Kigoma District',
                    'region_id' => 9,
                    'created_at' => '2024-01-10 09:28:07',
                    'postcode' => 472,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            47 =>
                array (
                    'id' => 52,
                    'name' => 'Uvinza',
                    'region_id' => 9,
                    'created_at' => '2024-01-10 09:28:55',
                    'postcode' => 476,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            48 =>
                array (
                    'id' => 53,
                    'name' => 'Hai',
                    'region_id' => 10,
                    'created_at' => '2024-01-10 09:30:31',
                    'postcode' => 253,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            49 =>
                array (
                    'id' => 54,
                    'name' => 'Moshi Municipal',
                    'region_id' => 10,
                    'created_at' => '2024-01-10 09:30:31',
                    'postcode' => 251,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            50 =>
                array (
                    'id' => 55,
                    'name' => 'Moshi District',
                    'region_id' => 10,
                    'created_at' => '2024-01-10 09:30:31',
                    'postcode' => 252,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            51 =>
                array (
                    'id' => 56,
                    'name' => 'Mwanga',
                    'region_id' => 10,
                    'created_at' => '2024-01-10 09:30:31',
                    'postcode' => 255,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            52 =>
                array (
                    'id' => 57,
                    'name' => 'Rombo',
                    'region_id' => 10,
                    'created_at' => '2024-01-10 09:30:31',
                    'postcode' => 257,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            53 =>
                array (
                    'id' => 58,
                    'name' => 'Same',
                    'region_id' => 10,
                    'created_at' => '2024-01-10 09:31:14',
                    'postcode' => 256,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            54 =>
                array (
                    'id' => 59,
                    'name' => 'Siha',
                    'region_id' => 10,
                    'created_at' => '2024-01-10 09:31:14',
                    'postcode' => 254,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            55 =>
                array (
                    'id' => 64,
                    'name' => 'Kilwa',
                    'region_id' => 11,
                    'created_at' => '2024-01-10 09:43:45',
                    'postcode' => 654,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            56 =>
                array (
                    'id' => 65,
                    'name' => 'Lindi District',
                    'region_id' => 11,
                    'created_at' => '2024-01-10 09:43:45',
                    'postcode' => 652,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            57 =>
                array (
                    'id' => 66,
                    'name' => 'Lindi Municipal',
                    'region_id' => 11,
                    'created_at' => '2024-01-10 09:43:45',
                    'postcode' => 651,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            58 =>
                array (
                    'id' => 67,
                    'name' => 'Liwale',
                    'region_id' => 11,
                    'created_at' => '2024-01-10 09:43:45',
                    'postcode' => 655,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            59 =>
                array (
                    'id' => 68,
                    'name' => 'Nachingwea',
                    'region_id' => 11,
                    'created_at' => '2024-01-10 09:43:45',
                    'postcode' => 653,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            60 =>
                array (
                    'id' => 69,
                    'name' => 'Ruangwa',
                    'region_id' => 11,
                    'created_at' => '2024-01-10 09:44:14',
                    'postcode' => 656,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            61 =>
                array (
                    'id' => 70,
                    'name' => 'Babati Town',
                    'region_id' => 12,
                    'created_at' => '2024-01-10 09:47:06',
                    'postcode' => 271,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            62 =>
                array (
                    'id' => 71,
                    'name' => 'Babati District',
                    'region_id' => 12,
                    'created_at' => '2024-01-10 09:47:06',
                    'postcode' => 272,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            63 =>
                array (
                    'id' => 72,
                    'name' => 'Hanang',
                    'region_id' => 12,
                    'created_at' => '2024-01-10 09:47:06',
                    'postcode' => 273,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            64 =>
                array (
                    'id' => 73,
                    'name' => 'Kiteto',
                    'region_id' => 12,
                    'created_at' => '2024-01-10 09:47:06',
                    'postcode' => 275,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            65 =>
                array (
                    'id' => 74,
                    'name' => 'Mbulu',
                    'region_id' => 12,
                    'created_at' => '2024-01-10 09:47:06',
                    'postcode' => 274,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            66 =>
                array (
                    'id' => 75,
                    'name' => 'Simanjiro',
                    'region_id' => 12,
                    'created_at' => '2024-01-10 09:47:30',
                    'postcode' => 276,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            67 =>
                array (
                    'id' => 76,
                    'name' => 'Bunda',
                    'region_id' => 13,
                    'created_at' => '2024-01-10 09:51:53',
                    'postcode' => 315,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            68 =>
                array (
                    'id' => 77,
                    'name' => 'Butiama',
                    'region_id' => 13,
                    'created_at' => '2024-01-10 09:51:53',
                    'postcode' => 312,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            69 =>
                array (
                    'id' => 78,
                    'name' => 'Musoma District',
                    'region_id' => 13,
                    'created_at' => '2024-01-10 09:51:53',
                    'postcode' => 311,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            70 =>
                array (
                    'id' => 79,
                    'name' => 'Musoma Municipal',
                    'region_id' => 13,
                    'created_at' => '2024-01-10 09:51:53',
                    'postcode' => 311,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            71 =>
                array (
                    'id' => 80,
                    'name' => 'Rorya',
                    'region_id' => 13,
                    'created_at' => '2024-01-10 09:51:53',
                    'postcode' => 313,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            72 =>
                array (
                    'id' => 81,
                    'name' => 'Serengeti',
                    'region_id' => 13,
                    'created_at' => '2024-01-10 09:53:14',
                    'postcode' => 316,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            73 =>
                array (
                    'id' => 82,
                    'name' => 'Tarime',
                    'region_id' => 13,
                    'created_at' => '2024-01-10 09:53:14',
                    'postcode' => 314,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            74 =>
                array (
                    'id' => 83,
                    'name' => 'Busokelo',
                    'region_id' => 14,
                    'created_at' => '2024-01-10 09:55:38',
                    'postcode' => 535,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            75 =>
                array (
                    'id' => 84,
                    'name' => 'Chunya',
                    'region_id' => 14,
                    'created_at' => '2024-01-10 09:55:38',
                    'postcode' => 538,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            76 =>
                array (
                    'id' => 85,
                    'name' => 'Kyela',
                    'region_id' => 14,
                    'created_at' => '2024-01-10 09:55:38',
                    'postcode' => 537,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            77 =>
                array (
                    'id' => 86,
                    'name' => 'Mbarali',
                    'region_id' => 14,
                    'created_at' => '2024-01-10 09:55:38',
                    'postcode' => 536,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            78 =>
                array (
                    'id' => 87,
                    'name' => 'Mbeya City',
                    'region_id' => 14,
                    'created_at' => '2024-01-10 09:55:38',
                    'postcode' => 531,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            79 =>
                array (
                    'id' => 88,
                    'name' => 'Mbeya District',
                    'region_id' => 14,
                    'created_at' => '2024-01-10 09:56:25',
                    'postcode' => 532,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            80 =>
                array (
                    'id' => 89,
                    'name' => 'Rungwe',
                    'region_id' => 14,
                    'created_at' => '2024-01-10 09:56:25',
                    'postcode' => 535,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            81 =>
                array (
                    'id' => 92,
                    'name' => 'Gairo',
                    'region_id' => 15,
                    'created_at' => '2024-01-10 09:01:47',
                    'postcode' => 677,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            82 =>
                array (
                    'id' => 93,
                    'name' => 'Kilombero',
                    'region_id' => 15,
                    'created_at' => '2024-01-10 09:01:47',
                    'postcode' => 675,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            83 =>
                array (
                    'id' => 94,
                    'name' => 'Kilosa',
                    'region_id' => 15,
                    'created_at' => '2024-01-10 09:01:47',
                    'postcode' => 674,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            84 =>
                array (
                    'id' => 95,
                    'name' => 'Morogoro District',
                    'region_id' => 15,
                    'created_at' => '2024-01-10 09:01:47',
                    'postcode' => 672,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            85 =>
                array (
                    'id' => 96,
                    'name' => 'Morogoro Municipal',
                    'region_id' => 15,
                    'created_at' => '2024-01-10 09:01:47',
                    'postcode' => 671,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            86 =>
                array (
                    'id' => 97,
                    'name' => 'Mvomero',
                    'region_id' => 15,
                    'created_at' => '2024-01-10 09:02:36',
                    'postcode' => 673,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            87 =>
                array (
                    'id' => 98,
                    'name' => 'Ulanga',
                    'region_id' => 15,
                    'created_at' => '2024-01-10 09:02:36',
                    'postcode' => 676,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            88 =>
                array (
                    'id' => 99,
                    'name' => 'Masasi District',
                    'region_id' => 16,
                    'created_at' => '2024-01-10 09:09:26',
                    'postcode' => NULL,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            89 =>
                array (
                    'id' => 100,
                    'name' => 'Masasi Town',
                    'region_id' => 16,
                    'created_at' => '2024-01-10 09:09:26',
                    'postcode' => 635,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            90 =>
                array (
                    'id' => 101,
                    'name' => 'Mtwara District',
                    'region_id' => 16,
                    'created_at' => '2024-01-10 09:09:26',
                    'postcode' => 632,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            91 =>
                array (
                    'id' => 102,
                    'name' => 'Mtwara Municipal',
                    'region_id' => 16,
                    'created_at' => '2024-01-10 09:09:26',
                    'postcode' => 631,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            92 =>
                array (
                    'id' => 103,
                    'name' => 'Nanyumbu',
                    'region_id' => 16,
                    'created_at' => '2024-01-10 09:09:26',
                    'postcode' => 636,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            93 =>
                array (
                    'id' => 104,
                    'name' => 'Newala',
                    'region_id' => 16,
                    'created_at' => '2024-01-10 09:10:27',
                    'postcode' => 634,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            94 =>
                array (
                    'id' => 105,
                    'name' => 'Tandahimba',
                    'region_id' => 16,
                    'created_at' => '2024-01-10 09:10:27',
                    'postcode' => 633,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            95 =>
                array (
                    'id' => 106,
                    'name' => 'Ilemela',
                    'region_id' => 2,
                    'created_at' => '2024-01-10 09:12:15',
                    'postcode' => 332,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            96 =>
                array (
                    'id' => 107,
                    'name' => 'Kwimba',
                    'region_id' => 2,
                    'created_at' => '2024-01-10 09:12:15',
                    'postcode' => 338,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            97 =>
                array (
                    'id' => 108,
                    'name' => 'Magu',
                    'region_id' => 2,
                    'created_at' => '2024-01-10 09:12:15',
                    'postcode' => 334,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            98 =>
                array (
                    'id' => 109,
                    'name' => 'Misungwi',
                    'region_id' => 2,
                    'created_at' => '2024-01-10 09:12:15',
                    'postcode' => 335,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            99 =>
                array (
                    'id' => 110,
                    'name' => 'Nyamagana',
                    'region_id' => 2,
                    'created_at' => '2024-01-10 09:12:15',
                    'postcode' => 331,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            100 =>
                array (
                    'id' => 111,
                    'name' => 'Sengerema',
                    'region_id' => 2,
                    'created_at' => '2024-01-10 09:12:46',
                    'postcode' => 333,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            101 =>
                array (
                    'id' => 112,
                    'name' => 'Ukerewe',
                    'region_id' => 2,
                    'created_at' => '2024-01-10 09:12:46',
                    'postcode' => 336,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            102 =>
                array (
                    'id' => 60,
                    'name' => 'Kati',
                    'region_id' => 29,
                    'created_at' => '2024-01-10 09:39:13',
                    'postcode' => NULL,
                    'updated_at' => NULL,
                    'deleted_at' => '2024-01-10 09:39:13',
                ),
            103 =>
                array (
                    'id' => 61,
                    'name' => 'Kusini',
                    'region_id' => 29,
                    'created_at' => '2024-01-10 09:39:13',
                    'postcode' => NULL,
                    'updated_at' => NULL,
                    'deleted_at' => '2024-01-10 09:39:13',
                ),
            104 =>
                array (
                    'id' => 90,
                    'name' => 'Magharibi A',
                    'region_id' => 30,
                    'created_at' => '2024-01-10 09:58:43',
                    'postcode' => NULL,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            105 =>
                array (
                    'id' => 91,
                    'name' => 'Mjini',
                    'region_id' => 30,
                    'created_at' => '2024-01-10 09:58:43',
                    'postcode' => NULL,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            106 =>
                array (
                    'id' => 62,
                    'name' => 'Kaskazini A',
                    'region_id' => 28,
                    'created_at' => '2024-01-10 09:39:58',
                    'postcode' => NULL,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            107 =>
                array (
                    'id' => 63,
                    'name' => 'Kaskazini B',
                    'region_id' => 28,
                    'created_at' => '2024-01-10 09:39:58',
                    'postcode' => NULL,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            108 =>
                array (
                    'id' => 38,
                    'name' => 'Micheweni',
                    'region_id' => 19,
                    'created_at' => '2024-01-10 09:17:15',
                    'postcode' => NULL,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            109 =>
                array (
                    'id' => 39,
                    'name' => 'Wete',
                    'region_id' => 19,
                    'created_at' => '2024-01-10 09:17:15',
                    'postcode' => NULL,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            110 =>
                array (
                    'id' => 40,
                    'name' => 'Chake Chake',
                    'region_id' => 20,
                    'created_at' => '2024-01-10 09:19:18',
                    'postcode' => NULL,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            111 =>
                array (
                    'id' => 41,
                    'name' => 'Mkoani',
                    'region_id' => 20,
                    'created_at' => '2024-01-10 09:19:18',
                    'postcode' => NULL,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            112 =>
                array (
                    'id' => 113,
                    'name' => 'Ludewa',
                    'region_id' => 18,
                    'created_at' => '2024-01-10 09:15:05',
                    'postcode' => 594,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            113 =>
                array (
                    'id' => 114,
                    'name' => 'Makambako',
                    'region_id' => 18,
                    'created_at' => '2024-01-10 09:15:05',
                    'postcode' => 593,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            114 =>
                array (
                    'id' => 115,
                    'name' => 'Makete',
                    'region_id' => 18,
                    'created_at' => '2024-01-10 09:15:05',
                    'postcode' => 595,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            115 =>
                array (
                    'id' => 116,
                    'name' => 'Njombe District',
                    'region_id' => 18,
                    'created_at' => '2024-01-10 09:15:05',
                    'postcode' => 592,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            116 =>
                array (
                    'id' => 117,
                    'name' => 'Njombe Town',
                    'region_id' => 18,
                    'created_at' => '2024-01-10 09:15:05',
                    'postcode' => 591,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            117 =>
                array (
                    'id' => 118,
                    'name' => 'Wanging\'ombe',
                    'region_id' => 18,
                    'created_at' => '2024-01-10 09:15:23',
                    'postcode' => 593,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            118 =>
                array (
                    'id' => 119,
                    'name' => 'Bagamoyo',
                    'region_id' => 21,
                    'created_at' => '2024-01-10 09:18:23',
                    'postcode' => 613,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            119 =>
                array (
                    'id' => 120,
                    'name' => 'Kibaha District',
                    'region_id' => 21,
                    'created_at' => '2024-01-10 09:18:23',
                    'postcode' => 612,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            120 =>
                array (
                    'id' => 121,
                    'name' => 'Kibaha Town',
                    'region_id' => 21,
                    'created_at' => '2024-01-10 09:18:23',
                    'postcode' => 611,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            121 =>
                array (
                    'id' => 122,
                    'name' => 'Kisarawe',
                    'region_id' => 21,
                    'created_at' => '2024-01-10 09:18:23',
                    'postcode' => 614,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            122 =>
                array (
                    'id' => 123,
                    'name' => 'Mafia',
                    'region_id' => 21,
                    'created_at' => '2024-01-10 09:18:23',
                    'postcode' => 617,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            123 =>
                array (
                    'id' => 124,
                    'name' => 'Mkuranga',
                    'region_id' => 21,
                    'created_at' => '2024-01-10 09:19:00',
                    'postcode' => 615,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            124 =>
                array (
                    'id' => 125,
                    'name' => 'Rufiji',
                    'region_id' => 21,
                    'created_at' => '2024-01-10 09:19:00',
                    'postcode' => 616,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            125 =>
                array (
                    'id' => 126,
                    'name' => 'Kalambo',
                    'region_id' => 22,
                    'created_at' => '2024-01-10 09:21:32',
                    'postcode' => 554,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            126 =>
                array (
                    'id' => 127,
                    'name' => 'Nkasi',
                    'region_id' => 22,
                    'created_at' => '2024-01-10 09:21:32',
                    'postcode' => 553,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            127 =>
                array (
                    'id' => 128,
                    'name' => 'Sumbawanga District',
                    'region_id' => 22,
                    'created_at' => '2024-01-10 09:22:15',
                    'postcode' => 552,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            128 =>
                array (
                    'id' => 129,
                    'name' => 'Sumbawanga Municipal',
                    'region_id' => 22,
                    'created_at' => '2024-01-10 09:22:15',
                    'postcode' => 551,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            129 =>
                array (
                    'id' => 130,
                    'name' => 'Mbinga',
                    'region_id' => 23,
                    'created_at' => '2024-01-10 09:27:52',
                    'postcode' => 574,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            130 =>
                array (
                    'id' => 131,
                    'name' => 'Songea District',
                    'region_id' => 23,
                    'created_at' => '2024-01-10 09:27:52',
                    'postcode' => 572,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            131 =>
                array (
                    'id' => 132,
                    'name' => 'Songea Municipal',
                    'region_id' => 23,
                    'created_at' => '2024-01-10 09:27:52',
                    'postcode' => 571,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            132 =>
                array (
                    'id' => 133,
                    'name' => 'Tunduru',
                    'region_id' => 23,
                    'created_at' => '2024-01-10 09:27:52',
                    'postcode' => 576,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            133 =>
                array (
                    'id' => 134,
                    'name' => 'Namtumbo',
                    'region_id' => 23,
                    'created_at' => '2024-01-10 09:27:52',
                    'postcode' => 573,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            134 =>
                array (
                    'id' => 135,
                    'name' => 'Nyasa',
                    'region_id' => 23,
                    'created_at' => '2024-01-10 09:28:55',
                    'postcode' => 575,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            135 =>
                array (
                    'id' => 141,
                    'name' => 'Bariadi',
                    'region_id' => 24,
                    'created_at' => '2024-01-10 09:36:58',
                    'postcode' => 391,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            136 =>
                array (
                    'id' => 142,
                    'name' => 'Busega',
                    'region_id' => 24,
                    'created_at' => '2024-01-10 09:36:58',
                    'postcode' => 395,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            137 =>
                array (
                    'id' => 143,
                    'name' => 'Itilima',
                    'region_id' => 24,
                    'created_at' => '2024-01-10 09:36:58',
                    'postcode' => 392,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            138 =>
                array (
                    'id' => 144,
                    'name' => 'Maswa',
                    'region_id' => 24,
                    'created_at' => '2024-01-10 09:36:58',
                    'postcode' => 393,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            139 =>
                array (
                    'id' => 145,
                    'name' => 'Meatu',
                    'region_id' => 24,
                    'created_at' => '2024-01-10 09:36:58',
                    'postcode' => 394,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            140 =>
                array (
                    'id' => 146,
                    'name' => 'Ikungi',
                    'region_id' => 25,
                    'created_at' => '2024-01-10 09:40:12',
                    'postcode' => 436,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            141 =>
                array (
                    'id' => 147,
                    'name' => 'Iramba',
                    'region_id' => 25,
                    'created_at' => '2024-01-10 09:40:12',
                    'postcode' => 433,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            142 =>
                array (
                    'id' => 148,
                    'name' => 'Manyoni',
                    'region_id' => 25,
                    'created_at' => '2024-01-10 09:40:12',
                    'postcode' => 434,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            143 =>
                array (
                    'id' => 149,
                    'name' => 'Mkalama',
                    'region_id' => 25,
                    'created_at' => '2024-01-10 09:40:12',
                    'postcode' => 435,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            144 =>
                array (
                    'id' => 150,
                    'name' => 'Singida District',
                    'region_id' => 25,
                    'created_at' => '2024-01-10 09:40:12',
                    'postcode' => 432,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            145 =>
                array (
                    'id' => 151,
                    'name' => 'Singida Municipal',
                    'region_id' => 25,
                    'created_at' => '2024-01-10 09:41:02',
                    'postcode' => 431,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            146 =>
                array (
                    'id' => 152,
                    'name' => 'Igunga',
                    'region_id' => 26,
                    'created_at' => '2024-01-10 09:43:41',
                    'postcode' => 456,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            147 =>
                array (
                    'id' => 153,
                    'name' => 'Kaliua',
                    'region_id' => 26,
                    'created_at' => '2024-01-10 09:43:41',
                    'postcode' => 457,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            148 =>
                array (
                    'id' => 154,
                    'name' => 'Nzega',
                    'region_id' => 26,
                    'created_at' => '2024-01-10 09:43:41',
                    'postcode' => 454,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            149 =>
                array (
                    'id' => 155,
                    'name' => 'Sikonge',
                    'region_id' => 26,
                    'created_at' => '2024-01-10 09:43:41',
                    'postcode' => 453,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            150 =>
                array (
                    'id' => 156,
                    'name' => 'Tabora Municipal',
                    'region_id' => 26,
                    'created_at' => '2024-01-10 09:43:41',
                    'postcode' => 451,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            151 =>
                array (
                    'id' => 157,
                    'name' => 'Urambo',
                    'region_id' => 26,
                    'created_at' => '2024-01-10 09:44:34',
                    'postcode' => 455,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            152 =>
                array (
                    'id' => 158,
                    'name' => 'Uyui',
                    'region_id' => 26,
                    'created_at' => '2024-01-10 09:44:34',
                    'postcode' => 452,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            153 =>
                array (
                    'id' => 159,
                    'name' => 'Handeni District',
                    'region_id' => 27,
                    'created_at' => '2024-01-10 09:49:00',
                    'postcode' => 218,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            154 =>
                array (
                    'id' => 160,
                    'name' => 'Handeni Town',
                    'region_id' => 27,
                    'created_at' => '2024-01-10 09:49:00',
                    'postcode' => 218,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            155 =>
                array (
                    'id' => 161,
                    'name' => 'Kilindi',
                    'region_id' => 27,
                    'created_at' => '2024-01-10 09:49:00',
                    'postcode' => 219,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            156 =>
                array (
                    'id' => 162,
                    'name' => 'Korogwe Town',
                    'region_id' => 27,
                    'created_at' => '2024-01-10 09:49:00',
                    'postcode' => 216,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            157 =>
                array (
                    'id' => 163,
                    'name' => 'Korogwe District',
                    'region_id' => 27,
                    'created_at' => '2024-01-10 09:49:00',
                    'postcode' => 216,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            158 =>
                array (
                    'id' => 164,
                    'name' => 'Lushoto',
                    'region_id' => 27,
                    'created_at' => '2024-01-10 09:49:00',
                    'postcode' => 217,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            159 =>
                array (
                    'id' => 165,
                    'name' => 'Muheza',
                    'region_id' => 27,
                    'created_at' => '2024-01-10 09:49:00',
                    'postcode' => 214,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            160 =>
                array (
                    'id' => 166,
                    'name' => 'Mkinga',
                    'region_id' => 27,
                    'created_at' => '2024-01-10 09:49:00',
                    'postcode' => 215,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            161 =>
                array (
                    'id' => 167,
                    'name' => 'Pangani',
                    'region_id' => 27,
                    'created_at' => '2024-01-10 09:49:00',
                    'postcode' => 213,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            162 =>
                array (
                    'id' => 168,
                    'name' => 'Tanga City',
                    'region_id' => 27,
                    'created_at' => '2024-01-10 09:49:00',
                    'postcode' => 211,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            163 =>
                array (
                    'id' => 136,
                    'name' => 'Kahama Town',
                    'region_id' => 32,
                    'created_at' => '2024-01-10 09:31:36',
                    'postcode' => 373,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            164 =>
                array (
                    'id' => 137,
                    'name' => 'Kahama District',
                    'region_id' => 32,
                    'created_at' => '2024-01-10 09:31:36',
                    'postcode' => 373,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            165 =>
                array (
                    'id' => 138,
                    'name' => 'Kishapu',
                    'region_id' => 32,
                    'created_at' => '2024-01-10 09:31:36',
                    'postcode' => 375,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            166 =>
                array (
                    'id' => 139,
                    'name' => 'Shinyanga District',
                    'region_id' => 32,
                    'created_at' => '2024-01-10 09:31:36',
                    'postcode' => 372,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            167 =>
                array (
                    'id' => 140,
                    'name' => 'Shinyanga Municipal',
                    'region_id' => 32,
                    'created_at' => '2024-01-10 09:31:36',
                    'postcode' => 371,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            168 =>
                array (
                    'id' => 169,
                    'name' => 'Songwe',
                    'region_id' => 33,
                    'created_at' => '2024-01-10 09:31:36',
                    'postcode' => 541,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            169 =>
                array (
                    'id' => 170,
                    'name' => 'Mbozi',
                    'region_id' => 33,
                    'created_at' => '2024-01-10 09:31:36',
                    'postcode' => 542,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            170 =>
                array (
                    'id' => 171,
                    'name' => 'Ileje',
                    'region_id' => 33,
                    'created_at' => '2024-01-10 09:31:36',
                    'postcode' => 543,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            171 =>
                array (
                    'id' => 172,
                    'name' => 'Momba',
                    'region_id' => 33,
                    'created_at' => '2024-01-10 09:31:36',
                    'postcode' => 544,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            172 =>
                array (
                    'id' => 173,
                    'name' => 'Kusini Unguja A',
                    'region_id' => 29,
                    'created_at' => '2024-01-10 09:39:13',
                    'postcode' => NULL,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            173 =>
                array (
                    'id' => 174,
                    'name' => 'Kusini Unguja B',
                    'region_id' => 29,
                    'created_at' => '2024-01-10 09:39:13',
                    'postcode' => NULL,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            174 =>
                array (
                    'id' => 175,
                    'name' => 'Magharibi B',
                    'region_id' => 30,
                    'created_at' => '2024-01-10 09:58:43',
                    'postcode' => NULL,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),

            175 =>
                array (
                    'id' => 176,
                    'name' => 'Mtama DC',
                    'region_id' => 11,
                    'created_at' => '2024-01-10 09:43:45',
                    'postcode' => 652,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
        ));

        $this->enableForeignKeys('districts');
    }
}
