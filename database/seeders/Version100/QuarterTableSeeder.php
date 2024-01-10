<?php
namespace Database\Seeders\Version100;
use Carbon\Carbon;
use Database\TruncateTable;
use App\Models\Bank\Quarter;
use Illuminate\Database\Seeder;
use Database\DisableForeignKeys;

class QuarterTableSeeder extends Seeder
{

    use DisableForeignKeys, TruncateTable;

    public function run()
    {
        /**Quarter 1 */

        $code= Quarter::updateOrCreate(
            [
                'id' => 1,
                'isactive' => 0,
            ],
            [
                'name' => 'Quarter 1',
                'shortcode' => 'Q1',
                'start_date' => Carbon::createFromFormat('m-d Y H:i:s', '07-01 ' . date('Y') . ' 00:00:00')->format('m-d H:i:s'),
                'end_date' => Carbon::createFromFormat('m-d Y H:i:s', '09-30 ' . date('Y') . ' 23:59:59')->format('m-d H:i:s'),
                'created_at' => '2024-01-10 12:53:53',
                'updated_at' => null,
            ]
        );

        $code= Quarter::updateOrCreate(
            [
                'id' => 2,
                'isactive' => 0,
            ],
            [
                'name' => 'Quarter 2',
                'shortcode' => 'Q2',
                'start_date' => Carbon::createFromFormat('m-d Y H:i:s', '10-01 ' . date('Y') . ' 00:00:00')->format('m-d H:i:s'),
                'end_date' => Carbon::createFromFormat('m-d Y H:i:s', '12-31 ' . date('Y') . ' 23:59:59')->format('m-d H:i:s'),
                'created_at' => '2024-01-10 12:53:53',
                'updated_at' => null,
            ]
        );

        $code= Quarter::updateOrCreate(
            [
                'id' => 3,
                'isactive' => 0,
            ],
            [
                'name' => 'Quarter 3',
                'shortcode' => 'Q3',
                'start_date' => Carbon::createFromFormat('m-d Y H:i:s', '01-01 ' . date('Y') . ' 00:00:00')->format('m-d H:i:s'),
                'end_date' => Carbon::createFromFormat('m-d Y H:i:s', '03-31 ' . date('Y') . ' 23:59:59')->format('m-d H:i:s'),
                'created_at' => '2024-01-10 12:53:53',
                'updated_at' => null,
            ]
        );

        $code= Quarter::updateOrCreate(
            [
                'id' => 4,
                'isactive' => 0,
            ],
            [
                'name' => 'Quarter 4',
                'shortcode' => 'Q4',
                'start_date' => Carbon::createFromFormat('m-d Y H:i:s', '04-01 ' . date('Y') . ' 00:00:00')->format('m-d H:i:s'),
                'end_date' => Carbon::createFromFormat('m-d Y H:i:s', '06-30 ' . date('Y') . ' 23:59:59')->format('m-d H:i:s'),
                'created_at' => '2024-01-10 12:53:53',
                'updated_at' => null,
            ]
        );

    }

}
