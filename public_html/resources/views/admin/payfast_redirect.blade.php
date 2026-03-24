<!DOCTYPE html>
<html>

<head>
    <title>Redirecting to Payment...</title>
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background: #f3f5f4;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .box {
            text-align: center;
            color: #545454;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #c7da30;
            border-top-color: #38b6ff;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin: 0 auto 20px auto;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <div class="box">
        <div class="spinner"></div>
        <p>Redirecting to secure payment...</p>
    </div>

    <form id="payfast-form" action="{{ $payfastUrl }}" method="post">
        @foreach ($data as $name => $value)
            <input type="hidden" name="{{ $name }}" value="{{ $value }}">
        @endforeach
    </form>

    <script>
        document.getElementById('payfast-form').submit();
    </script>
</body>

</html>
