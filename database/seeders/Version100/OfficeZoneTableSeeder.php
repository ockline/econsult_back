<?php

namespace Database\Seeders\Version100;

use Illuminate\Database\Seeder;
use Database\TruncateTable;
use Database\DisableForeignKeys;
use \App\Models\Sysdef\OfficeZone;

class OfficeZoneTableSeeder extends Seeder
{

    use DisableForeignKeys, TruncateTable;
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        $code= OfficeZone::updateOrCreate(
            ['id' => 1],
            ['name' => 'Laison Office',
                'created_at' => '2019-06-04 17:30:35',
            ]
        );

        $code= OfficeZone::updateOrCreate(
            ['id' => 2],
            ['name' => 'Da es Salaam Zone',
                'created_at' => '2019-06-04 17:30:35',
            ]
        );

        $code= OfficeZone::updateOrCreate(
            ['id' => 3],
            ['name' => 'Northern Zone',
                'created_at' => '2019-06-04 17:30:35',
            ]
        );


        $code= OfficeZone::updateOrCreate(
            ['id' => 4],
            ['name' => 'Eastern Zone',
                'created_at' => '2019-06-04 17:30:35',
            ]
        );


        $code= OfficeZone::updateOrCreate(
            ['id' => 5],
            ['name' => 'Central Zone',
                'created_at' => '2019-06-04 17:30:35',
            ]
        );


        $code= OfficeZone::updateOrCreate(
            ['id' => 6],
            ['name' => 'Lake Zone',
                'created_at' => '2019-06-04 17:30:35',
            ]
        );


        $code= OfficeZone::updateOrCreate(
            ['id' => 7],
            ['name' => 'Southern Highland Zone',
                'created_at' => '2019-06-04 17:30:35',
            ]
        );


        $code= OfficeZone::updateOrCreate(
            ['id' => 8],
            ['name' => 'Southern Zone',
                'created_at' => '2019-06-04 17:30:35',
            ]
        );

        $code= OfficeZone::updateOrCreate(
            ['id' => 9],
            ['name' => 'Western Zone',
                'created_at' => '2019-06-04 17:30:35',
            ]
        );


    }
}
