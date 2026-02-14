<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AttendancesReportController extends Controller
{
    /**
     * Get attendance report with filters
     */
    public function index(Request $request)
    {
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        $status = $request->get('status', '');
        $type = $request->get('type', 'all'); // all, normal, overtime

        $data = ['attendance' => [], 'overtime' => []];

        if (in_array($type, ['all', 'normal'])) {
            $query = DB::table('attendances as a')
                ->select('a.*', 'e.employee_no', 'e.firstname', 'e.middlename', 'e.lastname')
                ->leftJoin('employees as e', 'a.employee_id', '=', 'e.id');
            $this->applyFilters($query, 'a', $dateFrom, $dateTo, $status, 'date');
            $data['attendance'] = $query->orderBy('a.date', 'desc')->get();
        }

        if (in_array($type, ['all', 'overtime'])) {
            $query = DB::table('overtimes as o')
                ->select('o.*', 'e.employee_no', 'e.firstname', 'e.middlename', 'e.lastname')
                ->leftJoin('employees as e', 'o.employee_id', '=', 'e.id');
            $this->applyFilters($query, 'o', $dateFrom, $dateTo, $status, 'overtime_date');
            $data['overtime'] = $query->orderBy('o.overtime_date', 'desc')->get();
        }

        return response()->json($data);
    }

    /**
     * Export attendance report to Excel
     */
    public function export(Request $request): StreamedResponse
    {
        $data = $this->index($request)->getData(true);
        $dateFrom = $request->get('date_from', now()->subMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->format('Y-m-d'));

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Attendance');

        $row = 1;
        $sheet->setCellValue('A' . $row, 'Attendance Report');
        $sheet->mergeCells('A1:G1');
        $row += 2;
        $sheet->setCellValue('A' . $row, "Period: {$dateFrom} to {$dateTo}");
        $row += 2;

        $allRows = [];
        foreach ($data['attendance'] ?? [] as $a) {
            $allRows[] = ['Normal', $a->employee_no ?? '', ($a->firstname ?? '') . ' ' . ($a->lastname ?? ''), $a->date ?? '', $a->time_in ?? '', $a->time_out ?? ''];
        }
        foreach ($data['overtime'] ?? [] as $o) {
            $allRows[] = ['Overtime', $o->employee_no ?? '', ($o->firstname ?? '') . ' ' . ($o->lastname ?? ''), $o->overtime_date ?? '', $o->ot_hours ?? '', ''];
        }

        $headers = ['Type', 'Employee No', 'Employee Name', 'Date', 'Check In/Hours', 'Check Out'];
        foreach ($headers as $i => $h) {
            $sheet->setCellValueByColumnIndex($i + 1, $row, $h);
        }
        $row++;
        foreach ($allRows as $r) {
            foreach ($r as $i => $v) {
                $sheet->setCellValueByColumnIndex($i + 1, $row, $v);
            }
            $row++;
        }

        return $this->streamExcel($spreadsheet, 'Attendance_Report_' . $dateFrom . '_' . $dateTo . '.xlsx');
    }

    private function applyFilters($query, $alias, $dateFrom, $dateTo, $status, $dateCol = 'created_at')
    {
        if ($dateFrom) $query->whereDate("{$alias}.{$dateCol}", '>=', $dateFrom);
        if ($dateTo) $query->whereDate("{$alias}.{$dateCol}", '<=', $dateTo);
        if ($status !== '' && $status !== null) {
            $query->where("{$alias}.status", $status);
        }
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
