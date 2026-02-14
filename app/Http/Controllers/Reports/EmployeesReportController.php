<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EmployeesReportController extends Controller
{
    /**
     * Get employee registration report with filters
     */
    public function index(Request $request)
    {
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        $status = $request->get('status', '');
        $type = $request->get('type', 'all');

        $query = DB::table('employees as emp')
            ->select([
                'emp.id',
                'emp.employee_no',
                'emp.firstname',
                'emp.middlename',
                'emp.lastname',
                'emp.progressive_stage',
                'emp.created_at',
                'jt.name as job_title_name',
                'dpt.name as department_name',
                'e.name as employer_name',
            ])
            ->leftJoin('job_title as jt', 'emp.job_title_id', '=', 'jt.id')
            ->leftJoin('departments as dpt', 'emp.department_id', '=', 'dpt.id')
            ->leftJoin('employers as e', 'emp.employer_id', '=', 'e.id')
            ->whereNull('emp.deleted_at');

        if ($status !== '' && $status !== null) {
            $query->where('emp.progressive_stage', $status);
        }

        // Type maps to progressive_stage: 1-Employee details, 2-Supportive Document, 3-Social Record,
        // 4-Induction training, 5-Contract, 6-Person ID, 7-Employee Registration Completed
        if ($type !== 'all' && in_array($type, ['1', '2', '3', '4', '5', '6', '7'])) {
            $query->where('emp.progressive_stage', $type);
        }

        if ($dateFrom) $query->whereDate('emp.created_at', '>=', $dateFrom);
        if ($dateTo) $query->whereDate('emp.created_at', '<=', $dateTo);

        $employees = $query->orderBy('emp.created_at', 'desc')->get();

        return response()->json(['employees' => $employees]);
    }

    /**
     * Export employee report to Excel
     */
    public function export(Request $request): StreamedResponse
    {
        $res = $this->index($request);
        $data = $res->getData(true);
        $employees = $data['employees'] ?? [];
        $dateFrom = $request->get('date_from', now()->subMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->format('Y-m-d'));

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Employee Registration');

        $row = 1;
        $sheet->setCellValue('A' . $row, 'Employee Registration Report');
        $sheet->mergeCells('A1:J1');
        $row += 2;
        $sheet->setCellValue('A' . $row, "Period: {$dateFrom} to {$dateTo}");
        $row += 2;

        $headers = ['No', 'Employee No', 'First Name', 'Middle Name', 'Last Name', 'Job Title', 'Department', 'Employer', 'Stage', 'Created At'];
        foreach ($headers as $i => $h) {
            $sheet->setCellValueByColumnIndex($i + 1, $row, $h);
        }
        $row++;
        foreach ($employees as $i => $emp) {
            $sheet->setCellValueByColumnIndex(1, $row, $i + 1);
            $sheet->setCellValueByColumnIndex(2, $row, $emp->employee_no ?? '');
            $sheet->setCellValueByColumnIndex(3, $row, $emp->firstname ?? '');
            $sheet->setCellValueByColumnIndex(4, $row, $emp->middlename ?? '');
            $sheet->setCellValueByColumnIndex(5, $row, $emp->lastname ?? '');
            $sheet->setCellValueByColumnIndex(6, $row, $emp->job_title_name ?? '');
            $sheet->setCellValueByColumnIndex(7, $row, $emp->department_name ?? '');
            $sheet->setCellValueByColumnIndex(8, $row, $emp->employer_name ?? '');
            $sheet->setCellValueByColumnIndex(9, $row, $emp->progressive_stage ?? '');
            $sheet->setCellValueByColumnIndex(10, $row, $emp->created_at ?? '');
            $row++;
        }

        return $this->streamExcel($spreadsheet, 'Employees_Report_' . $dateFrom . '_' . $dateTo . '.xlsx');
    }

    private function streamExcel(Spreadsheet $spreadsheet, string $filename): StreamedResponse
    {
        return new StreamedResponse(function () use ($spreadsheet, $filename) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
