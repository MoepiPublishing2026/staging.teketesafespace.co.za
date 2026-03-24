<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Updated status report: {{ $status }}</title>
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        .content {
            padding: 40px 20px;
        }

        footer {
            background-color: #d3d3d3;
            color: black;
            text-align: center;
            padding: 1rem 0;
            width: 100%;
            margin-top: 3rem;
        }
    </style>
</head>
<body>
    <div class="content">
        <p>Hello,</p>

        <p>Your case number is <strong>{{ $report->case_number }}</strong>.</p>

        <p>Your report status has been updated to <strong>{{ $status }}</strong>. Please visit the website to view the reason for the status update on your report.</p>

        <br>

        <p>Thank you.</p>
        <p>— The Support Team</p>
    </div>

    <footer>
        <div>
            <p>© {{ date('Y') }} Tekete Safe Space from Moepi Publishing</p>
        </div>
    </footer>
</body>
</html>