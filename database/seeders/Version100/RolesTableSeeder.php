<?php

namespace Database\Seeders\Version100;

use Database\TruncateTable;
use Illuminate\Database\Seeder;
use Database\DisableForeignKeys;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{

    use DisableForeignKeys, TruncateTable;
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        // $this->disableForeignKeys('roles');
        // $this->delete('roles');

        $data = array (
            0 =>
                array (
                    'id' => '1',
                    'name' => 'Developer',
                    'alias' => 'DEV',
                    //'desciption' => 'All Module',
                    'status' => '1',
                    'created_at' => '2024-05-24 09:28:50',
                    'updated_at' => '2024-05-24 09:28:50',
                    'deleted_at' => NULL,
                ),
            1 =>
                array (
                    'id' => '2',
                    'name' => 'System Administrator',
                    'alias' => 'SA',
                    //'desciption' => 'All Module',
                    'status' => '1',
                    'created_at' => '2024-05-24 09:28:50',
                    'updated_at' => '2024-05-24 09:28:50',
                    'deleted_at' => NULL,

                ),
            2 =>
                array (
                    'id' => '3',
                    'name' => 'Super Approver',
                    'alias' => 'SUA',
                    //'desciption' => 'MD - Will Approve all Module ',
                    'status' => '1',
                    'created_at' => '2024-05-24 09:28:50',
                    'updated_at' => '2024-05-24 09:28:50',
                    'deleted_at' => NULL,

                ),
            3 =>
                array (
                    'id' => '4',
                      'name' => 'Managing director',
                    'alias' => 'MD',
                    //'desciption' => 'All Module',
                    'status' => '1',
                    'created_at' => '2024-05-24 09:28:50',
                    'updated_at' => '2024-05-24 09:28:50',
                    'deleted_at' => NULL,

                ),
            4 =>
                array (
                    'id' => '5',
                   'name' => 'Operation Manager ',
                    'alias' => 'OM',
                    //'desciption' => 'All Module',
                    'status' => '1',
                    'created_at' => '2024-05-24 09:28:50',
                    'updated_at' => '2024-05-24 09:28:50',
                    'deleted_at' => NULL,

                ),
            5 =>
                array (
                    'id' => '6',
                   'name' => 'Administrator Functional',
                    'alias' => 'AF',
                    //'desciption' => 'All Module',
                    'status' => '1',
                    'created_at' => '2024-05-24 09:28:50',
                    'updated_at' => '2024-05-24 09:28:50',
                    'deleted_at' => NULL,

                ),
            6 =>
array (
                    'id' => '7',
                      'name' => 'Registration Initiator',
                   'alias' => 'RI',
                    //'desciption' => 'Initiate Employer Registration',
                    'status' => '1',
                    'created_at' => '2024-05-24 09:28:50',
                    'updated_at' => '2024-05-24 09:28:50',
                    'deleted_at' => NULL,

                ),

            7 => array (
                    'id' => '8',
                      'name' => 'Registration Reviewer',
                    'alias' => 'RR',
                    //'desciption' => 'Review All important Particular',
                    'status' => '1',
                    'created_at' => '2024-05-24 09:28:50',
                    'updated_at' => '2024-05-24 09:28:50',
                    'deleted_at' => NULL,

                ),

            8 =>
                array (
                    'id' => '9',
                     'name' => 'Registration Approver',
                    'alias' => 'RA',
                    //'desciption' => 'Approve Client Registration ',
                    'status' => '1',
                    'created_at' => '2024-05-24 09:28:50',
                    'updated_at' => '2024-05-24 09:28:50',
                    'deleted_at' => NULL,

                ),
            9 =>
                array (
                    'id' => '10',
                     'name' => 'Vacancy Initiator',
                    'alias' => 'VI', //supervisor initiate
                    //'desciption' => 'Initiate Job  anouncement',
                    'status' => '1',
                    'created_at' => '2024-05-24 09:28:50',
                    'updated_at' => '2024-05-24 09:28:50',
                    'deleted_at' => NULL,

                ),
            10 =>
                array (
                    'id' => '11',
                    'name' => 'Vacancy Approval',
                    'alias' => 'VA',//HR MAnager
                    //'desciption' => 'Approve Job Vacancy',
                    'status' => '1',
                    'created_at' => '2024-05-24 09:28:50',
                    'updated_at' => '2024-05-24 09:28:50',
                    'deleted_at' => NULL,

                ),
            11 =>
                array (
                    'id' => '12',
                     'name' => 'Interview Initiator',
                    'alias' => 'II',
                    //'desciption' => 'Conduct HR and Technical Interview',
                    'status' => '1',
                    'created_at' => '2024-05-24 09:28:50',
                    'updated_at' => '2024-05-24 09:28:50',
                    'deleted_at' => NULL,

                ),
            12 =>
                array (
                    'id' => '13',
                    'name' => 'Interview Cordinator',
                    'alias' => 'IC',
                    //'desciption' => 'Participate in all process of interview',
                    'status' => '1',
                    'created_at' => '2024-05-24 09:28:50',
                    'updated_at' => '2024-05-24 09:28:50',
                    'deleted_at' => NULL,

                ),
            13 =>
                array (
                    'id' => '14',
                     'name' => 'Interview Assessor',
                    'alias' => 'IA',
                    //'desciption' => 'Assess all process of interview',
                    'status' => '1',
                    'created_at' => '2024-05-24 09:28:50',
                    'updated_at' => '2024-05-24 09:28:50',
                    'deleted_at' => NULL,

                ),
            14 =>
                array (
                    'id' => '15',
                    'name' => 'Interview Approver',
                    'alias' => 'INA',
                    //'desciption' => 'Allow Employement Contrinuite',
                    'status' => '1',
                    'created_at' => '2024-05-24 09:28:50',
                    'updated_at' => '2024-05-24 09:28:50',
                    'deleted_at' => NULL,

                ),
            15 =>
                array (
                    'id' => '16',
                      'name' => 'Hiring Initiator',
                    'alias' => 'HI',
                    //'desciption' => 'Initiate all process of employee registration',
                    'status' => '1',
                    'created_at' => '2024-05-24 09:28:50',
                    'updated_at' => '2024-05-24 09:28:50',
                    'deleted_at' => NULL,

                ),
            16 =>
                array (
                    'id' => '18',
                     'name' => 'Hiring Checker',
                    'alias' => 'HC',
                    //'desciption' => 'Review all particular or Process if are in order',
                    'status' => '1',
                    'created_at' => '2024-05-24 09:28:50',
                    'updated_at' => '2024-05-24 09:28:50',
                    'deleted_at' => NULL,

                ),
            17 =>
                array (
                    'id' => '19',
                    'name' => 'Hiring Approver',
                    'alias' => 'HA',
                    //'desciption' => 'Recommend for the Completion of Employee Registration',
                    'status' => '1',
                    'created_at' => '2024-05-24 09:28:50',
                    'updated_at' => '2024-05-24 09:28:50',
                    'deleted_at' => NULL,

                ),
            18 =>
                array (
                    'id' => '20',
                     'name' => 'Social Initiator',
                    'alias' => 'SI',
                    //'desciption' => 'Initiate Social Record',
                    'status' => '1',
                    'created_at' => '2024-05-24 09:28:50',
                    'updated_at' => '2024-05-24 09:28:50',
                    'deleted_at' => NULL,

                ),
            19 =>
                array (
                    'id' => '21',
                  'name' => 'Social Reviewer',
                    'alias' => 'SR',
                    //'desciption' => 'Recommend ',
                    'status' => '1',
                    'created_at' => '2024-05-24 09:28:50',
                    'updated_at' => '2024-05-24 09:28:50',
                    'deleted_at' => NULL,
                ),
            20 =>
                array (
                    'id' => '22',
                     'name' => 'Induction Initiator',
                    'alias' => 'ITI',
                    //'desciption' => 'Induction Training Initiator',
                    'status' => '1',
                    'created_at' => '2024-05-24 09:28:50',
                    'updated_at' => '2024-05-24 09:28:50',
                    'deleted_at' => NULL,

                ),
            21 =>
                array (
                    'id' => '23',
                     'name' => 'Induction Reviewer',
                    'alias' => 'ITR',
                    //'desciption' => 'Reviewe Induction training',
                    'status' => '1',
                    'created_at' => '2024-05-24 09:28:50',
                    'updated_at' => '2024-05-24 09:28:50',
                    'deleted_at' => NULL,

                ),
            22 =>
                array (
                    'id' => '24',
                     'name' => 'Induction Approver',
                    'alias' => 'ITAr',
                    //'desciption' => 'Approve training',
                    'status' => '1',
                    'created_at' => '2024-05-24 09:28:50',
                    'updated_at' => '2024-05-24 09:28:50',
                    'deleted_at' => NULL,

                ),
            23 =>
                array (
                    'id' => '25',
                      'name' => 'Contact Initiator',
                    'alias' => 'CI',
                    //'desciption' => 'Initiate Contract',
                    'status' => '1',
                    'created_at' => '2024-05-24 09:28:50',
                    'updated_at' => '2024-05-24 09:28:50',
                    'deleted_at' => NULL,

                ),
            24 =>
                array (
                    'id' => '26',
                      'name' => 'Contract Reviewer',
                    'alias' => 'CR',
                    //'desciption' => 'Review All contract before Approval',
                    'status' => '1',
                    'created_at' => '2024-05-24 09:28:50',
                    'updated_at' => '2024-05-24 09:28:50',
                    'deleted_at' => NULL,

                ),
            25 =>
                array (
                    'id' => '27',
                    'name' => 'Contract Approver',
                    'alias' => 'CA',
                    //'desciption' => 'Contract Approval',
                    'status' => '1',
                    'created_at' => '2024-05-24 09:28:50',
                    'updated_at' => '2024-05-24 09:28:50',
                    'deleted_at' => NULL,

                ),
            26 =>
                array (
                    'id' => '28',
                    'name' => 'Id initiator',
                    'alias' => 'IDIN',
                    //'desciption' => 'Initiate id application ',
                    'status' => '1',
                    'created_at' => '2024-05-24 09:28:50',
                    'updated_at' => '2024-05-24 09:28:50',
                    'deleted_at' => NULL,

                ),
            27 =>
                array (
                    'id' => '29',
                      'name' => 'Id Issuer',
                    'alias' => 'IDI',
                    //'desciption' => 'Issue id Card',
                    'status' => '1',
                    'created_at' => '2024-05-24 09:28:50',
                    'updated_at' => '2024-05-24 09:28:50',
                    'deleted_at' => NULL,

                ),
            28 =>
                array (
                    'id' => '30',
                     'name' => 'View Only',
                    'alias' => 'VO',
                    //'desciption' => 'User can only view',
                    'status' => '1',
                    'created_at' => '2024-05-24 09:28:50',
                    'updated_at' => '2024-05-24 09:28:50',
                    'deleted_at' => NULL,

                ),
     29 =>
                array (
                    'id' => '31',
                     'name' => 'All User',
                    'alias' => 'ALL',
                    //'desciption' => 'User can only view',
                    'status' => '1',
                    'created_at' => '2024-05-24 09:28:50',
                    'updated_at' => '2024-05-24 09:28:50',
                    'deleted_at' => NULL,

                ),
          30 =>
                array (
                    'id' => '32',
                     'name' => 'Vacancy Reviewer',
                    'alias' => 'VR', //Direct Manager
                    //'desciption' => 'Initiate Job  anouncement',
                    'status' => '1',
                    'created_at' => '2024-05-24 09:28:50',
                    'updated_at' => '2024-05-24 09:28:50',
                    'deleted_at' => NULL,

                ),
        );

        // $this->enableForeignKeys('roles');
 $lastRecordCount = $this->getRecordCount("roles");
        $slice = array_slice($data, $lastRecordCount);;
        if (count($slice)) {
            DB::table('roles')->insert($slice);
        }
    }
}
