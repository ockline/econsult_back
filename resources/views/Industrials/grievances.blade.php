<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>FOMU YA MALALAMIKO RASMI</title>
    <style>
        @font-face {
            font-family: 'Calibri Light';
            src: local('Calibri Light'), local('Calibri-Light');
        }

        body {
            font-family: 'Calibri Light', sans-serif;
            font-size: 14px;
            margin: 40px;
            padding: 0;
            line-height: 1.6;
        }

        .info-line {
            border-bottom: 1px dotted black;
            display: inline-block;
            min-width: 200px;
            padding: 2px 8px;
        }

        .block-line {
            border-bottom: 1px dotted black;
            display: block;
            min-height: 40px;
            width: 100%;
            padding: 5px;
            white-space: pre-wrap;
            word-break: break-word;
        }

        .section {
            margin-top: 30px;
        }

        .text-justify {
            text-align: justify;
        }

        .signature-line {
            display: inline-block;
            min-width: 150px;
            border-bottom: 1px solid black;
            margin-left: 10px;
        }

        .subsection {
            margin-left: 30px;
            margin-top: 10px;
        }

        .bold {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div style="text-align: center; margin-bottom: 30px;">
        <h1>FOMU YA MALALAMIKO RASMI</h1>
        <label>(Ijazwe na mwajiriwa anayeleta malalamiko kulingana na hatua ya pili ya taratibu za kushughulikia malalamiko)</label>
    </div>

    <div class="section">
        <p>
            Jina la Mwajiriwa:
            <span class="info-line">{{ $data->employee_name ?? '________________' }}</span> &nbsp;&nbsp;
            Jinsi:
            <span class="info-line">{{ $data->gender ?? '________' }}</span>
        </p>
    </div>

    <div class="section">
        <p class="bold">Sababu ya Malalamiko:</p>
        <div class="subsection">
            <div class="block-line">
                {{ $data->grievance_reason ?? '________________________________________________________________________' }}
            </div>
        </div>
    </div>

    <div class="section">
        <p class="bold">Suluhisho Lililotafutwa:</p>
        <div class="subsection">
            <div class="block-line">
                {{ $data->grievance_solution ?? '________________________________________________________________________' }}
            </div>
        </div>
    </div>

    <div class="section">
        <p>
            Sahihi ya Mwajiriwa: <span class="signature-line"></span> &nbsp;
            Tarehe: <span class="signature-line"></span>
        </p>
        <p>
            Sahihi ya Mwakilishi wa Mwajiriwa: <span class="signature-line"></span> &nbsp;
            Tarehe: <span class="signature-line"></span>
        </p>
    </div>

    <hr style="margin: 50px 0;">

    <div class="section">
        <p class="bold" style="text-align: center; margin-bottom: 30px;"><h1>SEHEMU YA II</h1>(Ijazwe na Meneja ambaye anashughulikia malalamiko katika utaratibu wa
hatua ya malalamiko yasiyo rasmi na hatua ya kwanza ya malalamiko
rasmi)(isipokuwa kama haihitajiki kulingana na ibara ya 2(2) ya hatua ya
malalamiko yasiyo rasmi) </p>

        <div class="subsection">
            <div class="block-line">
                {{ $reviewerDetails->comments ?? '________________________________________________________________________' }}
            </div>
        </div>

        <p>Tarehe ya Kupokelewa:
            <span class="info-line">{{ $reviewerDetails->received_date ?? '__________' }}</span>
        </p>
        <p>Jina la Meneja:
            <span class="info-line">{{ $reviewerDetails->manager_name ?? '_____________________' }}</span>
        </p>

        <div class="section">
            <p class="bold">Hatua zilizochukuliwa kushughulikia malalamiko:</p>
            <div class="subsection">
                <div class="block-line">
                    {{ $reviewerDetails->action_taken ?? '________________________________________________________________________' }}
                </div>
            </div>
        </div>

        <div class="section">
            <p class="bold">Marekebisho yaliyopendekezwa:</p>
            <div class="subsection">
                <div class="block-line">
                    {{ $reviewerDetails->recommendation ?? '________________________________________________________________________' }}
                </div>
            </div>
        </div>

        <div class="section">
            <p class="bold">Matokeo:</p>
            <div class="subsection">
                <div class="block-line">
                    {{ $reviewerDetails->result ?? '________________________________________________________________________' }}
                </div>
            </div>
        </div>
    </div>

    <hr style="margin: 50px 0;">

    <div class="section">
        <p class="bold" style="text-align: center; margin-bottom: 30px;"><h1>SEHEMU YA III</h1>  (Ijazwe na Meneja anayeshughulikia malalamiko kulingana na taratibu za
hatua ya pili ya malalamiko yasiyo rasmi)</p>

        <p>Tarehe ya Kupokelewa:
            <span class="info-line">{{ $reviewerDetails->action_date ?? '__________' }}</span>
        </p>

        <div class="section">
            <p class="bold">Maoni ya Meneja Mwandamizi:</p>
            <div class="subsection">
                <div class="block-line">
                    {{ $approverDetails->comments ?? '________________________________________________________________________' }}
                </div>
            </div>
        </div>

        <div class="section">
            <p class="bold">Matokeo:</p>
            <div class="subsection">
                <div class="block-line">
                    {{ $approverDetails->result ?? '________________________________________________________________________' }}
                </div>
            </div>
        </div>

        <br><br>

        <p>
            Saini ya Meneja Mwandamizi: <span class="signature-line"></span> &nbsp;
            Tarehe: <span class="signature-line"></span>
        </p>
        <p>
            Saini ya Meneja Mwajiriwa: <span class="signature-line"></span> &nbsp;
            Tarehe: <span class="signature-line"></span>
        </p>
        <p>
            Saini ya Mwakilishi wa Mwajiriwa: <span class="signature-line"></span> &nbsp;
            Tarehe: <span class="signature-line"></span>
        </p>
    </div>

</body>

</html>
