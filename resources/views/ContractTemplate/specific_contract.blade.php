<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>SPECIFIC TASK CONTRACT</title>
    <style>
        @font-face {
            font-family: 'Calibri Light';
            src: local('Calibri Light'), local('Calibri-Light');
        }

        body {
            font-family: 'Calibri Light', sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        .page {
            border: 4px solid black;
            margin: 40px;
            padding: 40px;
        }

        .section {
            margin-top: 30px;
        }

        .bold {
            font-weight: bold;
        }

        .underline {
            text-decoration: underline;
        }

        .signature {
            margin-top: 60px;
        }

        .contract-table td {
            padding: 6px 12px;
        }

        .info-line {
            border-bottom: 1px dotted black;
            display: inline-block;
            text-align: right;
            padding: 2px 8px;
            min-width: 200px;
        }

        h1 {
            text-transform: uppercase;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin: 15px 0;
        }

        table {
            width: 100%;
        }

        td {
            vertical-align: top;
        }

        .employee {
            line-height: 1.0;
        }

        .section-content {
            margin-left: 20px;
        }

        .subsection {
            margin-left: 40px;
            margin-bottom: 15px;
        }

        .section-number {
            float: left;
            margin-right: 10px;
        }

        .section-title {
            font-weight: bold;
            margin-bottom: 15px;
        }

        .text-justify {
            text-align: justify;
        }
    </style>
</head>

<body>

    <div class="page">

        <div style="text-align: center; margin-bottom: 40px;">
            <h1>MKATABA WA AJIRA</h1>
            <h1>(CONTRACT OF EMPLOYMENT)</h1>
            <h1>WA</h1>
            <h1>(FOR)</h1>
            <h1>KAZI MAALUM</h1>
            <h1>(SPECIFIC TASK)</h1>
        </div>
        <br /><br /><br /><br /><br /><br /><br /><br /><br />

        <table class="employee">
            <tr>
                <td>Jina la Mfanyakazi (Name of Employee):</td>
                <td><span class="info-line"><strong>{{ $data->employee_name }}</strong></span></td>
            </tr>
            <tr>
                <td>Nafasi ya kazi (Position):</td>
                <td><span class="info-line"><strong>{{ $data->job_title }}</span></td>
            </tr>
            <tr>
                <td>Nambari ya Usajili (Registration Number):</td>
                <td><span class="info-line"><strong>{{ $data->reg_number }}</strong></span></td>
            </tr>
            <tr>
                <td>Nambari ya NSSF (NSSF Number):</td>
                <td><span class="info-line"><strong>{{ $data->nssf_number }}</strong></span></td>
            </tr>
            <tr>
                <td>Nambari ya Banki ({{ $data->bank_name }} Account Number):</td>
                <td><span class="info-line"><strong>{{ $data->bank_account_no }}</strong></span></td>
            </tr>
        </table>
        <br /><br /><br /><br /><br />
    </div>

    <br /><br /><br /><br /><br /><br /><br />
    <div class="section">
        <p>This contract is between:</p>
        <p><span class="bold">EMPLOYER:&nbsp;&nbsp;&nbsp;</span> <span class="info-line">{{ $data->employer_name ?? 'JV AC-EE' }}</span></p>
        <p><span class="bold text-center">AND</span> </p>
        <p class="info-line">{{ $data->employee_name ?? '____________________' }} of <span class="info-line">{{ $data->residence_place ?? '________________' }}</span> herein referred to as employee.</p>
    </div>

    <div class="section">
        <p><span class="bold">Date of Birth:</span> <span class="info-line">{{ \Carbon\Carbon::parse($data->dob)->format('d/m/Y') }}</span></p>
        <p><span class="bold">Phone Number:</span> <span class="info-line">{{ $data->phone_number }}</span></p>
        <p><span class="bold">Sex:</span> <span class="info-line">{{ $data->gender }}</span></p>
    </div>
    <div>
        <table>
            <tr>
                <td class="text-center text-black">
                    <h4 class="p-4 text-lg text-black font-bold " style=" lineHeight: 1.0 ">
                        WHEREAS:
                    </h4>
                </td>
                <td>
                    <span class="text-sm text-black font-medium" style=" width: 800px, lineHeight: 1.0 ">
                        The Employer is in the business of construction.
                    </span>
                </td>
            </tr>
            <tr></tr>
            <br />
            <tr>
                <td class="text-center text-black">
                    <h4 class="p-4 text-lg text-black font-bold " style="lineHeight: 1.0">
                        WHEREAS:&nbsp;&nbsp;&nbsp;&nbsp;
                    </h4>
                </td>
                <td>
                    <span class=" text-black font-medium" style="text-align: justify; lineHeight: 1.5">
                        The Employee is expected;. <br />
                        You are employed to undertake Technician work as <label class="text-lg text-black font-bold">{{$data->job_title}}</label> at <label class="text-lg text-black font-bold">{{$data->department}}</label> Department, packaging <label class="text-lg text-black font-bold">{{$data->department}}.</label> You will be handling all <label className="text-lg text-black font-bold">{{$data->job_title}}</label>work at <label className="text-lg text-black font-bold">{{$data->department}}</label> as per instruction from your supervisor.
                    </span>
                </td>
            </tr>
            <br />
            </tbody>
        </table>

    </div>

    <div class="section" style="text-align: justify;">
        <p><span class="bold">1. Start Date:</span><br /> (This Employment contract will start/started on <label class="text-lg text-black font-bold">{{ \Carbon\Carbon::parse($data->start_date)->format('d/m/Y') }}</label> and it will end then when the “Specific Task” reached to an end, whereas the Employment and Labour Relations Act [CAP 366 R.E. 2019] read together with The Employment and Labour Relations Rules [CODE OF GOOD PRACTICE] G.N No. 42/2007 will guide. Your employer will give you a twenty-eight (28) days’ notice that the specific task is about to end and intention to end this contract)
            </span></p>
        <p><span class="bold">2. Place of Recruitment:</span> <span class="info-line">{{ $data->place_recruitment }}</span></p>
        <p><span class="bold">3. Place of Work:</span> <span class="info-line">{{ $data->work_station }}</span></p>
        <p><span class="bold">4. Department:</span> <span class="info-line">{{ $data->department }}</span></p>
        <p><span class="bold">5. Supervisor:</span> <span class="info-line">{{ $data->supervisor }}</span></p>
        <p><span class="bold">Expected End Date:</span> <span class="info-line">{{ \Carbon\Carbon::parse($data->expected_end_date)->format('d/m/Y') }}</span></p>
    </div>

    <div class="section">
        <p class="bold underline">6. Salary and Benefits given by the employer</p>
        <table>
            <tbody>
                <tr>
                    <td><span class="normal">The employees’ monthly salary is</span><span class="info-line">TZS {{ number_format((float) $data->monthly_salary, 2) }} </span></td>
                    <td></td>
                    <td><span>which will include the following: -</span></td>
                </tr>
                <tr>
                    <td><span class="bold">Basic Salary:</span></td>
                    <td></td>
                    <td><span class="info-line">TZS {{ number_format((float) $data->basic_salary, 2) }}</span></td>
                </tr>
                <tr>
                    <td><span class="bold">House Allowance:</span> </td>
                    <td></td>
                    <td><span class="info-line">{{ $data->house_allowance ?? 'Provided by JV' }}</span></td>
                </tr>
                <tr>
                    <td><span class="bold">Meal Allowance:</span></td>
                    <td></td>
                    <td><span class="info-line">{{ $data->meal_allowance ?? 'Provided by JV' }}</span></td>
                </tr>
                <tr>
                    <td><span class="bold">Transport Allowance:</span></td>
                    <td></td>
                    <td><span class="info-line">{{ $data->transport_allowance ?? 'Provided by JV' }}</span></td>
                </tr>
                <tr>
                    <td><span class="bold">Risk/Bush Allowance:</span> </td>
                    <td></td>
                    <td><span class="info-line">TZS {{ number_format((float) $data->risk_bush_allowance, 2) }}</span></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="section text-justify">
        <div class="section-content">

            <div class="section-title"> 7. Working Hours</div>
            <div class="subsection">
                <span>a.</span>
                <span class="text-justify" style="margin-left: 20px;">
                    Working hours shall be from 08:00 AM in the morning until 17:00 PM in the evening (Monday to Friday) and 8:00 AM in the morning until 13:00 PM in the afternoon (Saturday). As an employee who will work the night shift, working hours shall be from 18:00 PM in the evening until 03:00 AM in the morning (Monday to Friday) and 18:00 PM until 00:00 AM midnight (Saturday). Total working hours shall be 45 in a week.
                </span>
            </div>
            <div class="subsection">
                <span>b.</span>
                <span class="text-justify" style="margin-left: 20px;">
                    Any overtime work shall be first agreed and approved by your supervisor.
                </span>
            </div>
            <div class="subsection">
                <span>c.</span>
                <div class="text-justify" style="margin-left: 20px;">
                    The employee may be required to work on Sundays or overtime, and they will be paid their overtime dues in accordance with the Employment and Labour Relations Act of Tanzania and its Regulations.
                </div>
            </div>
        </div>
    </div>

    <div class="section text-justify">
        <div class="section-content">

            <div class="section-title">8. Annual Leave</div>
            <p>Annual Leave is in the 12 months' cycle and other leave's remaining are in 36 months</p>
            @php
            $annualLeavePoints = [
            'The employee shall be entitled to 28 days leave in a row from the 12 months\' cycle and if this specific task shall take more than that time or equal.',
            'Leave days can be deducted if the employee has received leaves or day offs several times.',
            'The employer can decide the start date of the leave for the employee within six months from the day the employee is entitled to start leave.',
            'The leave days\' start date after six months can be moved forward after six months in agreement if there is a need in the project and the leave can be added to start in not more than twelve months.',
            'The employee is not allowed to work during leave days.',
            'It is not allowed to pay the employee instead of leave days (buying leave days only when the employment contract comes to end.',
            'Annual leave will not be taken during other leaves or during the period of notice of ending the employment.',
            'The employer will pay the employee during the annual leave.',
            'The annual leave request shall be lodged by employee intending to take annual leave not less than 7 working days.',
            ];
            @endphp
            @foreach($annualLeavePoints as $index => $point)
            <div class="subsection">
                <div class="text-justify" style="margin-left: 20px;">
                   <span>{{ chr(97 + $index) }}.</span>  {{ $point }}
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="section text-justify">
        <div class="section-content">

            <div class="section-title">9. Sick Leave</div>
            @php
            $sickLeavePoints = [
            'The employee is entitled to sick leave of at least 126 days in accordance with the Employment and Labour Relations Act of Tanzania.',
            'In the first 63 days the employee is entitled to be paid full salary and the following 63 days the employee is entitled to half salary.',
            'Before taking the sick leave, the employee must submit proof to the employer from the Doctor.',
            'The employer shall have the right to submit the medical record submitted by an employee to the doctor of his choice for further review before authorization of the leave days.',
            'Submission of the wrong information regarding to medical certificate shall mount to disciplinary action including termination of the employment without notice.',
            ];
            @endphp
            @foreach($sickLeavePoints as $index => $point)
            <div class="subsection">

                <div class="text-justify" style="margin-left: 20px;">
                    <span>{{ chr(97 + $index) }}.</span> {{ $point }}
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="section text-justify">
        <div class="section-content">

            <div class="section-title">10.Termination of Employment</div>
            <p>Termination of the agreement will come to be due to the following reasons;</p>
            @php
            $terminationPoints = [
            'Termination due to poor performance;',
            'Termination due to Operational Requirements;',
            'Resignation of his employee at his own will be by giving employer a notice of 28 days or payment in lieu of that notice;',
            'Employee termination after receiving a notice from the employer;',
            'The end of the Specific Task;',
            'Termination due to Misconduct, any other reason that will make it impossible for the contract to continue, death and others;',
            'Termination by agreement.',
            ];
            @endphp
            @foreach($terminationPoints as $index => $point)
            <div class="subsection">

                <div class="text-justify" style="margin-left: 20px;">
                    <span>{{ chr(97 + $index) }}.</span>  {{ $point }}
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="section text-justify">
        <div class="section-content">

            <div class="section-title">11. Payment to be paid upon Termination of the Contract</div>
            <div class="text-justify">
                The Employee shall be paid his dues at the end of this contract in accordance with the Employment and Labour Relations Act of Tanzania.
            </div>
        </div>
    </div>

    <div class="section text-justify">
        <div class="section-content">

            <div class="section-title">12. Others or General</div>
            @php
            $othersPoints = [
            'This contract is written in English and Swahili for the benefits of both the employer and employee and when it happens that the translation of the language in this contract is in question, the Swahili language will prevail as the correct language in this agreement.',
            'Upon termination of this contract of specific task, the employer will decide to hire the employee for another specific task or end the employment relationship with the employee at the end of this contract.',
            'This contract of specific task shall end when the supervisor of the department mentioned above shall certify that the task mentioned above is completed.',
            ];
            @endphp
            @foreach($othersPoints as $index => $point)
            <div class="subsection">
                <div class="text-justify" style="margin-left: 20px;">
                   <span>{{ chr(97 + $index) }}.</span>  {{ $point }}
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="section text-justify">
        <div class="section-content">
            <div class="section-title">13.Governing Law and Contract</div>
            <div class="text-justify">
                <p>This Employment Contract will be guided and translated under the laws of the United Republic of Tanzania.</p>
                <p>The Employee has the right or is required to refer to the terms of the contract which is part of this contract. Under the good cause terms and conditions of this contract can change and they must be in writing and signed by both parties (Employer) and (Employee). Unreasonable employee refusal to adjust the terms of the contract shall not bar the effect of the changes and the act shall mount to disciplinary action.</p>
            </div>
        </div>
    </div>

    <div class="section signature">
        <table class="contract-table">
            <tr>
                <td class="bold">Employee:</td>
                <td>___________________________</td>
                <td class="bold">Date:</td>
                <td>__________________</td>
            </tr>
            <tr>
                <td class="bold">Employer:</td>
                <td>___________________________</td>
                <td class="bold">Date:</td>
                <td>__________________</td>
            </tr>
        </table>
    </div>

    <p style="margin-top: 40px; font-style: italic;">
        This contract shall be governed under the laws of the United Republic of Tanzania.
    </p>

</body>

</html>
