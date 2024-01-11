<?php

namespace Database\Seeders\Version100;


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
                'samaccountname' => 'ockline.msungu',
                'password' => '$2a$12$rh6P2bvTsfke.GS1n9QzSO97b8qsAkybnBFblWiG8v18oMHAyzAky',
                'firstname' => 'Ockline',
                'lastname' => 'Msungu',
                'middlename' => 'M',
                'email' => 'ockline.msungu@econsult.co.tz',
                'phone' => '0762700692',
                'dob' => '2001-01-01',
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
                'created_by' => 1,
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
                'username' => 'smtalemwa',
                'samaccountname' => NULL,
                'password' => '$2a$12$rh6P2bvTsfke.GS1n9QzSO97b8qsAkybnBFblWiG8v18oMHAyzAky',
                'firstname' => 'Samuel',
                'lastname' => 'Mtalwemwa',
                'middlename' => '',
                'email' => 'samuel.mtalemwa@econsult.co.tz',
                'phone' => '0762700692',
                'dob' => '2001-01-01',
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
                'created_by' => 1,
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
                'username' => 'emtalemwa',
                'samaccountname' => NULL,
                'password' => '$2a$12$rh6P2bvTsfke.GS1n9QzSO97b8qsAkybnBFblWiG8v18oMHAyzAky',
                'firstname' => 'Ellen',
                'lastname' => 'Mtalemwa',
                'middlename' => '',
                'email' => 'ellen.mtalemwa@econsult.co.tz',
                'phone' => '0762700692',
                'dob' => '2001-01-01',
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
                'created_by' => 1,
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
                'username' => 'kKajolo',
                'samaccountname' => NULL,
                'password' => '$2a$12$rh6P2bvTsfke.GS1n9QzSO97b8qsAkybnBFblWiG8v18oMHAyzAky',
                'firstname' => 'kheri',
                'lastname' => 'Kajolo',
                'middlename' => 'M',
                'email' => 'kheri.kajolo@econsult.co.tz',
                'phone' => '0762700692',
                'dob' => '2001-01-01',
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
                'created_by' => 1,
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
