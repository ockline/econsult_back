<?php

namespace Database\Seeders;

require_once base_path('database/DisableForeignKeys.php');

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Sysdef\LanguageFluency;
// use Database\DisableForeignKeys;
use Illuminate\Support\Facades\Schema;
use Database\Seeders\Version100\BanksTableSeeder;
use Database\Seeders\Version100\RolesTableSeeder;
use Database\Seeders\Version100\UnitsTableSeeder;
use Database\Seeders\Version100\UsersTableSeeder;
use Database\Seeders\Version100\ModuleTableSeeder;
use Database\Seeders\Version100\ShiftsTableSeeder;
use Database\Seeders\Version100\OfficesTableSeeder;
use Database\Seeders\Version100\QuarterTableSeeder;
use Database\Seeders\Version100\RegionsTableSeeder;
use Database\Seeders\Version100\PackagesTableSeeder;
use Database\Seeders\Version100\PostCodeTableSeeder;
use Database\Seeders\Version100\ContractsTableSeeder;
use Database\Seeders\Version100\CountriesTableSeeder;
use Database\Seeders\Version100\DistrictsTableSeeder;
use Database\Seeders\Version100\DocumentsTableSeeder;
use Database\Seeders\Version100\JobTitlesTableSeeder;
use Database\Seeders\Version100\LeaveTypeTableSeeder;
use Database\Seeders\Version100\OfficeZoneTableSeeder;
use Database\Seeders\Version100\AllowanciesTableSeeder;
use Database\Seeders\Version100\DepartmentsTableSeeder;
use Database\Seeders\Version100\BankBranchesTableSeeder;
use Database\Seeders\Version100\CompetenciesTableSeeder;
use Database\Seeders\Version100\DesignationsTableSeeder;
use Database\Seeders\Version100\LocationTypesTableSeeder;
use Database\Seeders\Version100\TypeVacanciesTableSeeder;
use Database\Seeders\Version100\DependentTypesTableSeeder;
use Database\Seeders\Version100\DocumentGroupsTableSeeder;
use Database\Seeders\Version100\MisconductTypeTableSeeder;
use Database\Seeders\Version100\PracticalTestsTableSeeder;
use Database\Seeders\Version100\MaritalStatusesTableSeeder;
use Database\Seeders\Version100\LanguageFluenciesTableSeeder;
use Database\Seeders\Version100\RankingCreterialsTableSeeder;
use Database\Seeders\Version100\CompetencySubjectsTableSeeder;
use Database\Seeders\Version100\EducationHistoriesTableSeeder;
use Database\Seeders\Version100\PerfomanceCriterialTableSeeder;



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
        $this->call(DocumentGroupsTableSeeder::class);
        $this->call(DocumentsTableSeeder::class);
        // $this->call(JobTitlesTableSeeder::class);

        // //  /*  Offices */
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
        $this->call(LeaveTypeTableSeeder::class);
        $this->call(MisconductTypeTableSeeder::class);
        $this->call(PerfomanceCriterialTableSeeder::class);
        $this->call(DepartmentsTableSeeder::class);
        // $this->call(UnitsTableSeeder::class);
        $this->call(EducationHistoriesTableSeeder::class);
        $this->call(PracticalTestsTableSeeder::class);

       /**  Contracts */
        $this->call(ContractsTableSeeder::class);

        // /* Role & Permission */
        $this->call(RolesTableSeeder::class);
        // $this->call(PermissionGroupsTableSeeder::class);
        // $this->call(PermissionsTableSeeder::class);
        // $this->call(PermissionDependenciesTableSeeder::class);
        // $this->call(SysdefsTableSeeder::class);
        // $this->call(UnitGroupsTableSeeder::class);
        $this->call(ModuleTableSeeder::class);


        // /*postcodes*/
        $this->call(PostCodeTableSeeder::class);
        /**Quarters */
        $this->call(QuarterTableSeeder::class);


        DB::commit();

        Schema::enableForeignKeyConstraints();
    }
}
