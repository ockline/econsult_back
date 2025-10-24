<?php

namespace App\Services;

use App\Models\Exits\EndContract;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class EndContractPdfService
{
    /**
     * Generate Employment Contract PDF
     */
    public function generateEmploymentContract(EndContract $endContract)
    {
        try {
            $data = [
                'endContract' => $endContract,
                'employee' => $endContract->employee,
                'title' => 'End of Employment Contract',
                'generated_at' => now()->format('d/m/Y H:i:s')
            ];

            $html = View::make('pdfs.employment_contract', $data)->render();

            $pdf = Pdf::loadHTML($html)
                ->setPaper('A4', 'portrait')
                ->setOptions([
                    'defaultFont' => 'Arial',
                    'isRemoteEnabled' => true,
                    'isHtml5ParserEnabled' => true,
                    'chroot' => public_path(),
                ]);

            $fileName = 'employment_contract_' . $endContract->employee_name . '_' . time() . '.pdf';
            $filePath = 'public/contracts/employment/' . $fileName;

            Storage::put($filePath, $pdf->output());

            return [
                'success' => true,
                'file_name' => $fileName,
                'file_path' => $filePath,
                'download_url' => Storage::url($filePath)
            ];
        } catch (\Exception $e) {
            \Log::error('Failed to generate employment contract PDF', [
                'end_contract_id' => $endContract->id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Generate Non-Renewal Contract PDF
     */
    public function generateNonRenewalContract(EndContract $endContract)
    {
        try {
            $data = [
                'endContract' => $endContract,
                'employee' => $endContract->employee,
                'title' => 'Non-Renewal Contract Notice',
                'generated_at' => now()->format('d/m/Y H:i:s')
            ];

            $html = View::make('pdfs.non_renewal_contract', $data)->render();

            $pdf = Pdf::loadHTML($html)
                ->setPaper('A4', 'portrait')
                ->setOptions([
                    'defaultFont' => 'Arial',
                    'isRemoteEnabled' => true,
                    'isHtml5ParserEnabled' => true,
                    'chroot' => public_path(),
                ]);

            $fileName = 'non_renewal_contract_' . $endContract->employee_name . '_' . time() . '.pdf';
            $filePath = 'public/contracts/non_renewal/' . $fileName;

            Storage::put($filePath, $pdf->output());

            return [
                'success' => true,
                'file_name' => $fileName,
                'file_path' => $filePath,
                'download_url' => Storage::url($filePath)
            ];
        } catch (\Exception $e) {
            \Log::error('Failed to generate non-renewal contract PDF', [
                'end_contract_id' => $endContract->id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Generate Certificate of Service PDF
     */
    public function generateCertificateOfService(EndContract $endContract)
    {
        try {
            $data = [
                'endContract' => $endContract,
                'employee' => $endContract->employee,
                'title' => 'Certificate of Service',
                'generated_at' => now()->format('d/m/Y H:i:s')
            ];

            $html = View::make('pdfs.certificate_of_service', $data)->render();

            $pdf = Pdf::loadHTML($html)
                ->setPaper('A4', 'portrait')
                ->setOptions([
                    'defaultFont' => 'Arial',
                    'isRemoteEnabled' => true,
                    'isHtml5ParserEnabled' => true,
                    'chroot' => public_path(),
                ]);

            $fileName = 'certificate_of_service_' . $endContract->employee_name . '_' . time() . '.pdf';
            $filePath = 'public/contracts/certificates/' . $fileName;

            Storage::put($filePath, $pdf->output());

            return [
                'success' => true,
                'file_name' => $fileName,
                'file_path' => $filePath,
                'download_url' => Storage::url($filePath)
            ];
        } catch (\Exception $e) {
            \Log::error('Failed to generate certificate of service PDF', [
                'end_contract_id' => $endContract->id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get PDF template data
     */
    private function getPdfTemplateData(EndContract $endContract)
    {
        return [
            'company_name' => config('app.company_name', 'Your Company Name'),
            'company_address' => config('app.company_address', 'Company Address'),
            'company_phone' => config('app.company_phone', 'Company Phone'),
            'company_email' => config('app.company_email', 'company@email.com'),
            'company_logo' => public_path('images/logo.png'),

            'employee_name' => $endContract->employee_name,
            'employee_id' => $endContract->employee_id,
            'department' => $endContract->department_name,
            'job_title' => $endContract->job_title,
            'start_date' => $endContract->started_date ? $endContract->started_date->format('d/m/Y') : 'N/A',
            'end_date' => $endContract->end_date->format('d/m/Y'),
            'days_worked' => $endContract->days_worked ?? 'N/A',
            'reason' => $endContract->remark,

            'hr_name' => $endContract->hr_name,
            'hr_designation' => $endContract->designation,
            'on_behalf_of' => $endContract->on_behalf_of,
            'signed_date' => $endContract->signed_date ? $endContract->signed_date->format('d/m/Y') : now()->format('d/m/Y'),

            'contract_date' => $endContract->contract_date ? $endContract->contract_date->format('d/m/Y') : 'N/A',
            'expire_date' => $endContract->expire_date ? $endContract->expire_date->format('d/m/Y') : 'N/A',
        ];
    }

    /**
     * Clean up old PDF files
     */
    public function cleanupOldFiles($directory = 'public/contracts', $days = 30)
    {
        try {
            $files = Storage::allFiles($directory);
            $cutoffTime = now()->subDays($days);

            foreach ($files as $file) {
                $lastModified = Storage::lastModified($file);
                if ($lastModified < $cutoffTime->timestamp) {
                    Storage::delete($file);
                }
            }

            return true;
        } catch (\Exception $e) {
            \Log::error('Failed to cleanup old PDF files', ['error' => $e->getMessage()]);
            return false;
        }
    }
}
