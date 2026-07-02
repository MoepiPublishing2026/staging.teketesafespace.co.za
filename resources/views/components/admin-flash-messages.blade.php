@if(\App\Support\AdminRoutes::matches(request()) && session('error_message'))
    <div style="position:fixed;top:16px;left:50%;transform:translateX(-50%);z-index:9999;max-width:90%;padding:14px 20px;border:2px solid #ef4444;background:#fef2f2;color:#991b1b;border-radius:12px;font-family:Montserrat,sans-serif;font-size:14px;box-shadow:0 8px 24px rgba(0,0,0,.08);">
        {{ session('error_message') }}
    </div>
@endif
