<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Database\TruncateTable;
use Database\DisableForeignKeys;

class UsersTableSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->disableForeignKeys('users');
        $this->delete('users');
        //

        \DB::table('users')->insert(array(

            0 =>
            array(
                'id' => '1',
                'username' => 'omsungu',
                'samaccountname' => NULL,
                'password' => 'd63580d0b63f1e3b84bf4f472ffc2da5123456:codee03aa161728f7468abe468c74dc67203',
                'firstname' => 'Ockline',
                'lastname' => 'Msungu',
                'middlename' => 'M',
                'email' => 'ockline.msungu@econsult.co.tz',
                'phone' => '0762700692',
                'dob' => null,
                'employer_id' => 1,
                'department_id' => 1,
                'section_id' => 2,
                'designation_id' => 1,
                'gender_id' => 1,
                'email_verified_at' => null,
                'active' => 1,
                'available' => 1,
                'last_login' => NULL,
                'remember_token' => NULL,
                'created_by' => NULL,
                'location_project' => NULL,
                'project_name' => null,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
                // 'sub' => NULL,
                // 'user_sub_id'=>NULL,
            ),
            1 =>
            array(
                'id' => '2',
                'username' => 'omsungu',
                'samaccountname' => NULL,
                'password' => 'd63580d0b63f1e3b84bf4f472ffc2da5123456:codee03aa161728f7468abe468c74dc67203',
                'firstname' => 'Ockline',
                'lastname' => 'Msungu',
                'middlename' => 'M',
                'email' => 'ockline.msungu@econsult.co.tz',
                'phone' => '0762700692',
                'dob' => null,
                'employer_id' => 1,
                'department_id' => 1,
                'section_id' => 2,
                'designation_id' => 1,
                'gender_id' => 1,
                'email_verified_at' => null,
                'active' => 1,
                'available' => 1,
                'last_login' => NULL,
                'remember_token' => NULL,
                'created_by' => NULL,
                'location_project' => NULL,
                'project_name' => null,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
                // 'sub' => NULL,
                // 'user_sub_id'=>NULL,
            ),
            2 =>
            array(
                'id' => '3',
                'username' => 'omsungu',
                'samaccountname' => NULL,
                'password' => 'd63580d0b63f1e3b84bf4f472ffc2da5123456:codee03aa161728f7468abe468c74dc67203',
                'firstname' => 'Ockline',
                'lastname' => 'Msungu',
                'middlename' => 'M',
                'email' => 'ockline.msungu@econsult.co.tz',
                'phone' => '0762700692',
                'dob' => null,
                'employer_id' => 1,
                'department_id' => 1,
                'section_id' => 2,
                'designation_id' => 1,
                'gender_id' => 1,
                'email_verified_at' => null,
                'active' => 1,
                'available' => 1,
                'last_login' => NULL,
                'remember_token' => NULL,
                'created_by' => NULL,
                'location_project' => NULL,
                'project_name' => null,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
                // 'sub' => NULL,
                // 'user_sub_id'=>NULL,
            ),
            127 =>
            array(
                'id' => '4',
                'username' => 'omsungu',
                'samaccountname' => NULL,
                'password' => 'd63580d0b63f1e3b84bf4f472ffc2da5123456:codee03aa161728f7468abe468c74dc67203',
                'firstname' => 'Ockline',
                'lastname' => 'Msungu',
                'middlename' => 'M',
                'email' => 'ockline.msungu@econsult.co.tz',
                'phone' => '0762700692',
                'dob' => null,
                'employer_id' => 1,
                'department_id' => 1,
                'section_id' => 2,
                'designation_id' => 1,
                'gender_id' => 1,
                'email_verified_at' => null,
                'active' => 1,
                'available' => 1,
                'last_login' => NULL,
                'remember_token' => NULL,
                'created_by' => NULL,
                'location_project' => NULL,
                'project_name' => null,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
                // 'sub' => NULL,
                // 'user_sub_id'=>NULL,
            ),

        ));

        $this->enableForeignKeys('users');
    }
}
