<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>{{strtoupper('JOB TITLE OR DEPARTMENT CHANGE')}}</title>
    <style>
        body {
            font-size: 13px;
            /* font-family: Georgia, "Times New Roman", serif; */
            /* font-family: Georgia, "Bookman Old", Style; */

            background-color: #ffffff;
            margin: 0;
            padding: 20px;
            line-height: 1.15;
            /* Corrected */
        }

        /* Remove hover effects as they don't work in PDFs */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        td,
        th {
            padding: 6px;
            border: 1px solid #ddd;
        }

        .header-logo {
            width: 80px;
            height: 100px;
        }

        .oval {
            width: 20px;
            height: 10px;
            background-color: #000000;
            border-radius: 50%;
            display: inline-block;
        }

        .signature-line {
            border-bottom: 1px solid #000;
            display: inline-block;
            width: 200px;
        }
    </style>
</head>

<body>
    <div style="border: none solid #333; padding: 20px;">
        <table>
            <tr>
                <!-- <td style="text-align: right; width: 25%;">
                    <img src="{{ $logoPath }}" alt="Socrate" class="header-logo">
                </td> -->
                <td style="text-align: center; width: 50%; border: none">
                    <h2 style="font-size: 15px; font-family: 'Bookman Old'; font-size: 22px; color: #6899e7">SITE ID APPLICATION FORM</h2>
                </td>

            </tr>
            <tr>
                <td style="border: none">
                    <h5 style="font-size: 13px; ">This form must be completed and approved before a Site ID is issued. Please ensure that all required fields are filled out accurately.</h5>
                </td>
                <!-- <td style="text-align: right; width: 25%;">
                    <img src="{{ $logoPath }}" alt="Socrate" class="header-logo">
                </td> -->
            </tr>
        </table>
        <!-- <div style="margin-right: 10px;margin-left: 30px;margin-top: 20px"> -->
        <table style="width: 95%;font-size: 13px;font-family: 'Bookman Old'; border: none">
            <tbody>
                <tr>

                    <td style="border: none solid #333; font-family: 'Bookman Old'; font-size: 17px; color: #6899e7"><b>JOB TITLE OR DEPARTMENT CHANGE FORM</td>
                </tr>
                <tr>
                    <td style="border: none solid #333; font-family: 'Bookman Old'; font-size: 14px; color: #6899e7"><b>Current Employee Information:</b></td>
                </tr>
                <tr>
                    <td style="text-align: left; border: none;">
                        <b>Full Name</b>:
                        <span style="display: inline-block; width: 350px; border-bottom: 1px solid black;">
                            {{ $employee->applicant }}
                        </span>
                    </td>

                </tr>
                <td style="text-align: left; border: none"><b>Current Department </b>: <span style="display: inline-block; width: 350px; border-bottom: 1px solid black;">{{ $employee->department }}</span></td>
                </tr>
                <tr>
                    <td style="text-align: left; border: none"><b> Current Job Title </b>: <span style="display: inline-block; width: 350px; border-bottom: 1px solid black;">{{ $employee->job_title }}</span>
                    </td>
                </tr>
                <tr>



                    <br />
                <tr>
                    <td style="border: none solid #333; font-family: 'Bookman Old'; font-size: 14px; color: #6899e7; "><b>New Job Details:</b></td>
                </tr>
                <tr>
                    <td style="text-align: left;border: none"><b>New Job Title</b>: <span style="display: inline-block; width: 350px; border-bottom: 1px solid black;"> {{ $employee->new_job_title}}</span></td>
                </tr>
                <tr>
                    <td style="text-align: left;border: none"><b>New Department Name</b>: <span style="display: inline-block; width: 350px; border-bottom: 1px solid black;"> {{ $employee->new_department}}</span></td>
                </tr>
                <tr>
                    <td style="text-align: leftl; border: none"><b>Effective Date </b>: <span style="display: inline-block; width: 350px; border-bottom: 1px solid black;"> {{ \Carbon\Carbon::parse($employee->effective_date)->format('F, Y') }}</span></td>
                </tr>


                <br />
                <tr>
                    <td style="text-align: left; border: none; border: none solid #333; font-family: 'Bookman Old'; font-size: 14px; color: #6899e7"><b>Approval </b>: </td>
                </tr>

                <tr>
                    <td style="text-align: left; border: none"><b>Supervisor’s Name </b>: <span style="display: inline-block; width: 350px; border-bottom: 1px solid black;"> {{ $employee->supervisor_name }} </span>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: leftl; border: none"><b>Signature </b>: <span style="display: inline-block; width: 350px; border-bottom: 1px solid black;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>- &nbsp; <b>Date:</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="display: inline-block; width: 350px; border-bottom: 1px solid black;">{{ \Carbon\Carbon::parse($employee->approval_date)->format('F, Y') }} </span></td>
                </tr>
                <br />
                <br />
                <tr>
                    <td style="text-align: leftl; border: none"><b>NOTE:</b>&nbsp;&nbsp;All applicants must adhere to company safety regulations and present valid identification before being issued a Site ID.</td>
                </tr>
            </tbody>
        </table>

    </div>
    </div>
    </div>
</body>

</html>