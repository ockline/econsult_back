<?php

namespace Database\Seeders\Version100;



use Illuminate\Database\Seeder;
use Database\DisableForeignKeys;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{

    use DisableForeignKeys;
    /**
     * Auto generated seed file
     *
     * @return void
     */
    protected function getRecordCount($table): int
    {
        return DB::table($table)->count();
    }
    public function run()
    {

        // $this->disableForeignKeys('roles');
        // $this->delete('roles');

        $data = array(
            0 =>
            array(
                'id' => '1',
                'name' => 'Developer',
                'alias' => 'DEV',
                'module_id' => 1,
                'status' => '1',
                'created_at' => '2024-05-24 09:28:50',
                'updated_at' => '2024-05-24 09:28:50',
                'deleted_at' => NULL,
            ),
            1 =>
            array(
                'id' => '2',
                'name' => 'System Administrator',
                'alias' => 'SA',
                'module_id' => 1,
                'status' => '1',
                'created_at' => '2024-05-24 09:28:50',
                'updated_at' => '2024-05-24 09:28:50',
                'deleted_at' => NULL,

            ),
            2 =>
            array(
                'id' => '3',
                'name' => 'Super Approver',
                'alias' => 'SUA',
                'module_id' => '1',
                'status' => '1',
                'created_at' => '2024-05-24 09:28:50',
                'updated_at' => '2024-05-24 09:28:50',
                'deleted_at' => NULL,

            ),
            3 =>
            array(
                'id' => '4',
                'name' => 'Managing director',
                'alias' => 'MD',
                'module_id' => 1,
                'status' => '1',
                'created_at' => '2024-05-24 09:28:50',
                'updated_at' => '2024-05-24 09:28:50',
                'deleted_at' => NULL,

            ),
            4 =>
            array(
                'id' => '5',
                'name' => 'Operation Manager ',
                'alias' => 'OM',
                'module_id' => 1,
                'status' => '1',
                'created_at' => '2024-05-24 09:28:50',
                'updated_at' => '2024-05-24 09:28:50',
                'deleted_at' => NULL,

            ),
            5 =>
            array(
                'id' => '6',
                'name' => 'Administrator Functional',
                'alias' => 'AF',
                'module_id' => 1,
                'status' => '1',
                'created_at' => '2024-05-24 09:28:50',
                'updated_at' => '2024-05-24 09:28:50',
                'deleted_at' => NULL,

            ),
            6 =>
            array(
                'id' => '7',
                'name' => 'Registration Initiator',
                'alias' => 'RI',
                'module_id' => 2,
                'status' => '1',
                'created_at' => '2024-05-24 09:28:50',
                'updated_at' => '2024-05-24 09:28:50',
                'deleted_at' => NULL,

            ),

            7 => array(
                'id' => '8',
                'name' => 'Registration Reviewer',
                'alias' => 'RR',
                'module_id' =>  2, //'Review All important Particular',
                'status' => '1',
                'created_at' => '2024-05-24 09:28:50',
                'updated_at' => '2024-05-24 09:28:50',
                'deleted_at' => NULL,

            ),

            8 =>
            array(
                'id' => '9',
                'name' => 'Registration Approver',
                'alias' => 'RA',
                'module_id' =>  2, //'Approve Client Registration ',
                'status' => '1',
                'created_at' => '2024-05-24 09:28:50',
                'updated_at' => '2024-05-24 09:28:50',
                'deleted_at' => NULL,

            ),
            9 =>
            array(
                'id' => '10',
                'name' => 'Vacancy Initiator',
                'alias' => 'VI', //supervisor initiate
                'module_id' =>  3, //'Initiate Job  anouncement',
                'status' => '1',
                'created_at' => '2024-05-24 09:28:50',
                'updated_at' => '2024-05-24 09:28:50',
                'deleted_at' => NULL,

            ),
            10 =>
            array(
                'id' => '11',
                'name' => 'Vacancy Approval',
                'alias' => 'VA', //HR MAnager
                'module_id' => 3, //'Approve Job Vacancy',
                'status' => '1',
                'created_at' => '2024-05-24 09:28:50',
                'updated_at' => '2024-05-24 09:28:50',
                'deleted_at' => NULL,

            ),
            11 =>
            array(
                'id' => '12',
                'name' => 'Interview Initiator',
                'alias' => 'II',
                'module_id' => 3, // 'Conduct HR and Technical Interview',
                'status' => '1',
                'created_at' => '2024-05-24 09:28:50',
                'updated_at' => '2024-05-24 09:28:50',
                'deleted_at' => NULL,

            ),
            12 =>
            array(
                'id' => '13',
                'name' => 'Interview Cordinator',
                'alias' => 'IC',
                'module_id' =>  3, //'Participate in all process of interview',
                'status' => '1',
                'created_at' => '2024-05-24 09:28:50',
                'updated_at' => '2024-05-24 09:28:50',
                'deleted_at' => NULL,

            ),
            13 =>
            array(
                'id' => '14',
                'name' => 'Interview Assessor',
                'alias' => 'IA',
                'module_id' => 3, //'Assess all process of interview',
                'status' => '1',
                'created_at' => '2024-05-24 09:28:50',
                'updated_at' => '2024-05-24 09:28:50',
                'deleted_at' => NULL,

            ),
            14 =>
            array(
                'id' => '15',
                'name' => 'Interview Approver',
                'alias' => 'INA',
                'module_id' => 3, // 'Allow Employement Contrinuite',
                'status' => '1',
                'created_at' => '2024-05-24 09:28:50',
                'updated_at' => '2024-05-24 09:28:50',
                'deleted_at' => NULL,

            ),
            15 =>
            array(
                'id' => '16',
                'name' => 'Hiring Initiator',
                'alias' => 'HI',
                'module_id' => 3, //'Initiate all process of employee registration',
                'status' => '1',
                'created_at' => '2024-05-24 09:28:50',
                'updated_at' => '2024-05-24 09:28:50',
                'deleted_at' => NULL,

            ),
            16 =>
            array(
                'id' => '17',
                'name' => 'Hiring Checker',
                'alias' => 'HC',
                'module_id' => 3, //'Review all particular or Process if are in order',
                'status' => '1',
                'created_at' => '2024-05-24 09:28:50',
                'updated_at' => '2024-05-24 09:28:50',
                'deleted_at' => NULL,

            ),
            17 =>
            array(
                'id' => '18',
                'name' => 'Hiring Approver',
                'alias' => 'HA',
                'module_id' => 3, //'Recommend for the Completion of Employee Registration',
                'status' => '1',
                'created_at' => '2024-05-24 09:28:50',
                'updated_at' => '2024-05-24 09:28:50',
                'deleted_at' => NULL,

            ),
            18 =>
            array(
                'id' => '19',
                'name' => 'Social Initiator',
                'alias' => 'SI',
                'module_id' => 4, //'Initiate Social Record',
                'status' => '1',
                'created_at' => '2024-05-24 09:28:50',
                'updated_at' => '2024-05-24 09:28:50',
                'deleted_at' => NULL,

            ),
            19 =>
            array(
                'id' => '20',
                'name' => 'Social Reviewer',
                'alias' => 'SR',
                'module_id' => 4, //'Recommend ',
                'status' => '1',
                'created_at' => '2024-05-24 09:28:50',
                'updated_at' => '2024-05-24 09:28:50',
                'deleted_at' => NULL,
            ),
            20 =>
            array(
                'id' => '21',
                'name' => 'Induction Initiator',
                'alias' => 'ITI',
                'module_id' => 4, //'Induction Training Initiator',
                'status' => '1',
                'created_at' => '2024-05-24 09:28:50',
                'updated_at' => '2024-05-24 09:28:50',
                'deleted_at' => NULL,

            ),
            21 =>
            array(
                'id' => '22',
                'name' => 'Induction Reviewer',
                'alias' => 'ITR',
                'module_id' => 4, //'Reviewe Induction training',
                'status' => '1',
                'created_at' => '2024-05-24 09:28:50',
                'updated_at' => '2024-05-24 09:28:50',
                'deleted_at' => NULL,

            ),
            22 =>
            array(
                'id' => '23',
                'name' => 'Induction Approver',
                'alias' => 'ITAr',
                'module_id' => 4, //'Approve training',
                'status' => '1',
                'created_at' => '2024-05-24 09:28:50',
                'updated_at' => '2024-05-24 09:28:50',
                'deleted_at' => NULL,

            ),
            23 =>
            array(
                'id' => '24',
                'name' => 'Contact Initiator',
                'alias' => 'CI',
                'module_id' => 5, //'Initiate Contract',
                'status' => '1',
                'created_at' => '2024-05-24 09:28:50',
                'updated_at' => '2024-05-24 09:28:50',
                'deleted_at' => NULL,

            ),
            24 =>
            array(
                'id' => '25',
                'name' => 'Contract Reviewer',
                'alias' => 'CR',
                'module_id' => 5, //'Review All contract before Approval',
                'status' => '1',
                'created_at' => '2024-05-24 09:28:50',
                'updated_at' => '2024-05-24 09:28:50',
                'deleted_at' => NULL,

            ),
            25 =>
            array(
                'id' => '26',
                'name' => 'Contract Approver',
                'alias' => 'CA',
                'module_id' => 5, //'Contract Approval',
                'status' => '1',
                'created_at' => '2024-05-24 09:28:50',
                'updated_at' => '2024-05-24 09:28:50',
                'deleted_at' => NULL,

            ),
            26 =>
            array(
                'id' => '27',
                'name' => 'Id initiator',
                'alias' => 'IDIN',
                'module_id' => 4, //'Initiate id application ',
                'status' => '1',
                'created_at' => '2024-05-24 09:28:50',
                'updated_at' => '2024-05-24 09:28:50',
                'deleted_at' => NULL,

            ),
            27 =>
            array(
                'id' => '28',
                'name' => 'Id Issuer',
                'alias' => 'IDI',
                'module_id' => 4, //'Issue id Card',
                'status' => '1',
                'created_at' => '2024-05-24 09:28:50',
                'updated_at' => '2024-05-24 09:28:50',
                'deleted_at' => NULL,

            ),
            28 =>
            array(
                'id' => '29',
                'name' => 'View Only',
                'alias' => 'VO',
                'module_id' => 1, //'User can only view',
                'status' => '1',
                'created_at' => '2024-05-24 09:28:50',
                'updated_at' => '2024-05-24 09:28:50',
                'deleted_at' => NULL,

            ),
            29 =>
            array(
                'id' => '30',
                'name' => 'All User',
                'alias' => 'ALL',
                'module_id' => 6, //'User can only view',
                'status' => '1',
                'created_at' => '2024-05-24 09:28:50',
                'updated_at' => '2024-05-24 09:28:50',
                'deleted_at' => NULL,

            ),
            30 =>
            array(
                'id' => '31',
                'name' => 'Vacancy Reviewer',
                'alias' => 'VR', //Direct Manager
                'module_id' => 3, //'Initiate Job  anouncement',
                'status' => '1',
                'created_at' => '2024-05-24 09:28:50',
                'updated_at' => '2024-05-24 09:28:50',
                'deleted_at' => NULL,

            ),
            31 =>
            array(
                'id' => '32',
                'name' => 'Grievance Initiator',
                'alias' => 'IRGI', //Industrial Relationship  Grievance Initiator
                'module_id' => 8,
                'status' => '1',
                'created_at' => '2025-04-26 09:28:50',
                'updated_at' => '2025-04-26 09:28:50',
                'deleted_at' => NULL,

            ),
            32 =>
            array(
                'id' => '33',
                'name' => 'Grievance Reviewer',
                'alias' => 'IRGR', //Industrial Relationship  Grievance Initiator
                'module_id' => 8,
                'status' => '1',
                'created_at' => '2025-04-26 09:28:50',
                'updated_at' => '2025-04-26 09:28:50',
                'deleted_at' => NULL,

            ),
            33 =>
            array(
                'id' => '34',
                'name' => 'Grievance Approver',
                'alias' => 'IRGA', //Industrial Relationship  Grievance Initiator
                'module_id' => 8,
                'status' => '1',
                'created_at' => '2025-04-26 09:28:50',
                'updated_at' => '2025-04-26 09:28:50',
                'deleted_at' => NULL,

            ),
            34 =>
            array(
                'id' => '35',
                'name' => 'Disciplinary Initiator',
                'alias' => 'IRDI', //Industrial Relationship  Disciplinary Initiator
                'module_id' => 8,
                'status' => '1',
                'created_at' => '2025-04-26 09:28:50',
                'updated_at' => '2025-04-26 09:28:50',
                'deleted_at' => NULL,

            ),
            35 =>
            array(
                'id' => '36',
                'name' => 'Disciplinary Reviewer',
                'alias' => 'IRDR', //Industrial Relationship  Disciplinary Reviewer
                'module_id' => 8,
                'status' => '1',
                'created_at' => '2025-04-26 09:28:50',
                'updated_at' => '2025-04-26 09:28:50',
                'deleted_at' => NULL,

            ),
            36 =>
            array(
                'id' => '37',
                'name' => 'Disciplinary Approver',
                'alias' => 'IRDA', //Industrial Relationship  Disciplinary Approver
                'module_id' => 8,
                'status' => '1',
                'created_at' => '2025-04-26 09:28:50',
                'updated_at' => '2025-04-26 09:28:50',
                'deleted_at' => NULL,

            ),
            37 =>
            array(
                'id' => '38',
                'name' => 'Misconduct Initiator (HR)',
                'alias' => 'IRMI', //Industrial Relationship  Misconduct Approver
                'module_id' => 8,
                'status' => '1',
                'created_at' => '2025-04-26 09:28:50',
                'updated_at' => '2025-04-26 09:28:50',
                'deleted_at' => NULL,

            ),
            38 =>
            array(
                'id' => '39',
                'name' => 'Misconduct Reviewer (IR)',
                'alias' => 'IRMR', //Industrial Relationship  Misconduct Approver
                'module_id' => 8,
                'status' => '1',
                'created_at' => '2025-04-26 09:28:50',
                'updated_at' => '2025-04-26 09:28:50',
                'deleted_at' => NULL,

            ),
            39 =>
            array(
                'id' => '40',
                'name' => 'Misconduct Approver',
                'alias' => 'IRMA', //Industrial Relationship  Misconduct Approver
                'module_id' => 8,
                'status' => '1',
                'created_at' => '2025-04-26 09:28:50',
                'updated_at' => '2025-04-26 09:28:50',
                'deleted_at' => NULL,

            ),
//Leave block
 40 =>
            array(
                'id' => '41',
                'name' => 'Leave Initiator',
                'alias' => 'LVI', //
                'module_id' => 7,
                'status' => '1',
                'created_at' => '2025-04-26 09:28:50',
                'updated_at' => '2025-04-26 09:28:50',
                'deleted_at' => NULL,

            ),
   41 =>
            array(
                'id' => '42',
                'name' => 'Leave Reviewer',
                'alias' => 'LVR', //
                'module_id' => 7,
                'status' => '1',
                'created_at' => '2025-04-26 09:28:50',
                'updated_at' => '2025-04-26 09:28:50',
                'deleted_at' => NULL,

            ),
 42 =>
            array(
                'id' => '43',
                'name' => 'Leave Approver',
                'alias' => 'LVA', //
                'module_id' => 7,
                'status' => '1',
                'created_at' => '2025-04-26 09:28:50',
                'updated_at' => '2025-04-26 09:28:50',
                'deleted_at' => NULL,

            ),

//Attendance Block
 43 =>
            array(
                'id' => '44',
                'name' => 'Attendance Initiator',
                'alias' => 'ATI', //
                'module_id' => 6, //who will prepare attendance
                'status' => '1',
                'created_at' => '2025-04-26 09:28:50',
                'updated_at' => '2025-04-26 09:28:50',
                'deleted_at' => NULL,

            ),
 44 =>
            array(
                'id' => '45',
                'name' => 'Attendance Reviewer',
                'alias' => 'ATR', // who will review prepared attendance for payroll run
                'module_id' => 6,
                'status' => '1',
                'created_at' => '2025-04-26 09:28:50',
                'updated_at' => '2025-04-26 09:28:50',
                'deleted_at' => NULL,

            ),
 45 =>
            array(
                'id' => '46',
                'name' => 'Attendance Approver',
                'alias' => 'ATA', //
                'module_id' => 6,
                'status' => '1',
                'created_at' => '2025-04-26 09:28:50',
                'updated_at' => '2025-04-26 09:28:50',
                'deleted_at' => NULL,

            ),
//Exit Block
 46 =>
            array(
                'id' => '47',
                'name' => 'Exit Initiator',
                'alias' => 'ETI', //
                'module_id' => 9,
                'status' => '1',
                'created_at' => '2025-04-26 09:28:50',
                'updated_at' => '2025-04-26 09:28:50',
                'deleted_at' => NULL,

            ),
 47 =>
            array(
                'id' => '48',
                'name' => 'Exit Reviewer',
                'alias' => 'ETR', //
                'module_id' => 9,
                'status' => '1',
                'created_at' => '2025-04-26 09:28:50',
                'updated_at' => '2025-04-26 09:28:50',
                'deleted_at' => NULL,

            ),
 48 =>
            array(
                'id' => '49',
                'name' => 'Exit Approver',
                'alias' => 'ETA', //
                'module_id' => 9,//the one who will approve the exit
                'status' => '1',
                'created_at' => '2025-04-26 09:28:50',
                'updated_at' => '2025-04-26 09:28:50',
                'deleted_at' => NULL,

            ),

//General Compliance
 49 =>
            array(
                'id' => '50',
                'name' => 'Compliance Initiator',
                'alias' => 'GCI', //
                'module_id' => 10,//the one who will register or initiate compliance issue
                'status' => '1',
                'created_at' => '2025-04-26 09:28:50',
                'updated_at' => '2025-04-26 09:28:50',
                'deleted_at' => NULL,

            ),
 50 =>
            array(
                'id' => '51',
                'name' => 'Compliance Reviewer',
                'alias' => 'GCR', //
                'module_id' => 10,//the one who will Review the Compliance issues
                'status' => '1',
                'created_at' => '2025-04-26 09:28:50',
                'updated_at' => '2025-04-26 09:28:50',
                'deleted_at' => NULL,

            ),
 51 =>
            array(
                'id' => '52',
                'name' => 'Compliance Approver',
                'alias' => 'GCA', //
                'module_id' => 10,//the one who will approve the exit
                'status' => '1',
                'created_at' => '2025-04-26 09:28:50',
                'updated_at' => '2025-04-26 09:28:50',
                'deleted_at' => NULL,

            ),
//payroll management block
 52 =>
            array(
                'id' => '53',
                'name' => 'Payroll Initiator',
                'alias' => 'PRI', //
                'module_id' => 11,//the one who will initiate payroll or prepare
                'status' => '1',
                'created_at' => '2025-04-26 09:28:50',
                'updated_at' => '2025-04-26 09:28:50',
                'deleted_at' => NULL,

            ),
 53 =>
            array(
                'id' => '54',
                'name' => 'Payroll Reviewer',
                'alias' => 'PRI', //
                'module_id' => 11,//the one who will review payroll
                'status' => '1',
                'created_at' => '2025-04-26 09:28:50',
                'updated_at' => '2025-04-26 09:28:50',
                'deleted_at' => NULL,

            ),
 54 =>
            array(
                'id' => '55',
                'name' => 'Payroll Approver',
                'alias' => 'PRA', //
                'module_id' => 11,//the one who will approve payroll
                'status' => '1',
                'created_at' => '2025-04-26 09:28:50',
                'updated_at' => '2025-04-26 09:28:50',
                'deleted_at' => NULL,

            ),

//Report management Block
 55 =>
            array(
                'id' => '56',
                'name' => 'Report View',
                'alias' => 'RTI', //
                'module_id' => 12,//the one who will initiate payroll or prepare
                'status' => '1',
                'created_at' => '2025-04-26 09:28:50',
                'updated_at' => '2025-04-26 09:28:50',
                'deleted_at' => NULL,

            ),

         56 =>
            array(
                'id' => '57',
                'name' => 'Report Process',
                'alias' => 'PRI', //
                'module_id' => 12,//the one who will initiate payroll or prepare
                'status' => '1',
                'created_at' => '2025-04-26 09:28:50',
                'updated_at' => '2025-04-26 09:28:50',
                'deleted_at' => NULL,

            ),

        );


        // $this->enableForeignKeys('roles');
        $lastRecordCount = $this->getRecordCount("roles");
        $slice = array_slice($data, $lastRecordCount);
        if (count($slice)) {
            DB::table('roles')->insert($slice);
        }
    }
}
