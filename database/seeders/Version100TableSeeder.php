<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Database\DisableForeignKeys;
use Illuminate\Support\Facades\DB;
// use Database\Seeders\Version100\PostCodesSeeder;
use Database\Seeders\Version100\BanksTableSeeder;
use Database\Seeders\Version100\BankBranchesTableSeeder;
use Database\Seeders\Version100\CountriesTableSeeder;
use Database\Seeders\Version100\RegionsTableSeeder;
use Database\Seeders\Version100\JobTitlesTableSeeder;
use Database\Seeders\Version100\OfficesTableSeeder;
use Database\Seeders\Version100\QuarterTableSeeder;
use Database\Seeders\Version100\DistrictsTableSeeder;
use Database\Seeders\Version100\DocumentsTableSeeder;
use Database\Seeders\Version100\LocationTypesTableSeeder;
// use Database\Seeders\Version100\MaritalStatusesTableSeeder;
use Database\Seeders\Version100\DependentTypesTableSeeder;
use Database\Seeders\Version100\DocumentGroupsTableSeeder;
use Database\Seeders\Version100\DesignationsTableSeeder;
use Database\Seeders\Version100\OfficeZoneTableSeeder;

class Version100TableSeeder extends Seeder
{

       use DisableForeignKeys;
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::beginTransaction();

        /* Banks*/
         $this->call(BanksTableSeeder::class);
         $this->call(BankBranchesTableSeeder::class);
        /* National */
        $this->call(CountriesTableSeeder::class);
        // $this->call(CurrenciesTableSeeder::class);

       /*  Users */
        $this->call(DependentTypesTableSeeder::class);
        // $this->call(MaritalStatusesTableSeeder::class);
        // $this->call(MemberTypesTableSeeder::class);

        $this->call(DesignationsTableSeeder::class);

         /*    Region  */
        $this->call(RegionsTableSeeder::class);
        $this->call(DistrictsTableSeeder::class);
        $this->call(LocationTypesTableSeeder::class);

         /*   Document */
        $this->call(DocumentsTableSeeder::class);
        $this->call(DocumentGroupsTableSeeder::class);
        $this->call(JobTitlesTableSeeder::class);

         /*  Offices */
        $this->call(OfficesTableSeeder::class);
        $this->call(OfficeZoneTableSeeder::class);

        /* Role & Permission */
        // $this->call(PermissionGroupsTableSeeder::class);
        // $this->call(PermissionsTableSeeder::class);
        // $this->call(PermissionDependenciesTableSeeder::class);
        // $this->call(SysdefsTableSeeder::class);
        // $this->call(UnitGroupsTableSeeder::class);
        // $this->call(UnitsTableSeeder::class);

        /*postcodes*/
        // $this->call(PostCodesSeeder::class);
         /**Quarters */
        $this->call(QuarterTableSeeder::class);


       DB::commit();
    }
}
