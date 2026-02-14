<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ContractsReportController extends Controller
{
    /**
     * Get contracts report (fixed + specific) with filters
     */
    public function index(Request $request)
    {
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        $status = $request->get('status', '');
        $type = $request->get('type', 'all'); // all, fixed, specific

        $data = ['fixed' => [], 'specific' => []];

        if (in_array($type, ['all', 'fixed'])) {
            $query = DB::table('contract_fixed as cf')
                ->select('cf.*', 'e.employee_no', 'e.firstname', 'e.middlename', 'e.lastname', 'jt.name as job_title_name')
                ->leftJoin('employees as e', 'cf.employee_id', '=', 'e.id')
                ->leftJoin('job_title as jt', 'cf.job_title_id', '=', 'jt.id')
                ->where('cf.stage', 1);
            $this->applyFilters($query, 'cf', $dateFrom, $dateTo, $status);
            $data['fixed'] = $query->get();
        }

        if (in_array($type, ['all', 'specific'])) {
            $query = DB::table('contract_specific as cs')
                ->select('cs.*', 'e.employee_no', 'e.firstname', 'e.middlename', 'e.lastname', 'jt.name as job_title_name')
                ->leftJoin('employees as e', 'cs.employee_id', '=', 'e.id')
                ->leftJoin('job_title as jt', 'cs.job_title_id', '=', 'jt.id');
            $this->applyFilters($query, 'cs', $dateFrom, $dateTo, $status);
            $data['specific'] = $query->get();
        }

        return response()->json($data);
    }

    /**
     * Export contracts report to Excel
     */
    public function export(Request $request): StreamedResponse
    {
        $data = $this->index($request)->getData(true);
        $dateFrom = $request->get('date_from', now()->subMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->format('Y-m-d'));

        $spreadsheet = new Spreadsheet();
        $row = 1;

        if (!empty($data['fixed'])) {
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Fixed Contracts');
            $sheet->setCellValue('A' . $row, 'Fixed Term Contracts Report');
            $sheet->mergeCells('A1:H1');
            $row += 2;
            $sheet->setCellValue('A' . $row, "Period: {$dateFrom} to {$dateTo}");
            $row += 2;
            $headers = ['No', 'Employee No', 'Employee Name', 'Job Title', 'Employer', 'Basic Salary', 'Created At'];
            foreach ($headers as $i => $h) {
                $sheet->setCellValueByColumnIndex($i + 1, $row, $h);
            }
            $row++;
            foreach ($data['fixed'] as $i => $c) {
                $name = trim(($c->firstname ?? '') . ' ' . ($c->middlename ?? '') . ' ' . ($c->lastname ?? ''));
                $sheet->setCellValueByColumnIndex(1, $row, $i + 1);
                $sheet->setCellValueByColumnIndex(2, $row, $c->employee_no ?? '');
                $sheet->setCellValueByColumnIndex(3, $row, $name ?: ($c->employee_name ?? ''));
                $sheet->setCellValueByColumnIndex(4, $row, $c->job_title_name ?? '');
                $sheet->setCellValueByColumnIndex(5, $row, $c->employer_name ?? '');
                $sheet->setCellValueByColumnIndex(6, $row, $c->basic_salary ?? '');
                $sheet->setCellValueByColumnIndex(7, $row, $c->created_at ?? '');
                $row++;
            }
        }

        return $this->streamExcel($spreadsheet, 'Contracts_Report_' . $dateFrom . '_' . $dateTo . '.xlsx');
    }

    private function applyFilters($query, $alias, $dateFrom, $dateTo, $status)
    {
        if ($dateFrom) $query->whereDate("{$alias}.created_at", '>=', $dateFrom);
        if ($dateTo) $query->whereDate("{$alias}.created_at", '<=', $dateTo);
        if ($status !== '' && $status !== null) $query->where("{$alias}.status", $status);
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
