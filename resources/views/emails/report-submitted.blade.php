<!DOCTYPE html>
<html>
<head>
    <title>Report Submission Confirmation</title>
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        h1 {
            color: #000;
            margin-top: 60px;
        }

        p {
            font-size: 16px;
            color: #333;
        }

        footer {
            background-color: #d3d3d3;
            color: black;
            text-align: center;
            padding: 1rem 0;
            position: relative;
            bottom: 0;
            width: 100%;
            margin-top: 3rem;
        }
    </style>
</head>
<body>
    <h1>Report Submitted Successfully!</h1>
    <p>Thank you for submitting your report. Your case number is: <strong>{{ $caseNumber }}</strong>.</p>
    <p>We will review your report and get back to you as soon as possible.</p>

    <footer>
        <div>
            <p>© {{ date('Y') }} Tekete Safe Space from Moepi Publishing</p>
        </div>
    </footer>
</body>
</html>
