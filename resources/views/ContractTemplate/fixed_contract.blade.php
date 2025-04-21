<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Fixed Term CONTRACT</title>
    <style>
        @font-face {
            font-family: 'Calibri';
            src: local('Calibri'), local('Calibri');
        }

        body {
            font-family: 'Calibri', sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        .section {
            margin-top: 10px;
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

         .clause {
        display: flex;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

  .section-title {
        text-align: justify;
        text-indent: -2.5em; /* Pull number part to left */
        padding-left: 3em;   /* Push text part to the right */
        margin-bottom: 0.5rem;
    }

    .text-justify {
        text-align: justify;
        text-indent: 2em; /* Optional: first-line indent */
        margin-top: 0;
    }

.justified-heading {
        text-align: justify;
        padding-left: 4em;
        text-indent: -4em;
        margin-bottom: 1rem;
    }

    .justified-continuation {
        text-align: justify;
        padding-left: 4em;
        margin-top: -0.5rem;
        margin-bottom: 1rem;
    }

    </style>
</head>

<body>

    <!-- <div class="page"> -->

    <span style="text-align: center;">
        <h1>FIXED TERM CONTRACT</h1>
        <h1>Employment Contract – Staff Grade</h1>
    </span>
    <label>The present Employment Contract has today been concluded and agreed </label>
    <span>
        <p><span class="bold">BETWEEN:&nbsp;&nbsp;&nbsp;</span> <span class="info-line">{{ $data->employer_name ?? 'JV AC-EE' }}</span>
            <br />
            <lable class="text-center">(Hereinafter referred to as the "Employer")</lable>
        </p>
        <p><span class="bold text-center">AND</span>:
            <span class="info-line">{{ $data->employee_name ?? '____________________' }} personal particulars as set out in Appendix A </span>
            <label class="text-center">(Hereinafter referred to as the "Employee")</label>
        </p>
    </span>

    <div class="section">
        <p><span class="bold">Date of Birth:</span> <span class="info-line">{{ isset($data->dob) ? \Carbon\Carbon::parse($data->dob)->format('d/m/Y') : '___/___/____' }}</span></p>
        <p><span class="bold">Phone Number:</span> <span class="info-line">{{ $data->phone_number ?? '________________' }}</span></p>

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
                        The Employer desires to engage the services of the Employee AND the Employee is ready and willing to accept the engagement;
                    </span>
                </td>
            </tr>


        </table>

    </div>
    <h3><strong>NOW THEREFORE THE EMPLOYER AND EMPLOYEE HAVE AGREED AS FOLLOWS:</strong></h3>

    <ol>
        <li><strong>EMPLOYMENT & RECRUITMENT PARTICULARS</strong></li>
    </ol>

    <table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse;">
        <tr>
            <td><strong>Job Title</strong></td>
            <td>{{ $data->job_title ?? 'Biodiversity Specialist' }}</td>
        </tr>
        <tr>
            <td><strong>Job Profile</strong></td>
            <td>A job profile is attached in Appendix B. Note that the job profile may be updated from time to time</td>
        </tr>
        <tr>
            <td><strong>Reporting to</strong></td>
            <td>{{ $data->reporting_to ?? 'JV Manager' }}</td>
        </tr>
        <tr>
            <td><strong>Staff Classification</strong></td>
            <td>{{ $data->staff_classification ?? 'Staff' }}</td>
        </tr>
        <tr>
            <td><strong>Type of Contract</strong></td>
            <td>{{ $data->contract_type ?? 'Time base - One Year Contract' }}</td>
        </tr>
        <tr>
            <td><strong>Place of Work</strong></td>
            <td>{{ $data->place_of_work ?? 'Julius Nyerere Hydro Electric Power Project Offices in Rufiji - Pwani and Dar Es Salaam' }}</td>
        </tr>
        <tr>
            <td><strong>Place of Recruitment</strong></td>
            <td>{{ $data->place_of_recruitment ?? 'Dar Es Salaam' }}</td>
        </tr>
    </table>

  <!-- Section 2 -->
<p class="justified-heading"><strong>2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;COMMENCEMENT AND DURATION</strong></p>
<p class="justified-continuation">
    This employment shall commence on <strong>{{ \Carbon\Carbon::parse($data->commencement_date)->format('jS F Y') }}</strong>
    and shall expire without notice on <strong>{{ \Carbon\Carbon::parse($data->end_commencement_date)->format('jS F Y') }}</strong>
    unless extended by mutual agreement before expiry.
</p>

<!-- Section 3 -->
<p class="justified-heading"><strong>3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PROBATION PERIOD</strong></p>
<p class="justified-continuation">
    Employee will undergo a six-month probationary period during which either party may terminate the employment contract by giving one month's written notice.
</p>

<!-- Section 4 -->
<p class="justified-heading"><strong>4.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;REMUNERATION</strong></p>
<p class="justified-continuation">
    The agreed gross monthly remuneration before tax and statutory deductions is
    <strong>TZS {{ isset($data->remuneration) ? number_format((float) $data->remuneration, 2) : '_________' }}</strong>
    payable on the last day of the month and made up as follows:
</p>

<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse;">
            <tr>
                <td><strong>Basic Salary:</strong></td>
                <td>TZS {{ isset($data->basic_salary) ? number_format((float) $data->basic_salary, 2) : '_________' }}</td>
            </tr>
            <tr>
                <td><strong>Housing Allowance:</strong></td>
                <td>{{ $data->house_allowance ?? 'JV to Provide' }}</td>
            </tr>
            <tr>
                <td><strong>Meal Allowance:</strong></td>
                <td>{{ $data->meal_allowance ?? 'JV to Provide' }}</td>
            </tr>
            <tr>
                <td><strong>Transport Allowance:</strong></td>
                <td>{{ $data->transport_allowance ?? 'JV to Provide' }}</td>
            </tr>
            <tr>
                <td><strong>Risk/Bush Allowance:</strong></td>
                <td>TZS {{ isset($data->risk_bush_allowance) ? number_format((float) $data->risk_bush_allowance, 2) : '_________' }}</td>
            </tr>
        </table>
<br/>

<p class="justified-continuation">
    The Employee agrees to all statutory deductions from the salary and is aware that contribution
    towards the Employee’s National Social Security Fund (<strong>NSSF</strong>) will be equally
    shared between the Employee and the Employer at a rate of 20% of the gross salary.
</p>

        <!-- Section 5: Working Hours -->
<p class="justified-heading">
    <strong>5.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;WORKING HOURS</strong><br>
    Normal working hours per week are 45 as stipulated in the Employment and Labour Relations Act 2004.
    The Employer's ordinary working week is Monday to Friday from 08:00 hrs to 17:00 hrs and on Saturday
    from 08:00 hrs to 13:00 hrs which includes a one-hour unpaid lunch break. Where a full hour’s lunch break is taken,
    the Employer may opt to perform the balance of ½ hour before or after official working hours.
</p>

<p class="justified-continuation">
    The nature of the work and responsibilities entrusted to the Employee may from time to time
    require overtime to meet deadlines or to speed up the project operation. In view of your
    position, which falls in a supervisory role, Overtime will be paid to cover extra hours worked
    as per Tanzania Labour Law.
</p>



<p class="justified-heading"><strong>6.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ANNUAL LEAVE</strong></p>
<p class="justified-continuation">
    The Employee is entitled to 28 calendar days paid leave for each year of completed service. The timing and length of the leave periods shall be in accordance with the job requirements and as agreed with the Project Management. Application of the annual leave shall be lodged not less than 7 working days.
</p>

<!-- SECTION 7 -->
<p class="justified-heading">7.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BENEFITS</p>
<p class="justified-continuation">
    The Employee is covered by statutory workmen's compensation – WCF.
</p>

<!-- SECTION 8 -->
<p class="justified-heading"><strong>8.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ETHICS</strong></p>
<p class="justified-continuation">
    The Employee is to devote all his working time to the service of the company. Without written consent of the Project Manager, employee may not engage in any outside duties including salaried or contracted work that could in any way be inconsistent with his employment with the company.
</p>

<!-- SECTION 9 -->
<p class="justified-heading"><strong>9.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CONFIDENTIALITY</strong></p>
<p class="justified-continuation">9.1 The Employee agrees to maintain full confidentiality during his employment and after the termination thereof...</p>
<p class="justified-continuation">9.2 The duty of confidentiality shall apply to all material, including but not limited to...</p>
<p class="justified-continuation">9.3 Any breach of the duty of confidentiality shall be deemed a material breach...</p>

<!-- SECTION 10 -->
<p class="justified-heading"><strong>10.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TERMINATION OF EMPLOYMENT</strong></p>
<p class="justified-continuation">	Upon completion of probationary period, either party may terminate the employment by giving one calendar months' notice in writing.</p>
<p class="justified-continuation">However, the Employer may terminate the Employee without notice for cause. For the purpose of this contract, "cause" shall mean:</p>
<p class="justified-continuation">a) Gross misconduct or repeated breaches after a written warning;</p>
<p class="justified-continuation">b) Unauthorized disclosure of confidential company information;</p>
<p class="justified-continuation">c) Refusal to carry out lawful instructions from a superior;</p>
<p class="justified-continuation">d) Un-notified absence from duties;</p>
<p class="justified-continuation">e) False statements or forged documents relating to health or qualifications.</p>

<!-- SECTION 11 -->
<p class="justified-heading"><strong>11.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;APPLICATION OF THE LAW</strong></p>
<p class="justified-continuation">
    This Agreement shall be interpreted and applied in accordance with the prevailing Laws of the United Republic of Tanzania. Where any conflict arises between this Agreement and the Laws, the provisions of the Laws shall apply as if they are terms of this Agreement.
</p>
<p class="justified-continuation">
    The Employee is required to refer to the condition of his/her employment contract and/or prevailing management notices for issues not specifically addressed in the contract.
</p>
<p class="justified-continuation">
    The employee shall be entitled to any other benefits stipulated by the Laws even if not stated in this Agreement or as agreed between the parties.
</p>

  <p class="justified-heading"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;APPENDICES</strong></p>
<ul class="justified-continuation" style="list-style: none; padding-left: 4em; margin-top: -0.5rem;">
    <li>A: Personal Particulars</li>
    <li>B: Job Description</li>
    <li>C: Terms and Conditions</li>
</ul>

<p class="justified-heading"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SIGNATURES</strong><br/>On behalf of the Employer</p>
<div style="display: flex; justify-content: space-between; padding-left: 4em; gap: 3rem;">
    <div>

        <div style="width: 200px;margin-top: 2rem; border-bottom: 1px solid #000; margin-bottom: 0.5rem;"></div>
        <p>Date: <div style="width: 200px; border-bottom: 1px solid #000; margin-bottom: 0.5rem;"></span></p>
    </div>

    <div>
        <p class="justified-heading">&nbsp;&nbsp;The Employee (Read, Understood & Agreed)</p>
        <div style="width: 200px; margin-top: 2.5rem;  border-bottom: 1px solid #000; margin-bottom: 0.5rem;"></div>
        <p>Date: <div style="width: 200px; margin-top: 2rem; border-bottom: 1px solid #000; margin-bottom: 0.5rem;"></div></p>
    </div>
</div>





</body>

</html>
