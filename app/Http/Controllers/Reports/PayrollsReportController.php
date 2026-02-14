<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PayrollsReportController extends Controller
{
    /**
     * Get payroll report with filters (stub - extend when payroll module exists)
     */
    public function index(Request $request)
    {
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        $status = $request->get('status', '');

        // Placeholder: use contract_fixed as payroll proxy if no payroll table exists
        $query = DB::table('contract_fixed as cf')
            ->select('cf.id', 'cf.employee_id', 'cf.employee_name', 'cf.basic_salary', 'cf.house_allowance', 'cf.meal_allowance', 'cf.transport_allowance', 'cf.created_at', 'e.employee_no')
            ->leftJoin('employees as e', 'cf.employee_id', '=', 'e.id');

        if ($dateFrom) $query->whereDate('cf.created_at', '>=', $dateFrom);
        if ($dateTo) $query->whereDate('cf.created_at', '<=', $dateTo);

        $records = $query->orderBy('cf.created_at', 'desc')->get();

        return response()->json(['payrolls' => $records]);
    }

    /**
     * Export payroll report to Excel
     */
    public function export(Request $request): StreamedResponse
    {
        $res = $this->index($request);
        $data = $res->getData(true);
        $records = $data['payrolls'] ?? [];
        $dateFrom = $request->get('date_from', now()->subMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->format('Y-m-d'));

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Payroll');

        $row = 1;
        $sheet->setCellValue('A' . $row, 'Payroll Report');
        $sheet->mergeCells('A1:H1');
        $row += 2;
        $sheet->setCellValue('A' . $row, "Period: {$dateFrom} to {$dateTo}");
        $row += 2;

        $headers = ['No', 'Employee No', 'Employee Name', 'Basic Salary', 'House', 'Meal', 'Transport', 'Created At'];
        foreach ($headers as $i => $h) {
            $sheet->setCellValueByColumnIndex($i + 1, $row, $h);
        }
        $row++;
        foreach ($records as $i => $r) {
            $sheet->setCellValueByColumnIndex(1, $row, $i + 1);
            $sheet->setCellValueByColumnIndex(2, $row, $r->employee_no ?? '');
            $sheet->setCellValueByColumnIndex(3, $row, $r->employee_name ?? '');
            $sheet->setCellValueByColumnIndex(4, $row, $r->basic_salary ?? '');
            $sheet->setCellValueByColumnIndex(5, $row, $r->house_allowance ?? '');
            $sheet->setCellValueByColumnIndex(6, $row, $r->meal_allowance ?? '');
            $sheet->setCellValueByColumnIndex(7, $row, $r->transport_allowance ?? '');
            $sheet->setCellValueByColumnIndex(8, $row, $r->created_at ?? '');
            $row++;
        }

        return $this->streamExcel($spreadsheet, 'Payroll_Report_' . $dateFrom . '_' . $dateTo . '.xlsx');
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
