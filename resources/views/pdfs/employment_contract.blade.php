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

    <div class="document-title">END OF EMPLOYMENT CONTRACT</div>

    <div class="content">
        <p><strong>Date:</strong> {{ $endContract->signed_date ? $endContract->signed_date->format('d/m/Y') : now()->format('d/m/Y') }}</p>

        <div class="employee-details">
            <h3 style="margin-top: 0; color: #b2000a;">Employee Information</h3>
            <table class="details-table">
                <tr>
                    <th>Employee Name</th>
                    <td>{{ $endContract->employee_name }}</td>
                </tr>
                <tr>
                    <th>Department</th>
                    <td>{{ $endContract->department_name }}</td>
                </tr>
                <tr>
                    <th>Job Title</th>
                    <td>{{ $endContract->job_title }}</td>
                </tr>
                <tr>
                    <th>Employment Start Date</th>
                    <td>{{ $endContract->started_date ? $endContract->started_date->format('d/m/Y') : 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Employment End Date</th>
                    <td>{{ $endContract->end_date->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <th>Total Days Worked</th>
                    <td>{{ $endContract->days_worked ?? 'N/A' }} days</td>
                </tr>
            </table>
        </div>

        <p>This is to certify that <strong>{{ $endContract->employee_name }}</strong> was employed with
        <strong>{{ $endContract->employer_name ?? config('app.company_name', 'Our Company') }}</strong>
        from {{ $endContract->started_date ? $endContract->started_date->format('d F Y') : 'the commencement date' }}
        to {{ $endContract->end_date->format('d F Y') }}.</p>

        <p>During the period of employment, {{ $endContract->employee_name }} served in the capacity of
        <strong>{{ $endContract->job_title }}</strong> in the <strong>{{ $endContract->department_name }}</strong> department.</p>

        @if($endContract->remark)
        <p><strong>Reason for End of Contract:</strong></p>
        <div style="background-color: #f8f9fa; padding: 15px; border-left: 4px solid #b2000a; margin: 15px 0;">
            {{ $endContract->remark }}
        </div>
        @endif

        <p>This contract termination is effective as of {{ $endContract->end_date->format('d F Y') }}.
        Both parties have fulfilled their obligations under the employment contract with perfect precision
        as specified by the terms and conditions.</p>

        <p>We wish {{ $endContract->employee_name }} all the best in future endeavors.</p>
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
                Date: {{ $endContract->signed_date ? $endContract->signed_date->format('d/m/Y') : now()->format('d/m/Y') }}
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
                Date: {{ $endContract->signed_date ? $endContract->signed_date->format('d/m/Y') : now()->format('d/m/Y') }}
            </div>
        </div>
    </div>

    <div class="footer">
        <p><strong>Note:</strong> This document serves as official confirmation of the end of employment contract.
        Should the employee refuse to acknowledge this notice, a witness must attest to the fact that
        the notice was properly issued and explained to the employee.</p>

        <p style="margin-top: 20px;">
            <em>This is a computer-generated document and does not require a physical signature when digitally signed.</em>
        </p>
    </div>
</body>
</html>
