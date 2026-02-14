<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class HiringReportController extends Controller
{
    /**
     * Get hiring report data (vacancies, HR & technical interviews) with filters
     */
    public function index(Request $request)
    {
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        $status = $request->get('status', '');
        $type = $request->get('type', 'all'); // all, vacancies, hr_interviews, technical_interviews

        $data = ['vacancies' => [], 'hr_interviews' => [], 'technical_interviews' => []];

        if (in_array($type, ['all', 'vacancies'])) {
            $query = DB::table('job_vacancies as jv')
                ->select('jv.*', 'jt.name as job_title_name', 'tv.name as vacancy_type_name', 'e.name as employer_name')
                ->leftJoin('job_title as jt', 'jv.job_title_id', '=', 'jt.id')
                ->leftJoin('type_vacancies as tv', 'jv.type_vacancy_id', '=', 'tv.id')
                ->leftJoin('employers as e', 'jv.employer_id', '=', 'e.id');
            $this->applyDateStatusFilters($query, 'jv', $dateFrom, $dateTo, $status, 'status');
            $data['vacancies'] = $query->get();
        }

        if (in_array($type, ['all', 'hr_interviews'])) {
            $query = DB::table('competency_interviews as ci')
                ->select('ci.*', 'jt.name as job_title', 'e.name as employer_name')
                ->leftJoin('job_title as jt', 'ci.job_title_id', '=', 'jt.id')
                ->leftJoin('employers as e', 'ci.employer_id', '=', 'e.id');
            $this->applyDateStatusFilters($query, 'ci', $dateFrom, $dateTo, $status, 'overall_rating');
            $data['hr_interviews'] = $query->get();
        }

        if (in_array($type, ['all', 'technical_interviews'])) {
            $query = DB::table('technical_interviews as ti')
                ->select('ti.*', 'jt.name as job_title', 'e.name as employer_name')
                ->leftJoin('job_title as jt', 'ti.job_title_id', '=', 'jt.id')
                ->leftJoin('employers as e', 'ti.employer_id', '=', 'e.id');
            $this->applyDateStatusFilters($query, 'ti', $dateFrom, $dateTo, $status, 'overall_rating');
            $data['technical_interviews'] = $query->get();
        }

        return response()->json($data);
    }

    /**
     * Export hiring report to Excel
     */
    public function export(Request $request): StreamedResponse
    {
        $data = $this->index($request)->getData(true);
        $dateFrom = $request->get('date_from', now()->subMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->format('Y-m-d'));

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Hiring Report');

        $row = 1;
        $sheet->setCellValue('A' . $row, 'Hiring Report');
        $sheet->mergeCells('A1:H1');
        $row += 2;
        $sheet->setCellValue('A' . $row, "Period: {$dateFrom} to {$dateTo}");
        $row += 2;

        if (!empty($data['vacancies'])) {
            $sheet->setCellValue('A' . $row, 'Job Vacancies');
            $row++;
            $headers = ['ID', 'Title', 'Job Title', 'Employer', 'Status', 'Created At'];
            foreach ($headers as $i => $h) {
                $sheet->setCellValueByColumnIndex($i + 1, $row, $h);
            }
            $row++;
            foreach ($data['vacancies'] as $v) {
                $sheet->setCellValueByColumnIndex(1, $row, $v->id ?? '');
                $sheet->setCellValueByColumnIndex(2, $row, $v->title ?? '');
                $sheet->setCellValueByColumnIndex(3, $row, $v->job_title_name ?? '');
                $sheet->setCellValueByColumnIndex(4, $row, $v->employer_name ?? '');
                $sheet->setCellValueByColumnIndex(5, $row, $v->status ?? '');
                $sheet->setCellValueByColumnIndex(6, $row, $v->created_at ?? '');
                $row++;
            }
            $row += 2;
        }

        return $this->streamExcel($spreadsheet, 'Hiring_Report_' . $dateFrom . '_' . $dateTo . '.xlsx');
    }

    private function applyDateStatusFilters($query, $alias, $dateFrom, $dateTo, $status, $statusColumn)
    {
        if ($dateFrom) {
            $query->whereDate("{$alias}.created_at", '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate("{$alias}.created_at", '<=', $dateTo);
        }
        if ($status !== '' && $status !== null) {
            $query->where("{$alias}.{$statusColumn}", $status);
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
