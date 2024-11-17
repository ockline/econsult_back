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
    ->select('at.id','at.employee_id', 'at.employee_name', 'at.time_in', 'at.time_out', 'at.date')
    ->whereRaw('EXTRACT(MONTH FROM "at"."date"::DATE) = ?', [$latestMonth->latest_month])
    ->whereRaw('EXTRACT(YEAR FROM "at"."date"::DATE) = ?', [$latestMonth->latest_year])
    ->latest('at.date')
    ->get();
;


return $data;

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
    ->select('ot.id','ot.employee_id', 'ot.employee_name', 'ot.ot_hours', 'ot.start_time','ot.end_time','ot.overtime_date', 'ot.remarks')
    ->whereRaw('EXTRACT(MONTH FROM "ot"."overtime_date"::DATE) = ?', [$latestMonth->latest_month])
    ->whereRaw('EXTRACT(YEAR FROM "ot"."overtime_date"::DATE) = ?', [$latestMonth->latest_year])
    ->latest('ot.overtime_date')
    ->get();
;


return $data;


}

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
'employee_name' => !empty($request->employee_name) ? $request->employee_name : ($request->firstname. " ". $request->middlename. " ". $request->lastname),
                    'ot_hours' => !empty($request->ot_hours) ? $request->ot_hours : null,
                    'overtime_date' => $request->overtime_date ?? null,
                    'status' => null,
                    'remarks' => !empty($request->remarks) ? $request->remarks : null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),

                ];

                $overtime->fill($data); // Fill the model with data
              $kana= $overtime->save();


            return response()->json(['status' => 200, 'message' => 'overtime successfuly created']);
       } catch (\Exception $e) {
    log::error('Failure to save overtime error: ' . $e->getMessage());
    }
}

}
