<?php

namespace App\Services;

use App\Models\Exits\EndContract;
use Mpdf\Mpdf;
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

            $mpdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4',
                'orientation' => 'P',
                'margin_left' => 15,
                'margin_right' => 15,
                'margin_top' => 16,
                'margin_bottom' => 16,
            ]);
            $mpdf->SetTitle('End of Employment Contract');
            $mpdf->WriteHTML($html);

            $fileName = 'employment_contract_' . $endContract->employee_name . '_' . time() . '.pdf';
            $filePath = 'public/contracts/employment/' . $fileName;

            Storage::put($filePath, $mpdf->Output('', 'S'));

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

            $mpdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4',
                'orientation' => 'P',
                'margin_left' => 15,
                'margin_right' => 15,
                'margin_top' => 16,
                'margin_bottom' => 16,
            ]);
            $mpdf->SetTitle('Non-Renewal Contract Notice');
            $mpdf->WriteHTML($html);

            $fileName = 'non_renewal_contract_' . $endContract->employee_name . '_' . time() . '.pdf';
            $filePath = 'public/contracts/non_renewal/' . $fileName;

            Storage::put($filePath, $mpdf->Output('', 'S'));

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

            $mpdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4',
                'orientation' => 'P',
                'margin_left' => 15,
                'margin_right' => 15,
                'margin_top' => 16,
                'margin_bottom' => 16,
            ]);
            $mpdf->SetTitle('Certificate of Service');
            $mpdf->WriteHTML($html);

            $fileName = 'certificate_of_service_' . $endContract->employee_name . '_' . time() . '.pdf';
            $filePath = 'public/contracts/certificates/' . $fileName;

            Storage::put($filePath, $mpdf->Output('', 'S'));

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
     * Generate End Specific Contract PDF
     */
    public function generateEndSpecificContractPdf(array $contractData)
    {
        try {
            $data = [
                'contractData' => $contractData,
                'title' => $contractData['letter_title'] ?? 'End of Specific Task Contract',
                'generated_at' => now()->format('d/m/Y H:i:s')
            ];

            // Use a view template for end specific contract
            // If the view doesn't exist, we'll create a simple HTML structure
            $viewName = 'pdfs.end_specific_contract';
            
            if (!View::exists($viewName)) {
                // Generate HTML directly if view doesn't exist
                $html = $this->generateEndSpecificContractHtml($contractData);
            } else {
                $html = View::make($viewName, $data)->render();
            }

            $mpdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4',
                'orientation' => 'P',
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 10,
                'margin_bottom' => 10,
                'margin_header' => 0,
                'margin_footer' => 0,
            ]);
            $mpdf->SetTitle($contractData['letter_title'] ?? 'End of Specific Task Contract');
            $mpdf->WriteHTML($html);

            return $mpdf->Output('', 'S');
        } catch (\Exception $e) {
            \Log::error('Failed to generate end specific contract PDF', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Generate HTML for End Specific Contract PDF
     */
    private function generateEndSpecificContractHtml(array $contractData)
    {
        $startedDate = $contractData['started_date'] ? \Carbon\Carbon::parse($contractData['started_date'])->format('dS F Y') : 'N/A';
        $endDate = $contractData['end_date'] ? \Carbon\Carbon::parse($contractData['end_date'])->format('dS F Y') : 'N/A';
        $signedDate = $contractData['signed_date'] ? \Carbon\Carbon::parse($contractData['signed_date'])->format('dS F Y') : 'N/A';
        
        // Format dates for document reference
        $docDate = $contractData['signed_date'] ? \Carbon\Carbon::parse($contractData['signed_date'])->format('dS F Y') : date('dS F Y');
        $docRef = 'SJVACEE/HR/' . strtoupper(date('F', strtotime($contractData['signed_date'] ?? 'now'))) . '/' . date('Y', strtotime($contractData['signed_date'] ?? 'now')) . '-R' . ($contractData['id'] ?? rand(1, 100));
        
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>End of Specific Task Contract</title>
            <style>
                * { margin: 0; padding: 0; box-sizing: border-box; }
                body { 
                    font-family: Arial, sans-serif; 
                    font-size: 11px;
                    line-height: 1.4;
                    padding: 10mm 15mm;
                }
                .header { 
                    display: flex;
                    justify-content: space-between;
                    margin-bottom: 8mm;
                    font-size: 10px;
                }
                .header-left {
                    text-align: left;
                }
                .header-right {
                    text-align: right;
                }
                .confidential { 
                    text-align: center; 
                    font-weight: bold; 
                    margin: 5mm 0;
                    font-size: 12px;
                }
                .content { 
                    margin: 5mm 0;
                    font-size: 11px;
                }
                .content p {
                    margin: 3mm 0;
                }
                .content ul {
                    margin: 3mm 0 3mm 20px;
                }
                .content li {
                    margin: 2mm 0;
                }
                .signature-section { 
                    margin-top: 8mm;
                    font-size: 11px;
                }
                .signature-line { 
                    border-top: 1px solid #000; 
                    width: 250px; 
                    margin-top: 15mm;
                    margin-bottom: 2mm;
                }
                .signature-info {
                    margin-top: 2mm;
                }
                .acknowledgement {
                    margin-top: 10mm;
                    font-size: 10px;
                }
                .acknowledgement p {
                    margin: 2mm 0;
                }
                .underline {
                    border-bottom: 1px solid #000;
                    display: inline-block;
                    min-width: 200px;
                    height: 12px;
                }
            </style>
        </head>
        <body>
            <div class="header">
                <div class="header-left">
                    <p><strong>' . $docRef . '</strong></p>
                </div>
                <div class="header-right">
                    <p>' . $docDate . '</p>
                </div>
            </div>
            
            <div class="confidential">
                <p>PRIVATE AND CONFIDENTIAL</p>
            </div>
            
            <div class="content">
                <p>Dear,</p>
                <p><strong>' . ($contractData['employee_name'] ?? 'Employee Name') . '</strong></p>
                <p><strong>' . ($contractData['employee_designation'] ?? 'Designation') . '</strong></p>
                <p>ID No: ' . ($contractData['employee_id'] ?? 'N/A') . '</p>
                
                <p style="margin-top: 5mm;"><strong><u>REF: END OF SPECIFIC TASK CONTRACT</u></strong></p>
                <p>The above heading refers.</p>
                
                <p style="margin-top: 4mm;">This is to inform you that the specific task contract signed by you on ' . $startedDate . ' for the period of one year of service will end on ' . $endDate . '. The contract will not be renewed.</p>
                
                <p style="margin-top: 4mm;">Subject to tax deductions, you will receive the following benefits:</p>
                <ul style="margin-top: 2mm;">
                    <li>Days worked (for the month up to ' . $endDate . ').</li>
                    <li>Leave balance from the day you started work (' . $startedDate . ').</li>
                    <li>Certificate of service.</li>
                    <li>Transport to the area of recruitment.</li>
                </ul>
                
                <p style="margin-top: 4mm;">Thank you for your Contribution to the organization and we wish you all the best for the future.</p>
            </div>
            
            <div class="signature-section">
                <p>For and on behalf of (' . ($contractData['employer_name'] ?? 'Employer') . ')</p>
                <div class="signature-line"></div>
                <div class="signature-info">
                    <p><strong>' . ($contractData['hr_name'] ?? 'HR Manager') . '</strong></p>
                    <p>' . ($contractData['designation'] ?? 'HR Manager') . '</p>
                    <p>' . $signedDate . '</p>
                </div>
            </div>
            
            <div class="acknowledgement">
                <p>Served upon me;</p>
                <p>Name: <span class="underline"></span></p>
                <p>Signature: <span class="underline"></span></p>
                <p>Date: <span class="underline"></span></p>
            </div>
        </body>
        </html>';

        return $html;
    }

    /**
     * Generate Mutual Agreement PDF in Swahili format
     */
    public function generateMutualAgreementPdf(array $contractData)
    {
        try {
            $html = $this->generateMutualAgreementHtml($contractData);

            $mpdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4',
                'orientation' => 'P',
                'margin_left' => 20,
                'margin_right' => 20,
                'margin_top' => 15,
                'margin_bottom' => 15,
                'margin_header' => 0,
                'margin_footer' => 0,
            ]);
            $mpdf->SetTitle('Makubaliano ya Hiari Kusitisha Mkataba wa Ajira');
            $mpdf->WriteHTML($html);

            return $mpdf->Output('', 'S');
        } catch (\Exception $e) {
            \Log::error('Failed to generate mutual agreement PDF', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Generate HTML for Mutual Agreement PDF in Swahili
     */
    private function generateMutualAgreementHtml(array $contractData)
    {
        $employeeName = $contractData['employee_name'] ?? 'N/A';
        $employerName = $contractData['employer_name'] ?? 'JV-AC-EE';
        $location = 'Rufiji, Pwani'; // Default location, can be made configurable
        
        // Get month name in Swahili
        $monthNames = [
            1 => 'JANUARI', 2 => 'FEBRUARI', 3 => 'MACHI', 4 => 'APRILI',
            5 => 'MEI', 6 => 'JUNI', 7 => 'JULAI', 8 => 'AGOSTI',
            9 => 'SEPTEMBA', 10 => 'OKTOBA', 11 => 'NOVEMBA', 12 => 'DESEMBA'
        ];
        
        // Format agreement date
        $agreementDate = $contractData['signed_date'] 
            ? \Carbon\Carbon::parse($contractData['signed_date'])
            : now();
        $agreementMonth = $monthNames[$agreementDate->month];
        $agreementDay = $agreementDate->day;
        $agreementYear = $agreementDate->year;
        
        // Format contract start date
        $contractStartDate = $contractData['started_date'] 
            ? \Carbon\Carbon::parse($contractData['started_date'])
            : null;
        $contractStartFormatted = $contractStartDate 
            ? $contractStartDate->day . ' ' . $monthNames[$contractStartDate->month] . ' ' . $contractStartDate->year
            : 'N/A';

        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Makubaliano ya Hiari Kusitisha Mkataba wa Ajira</title>
            <style>
                * { margin: 0; padding: 0; box-sizing: border-box; }
                body { 
                    font-family: "Times New Roman", Times, serif; 
                    font-size: 12px;
                    line-height: 1.4;
                    padding: 0;
                }
                .page-break {
                    page-break-before: always;
                }
                .title {
                    text-align: center;
                    font-weight: bold;
                    font-size: 14px;
                    margin-bottom: 5mm;
                    text-decoration: underline;
                    font-family: "Times New Roman", Times, serif;
                }
                .intro {
                    margin-bottom: 3mm;
                    text-align: justify;
                }
                .intro p {
                    margin: 1.5mm 0;
                }
                .section-title {
                    font-weight: bold;
                    margin: 3mm 0 2mm 0;
                    font-size: 12px;
                }
                .clause {
                    margin: 1.5mm 0;
                    text-align: justify;
                }
                .clause p {
                    margin: 0.5mm 0;
                }
                .clause-number {
                    font-weight: bold;
                }
                .sub-clause {
                    margin-left: 5mm;
                    margin-top: 0.5mm;
                }
                .sub-clause p {
                    margin: 0.5mm 0;
                }
                .signature-section {
                    margin-top: 3mm;
                }
                .signature-block {
                    margin: 4mm 0;
                }
                .signature-line {
                    border-top: 1px solid #000;
                    width: 200px;
                    margin-top: 8mm;
                }
                .witness-section {
                    margin-top: 2mm;
                    font-size: 12px;
                }
                .witness-field {
                    margin: 0.5mm 0;
                }
                .witness-field p {
                    margin: 0;
                }
                .sealing {
                    margin-top: 2mm;
                    font-size: 12px;
                }
                .sealing p {
                    margin: 0.5mm 0;
                }
                .bracket {
                    font-size: 20px;
                    line-height: 0.5;
                }
            </style>
        </head>
        <body>
            <div class="title">
                MAKUBALIANO YA HIARI KUSITISHA MKATABA WA AJIRA
            </div>
            
            <div class="intro">
                <p>Makubaliano haya yameingia leo, <strong>' . $agreementDay . ' Mwezi ' . $agreementMonth . ' ' . $agreementYear . '</strong></p>
                <p><strong>KATI YA (BETWEEN):</strong> <strong>' . $employerName . '</strong> ("Mwajiri" - Employer)</p>
                <p><strong>NA (AND):</strong> <strong>' . $employeeName . '</strong> ("Mwajiriwa" - Employee)</p>
            </div>
            
            <div class="section-title">KWAMBA:</div>
            
            <div class="clause">
                <p><strong>(A)</strong> Wahusika wote wameingia katika uhusiano wa ajira kupitia mkataba wa ajira uliofanywa tarehe <strong>' . $contractStartFormatted . '</strong>.</p>
            </div>
            
            <div class="clause">
                <p><strong>(B)</strong> Wahusika wote wamekubaliana kwa hiari kusitisha mkataba wa ajira na majukumu na haki zao kama zilivyobainishwa hapa chini.</p>
            </div>
            
            <div class="clause">
                <p><strong>(C)</strong> Kwamba Mtaalamu Mkuu wa Rasilimali za Watu kutoka kwa Mteja Mkuu, akiwa amesaidiziwa na mwajiriwa, amesoma na kuelewa kikamilifu makubaliano haya, na kwamba wameingia kwa hiari yao wenyewe, wakiwa wamejua kikamilifu maudhui na matokeo ya kisheria ya makubaliano haya.</p>
            </div>
            
            <div class="section-title">KWAMBA INAKUBALIWA Kama ifuatavyo:</div>
            
            <div class="clause">
                <p><span class="clause-number">1.</span> Makubaliano haya yameingia na kukamilika na wahusika wote kama ilivyoelezwa hapa.</p>
            </div>
            
            <div class="clause">
                <p><span class="clause-number">2.</span> Wahusika wote wamekubaliana kwa hiari kusitisha mkataba wa ajira ulioelezwa hapo juu kama ilivyobainishwa katika Kanuni ya 4(1) ya Sheria ya Ajira na Uhusiano wa Wafanyakazi (Kanuni ya Mazoezi Bora) ya 2007.</p>
            </div>
            
            <div class="clause">
                <p><span class="clause-number">3.</span> Wahusika wote wanakubaliana kwamba makubaliano haya hayatakufuatiwa na pingamizi lolote kutoka kwa mhusika yeyote, na hati hii itasababisha kusitishwa kwa makubaliano yoyote yaliyoingia chini ya mkataba wa ajira na madai yoyote chini ya mkataba wa ajira kana kwamba hayakuwa yameingia.</p>
            </div>
            
            <div class="clause">
                <p><span class="clause-number">4.</span> Mwajiriwa amekubaliana kwa hiari kuingia katika makubaliano haya na kusitisha mkataba wake wa ajira.</p>
            </div>
            
            <div class="clause">
                <p><span class="clause-number">5.</span> Kutokana na makubaliano haya, mwajiri amekubaliana kwa hiari kulipa mwajiriwa haki zifuatazo kama malipo ya mwisho na ya haki kulingana na makubaliano haya na kusitisha mkataba wa ajira kwa lengo la kusitisha makubaliano yote ya awali, yaliyopo na yanayoweza, yanayotokana na mkataba wa ajira:</p>
                <div class="sub-clause">
                    <p><strong>a. Malipo badala ya Notisi;</strong></p>
                    <p><strong>b. Mshahara wa siku alizofanyia kazi mpaka tarehe ya makubaliano haya;</strong></p>
                    <p><strong>c. Likizo (siku) ambazo hakuchukua hadi kufikia tarehe ya makubaliano haya;</strong></p>
                    <p><strong>d. Malipo ya kiinua mgongo;</strong></p>
                    <p><strong>e. Cheti cha utumishi; na</strong></p>
                    <p><strong>f. Usafiri mpaka mahali ulipoajiriwa</strong></p>
                </div>
            </div>
            
            <div class="clause">
                <p><span class="clause-number">6.</span> Malipo yatakayofanywa baada ya makubaliano haya kukamilika au ndani ya siku saba, yatawekwa kwenye akaunti ya benki ya mshahara ya mwajiriwa.</p>
            </div>
            
            <div class="clause">
                <p><span class="clause-number">7.</span> Mwajiriwa amekubaliana kwa hiari kusitisha mkataba wake wa ajira na kampuni, bila kulazimishwa au kushinikizwa na mwajiri.</p>
            </div>
            
            <div class="clause">
                <p><span class="clause-number">8.</span> Makubaliano haya yanatumika kama ushuhuda wa mwisho wa kusitishwa kwa mkataba wa ajira na <strong>' . $employeeName . '</strong> na kutatua madai yoyote yaliyopo kati ya mwajiri na mwajiriwa yanayohusiana na mkataba. Pia inasema kwamba makubaliano haya yanachukuliwa kuwa halali na wahusika wote na yatasainiwa kwa makubaliano ya pamoja.</p>
            </div>
            
            <div class="clause">
                <p><strong>Aidha,</strong> mwajiriwa anashauriwa kutembelea ofisi za OSHA katika Mkuranga, Morogoro, au Dar Es Salaam kwa ajili ya uchunguzi wa afya baada ya kusitishwa kwa mkataba, ndani ya siku 14 za kupokea barua ya kusitishwa.</p>
            </div>
            
            <div class="page-break"></div>
            
            <div class="signature-section">
                <div class="sealing">
                    <p>Imefungwa na kuwekwa muhuri wa <strong>' . $employerName . '</strong> ' . $location . ' leo, <strong>tarehe ' . $agreementDay . ' Mwezi ' . $agreementMonth . ' ' . $agreementYear . '</strong></p>
                </div>
                
                <div class="signature-block">
                    <div style="display: flex; align-items: flex-start;">
                        <span class="bracket">{</span>
                        <div style="flex: 1; margin-left: 5mm;">
                            <div class="witness-section">
                                <p><strong>Mbele yangu (Shahidi wa mwajiri):</strong></p>
                                <div class="witness-field">
                                    <p>Jina (Name): <strong>' . ($contractData['hr_name'] ?? 'SUSAN WANGWE') . '</strong></p>
                                </div>
                                <div class="witness-field">
                                    <p>Anuani (Address): <strong>' . ($contractData['employer_name'] ?? 'JNHPP') . '</strong></p>
                                </div>
                                <div class="witness-field">
                                    <p>Sahihi (Signature): _________________________</p>
                                </div>
                                <div class="witness-field">
                                    <p>Cheo (Title): <strong>' . ($contractData['designation'] ?? 'ASSISTANT HR MANAGER') . '</strong></p>
                                </div>
                            </div>
                            <div class="signature-line"></div>
                            <p style="margin-top: 2mm;">(MWAJIRI)</p>
                        </div>
                    </div>
                </div>
                
                <div class="signature-block">
                    <div style="display: flex; align-items: flex-start;">
                        <span class="bracket">{</span>
                        <div style="flex: 1; margin-left: 5mm;">
                            <p>Umeasainiwa ' . $location . ' na ndugu <strong>' . $employeeName . '</strong>, <strong>Tarehe ' . $agreementDay . ' ' . $agreementMonth . ' ' . $agreementYear . '</strong></p>
                            <div class="signature-line"></div>
                            <p style="margin-top: 2mm;">(Mwajiriwa)</p>
                        </div>
                    </div>
                </div>
                
                <div class="witness-section">
                    <p><strong>Mbele yangu (Shahidi wa mwajiriwa):</strong></p>
                    <div class="witness-field">
                        <p>Jina (Name): _________________________</p>
                    </div>
                    <div class="witness-field">
                        <p>Anuani (Address): _________________________</p>
                    </div>
                    <div class="witness-field">
                        <p>Sahihi (Signature): _________________________</p>
                    </div>
                    <div class="witness-field">
                        <p>Cheo (Title): _________________________</p>
                    </div>
                </div>
            </div>
        </body>
        </html>';

        return $html;
    }

    /**
     * Generate Retrenchment PDF in Swahili format (Agreement to Terminate Employment for Operational Reasons)
     */
    public function generateRetrenchmentPdf(array $contractData)
    {
        try {
            $html = $this->generateRetrenchmentHtml($contractData);

            $mpdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4',
                'orientation' => 'P',
                'margin_left' => 20,
                'margin_right' => 20,
                'margin_top' => 15,
                'margin_bottom' => 15,
                'margin_header' => 0,
                'margin_footer' => 0,
            ]);
            $mpdf->SetTitle('Makubaliano ya Kusitisha Ajira kwa Sababu za Kiuendeshaji');
            $mpdf->WriteHTML($html);

            return $mpdf->Output('', 'S');
        } catch (\Exception $e) {
            \Log::error('Failed to generate retrenchment PDF', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Generate HTML for Retrenchment PDF in Swahili (MAKUBALIANO YA KUSITISHA AJIRA KWA SABABU ZA KIUENDESHAJI)
     * Matches reference: 3-page layout, centered parties, full KWAMBA recitals, sealing + Mbele yangu on page 2, SHAHIDI + employee + SHAHIDI WA MWAJIRIWA on page 3.
     */
    private function generateRetrenchmentHtml(array $contractData)
    {
        $employeeName = $contractData['employee_name'] ?? 'N/A';
        $employerName = $contractData['employer_name'] ?? 'AC-EE-JOINT VENTURE';
        $location = 'Rufiji, Pwani';
        $locationFull = 'Rufiji Pwani | Tanzania';

        $monthNamesShort = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mac', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
            7 => 'Jul', 8 => 'Ago', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];

        $agreementDate = $contractData['signed_date']
            ? \Carbon\Carbon::parse($contractData['signed_date'])
            : now();
        $agreementDay = $agreementDate->day;
        $agreementMonthShort = $monthNamesShort[$agreementDate->month];
        $agreementYear = $agreementDate->year;
        $signedDateFormatted = sprintf('%02d/%s/%d', $agreementDay, $agreementMonthShort, $agreementYear);

        $contractStartDate = $contractData['started_date']
            ? \Carbon\Carbon::parse($contractData['started_date'])
            : null;
        $contractStartFormatted = $contractStartDate
            ? $contractStartDate->format('d/m/Y')
            : 'N/A';

        $hrName = strtoupper($contractData['hr_name'] ?? 'SUSAN WANGWE');
        $designation = strtoupper($contractData['designation'] ?? 'ASSISTANT HR MANAGER');
        $employerAddress = 'JNHPP, RUFIJI- PWANI';

        $dotLine = '.......................................';

        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Makubaliano ya Kusitisha Ajira kwa Sababu za Kiuendeshaji</title>
            <style>
                * { margin: 0; padding: 0; box-sizing: border-box; }
                body { font-family: "Times New Roman", Times, serif; font-size: 12pt; line-height: 1.4; padding: 0; }
                .page-break { page-break-before: always; }
                .title { text-align: center; font-weight: bold; font-size: 14pt; margin-bottom: 6mm; text-decoration: underline; font-family: "Times New Roman", Times, serif; }
                .intro { margin-bottom: 4mm; text-align: center; }
                .intro p { margin: 2mm 0; }
                .intro .party { font-weight: bold; }
                .section-title { font-weight: bold; margin: 4mm 0 2mm 0; font-size: 12pt; }
                .clause { margin: 2mm 0; text-align: justify; }
                .clause p { margin: 0.5mm 0; }
                .clause-number { font-weight: bold; }
                .sub-clause { margin-left: 5mm; margin-top: 1mm; }
                .sub-clause p { margin: 0.5mm 0; }
                .signature-section { margin-top: 4mm; }
                .signature-block { margin: 4mm 0; }
                .signature-line { border: none; border-bottom: 1px solid #000; margin-top: 2mm; min-width: 180px; }
                .dotted-line { letter-spacing: 2px; color: #333; }
                .witness-section { margin-top: 3mm; font-size: 12pt; }
                .witness-field { margin: 1mm 0; }
                .witness-field p { margin: 0; }
                .sealing { margin-top: 2mm; font-size: 12pt; }
                .sealing p { margin: 0.5mm 0; }
                .bracket { font-size: 22px; line-height: 0.4; vertical-align: top; }
                .employee-signature-row { display: flex; align-items: flex-start; gap: 15mm; margin-top: 4mm; }
            </style>
        </head>
        <body>
            <div class="title">
                MAKUBALIANO YA KUSITISHA AJIRA KWA SABABU ZA KIUENDESHAJI
            </div>

            <div class="intro">
                <p><strong>BAINA YA (BETWEEN):</strong></p>
                <p class="party">' . htmlspecialchars($employerName) . ', ' . $locationFull . ' (Mwajiri)</p>
                <p><strong>NA (AND):</strong></p>
                <p class="party">' . htmlspecialchars($employeeName) . ' (Mwajiriwa)</p>
            </div>

            <div class="section-title">KWAMBA:</div>

            <div class="clause">
                <p>Mkataba wa ajira ulioingia kati ya mwajiri na mwajiriwa tarehe <strong>' . $contractStartFormatted . '</strong>.</p>
            </div>

            <div class="clause">
                <p>Mtaalamu Mkuu wa Rasilimali za Watu amesaidizia kueleza makubaliano haya kwa mwajiriwa na kuhakikisha wahusika wote wanauelewa maudhui na matokeo ya kisheria ya makubaliano haya.</p>
            </div>

            <div class="clause">
                <p>Mwajiri ana nia ya kusitisha baadhi ya mikataba ya ajira kwa <strong>Mahitaji ya Kiuendeshaji</strong> yanayotokana na kupungua kwa kazi katika Mradi wa Umeme wa Maji Julius Nyerere (JNHPP) kutokana na maendeleo ya mradi.</p>
            </div>

            <div class="clause">
                <p>Mchakato wa kusitisha mikataba ulianzia kwa tangazo kwa wafanyakazi wote tarehe <strong>01-09-2023</strong>, uliowekwa katika maeneo yaliyoonekana kama vile mabaraza ya chakula na ubao wa matangazo.</p>
            </div>

            <div class="clause">
                <p>Mikutano ya mashauriano ilifanyika tarehe <strong>04-09-2023</strong> na <strong>06-09-2023</strong> katika eneo la Mradi wa Umeme wa Maji Julius Nyerere (JNHPP), kushirikiana na Uwakilishi wa Uongozi, Chama cha Wafanyakazi (NUMET), na wawakilishi wa wafanyakazi. Mjumbe mwingine ulifanyika tarehe <strong>30-10-2023</strong> kati ya mwakilishi wa Uongozi na wafanyakazi walioteuliwa kusitishwa.</p>
            </div>

            <div class="clause">
                <p>Mikutano ya tarehe <strong>30-10-2023</strong> kwa wafanyakazi wote wanaohusika na wafanyakazi binafsi ilijadili sababu za kupunguzwa, kipindi cha kupunguzwa, mikakati ya kuepuka au kupunguza athari, na haki zilizopendekezwa na wawakilishi wa wafanyakazi na mwajiri alizokubalia.</p>
            </div>

            <div class="section-title">KWAMBA, MAKUBALIANO YALIFANYIKA KAMA IFUATAVYO.</div>

            <div class="clause">
                <p><span class="clause-number">1.</span> Kwamba, pande zote zilijadiliana na kukubaliana katika ajenda kuu 1 (moja) ambayo ni kujadili kusudio la mwajiri la kupunguza wafanyakazi katika mradi wa <strong>JNHPP</strong> kama ilivyotajwa katika tangazo la tarehe 01-09-2023.</p>
            </div>

            <div class="page-break"></div>

            <div class="clause">
                <p><span class="clause-number">2.</span> Kwamba, sababu za kusitisha mkataba wa ajira ni halali na zimekubaliana na pande zote mbili wakati wa mjadala.</p>
            </div>

            <div class="clause">
                <p><span class="clause-number">3.</span> Kwamba, pande zote zimekubaliana kwamba mikataba ya ajira ya baadhi ya wafanyakazi itasitishwa kulingana na vigezo vya utendaji wa kampuni, ikiwa ni pamoja na rekodi za nidhamu na utendaji wa mwajiriwa. Inahusisha wafanyakazi chini ya mradi wa <strong>JNHPP</strong>, mwajiri <strong>JVACEE</strong>.</p>
            </div>

            <div class="clause">
                <p><span class="clause-number">4.</span> Kwamba, mchakato wa kusitisha mkataba wa ajira kwa sababu za kiutendaji (kupungua kazi katika mradi wa JNHPP unaokaribia kukamilika) utafanyika tarehe <strong>' . $signedDateFormatted . '</strong>, baada ya mikutano ya mwajiriwa mmoja mmoja na uwakilishi wa uongozi.</p>
            </div>

            <div class="clause">
                <p><span class="clause-number">5.</span> Kwamba, madarasa yote chini ya JNHPP na JVACEE yataathiriwa na mazoezi haya ya kusitishwa, ikiwa ni pamoja na wale waliojiandikisha kwa hiari.</p>
            </div>

            <div class="clause">
                <p><span class="clause-number">6.</span> Kwamba, mchakato mzima utafuata Sheria ya Ajira na Uhusiano wa Watu Kazi [SURA 366 MAREJEO YA 2019] na Kanuni za Utendaji Bora [T. S. Na. 42/2007], ikiwa ni pamoja na haki zifuatazo zilizojadiliwa na kukubaliwa:</p>
                <div class="sub-clause">
                    <p><strong>i.</strong> Malipo badala ya notisi (sawa na mshahara wa mwezi mmoja);</p>
                    <p><strong>ii.</strong> Malipo ya mshahara kwa siku ulizofanyia kazi mpaka tarehe ya kusitisha ajira;</p>
                    <p><strong>iii.</strong> Malipo ya likizo ya mwaka ambayo haikuchukuliwa;</p>
                    <p><strong>iv.</strong> Malio ya kiinua mgongo;</p>
                    <p><strong>v.</strong> Cheti cha utumishi;</p>
                    <p><strong>vi.</strong> Usafiri mpaka sehemu uliyoajiriwa;</p>
                    <p><strong>vii.</strong> Malipo ya ziada ya nyongeza ya nauli ya usafiri kiasi cha sh 50,000/=TZSHS ya kukufikisha ofisi za OSHA Mkuranga, Morogoro au Dar Es Salaam kwaajili ya vipimo.</p>
                </div>
            </div>

            <div class="clause">
                <p>Malipo yote yaliyoorodheshwa hapo juu yatakatwa kodi kwa mujibu wa sheria.</p>
            </div>

            <div class="clause">
                <p>Mkataba huu umeasainiwa na pande zote mbili leo tarehe <strong>' . $signedDateFormatted . '</strong> kama ulivyooneshwa hapo chini.</p>
            </div>

            <div class="signature-section">
                <div class="sealing">
                    <p>Imewekwa na kufungwa muhuri wa <strong>' . htmlspecialchars($employerName) . '</strong> leo ' . $location . ' <strong>' . $signedDateFormatted . '</strong></p>
                    <p style="margin-left: 2em;">(Muhuri wa Kampuni)</p>
                </div>

                <div class="signature-block">
                    <p><strong>Mbele yangu;</strong></p>
                    <div class="witness-field"><p>Jina: <strong>' . htmlspecialchars($hrName) . '</strong></p></div>
                    <div class="witness-field"><p>Anuani: <strong>' . htmlspecialchars($employerAddress) . '</strong></p></div>
                    <div class="witness-field"><p>Sahihi: <span class="dotted-line">' . $dotLine . '</span></p></div>
                    <div class="witness-field"><p>Cheo: <strong>' . htmlspecialchars($designation) . '</strong></p></div>
                </div>
            </div>

            <div class="page-break"></div>

            <div class="signature-section">
                <div class="signature-block">
                    <p><strong>SHAHIDI:</strong></p>
                    <div class="witness-field"><p>Jina: <span class="dotted-line">' . $dotLine . '</span></p></div>
                    <div class="witness-field"><p>Anuani: <span class="dotted-line">' . $dotLine . '</span></p></div>
                    <div class="witness-field"><p>Sahihi: <span class="dotted-line">' . $dotLine . '</span></p></div>
                    <div class="witness-field"><p>Cheo: <span class="dotted-line">' . $dotLine . '</span></p></div>
                </div>

                <div class="signature-block">
                    <div style="display: flex; align-items: flex-start;">
                        <span class="bracket">{</span>
                        <div style="flex: 1; margin-left: 4mm;">
                            <p>Umeasainiwa ' . $location . ' na ndugu <strong>' . htmlspecialchars($employeeName) . '</strong>,</p>
                            <p><strong>' . $signedDateFormatted . '</strong>.</p>
                        </div>
                        <div style="min-width: 120px;">
                            <div class="signature-line"></div>
                            <p style="margin-top: 2mm; font-size: 11pt;">(Mwajiriwa)</p>
                        </div>
                    </div>
                </div>

                <div class="witness-section" style="margin-top: 8mm;">
                    <p><strong>SHAHIDI WA MWAJIRIWA:</strong></p>
                    <div class="witness-field"><p>Jina: <span class="dotted-line">' . $dotLine . '</span></p></div>
                    <div class="witness-field"><p>Anuani: <span class="dotted-line">' . $dotLine . '</span></p></div>
                    <div class="witness-field"><p>Sahihi: <span class="dotted-line">' . $dotLine . '</span></p></div>
                    <div class="witness-field"><p>Cheo: <span class="dotted-line">' . $dotLine . '</span></p></div>
                </div>
            </div>
        </body>
        </html>';

        return $html;
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
