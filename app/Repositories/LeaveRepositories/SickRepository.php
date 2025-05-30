<?php

namespace App\Repositories\LeaveRepositories;


use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Leave\AllLeave;
use App\Models\Leave\AnnualLeave;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Validator;


class SickRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    const MODEL = AllLeave::class;


    protected $sick_leave;


    public function __construct(AllLeave $sick_leave)
    {
        $this->sick_leave = $sick_leave;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id)
    {
        $sick_leaves = $this->sick_leave->where("id", $id)->first();

        if (!is_null($sick_leaves)) {
            return $sick_leaves;
        }
        // throw new GeneralException(trans('exceptions.operation.data_not_found'));
    }
    /**
     *@method to get annual paid and unpaid leave
     */
    public function getAllLeaveDetails() {}
    /**
     *@method to get all employees according to id
     */

    public function retrieveEmployeeDetails($id)
    {
        $data = DB::table('employees as e')->select('e.employee_no as employee_id', 'e.firstname', 'e.middlename', 'e.lastname', 'e.job_title_id', 'e.department_id', 'jt.name as job_title', 'dpt.name as departments', 'e.employer_id', 'emp.name as employer')
            ->leftJoin('job_title as jt', 'e.job_title_id', '=', 'jt.id')
            ->leftJoin('departments as dpt', 'e.department_id', 'dpt.id')
            ->leftJoin('employers as emp', 'e.employer_id', '=', 'emp.id')
            ->where('e.employee_no', $id)
            ->first();

        return $data;
    }

    public function getDatatable()
    {
        $sick_leaves = $this->sick_leave->get();
        return $sick_leaves;
    }
    /**
     *@method to save sick full paid leave according to  leave type
     */
    public function saveFullPaidLeave($request)
    {

        try {

            $full_balance = $this->balanceDaysPaid($request);

            $financial = $this->getFinancialYear();

            $all_balance = $this->allBalanceDays($request);

            //paid  == 1
            if ($request->leave_type == 5) {

                $paid_leave = new AllLeave();
                $data = [
                    'leave_type_id' => !empty($request->leave_type) ? $request->leave_type : 5,
                    'employer_id' => !empty($request->employer_id) ? $request->employer_id : null,
                    'employee_id' => !empty($request->employee_id) ? $request->employee_id : 2,
                    'balance_days' => !empty($full_balance) ? $full_balance  : null,
                    'financial_year' => !empty($financial) ? (string)$financial : null,
                    // 'all_balance' =>  $balance?? 2,
                    'all_balance' => !empty($all_balance) ? $all_balance : 0,
                    'start_date' => $request->start_date ?? null,
                    'end_date' => $request->end_date ?? null,
                    'status' => null,
                    'remarks' => !empty($request->remarks) ? $request->remarks : null,
                    'refferal_to' => $request->refferal_to ?? null,
                    'hospital_name'  => $request->hospital_name ?? null,
                    'age' => $request->age ?? null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),

                ];

                $paid_leave->fill($data); // Fill the model with data
                $paid_leave->save();
            }
            return response()->json(['status' => 200, 'message' => 'full paid Leave successfuly created']);
        } catch (\Exception $e) {
            log::error('Failure to save full paid leave error: ' . $e->getMessage());
        }
    }

    /**
     *@method to save sick half paid leave according to  leave type
     */
    public function saveHalfPaidLeave($request)
    {

        try {

            $balance = $this->balanceDaysHalfPaid($request);

            $financial = $this->getFinancialYear();

            $all_balance = $this->allHalfBalanceDays($request);

            //paid  == 1
            if ($request->leave_type == 6) {

                $paid_leave = new AllLeave();
                $data = [
                    'leave_type_id' => !empty($request->leave_type) ? $request->leave_type : 6,
                    'employer_id' => !empty($request->employer_id) ? $request->employer_id : null,
                    'employee_id' => !empty($request->employee_id) ? $request->employee_id : 2,
                    'balance_days' => !empty($balance) ? $balance : null,
                    'financial_year' => !empty($financial) ? (string)$financial : null,
                    // 'all_balance' =>  $balance?? 2,
                    'all_balance' => !empty($all_balance) ? $all_balance : 0,
                    'start_date' => $request->start_date ?? null,
                    'end_date' => $request->end_date ?? null,
                    'refferal_to' => $request->refferal_to ?? null,
                    'hospital_name'  => $request->hospital_name ?? null,
                    'age' => $request->age ?? null,
                    'status' => null,
                    'remarks' => !empty($request->remarks) ? $request->remarks : null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),

                ];

                $paid_leave->fill($data); // Fill the model with data
                $paid_leave->save();
            }
            return response()->json(['status' => 200, 'message' => 'full paid Leave successfuly created']);
        } catch (\Exception $e) {
            log::error('Failure to save full paid leave error: ' . $e->getMessage());
        }
    }
    /**
     *@method to  save unpaid sick leave   that will start after
     */
    public function saveUnpaidLeave($request)
    {

        try {
            // DB::transaction();

            // $balance = $this->balanceDaysPaid($request);
            // $financial = $this->getFinancialYear();
            // $all_balance = $this->allBalanceDays($request);
            //paid  == 1 , unpaid ==2
            if ($request->leave_type = 7) {
                $unpaid_leave = new AllLeave();
                $data = [
                    'leave_type_id' => !empty($request->leave_type) ? $request->leave_type : 7,
                    'employer_id' => !empty($request->employer_id) ? $request->employer_id : null,
                    'employee_id' => !empty($request->employee_id) ? $request->employee_id : 2,
                    'balance_days' => !empty($balance) ? $balance : null,
                    'financial_year' => !empty($financial) ? (string)$financial : null,
                    // 'all_balance' =>  $balance?? 2,
                    'all_balance' => !empty($all_balance) ? $all_balance : 0,
                    'start_date' => $request->start_date ?? null,
                    'end_date' => $request->end_date ?? null,
                    'refferal_to' => $request->refferal_to ?? null,
                    'hospital_name'  => $request->hospital_name ?? null,
                    'age' => $request->age ?? null,
                    'status' => null,
                    'remarks' => !empty($request->remarks) ? $request->remarks : null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),

                ];

                $unpaid_leave->fill($data); // Fill the model with data
                $unpaid_leave->save();
            }

            // DB::commit();
            return response()->json(['status' => 200, 'message' => 'Annual Leave successfuly created']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 500, 'message' => 'failed to create Annual Leave ' . $th->getMessage()]);
        }
    }


    /**
     *@method to check remainig days on paid leave per for all period of working  based with employer
     */
    public function balanceDaysPaid($request)
    {

        $balance = 63; // Define maximum leave balance

        // Check the most recent leave record for the employee
        $check = DB::table('leaves')
            ->select('*')
            ->where('employee_id', $request->employee_id)
            ->where('leave_type_id', 5)
            ->latest()
            ->first(); // Use `first()` to get the latest record

        if (!empty($check)) {

            // If the employee has a leave record and their balance is less than the max balance
            if ($check->balance_days < $balance) {
                $start = Carbon::parse($request->start_date); // Parse the start date
                $end = Carbon::parse($request->end_date); // Parse the end date

                // Calculate the difference in days between the start and end date
                $new_days = $end->diffInDays($start);

                // Calculate the new balance after deducting the leave days
                $new_balance = $check->balance_days - $new_days;

                // Check if the new balance is less than the predefined balance
                if ($new_balance) {
                    return $new_balance; // Return the new balance if it's valid
                } else {
                    // If the new balance is negative, return an error response
                    return response()->json([
                        'status' => 422,
                        'message' => 'Your leave exceeds your remaining balance'
                    ]);
                }
            }
        } else {

            //if  check if empty
            $start = Carbon::parse($request->start_date); // Parse the start date
            $end = Carbon::parse($request->end_date); // Parse the end date

            // Calculate the difference in days between the start and end date
            $new_days = $end->diffInDays($start);

            // Calculate the new balance after deducting the leave days
            $new_balance = $balance - $new_days;
            if ($new_balance) {
                log::info($new_balance);
                return  $new_balance;
            } else {

                return  response()->json(['status' => 423, 'message' => 'Leave days can not exceedd maximum annual leave at cicycle']);
            }
        }
    }
    /**
     *@method to get get all remaining balance after in all period of employements
     */
    public function allBalanceDays($request)
    {


        $perYearDays = 63; // Leave days per year

        // Fetch employee details
        $employee = DB::table('employees')->select('employee_no', 'from_date')->where('employee_no', $request->employee_id)->first();

        if (!$employee) {
            return response()->json(['status' => 404, 'message' => 'Employee not found']);
        }

        // Calculate years worked based on employment start date and request start date
        $employmentStartYear = Carbon::parse($employee->from_date)->year;
        $currentYear = Carbon::parse($request->start_date)->year;





        if ($currentYear > 0) {
            $totalDays = $perYearDays;

            // Retrieve latest all_balance for the employee
            $employeeDays = DB::table('leaves')->select('all_balance')->where('leave_type_id', 5)->latest()->first();
            $allBalance = $employeeDays->all_balance ?? 0; // Use 0 if all_balance is null



            // Calculate remaining days overall
            $remainingDaysOverall = $totalDays - $allBalance;
        }

        return $remainingDaysOverall;
    }
    /**
     *mehtod to get financial year
     */
    public function getFinancialYear()
    {

        $today = now(); // Get the current date
        $startMonth = 1; // Financial year starts in April

        // Determine the financial year
        if ($today->month >= $startMonth) {
            $financialYear = $today->year . '-' . ($today->year + 1);
        } else {
            $financialYear = ($today->year - 1) . '-' . $today->year;
        }

        return $financialYear;
    }
    /**
     *@method to retrive annual leave ..paid and unpaid
     */
    public function getSickLeave()
    {

        $data = DB::table('leaves as l')
            ->select(
                'l.id',
                'l.employee_id',
                'l.balance_days',
                'l.financial_year',
                'l.all_balance',
                'l.start_date',
                'l.end_date',
                'l.status',
                // DB::raw("TO_CHAR(l.start_date, 'DD-Mon-YYYY') as start_date"),
                // DB::raw("TO_CHAR(l.end_date, 'DD-Mon-YYYY') as end_date"),
                'lt.name as leave_type',
                'e.employee_name',
                'emp.name as employer'
            )
            ->leftJoin('employees as e', 'l.employee_id', '=', 'e.employee_no')
            ->leftJoin('leave_types as lt', 'l.leave_type_id', '=', 'lt.id')
            ->leftJoin('employers as emp', 'l.employer_id', '=', 'emp.id')
            ->whereIn('leave_type_id', [5, 6, 7])
            ->get();

        return $data;
    }


    /**
     *@method to check remainig days on Half paid leave per for all period of working  based with employer
     */
    public function balanceDaysHalfPaid($request)
    {

        $balance = 63; // Define maximum leave balance

        // Check the most recent leave record for the employee
        $check = DB::table('leaves')
            ->select('*')
            ->where('employee_id', $request->employee_id)
            ->where('leave_type_id', 6)
            ->latest()
            ->first(); // Use `first()` to get the latest record

        if (!empty($check)) {

            // If the employee has a leave record and their balance is less than the max balance
            if ($check->balance_days < $balance) {
                $start = Carbon::parse($request->start_date); // Parse the start date
                $end = Carbon::parse($request->end_date); // Parse the end date

                // Calculate the difference in days between the start and end date
                $new_days = $end->diffInDays($start);

                // Calculate the new balance after deducting the leave days
                $new_balance = $check->balance_days - $new_days;

                // Check if the new balance is less than the predefined balance
                if ($new_balance >= 0) {
                    return $new_balance; // Return the new balance if it's valid
                } else {
                    // If the new balance is negative, return an error response
                    return response()->json([
                        'status' => 422,
                        'message' => 'Your leave exceeds your remaining balance'
                    ]);
                }
            }
        } else {

            //if  check if empty
            $start = Carbon::parse($request->start_date); // Parse the start date
            $end = Carbon::parse($request->end_date); // Parse the end date

            // Calculate the difference in days between the start and end date
            $new_days = $end->diffInDays($start);

            // Calculate the new balance after deducting the leave days
            $new_balance = $balance - $new_days;
            if ($new_balance <= $balance) {
                return  $new_balance;
            } else {

                return  response()->json(['status' => 423, 'message' => 'Leave days can not exceedd maximum annual leave at cicycle']);
            }
        }
    }
    /**
     *@method to get  all remaining balance  of half paid  sick leave after in that year
     */
    public function allHalfBalanceDays($request)
    {


        $perYearDays = 63; // Leave days per year

        // Fetch employee details
        $employee = DB::table('employees')->select('employee_no', 'from_date')->where('employee_no', $request->employee_id)->first();

        if (!$employee) {
            return response()->json(['status' => 404, 'message' => 'Employee not found']);
        }

        // Calculate years worked based on employment start date and request start date
        $employmentStartYear = Carbon::parse($employee->from_date)->year;
        $currentYear = Carbon::parse($request->start_date)->year;





        if ($currentYear > 0) {
            $totalDays = $perYearDays;

            // Retrieve latest all_balance for the employee
            $employeeDays = DB::table('leaves')->select('all_balance')->where('leave_type_id', 5)->latest()->first();
            $allBalance = $employeeDays->all_balance ?? 0; // Use 0 if all_balance is null



            // Calculate remaining days overall
            $remainingDaysOverall = $totalDays - $allBalance;

            log::info($remainingDaysOverall);
        }

        return $remainingDaysOverall;
    }
    //update sick leaves
    public function updateFullPaidLeave($request, $id)
    {

        try {

            $full_balance = $this->balanceDaysPaid($request);

            $financial = $this->getFinancialYear();

            $all_balance = $this->allBalanceDays($request);

            //paid  == 1
            if ($request->leave_type == 5) {

                log::info('tumeanzaaaaa');
                $paid_leave =  AllLeave::find($id)->update([

                    'balance_days' => !empty($full_balance) ? $full_balance  : null,
                    'financial_year' => !empty($financial) ? (string)$financial : null,
                    'all_balance' => !empty($all_balance) ? $all_balance : 0,
                    'start_date' => $request->start_date ?? null,
                    'end_date' => $request->end_date ?? null,
                    'refferal_to' => $request->refferal_to ?? null,
                    'hospital_name'  => $request->hospital_name ?? null,
                    'age' => $request->age ?? null,
                    'status' => null,
                    'updated_at' => Carbon::now(),
                ]);
            }
            return response()->json(['status' => 200, 'message' => 'full paid Leave successfuly updated']);
        } catch (\Exception $e) {
            log::error('Failure to save full paid leave error: ' . $e->getMessage());
        }
    }

    public function updateHalfPaidLeave($request, $id)
    {



        try {

            $balance = $this->balanceDaysHalfPaid($request);

            $financial = $this->getFinancialYear();

            $all_balance = $this->allHalfBalanceDays($request);

            //paid  == 1
            if ($request->leave_type == 6) {

                AllLeave::find($id)->update([
                    'balance_days' => !empty($full_balance) ? $full_balance  : null,
                    'financial_year' => !empty($financial) ? (string)$financial : null,
                    'all_balance' => !empty($all_balance) ? $all_balance : 0,
                    'start_date' => $request->start_date ?? null,
                    'end_date' => $request->end_date ?? null,
                    'refferal_to' => $request->refferal_to ?? null,
                    'hospital_name'  => $request->hospital_name ?? null,
                    'age' => $request->age ?? null,
                    'updated_at' => Carbon::now(),

                ]);
            }
            return response()->json(['status' => 200, 'message' => 'full paid Leave successfuly update']);
        } catch (\Exception $e) {
            log::error('Failure to save full paid leave error: ' . $e->getMessage());
        }
    }

    public function updateUnPaidLeave($request, $id)
    {


        try {
            // DB::transaction();


            if ($request->leave_type = 7) {
                $unpaid_leave =  AllLeave::find($id);
                $data = [
                    'start_date' => $request->start_date ?? null,
                    'end_date' => $request->end_date ?? null,
                    'refferal_to' => $request->refferal_to ?? null,
                    'hospital_name'  => $request->hospital_name ?? null,
                    'age' => $request->age ?? null,
                    'updated_at' => Carbon::now(),

                ];

                $unpaid_leave->fill($data); // Fill the model with data
                $unpaid_leave->update();
            }

            // DB::commit();
            return response()->json(['status' => 200, 'message' => 'Unpaid Leave successfuly updated']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 500, 'message' => 'failed to update Leave ' . $th->getMessage()]);
        }
    }
    /**
     *@method to get employee leave details
     */

    public function retrieveSickLeaveDetails($leaveId)
    {
        $data = DB::table('leaves as lv')->select(
            'lv.id',
            'lv.balance_days',
            'lv.leave_type_id as leave_type',
            'lv.start_date',
            'end_date',
            'e.employee_no as employee_id',
            'e.firstname',
            'e.middlename',
            'e.lastname',
            'e.mobile_number',
            'e.job_title_id',
            'e.department_id',
            'jt.name as job_title',
            'dpt.name as departments',
            'e.employer_id',
            'emp.name as employer',
            'lt.name as leave',
            'lv.age',
            'lv.refferal_to',
            'lv.hospital_name',
            DB::raw("DATE_PART('day', lv.end_date::timestamp - lv.start_date::timestamp) as leave_days")

        )
            ->leftJoin('employees as e', 'lv.employee_id', '=', 'e.employee_no')
            ->leftJoin('job_title as jt', 'e.job_title_id', '=', 'jt.id')
            ->leftJoin('departments as dpt', 'e.department_id', 'dpt.id')
            ->leftJoin('employers as emp', 'e.employer_id', '=', 'emp.id')
            ->leftJoin('leave_types as lt', 'lv.leave_type_id', '=', 'lt.id')
            ->where('lv.id', $leaveId)
            ->first();

        return $data;
    }
}
