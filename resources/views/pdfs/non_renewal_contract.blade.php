<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #b2000a;
            padding-bottom: 20px;
        }

        .company-logo {
            max-height: 80px;
            margin-bottom: 10px;
        }

        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #b2000a;
            margin: 10px 0;
        }

        .company-details {
            font-size: 11px;
            color: #666;
        }

        .document-title {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin: 30px 0;
            text-decoration: underline;
            color: #b2000a;
        }

        .content {
            margin: 20px 0;
            text-align: justify;
        }

        .notice-box {
            background-color: #fff3cd;
            border: 2px solid #ffc107;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }

        .employee-details {
            background-color: #f8f9fa;
            padding: 15px;
            border-left: 4px solid #b2000a;
            margin: 20px 0;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .details-table th,
        .details-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .details-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .signature-section {
            margin-top: 50px;
            display: table;
            width: 100%;
        }

        .signature-box {
            display: table-cell;
            width: 45%;
            text-align: center;
            vertical-align: top;
        }

        .signature-line {
            border-top: 1px solid #333;
            margin-top: 60px;
            padding-top: 5px;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }

        .date-generated {
            text-align: right;
            font-size: 10px;
            color: #666;
            margin-bottom: 20px;
        }

        .important-notice {
            background-color: #f8d7da;
            border: 2px solid #dc3545;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="date-generated">
        Generated on: {{ $generated_at }}
    </div>

    <div class="header">
        @if(file_exists(public_path('images/logo.png')))
            <img src="{{ public_path('images/logo.png') }}" alt="Company Logo" class="company-logo">
        @endif
        <div class="company-name">{{ config('app.company_name', 'Your Company Name') }}</div>
        <div class="company-details">
            {{ config('app.company_address', 'Company Address') }}<br>
            Phone: {{ config('app.company_phone', 'Company Phone') }} |
            Email: {{ config('app.company_email', 'company@email.com') }}
        </div>
    </div>

    <div class="document-title">NOTICE OF NON-RENEWAL OF CONTRACT</div>

    <div class="content">
        <p><strong>Date:</strong> {{ now()->format('d/m/Y') }}</p>

        <div class="employee-details">
            <h3 style="margin-top: 0; color: #b2000a;">Employee Information</h3>
            <table class="details-table">
                <tr>
                    <th>Employee Name</th>
                    <td>{{ $endContract->employee_name }}</td>
                </tr>
                <tr>
                    <th>Department</th>
                    <td>{{ $endContract->job_department ?? $endContract->department_name }}</td>
                </tr>
                <tr>
                    <th>Job Title</th>
                    <td>{{ $endContract->job_title }}</td>
                </tr>
                <tr>
                    <th>Current Contract Date</th>
                    <td>{{ $endContract->contract_date ? $endContract->contract_date->format('d/m/Y') : 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Contract Expiry Date</th>
                    <td>{{ $endContract->expire_date ? $endContract->expire_date->format('d/m/Y') : $endContract->end_date->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <th>Employment End Date</th>
                    <td>{{ $endContract->end_date->format('d/m/Y') }}</td>
                </tr>
            </table>
        </div>

        <div class="notice-box">
            <h3 style="margin-top: 0; color: #856404;">OFFICIAL NOTICE</h3>
            <p><strong>Dear {{ $endContract->employee_name }},</strong></p>

            <p>This letter serves as formal notification that your employment contract with
            <strong>{{ $endContract->employer_name ?? config('app.company_name', 'Our Company') }}</strong>
            will <strong>NOT BE RENEWED</strong> upon its expiration.</p>
        </div>

        <p>Your current contract, which commenced on
        {{ $endContract->contract_date ? $endContract->contract_date->format('d F Y') : 'the original start date' }},
        is scheduled to expire on {{ $endContract->expire_date ? $endContract->expire_date->format('d F Y') : $endContract->end_date->format('d F Y') }}.</p>

        <p>As per the terms and conditions of your employment contract, we are providing you with this notice
        <strong>at least 28 days</strong> before the contract expiration date, in accordance with company policy
        and employment regulations.</p>

        @if($endContract->remark)
        <p><strong>Reason for Non-Renewal:</strong></p>
        <div style="background-color: #f8f9fa; padding: 15px; border-left: 4px solid #b2000a; margin: 15px 0;">
            {{ $endContract->remark }}
        </div>
        @endif

        <div class="important-notice">
            <h4 style="margin-top: 0;">IMPORTANT INFORMATION</h4>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li>Your last working day will be: <strong>{{ $endContract->end_date->format('d F Y') }}</strong></li>
                <li>Please ensure all company property is returned before your last working day</li>
                <li>Final settlement will be processed according to company policy</li>
                <li>Any outstanding leave days will be calculated and included in your final settlement</li>
                <li>Please coordinate with HR for the handover process</li>
            </ul>
        </div>

        <p>We acknowledge your contributions during your tenure with us and wish you success in your future endeavors.</p>

        <p>If you have any questions regarding this notice or the transition process, please contact the Human Resources department.</p>
    </div>

    <div class="signature-section">
        <div class="signature-box">
            <div style="margin-bottom: 20px;">
                @if($endContract->signature_file)
                    <img src="{{ public_path('storage/endcontracts/signatures/' . $endContract->signature_file) }}"
                         alt="HR Signature" style="max-height: 50px;">
                @endif
            </div>
            <div class="signature-line">
                <strong>{{ $endContract->hr_name ?? 'HR Manager' }}</strong><br>
                {{ $endContract->designation ?? 'Human Resources Manager' }}<br>
                On behalf of: {{ $endContract->on_behalf_of ?? config('app.company_name', 'Company') }}<br>
                Date: {{ now()->format('d/m/Y') }}
            </div>
        </div>

        <div style="display: table-cell; width: 10%;"></div>

        <div class="signature-box">
            <div style="margin-bottom: 20px;">
                @if($endContract->employee_signature_file)
                    <img src="{{ public_path('storage/endcontracts/employee_signatures/' . $endContract->employee_signature_file) }}"
                         alt="Employee Signature" style="max-height: 50px;">
                @endif
            </div>
            <div class="signature-line">
                <strong>{{ $endContract->employee_name }}</strong><br>
                {{ $endContract->employee_designation ?? 'Employee' }}<br>
                <em>Acknowledgment of Receipt</em><br>
                Date: _______________
            </div>
        </div>
    </div>

    <div class="footer">
        <p><strong>Legal Notice:</strong> This notice is issued in accordance with employment regulations.
        Should the employee refuse to acknowledge receipt of this notice, a witness must attest to the fact
        that the notice was properly issued and explained to the employee.</p>

        <p style="margin-top: 20px;">
            <em>This is a computer-generated document. Please retain this copy for your records.</em>
        </p>
    </div>
</body>
</html>
