<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="icon" href={{asset('images/socrate-logo.png')}} type="image/png" sizes="16x16">
    <title>{{strtoupper('Demand Notice')}}</title>
    <style>
        body {
            size: 7in 9.25in;
            margin: 27mm 16mm 27mm 16mm;
            font-size: 12px;
            font-family: Georgia, Times New Roman, serif;
        }
        #customers {
            border-collapse: collapse;
            width: 100%;
        }

        #customers td, #customers th {
            border-left: 0px solid;
            border-right: 0px solid;
            padding: 6px;
        }

        #customers tr:hover {background-color: #ddd;}

        #customers1 {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers1 td, #customers th {
            border-bottom: 1px solid #ddd;
            border-left: 0px solid;
            border-right: 0px solid;
            padding: 6px;
        }

        #customers1 tr:hover {background-color: #ddd;}

        #spsl-lpsm td, #spsl-lpsm th {
            border: 1px solid #ddd;
            text-align: left;
        }

        #spsl-lpsm th, #spsl-lpsm  td {
            padding: 6px;
        }

        #sig-table th, #spsl-lpsm  td {
            padding: 6px;
        }

       .oval {
            display: inline-block;
            width: 20px;
            height: 10px;
            border-radius: 50%;
            background-color: black;
            margin-right: 10px; /* Adjust the space between the oval and the text */
        }
    </style>
</head>
<body style="background-image: url('{{asset('images/doc-logo-bg.png')}}');background-position: center;background-repeat: no-repeat;background-size: cover">
<div style="border: 1px solid #333;height: 100%">
    <div style="margin-right: 10px;margin-left: 30px">
        <table id="customers" style="width: 95%;font-family: 'Tahoma'">
        <tr>
                <td style="text-align: right">
                    <img src="{{asset('images/socrate1.png')}}" alt="Socrate" style="width:80px;height:100px;border-radius: 2%;padding:2px; float:right">
                </td>
                <td style="text-align: center">
                    <h2 style="font-size: 15px">EMPLOYEE PERFORMANCE REVIEW FORM</h2>
                    <h2 style="font-size: 15px">PRIME MINISTER’S OFFICE </h2>
                    <h2 style="font-size: 15px">LABOUR, YOUTH, EMPLOYMENT AND PERSONS WITH DISABILITY </h2>
                    <h2 style="font-size: 15px">NATIONAL SOCIAL SECURITY FUND </h2>
                </td>
                <td style="text-align: right">
                    <img src="{{asset('images/socrate.png')}}" alt="Socrate " style="width:80px;height:100px;border-radius: 2%;padding:2px; float: right">
                </td>
            </tr>
        </table>
    </div>
    <!-- <div style="margin-right: 10px;margin-left: 30px;margin-top: 20px">
        <table id="customers" style="width: 95%;font-size: 13px;font-family: 'Tahoma'">
            <tbody>

            <tr>

                <td><b>Ref No</b>: {{ $fixed_contract->commencement_date ?? '-' }}</td>
                <td style="text-align: right"><b>Date</b>:  {{ \Carbon\Carbon::parse($fixed_contract->created_at)->format('d \ F, Y') }}</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td style="text-align: right">National Social Security Fund (NSSF)<br/>P.O.Box {{empty($fixed_contract->office_addres) ? ' ' : $fixed_contract->email}}<br>{{$fixed_contract->employee_name}}<br/><br/>{{empty($fixed_contract->employee_name) ? ' ' : $fixed_contract->employee_name}}</td>
            </tr>
            <tr>
                <td style="text-align: left"><b>To</b>:  {{ $fixed_contract->employer_name }}<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $fixed_contract->employee_name }}<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $fixed_contract->employee_name }}</td>
                <td>&nbsp;</td>
            </tr>

            </tbody>
        </table>
        <div style="width: 95%;font-size: 13px;font-family: 'Tahoma">
            <h2 style="font-size: 15px;font-family: 'Tahoma';text-align: justify">PART A: <u>DEMAND NOTICE; MEMBERS STATUTORY CONTRIBUTIONS’ ARREARS</u></h2>
            <p style="text-align: justify">Reference is made from the heading above</p>
            <p style="text-align: justify">
                This letter is served as an official demand notice to you to pay statutory contributions of your employees which
                has been accrued as arrears due and payable to the Fund as stipulated under Section 14 of the NSSF Act [Cap.
                50 R.E. 2018] for the period of <b>{{ \Carbon\Carbon::parse($fixed_contract->created_at)->format('F, Y') }}</b> to <b>{{ \Carbon\Carbon::parse($fixed_contract->created_at)->format('F, Y') }}</b> totaling <b>TZS {{ $fixed_contract->commencement_date }}</b> as at <b>{{ \Carbon\Carbon::parse($fixed_contract->created_at)->format('F, Y') }}</b>.
            </p>
            <p style="text-align: justify">
                Kindly be reminded that, failure to remit statutory contributions to the Fund within the prescribed period, attracts
                imposition of penalty chargeable on every contribution monthly payment delayed to the Fund.
            </p>
            <p style="text-align: justify">
                In this regard, you are hereby issued <b> {{ $fixed_contract->employee_name }} days</b> from the date of receiving this notice to pay the whole
                amount of the outstanding statutory contributions arrears of <b>TZS {{ $fixed_contract->employee_name }}</b>. and penalties of <b>TZS {{ $fixed_contract->employee_name }}</b>.
                without any further delay. If there is no payment/response to this letter after expiry of the
                given period; The Fund shall resort to all recovery measures including but not limited to stringent legal
                proceedings necessary to recover the outstanding arrears without further notice.
            </p>
            <p>Yours, <br/><span style="font-size: 15px"><b>NATIONAL SOCIAL SECURITY FUND</b></span></p>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="margin-bottom: 10px"><img src="" style="width: 80px; height: 40px;" /></span>
            <br/>
            <b>{{$fixed_contract->employee_name}}</b><br/>
            <b>For: DIRECTOR GENERAL</b></p>

            <h2 style="font-size: 15px;font-family: 'Tahoma';text-align: justify;">PART B: <u>EMPLOYER COMMITMENT FOR SETTLEMENT OF ARREARS</u></h2>
            <p style="text-align: justify;">
                I,<b class="dotted-underline">{{ $fixed_contract->employee_name }}</b>
, do hereby acknowledge receipting of the Demand Notice with the stated amount
                of <b>{{ number_format($fixed_contract->basic_salary, 2) }}
                </b> (being statutory contribution arrears and penalties) owed by the Fund and that I
                commit myself to pay the same in full by the given period above.
            </p>
            <p style="text-align: justify">
                <span><b>Signature</b>:.....................................</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <span><b>Title</b>:.....................................</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <span><b>Date</b>:.....................................</span>
            </p>

        <b>Employers’ Official Rubber Stamp: <span class="oval"></span>
        <div style="margin-top: 40px; text-align: right;">
    @if($fixed_contract->employee_name)
        <span style="border-left: 2px solid #529bfe; height: 50px; margin-left: 5px; display: inline-block;"></span>
        <b style="color: #2bca7d;">Electronically acknowledged on</b>&nbsp;&nbsp;{{ \Carbon\Carbon::parse($fixed_contract->commencement_date)->format('d-M-Y H:i:s') ?? '.........................' }}
    @endif
</div> -->

    <!-- </h3> -->
        </div>
    </div>
</div>
</body>
</html>
