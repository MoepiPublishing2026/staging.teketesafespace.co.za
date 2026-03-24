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

    <form id="payfast-form" action="<?php echo e($payfastUrl); ?>" method="post">
        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <input type="hidden" name="<?php echo e($name); ?>" value="<?php echo e($value); ?>">
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </form>

    <script>
        document.getElementById('payfast-form').submit();
    </script>
</body>

</html>
<?php /**PATH /home/teketeq9v8o0/staging.teketesafespace.co.za/resources/views/admin/payfast_redirect.blade.php ENDPATH**/ ?>