<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Something went wrong | Tekete SafeSpace</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f5f7fa;
            font-family: 'Montserrat', sans-serif;
            color: #545454;
            padding: 24px;
        }

        .card {
            width: 100%;
            max-width: 560px;
            background: #fff;
            border: 3px solid #c7da30;
            border-radius: 20px;
            padding: 40px 32px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
        }

        h1 {
            margin: 0 0 16px;
            font-size: 1.5rem;
            color: #253f58;
        }

        p {
            margin: 0 0 28px;
            line-height: 1.6;
        }

        a {
            display: inline-block;
            padding: 14px 28px;
            border: 3px solid #c7da30;
            border-radius: 999px;
            color: #38b6ff;
            text-decoration: none;
            font-weight: 600;
        }

        a:hover {
            background: #c7da30;
            color: #000;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>Something went wrong</h1>
        <p>{{ $message ?? 'We could not complete that action. Please try again.' }}</p>
        <a href="{{ $backUrl ?? route('school-admin') }}">Go back</a>
    </div>
</body>
</html>
