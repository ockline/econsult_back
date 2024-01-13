<?php

namespace Database\Seeders;

require_once base_path('database/DisableForeignKeys.php');

use App\Models\Hiring\Interview\RankingCreterial;
use App\Models\Sysdef\LanguageFluency;
use Illuminate\Database\Seeder;
// use Database\DisableForeignKeys;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Database\Seeders\Version100\UsersTableSeeder;
use Database\Seeders\Version100\PostCodesTableSeeder;
use Database\Seeders\Version100\BanksTableSeeder;
use Database\Seeders\Version100\BankBranchesTableSeeder;
use Database\Seeders\Version100\CompetenciesTableSeeder;
use Database\Seeders\Version100\CountriesTableSeeder;
use Database\Seeders\Version100\RegionsTableSeeder;
use Database\Seeders\Version100\JobTitlesTableSeeder;
use Database\Seeders\Version100\OfficesTableSeeder;
use Database\Seeders\Version100\DistrictsTableSeeder;
use Database\Seeders\Version100\DocumentsTableSeeder;
use Database\Seeders\Version100\LocationTypesTableSeeder;

use Database\Seeders\Version100\MaritalStatusesTableSeeder;

use Database\Seeders\Version100\DependentTypesTableSeeder;
use Database\Seeders\Version100\DocumentGroupsTableSeeder;
use Database\Seeders\Version100\DesignationsTableSeeder;
use Database\Seeders\Version100\OfficeZoneTableSeeder;
use Database\Seeders\Version100\TypeVacanciesTableSeeder;
use Database\Seeders\Version100\LanguageFluenciesTableSeeder;
use Database\Seeders\Version100\ShiftsTableSeeder;
use Database\Seeders\Version100\RankingCreterialsTableSeeder;
use Database\Seeders\Version100\CompetencySubjectsTableSeeder;
use Database\Seeders\Version100\AllowanciesTableSeeder;
use Database\Seeders\Version100\PackagesTableSeeder;
// use Database\Seeders\Version100\QuarterTableSeeder;

class Version100TableSeeder extends Seeder
{
         use \Database\DisableForeignKeys;
    //    use DisableForeignKeys;
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::beginTransaction();

        /* Banks*/
         $this->call(BanksTableSeeder::class);
         $this->call(BankBranchesTableSeeder::class);
        /* National */
        $this->call(CountriesTableSeeder::class);
        // $this->call(CurrenciesTableSeeder::class);

       /*  Users */
        $this->call(UsersTableSeeder::class);
        $this->call(DependentTypesTableSeeder::class);
        $this->call(MaritalStatusesTableSeeder::class);
        // $this->call(MemberTypesTableSeeder::class);

        $this->call(DesignationsTableSeeder::class);

        //  /*    Region  */
        $this->call(RegionsTableSeeder::class);
        $this->call(DistrictsTableSeeder::class);
        $this->call(LocationTypesTableSeeder::class);

        //  /*   Document */
        $this->call(DocumentsTableSeeder::class);
        $this->call(DocumentGroupsTableSeeder::class);
        $this->call(JobTitlesTableSeeder::class);

        //  /*  Offices */
        $this->call(OfficesTableSeeder::class);
        $this->call(OfficeZoneTableSeeder::class);

         /* Hiring and Registration*/
        $this->call(LanguageFluenciesTableSeeder::class);
        $this->call(ShiftsTableSeeder::class);
        $this->call(RankingCreterialsTableSeeder::class);
        $this->call(TypeVacanciesTableSeeder::class);
        $this->call(AllowanciesTableSeeder::class);
        $this->call(CompetenciesTableSeeder::class);
        $this->call(CompetencySubjectsTableSeeder::class);
         $this->call(PackagesTableSeeder::class);


        /* Role & Permission */
        // $this->call(PermissionGroupsTableSeeder::class);
        // $this->call(PermissionsTableSeeder::class);
        // $this->call(PermissionDependenciesTableSeeder::class);
        // $this->call(SysdefsTableSeeder::class);
        // $this->call(UnitGroupsTableSeeder::class);
        // $this->call(UnitsTableSeeder::class);

        /*postcodes*/
        $this->call(PostCodesTableSeeder::class);
         /**Quarters */
        // $this->call(QuarterTableSeeder::class);

       DB::commit();

      Schema::enableForeignKeyConstraints();
    }
}
