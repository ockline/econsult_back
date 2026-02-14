<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class IndustrialsReportController extends Controller
{
    /**
     * Get industrial relations report (misconducts, disciplinaries, performance, grievances) with filters
     */
    public function index(Request $request)
    {
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        $status = $request->get('status', '');
        $type = $request->get('type', 'all');

        $data = ['misconducts' => [], 'disciplinaries' => [], 'performance_reviews' => [], 'grievances' => []];

        if (in_array($type, ['all', 'misconducts'])) {
            $query = DB::table('misconducts as m')
                ->select('m.*', 'e.employee_no', 'e.firstname', 'e.middlename', 'e.lastname', 'mt.name as misconduct_type_name')
                ->leftJoin('employees as e', 'm.employee_id', '=', 'e.employee_no')
                ->leftJoin('misconduct_types as mt', function ($join) {
                    $join->on(
                        DB::raw("CASE
                            WHEN m.misconduct_cause IS NOT NULL AND m.misconduct_cause::text ~ '^\\[.*\\]$'
                            THEN (m.misconduct_cause::jsonb->0)::text::bigint
                            WHEN m.misconduct_cause IS NOT NULL AND m.misconduct_cause::text ~ '^[0-9]+(,[0-9]+)*$'
                            THEN split_part(m.misconduct_cause::text, ',', 1)::bigint
                            ELSE NULL
                        END"),
                        '=',
                        'mt.id'
                    );
                });
            $this->applyFilters($query, 'm', $dateFrom, $dateTo, $status);
            $data['misconducts'] = $query->get();
        }

        if (in_array($type, ['all', 'disciplinaries'])) {
            $query = DB::table('disciplinaries as d')
                ->select('d.*', 'e.employee_no', 'e.firstname', 'e.middlename', 'e.lastname')
                ->leftJoin('employees as e', 'd.employee_id', '=', 'e.employee_no');
            $this->applyFilters($query, 'd', $dateFrom, $dateTo, $status);
            $data['disciplinaries'] = $query->get();
        }

        if (in_array($type, ['all', 'performance_reviews'])) {
            $query = DB::table('performance_new_reviews as pr')
                ->select('pr.*', 'e.employee_no', 'e.firstname', 'e.middlename', 'e.lastname')
                ->leftJoin('employees as e', 'pr.employee_id', '=', 'e.employee_no');
            $this->applyFilters($query, 'pr', $dateFrom, $dateTo, $status);
            $data['performance_reviews'] = $query->get();
        }

        if (in_array($type, ['all', 'grievances'])) {
            $query = DB::table('grievances as g')
                ->select('g.*', 'e.employee_no', 'e.firstname', 'e.middlename', 'e.lastname')
                ->leftJoin('employees as e', 'g.employee_id', '=', 'e.id');
            $this->applyFilters($query, 'g', $dateFrom, $dateTo, $status);
            $data['grievances'] = $query->get();
        }

        return response()->json($data);
    }

    /**
     * Export industrial report to Excel
     */
    public function export(Request $request): StreamedResponse
    {
        $data = $this->index($request)->getData(true);
        $dateFrom = $request->get('date_from', now()->subMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->format('Y-m-d'));

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Industrial Relations');

        $row = 1;
        $sheet->setCellValue('A' . $row, 'Industrial Relations Report');
        $sheet->mergeCells('A1:G1');
        $row += 2;
        $sheet->setCellValue('A' . $row, "Period: {$dateFrom} to {$dateTo}");
        $row += 2;

        $allRows = [];
        foreach ($data['misconducts'] as $m) {
            $allRows[] = ['Misconduct', $m->employee_no ?? '', ($m->firstname ?? '') . ' ' . ($m->lastname ?? ''), $m->misconduct_type_name ?? '', $m->created_at ?? ''];
        }
        foreach ($data['disciplinaries'] as $d) {
            $allRows[] = ['Disciplinary', $d->employee_no ?? '', ($d->firstname ?? '') . ' ' . ($d->lastname ?? ''), $d->status ?? '', $d->created_at ?? ''];
        }
        foreach ($data['performance_reviews'] as $p) {
            $allRows[] = ['Performance', $p->employee_no ?? '', ($p->firstname ?? '') . ' ' . ($p->lastname ?? ''), $p->overall_rating ?? '', $p->created_at ?? ''];
        }
        foreach ($data['grievances'] as $g) {
            $allRows[] = ['Grievance', $g->employee_no ?? '', ($g->firstname ?? '') . ' ' . ($g->lastname ?? ''), $g->status ?? '', $g->created_at ?? ''];
        }

        $headers = ['Type', 'Employee No', 'Employee Name', 'Status/Type', 'Created At'];
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

        return $this->streamExcel($spreadsheet, 'Industrials_Report_' . $dateFrom . '_' . $dateTo . '.xlsx');
    }

    private function applyFilters($query, $alias, $dateFrom, $dateTo, $status)
    {
        if ($dateFrom) $query->whereDate("{$alias}.created_at", '>=', $dateFrom);
        if ($dateTo) $query->whereDate("{$alias}.created_at", '<=', $dateTo);
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
