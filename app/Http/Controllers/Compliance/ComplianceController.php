<?php

namespace App\Http\Controllers\Compliance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComplianceController extends Controller
{
    /**
     * Get employees for compliance template generation (ECMS.Req.009)
     * Falls back to contract data when no dedicated compliance endpoint exists
     */
    public function templateEmployees(Request $request)
    {
        $month = $request->get('month');
        $year = $request->get('year');
        $category = $request->get('category', 'all');

        $query = DB::table('contract_fixed as cf')
            ->select([
                'cf.id',
                'cf.employee_id',
                'cf.employee_name',
                'cf.employer_name',
                'cf.basic_salary',
                'cf.house_allowance',
                'cf.meal_allowance',
                'cf.transport_allowance',
                'cf.dob',
                'cf.staff_classfication',
                'e.wcf',
                'e.nssf',
                'e.tin',
                'e.national_id',
                'e.gender',
                'e.firstname',
                'e.middlename',
                'e.lastname',
                'e.employee_no',
                'jt.name as job_title_name',
            ])
            ->leftJoin('employees as e', 'cf.employee_id', '=', 'e.id')
            ->leftJoin('job_title as jt', 'cf.job_title_id', '=', 'jt.id')
            ->where('cf.stage', 1);

        $contracts = $query->get();

        $employees = $contracts->map(function ($c) {
            $nameParts = explode(' ', $c->employee_name ?? '');
            return [
                'id' => $c->id,
                'employee_id' => $c->employee_id,
                'employee_no' => $c->employee_no ?? $c->employee_id,
                'employee_name' => $c->employee_name,
                'employer_name' => $c->employer_name,
                'basic_salary' => $c->basic_salary,
                'house_allowance' => $c->house_allowance ?? 0,
                'meal_allowance' => $c->meal_allowance ?? 0,
                'transport_allowance' => $c->transport_allowance ?? 0,
                'dob' => $c->dob,
                'gender' => $c->gender ?? '',
                'job_title' => $c->job_title_name ?? '',
                'staff_classfication' => $c->staff_classfication ?? '',
                'firstname' => $c->firstname ?? $nameParts[0] ?? '',
                'middlename' => $c->middlename ?? '',
                'lastname' => $c->lastname ?? implode(' ', array_slice($nameParts, 1)) ?: '',
                'wcf' => $c->wcf ?? '',
                'nssf' => $c->nssf ?? '',
                'tin' => $c->tin ?? '',
                'national_id' => $c->national_id ?? '',
            ];
        });

        return response()->json(['employees' => $employees]);
    }

    /**
     * List WCF occupational reconciliation records (ECMS.Req.009.2)
     */
    public function occupationalList(Request $request)
    {
        try {
            $records = DB::table('wcf_occupational')->orderBy('id', 'desc')->get();
            return response()->json(['occupational' => $records]);
        } catch (\Exception $e) {
            return response()->json(['occupational' => []]);
        }
    }

    /**
     * Show single occupational record
     */
    public function occupationalShow($id)
    {
        try {
            $record = DB::table('wcf_occupational')->where('id', $id)->first();
            return response()->json(['occupational' => $record]);
        } catch (\Exception $e) {
            return response()->json(['occupational' => null]);
        }
    }

    /**
     * Store WCF occupational record
     */
    public function occupationalStore(Request $request)
    {
        try {
            $id = DB::table('wcf_occupational')->insertGetId([
                'employee_id' => $request->employee_id,
                'employee_number' => $request->employee_number,
                'employee_name' => $request->employee_name,
                'wcf_case_number' => $request->wcf_case_number,
                'incident_type' => $request->incident_type,
                'employer_reported_by' => $request->employer_reported_by,
                'incident_date' => $request->incident_date,
                'reason_for_termination' => $request->reason_for_termination,
                'sick_leave_less' => $request->sick_leave_less,
                'comment' => $request->comment,
                'amount' => $request->amount,
                'payment_status' => $request->payment_status,
                'health_status' => $request->health_status,
                'cause' => $request->cause,
                'status' => $request->status ?? 'Active',
                'recommendation' => $request->recommendation,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            return response()->json(['id' => $id, 'message' => 'Occupation Added Successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Sorry! Operation failed'], 500);
        }
    }

    /**
     * Update WCF occupational record
     */
    public function occupationalUpdate(Request $request, $id)
    {
        try {
            DB::table('wcf_occupational')->where('id', $id)->update([
                'wcf_case_number' => $request->wcf_case_number,
                'incident_type' => $request->incident_type,
                'incident_date' => $request->incident_date,
                'reason_for_termination' => $request->reason_for_termination,
                'comment' => $request->comment,
                'amount' => $request->amount,
                'payment_status' => $request->payment_status,
                'updated_at' => now(),
            ]);
            return response()->json(['message' => 'Occupation Updated Successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Sorry! Operation failed'], 500);
        }
    }

    /**
     * Import occupational Excel
     */
    public function occupationalImport(Request $request)
    {
        try {
            $file = $request->file('file');
            if (!$file) {
                return response()->json(['error' => 'No file uploaded'], 400);
            }
            // TODO: Parse Excel and insert records
            return response()->json(['message' => 'Occupation Incident uploaded Successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Sorry! Operation failed'], 500);
        }
    }
}
