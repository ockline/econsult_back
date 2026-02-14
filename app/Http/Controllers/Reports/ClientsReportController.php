<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ClientsReportController extends Controller
{
    /**
     * Get employer/clients report with filters
     */
    public function index(Request $request)
    {
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        $status = $request->get('status', '');

        $query = DB::table('employers as emp')
            ->select('emp.*');

        if ($dateFrom) {
            $query->whereDate('emp.created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('emp.created_at', '<=', $dateTo);
        }
        if ($status !== '' && $status !== null) {
            $query->where('emp.status', $status);
        }

        $employers = $query->orderBy('emp.created_at', 'desc')->get();

        return response()->json(['employers' => $employers]);
    }

    /**
     * Export clients report to Excel
     */
    public function export(Request $request): StreamedResponse
    {
        $res = $this->index($request);
        $data = $res->getData(true);
        $employers = $data['employers'] ?? [];
        $dateFrom = $request->get('date_from', now()->subMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->format('Y-m-d'));

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Employers / Clients');

        $row = 1;
        $sheet->setCellValue('A' . $row, 'Employer / Clients Report');
        $sheet->mergeCells('A1:G1');
        $row += 2;
        $sheet->setCellValue('A' . $row, "Period: {$dateFrom} to {$dateTo}");
        $row += 2;

        $headers = ['No', 'Name', 'Contact', 'Email', 'VRN', 'Created At'];
        foreach ($headers as $i => $h) {
            $sheet->setCellValueByColumnIndex($i + 1, $row, $h);
        }
        $row++;
        foreach ($employers as $i => $emp) {
            $sheet->setCellValueByColumnIndex(1, $row, $i + 1);
            $sheet->setCellValueByColumnIndex(2, $row, $emp->name ?? '');
            $sheet->setCellValueByColumnIndex(3, $row, $emp->phone_number ?? $emp->telephone ?? '');
            $sheet->setCellValueByColumnIndex(4, $row, $emp->email ?? '');
            $sheet->setCellValueByColumnIndex(5, $row, $emp->vrn ?? '');
            $sheet->setCellValueByColumnIndex(6, $row, $emp->created_at ?? '');
            $row++;
        }

        return $this->streamExcel($spreadsheet, 'Clients_Report_' . $dateFrom . '_' . $dateTo . '.xlsx');
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
