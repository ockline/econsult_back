<?php

namespace App\Repositories\AttendanceRepositories;


use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Employer\Employer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mews\Purifier\Facades\Purifier;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Hash;
use App\Models\Attendance\Attendance;
use App\Models\Attendance\OverTime;
use Illuminate\Support\Facades\Request;
use App\Models\Employee\Social\Dependant;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;






class AttendanceRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    const MODEL = Attendance::class;


    protected $attendance;


    public function __construct(Attendance $attendance)
    {
        $this->attendance = $attendance;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function retrieveEmployeeDetails($id)
    {
        return DB::table('employees')->where('employee_no', $id)->first();
    }

    public function createAttendanceRecord($request)
    {
        // log::info($request->all());


        // DB::beginTransaction();

        try {

            $file = $request->file('attendance_attachment');

            // Load the spreadsheet
            $spreadsheet = IOFactory::load($file);
            $sheet = $spreadsheet->getActiveSheet();

            // log::info(json_encode($sheet));
            // Initialize an array to store data
            $attendanceData = [];

            foreach ($sheet->getRowIterator() as $rowIndex => $row) {

                // Skip the header row (rowIndex 1)
                if ($rowIndex == 1) {
                    continue;
                }

                // Use getCell() to retrieve data from specific columns (e.g., A = 1, B = 2, C = 3)
                $employee_id = $sheet->getCell('A' . $rowIndex)->getValue(); // Column A (1)
                $employee_name = $sheet->getCell('B' . $rowIndex)->getValue(); // Column B (2)
                $time = $sheet->getCell('C' . $rowIndex)->getValue(); // Column C (3)

                // Format the time using Carbon
                $timeFormatted = Carbon::createFromFormat('d-M-y h:i A', $time); // Adjust format as needed

                // Extract the date and determine time_in / time_out
                if ($timeFormatted) {
                    $date = $timeFormatted->format('Y-m-d'); // Get the date
                    $timeInOrOut = ($timeFormatted->format('A') == 'AM') ? 'time_in' : 'time_out'; // AM = time_in, PM = time_out
                    $timeFormatted = $timeFormatted->format('H:i:s'); // Format the time as HH:mm:ss

                    // Prepare data for saving
                    $attendanceData[] = [
                        'employee_id' => $employee_id,
                        'employee_name' => $employee_name,
                        'date' => $date,
                        $timeInOrOut => $timeFormatted, // Save either time_in or time_out based on AM/PM
                    ];
                }
            }

            // Save the processed attendance data into the Attendance model
            foreach ($attendanceData as $data) {
                // Check if attendance already exists for the employee on that date
                $attendance = Attendance::where('employee_id', $data['employee_id'])
                    ->where('date', $data['date'])
                    ->first();

                if (!$attendance) {
                    // log::info('hapaa ndanii kusave');
                    // log::info($attendance);
                    // If no record found, create a new attendance record
                    Attendance::create([
                        'employee_id' => $data['employee_id'],
                        'employee_name' => $data['employee_name'],
                        'date' => $data['date'],
                        'time_in' => isset($data['time_in']) ? $data['time_in'] : null,
                        'time_out' => isset($data['time_out']) ? $data['time_out'] : null,
                    ]);
                } else {
                    // If record found, update the existing attendance
                    $attendance->update([
                        'time_in' => isset($data['time_in']) ? $data['time_in'] : $attendance->time_in,
                        'time_out' => isset($data['time_out']) ? $data['time_out'] : $attendance->time_out,
                    ]);
                }
            }
            return response()->json(['message' => 'Attendance Details created successfully', 'status' => 201], 201);
        } catch (\Exception $e) {

            Log::error('Failed to create attendance Details', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to create attendance Details', 'status' => 500]);
        }
    }

    /**
     *method to get all all data  for attendance
     */
    public function getMonthlyAttendanceDetails()
    {
        $latestMonth = DB::table('attendances')
            ->select(DB::raw('MAX(EXTRACT(YEAR FROM "date"::DATE)) as latest_year'), DB::raw('MAX(EXTRACT(MONTH FROM "date"::DATE)) as latest_month'))
            ->first();

        $data = DB::table('attendances as at')
            ->select('at.id', 'at.employee_id', 'at.employee_name', 'at.time_in', 'at.time_out', 'at.date')
            ->whereRaw('EXTRACT(MONTH FROM "at"."date"::DATE) = ?', [$latestMonth->latest_month])
            ->whereRaw('EXTRACT(YEAR FROM "at"."date"::DATE) = ?', [$latestMonth->latest_year])
            ->latest('at.date')
            ->get();


        return $data;
    }
    public function retrieveAttendanceDetails($id)
    {
        $latestMonth = DB::table('attendances')
            ->select(DB::raw('MAX(EXTRACT(YEAR FROM "date"::DATE)) as latest_year'), DB::raw('MAX(EXTRACT(MONTH FROM "date"::DATE)) as latest_month'))->where('id', $id)
            ->first();

        $data = DB::table('attendances as at')
            ->select('at.id', 'at.employee_id', 'at.employee_name','at.firstname', 'at.middlename','at.lastname','at.shift','at.time_in', 'at.time_out', 'at.date','e.name as employer_name')
            ->leftJoin('employers as e', 'at.employer_id', '=',  'e.id')
            ->where('at.id', $id)
            ->whereRaw('EXTRACT(MONTH FROM "at"."date"::DATE) = ?', [$latestMonth->latest_month])
            ->whereRaw('EXTRACT(YEAR FROM "at"."date"::DATE) = ?', [$latestMonth->latest_year])
            ->latest('at.date')
            ->first();

    return $data;

    }
/**
*@method to  update attendance
 */

public function updateAttendance($request, $id)
{

  try {
    $data = Attendance::find($id)->update(['shift' => $request->shift]);

log::info($data);
    return response()->json(['status' => 200, 'message' => 'Attendance successfully updated.']);
  } catch (\Throwable $th) {
    return response()->json(['status' => 500, 'message' => $th]);
  }


}
/** crusial method
*@method to get generate attendance
 */
public function exportAttendanceDetails($request)
{
    // Ensure that the date format is correct (you can adjust it if needed)
    $startingDate = $request->startingDate;
    $endDate = $request->endDate;

if(!empty($request)){
$details = DB::table('attendances')
        ->select('*')
        ->whereBetween('date', [$startingDate, $endDate])
        ->get();
if(!empty($details))

{
$details = DB::table('attendances')
        ->select('*')
        ->get();
log::info('chiniii');
log::info($details);
$detail = null;
foreach($details as $detail){
        $annual = $this->checkAnnualLeaveBalance();
        $unpaid_leave = $this->checkUnpaidLeaveBalance();
        $maternity = $this->checkMaternityLeaveBalance();
        $paternity = $this->checkPaternityLeaveBalance();
        $compassionate = $this->checkCompassionateLeaveBalance();
        $sick_full_paid = $this->checkSickFullPaidLeaveBalance();
        $sick_half_paid = $this->checkSickHalfPaidLeaveBalance();
        $sick_unpaid = $this->checkSickUnpaidLeaveBalance();
        $absent = $this->checkAbsentDays();
}
    return $detail;
}
}else{


{
log::info('ndaniii');
log::info($details);
$detail = null;
foreach($details as $detail){
        $annual = $this->checkAnnualLeaveBalance();
        $unpaid_leave = $this->checkUnpaidLeaveBalance();
        $maternity = $this->checkMaternityLeaveBalance();
        $paternity = $this->checkPaternityLeaveBalance();
        $compassionate = $this->checkCompassionateLeaveBalance();
        $sick_full_paid = $this->checkSickFullPaidLeaveBalance();
        $sick_half_paid = $this->checkSickHalfPaidLeaveBalance();
        $sick_unpaid = $this->checkSickUnpaidLeaveBalance();
        $absent = $this->checkAbsentDays();
}
    return $detail;
}
}


}
public function checkAnnualLeaveBalance()
{

}

public function checkUnpaidLeaveBalance()
{

}
public function checkMaternityLeaveBalance()
{

}
public function checkPaternityLeaveBalance()
{

}
public function checkCompassionateLeaveBalance()
{

}
public function checkSickFullPaidLeaveBalance()
{

}
public function checkSickHalfPaidLeaveBalance()
{

}
public function checkSickUnpaidLeaveBalance()
{

}

public function checkAbsentDays()
{


}

    /**
     *************************************** OVERTIME BLOCK  *********************************
     */

    //method to retrieve overtime request
    public function getAllOverTimeDetails()
    {

        $latestMonth = DB::table('overtimes')
            ->select(DB::raw('MAX(EXTRACT(YEAR FROM "overtime_date"::DATE)) as latest_year'), DB::raw('MAX(EXTRACT(MONTH FROM "overtime_date"::DATE)) as latest_month'))
            ->first();

        $data = DB::table('overtimes as ot')
            ->select('ot.id', 'ot.employee_id', 'ot.employee_name', 'ot.ot_hours', 'ot.start_time', 'ot.end_time', 'ot.overtime_date', 'ot.remarks')
            ->whereRaw('EXTRACT(MONTH FROM "ot"."overtime_date"::DATE) = ?', [$latestMonth->latest_month])
            ->whereRaw('EXTRACT(YEAR FROM "ot"."overtime_date"::DATE) = ?', [$latestMonth->latest_year])
            ->latest('ot.overtime_date')
            ->get();

        return $data;
    }
    /**
     *@method to save overtime  that uploaded
     */
 public function createOvertimeRecordUploaded($request)
{

    try {
        $file = $request->file('overtime_attachment');

        // Load the spreadsheet with a specific reader
        try {
            $spreadsheet = IOFactory::load($file);
        } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
            Log::error('Error reading Excel file: ' . $e->getMessage());
            return response()->json(['message' => 'Invalid file format', 'status' => 400]);
        }

        $sheet = $spreadsheet->getActiveSheet();
        // Initialize an array to store data
        $overtimeData = [];

        foreach ($sheet->getRowIterator() as $rowIndex => $row) {

            // Initialize an array to hold the row data
            $rowData = [];

            // Iterate over the cells in the current row
            foreach ($row->getCellIterator() as $cell) {
                $rowData[] = $cell->getValue();
            }

            // Skip empty rows
            if (empty(array_filter($rowData))) {
                continue; // Skip empty rows
            }


            // Skip the header row (rowIndex 1)
            if ($rowIndex == 1) {
                continue;
            }

            // Retrieve data from specific columns (e.g., A = 1, B = 2, C = 3)
            $id = $sheet->getCell('A' . $rowIndex)->getValue(); // Column A (1)
            $ot_hours = $sheet->getCell('B' . $rowIndex)->getValue(); // Column B (3)
            $admin_remarks = $sheet->getCell('C' . $rowIndex)->getValue(); // Column C (3)
            $name = $sheet->getCell('D' . $rowIndex)->getValue(); // Column D (4)
            $date = $sheet->getCell('E' . $rowIndex)->getValue(); // Column E (5)

            // Log the raw date value for debugging


            // Convert the Excel date serial number to a DateTime object
            try {
                $dateFormatted = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date)->format('Y-m-d');
            } catch (\Exception $e) {
                log::error('Error formatting date for row ' . $rowIndex . ': ' . $e->getMessage());
                continue; // Skip this row if the date is invalid
            }

            // Prepare data for saving
            $overtimeData[] = [
                'employee_id' => $id,
                'ot_hours' => $ot_hours,
                'remarks' => $admin_remarks,
                'employee_name' => $name,
                'overtime_date' => $dateFormatted,
            ];
        }

        // Save the processed attendance data into the OverTime model
        foreach ($overtimeData as $data) {
            // log::info('Checking overtime for employee ID: ' . $data['employee_id'] . ' on date: ' . $data['overtime_date']);

            // Check if overtime already exists for the employee on that date
            $overtime = OverTime::where('employee_id', $data['employee_id'])
                ->where('overtime_date', $data['overtime_date'])
                ->first();

            // log::info('Overtime record: ' . json_encode($overtime));

            if (!$overtime) {
                // log::info('No overtime record found, creating new entry.');
                OverTime::create([
                    'employee_id' => $data['employee_id'],
                    'employee_name' => $data['employee_name'],
                    'ot_hours' => $data['ot_hours'],
                    'remarks' => $data['remarks'],
                    'overtime_date' => $data['overtime_date'],
                ]);
            }
        }

        return response()->json(['message' => 'Overtime Details created successfully', 'status' => 201], 201);
    } catch (\Exception $e) {
        Log::error('Failed to create overtime Details', ['error' => $e->getMessage()]);
        return response()->json(['message' => 'Failed to create overtime Details', 'status' => 500]);
    }
}


    //overtime request that addedd manual

    public function saveOvertimeRequest($request)
    {

        try {

            $overtime = new OverTime();
            $data = [
                'employer_id' => !empty($request->employer_id) ? $request->employer_id : null,
                'employee_id' => !empty($request->employee_id) ? $request->employee_id : 2,
                'firstname' => !empty($request->firstname) ? $request->firstname : null,
                'middlename' => !empty($request->middlename) ? $request->middlename : null,
                'lastname' => !empty($request->lastname) ? $request->lastname : null,
                'employee_name' => !empty($request->employee_name) ? $request->employee_name : ($request->firstname . " " . $request->middlename . " " . $request->lastname),
                'ot_hours' => !empty($request->ot_hours) ? $request->ot_hours : null,
                'overtime_date' => $request->overtime_date ?? null,
                'status' => null,
                'remarks' => !empty($request->remarks) ? $request->remarks : null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ];

            $overtime->fill($data); // Fill the model with data
            $kana = $overtime->save();


            return response()->json(['status' => 200, 'message' => 'overtime successfuly created']);
        } catch (\Exception $e) {
            log::error('Failure to save overtime error: ' . $e->getMessage());
        }
    }
}
