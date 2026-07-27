<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forgot Password | Newsletter Manager</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white;
            margin: 0;
        }
        .login-content-area {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            flex-grow: 1;
            width: 100%;
            padding: 40px 20px;
            margin-top: 60px;
        }
        .login-box {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            border-top: 5px solid #c7da30;
        }
        h2 { margin-top: 0; color: #c7da30; text-align: center; margin-bottom: 12px; font-weight: bold; }
        .form-subtitle { text-align: center; color: #666; font-size: 14px; margin: 0 0 25px 0; line-height: 1.5; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; }
        input[type="email"], input[type="password"] { width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn { background: #c7da30; color: white; width: 100%; padding: 12px; border: none; border-radius: 4px; font-size: 16px; font-weight: bold; cursor: pointer; transition: background 0.2s ease; }
        .btn:hover { background: #b2c42b; }
        .back-link { display: block; text-align: center; margin-top: 16px; color: #666; font-size: 14px; text-decoration: none; }
        .back-link:hover { color: #c7da30; }
        .alert-error { background-color: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; border: 1px solid #f5c6cb; margin-bottom: 20px; font-size: 14px; }
        .alert-error ul { margin: 0; padding-left: 20px; }
        .hint-text { color: #888; font-size: 12px; margin-top: 6px; }
    </style>
</head>
<body class="flex flex-col min-h-screen">

    <header style="position: fixed; top: 0; left: 0; width: 100%; background-color: #ffffff; z-index: 150; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
        <div class="flex flex-row justify-between items-center px-8 py-2" style="max-width: 1280px; margin: 0 auto;">
            <div>
                <img src="{{ asset('images/logo.png') }}" alt="Safe Space Logo" class="w-[143px] h-auto flex-shrink-0">
            </div>
            <div style="font-family: 'Montserrat', sans-serif; font-size: 17px;">
                <div class="hidden md:flex gap-8">
                    <a href="{{ route('landing-page') }}" class="transition-colors hover:text-[#c7da30]" style="color: black; text-decoration: none;">Home</a>
                    <a href="{{ route('about-us') }}" class="transition-colors hover:text-[#c7da30]" style="color: black; text-decoration: none;">About Us</a>
                    <a href="{{ route('contact-us') }}" class="transition-colors hover:text-[#c7da30]" style="color: black; text-decoration: none;">Contact Us</a>
                    <a href="{{ route('news') }}" class="transition-colors hover:text-[#c7da30]" style="color: black; text-decoration: none;">News</a>
                </div>
                <div class="md:hidden flex items-center relative z-[160]">
                    <button id="mobile-menu-button" type="button" class="p-2 rounded-md text-black hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#c7da30] cursor-pointer">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div id="mobile-menu" class="fixed top-0 right-0 h-full w-[280px] bg-white shadow-2xl z-[200] transform translate-x-full transition-transform duration-300 ease-in-out p-6 flex flex-col gap-6 border-l border-gray-100">
            <div class="flex justify-between items-center pb-4 border-b border-gray-100">
                <img src="{{ asset('images/logo.png') }}" alt="Safe Space Logo" class="w-[110px] h-auto">
                <button id="mobile-menu-close" type="button" class="text-gray-500 hover:text-black focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <nav class="flex flex-col gap-5 text-[16px] font-medium" style="font-family: 'Montserrat', sans-serif;">
                <a href="{{ route('landing-page') }}" class="text-black hover:text-[#c7da30] transition-colors" style="text-decoration: none;">Home</a>
                <a href="{{ route('about-us') }}" class="text-black hover:text-[#c7da30] transition-colors" style="text-decoration: none;">About Us</a>
                <a href="{{ route('contact-us') }}" class="text-black hover:text-[#c7da30] transition-colors" style="text-decoration: none;">Contact Us</a>
                <a href="{{ route('news') }}" class="text-black hover:text-[#c7da30] transition-colors" style="text-decoration: none">News</a>
            </nav>
        </div>
        <div id="mobile-menu-overlay" class="fixed inset-0 bg-black/40 z-[190] hidden transition-opacity duration-300"></div>
    </header>

    <main class="login-content-area">
        <div class="login-box">
            <h2>Forgot Password</h2>
            <p class="form-subtitle">Enter your newsletter admin email and choose a new password.</p>

            @if ($errors->any())
                <div class="alert-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('newsletter.password.update') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="admin@example.com">
                </div>

                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" name="password" required placeholder="••••••••">
                    <p class="hint-text">At least 8 characters.</p>
                </div>

                <div class="form-group">
                    <label>Confirm New Password</label>
                    <input type="password" name="password_confirmation" required placeholder="••••••••">
                </div>

                <button type="submit" class="btn">Reset Password</button>
            </form>

            <a href="{{ route('newsletter.login') }}" class="back-link">Back to Login</a>
        </div>
    </main>

    <footer class="mt-auto" style="width: 100%; background-color: #808080; color: white; padding: 1.5rem 0;">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 px-6"
            style="max-width: 1280px; margin: 0 auto; font-family: 'Montserrat', sans-serif; font-size: 16px;">
            <div>
                <p>&copy; {{ date('Y') }} Tekete SafeSpace from Moepi Publishing. All rights reserved.</p>
            </div>
            <div class="flex items-center gap-4">
                <a href="https://www.youtube.com/@matauramapuputla6836" target="_blank">
                    <img src="{{ asset('images/youtube.png') }}" alt="YouTube Icon" style="width: 30px; height: 30px;">
                </a>
                <a href="https://www.X.com/moepipublishing" target="_blank">
                    <img src="{{ asset('images/X.png') }}" alt="X Icon" style="width: 30px; height: 30px;">
                </a>
                <a href="https://www.linkedin.com/company/moepi-publishing/" target="_blank">
                    <img src="{{ asset('images/linkedIn.png') }}" alt="LinkedIn Icon" style="width: 30px; height: 30px;">
                </a>
                <a href="https://www.facebook.com/MoepiPublishing" target="_blank">
                    <img src="{{ asset('images/facebook.png') }}" alt="Facebook Icon" style="width: 35.2px; height: 30px;">
                </a>
                <a href="https://www.instagram.com/moepipublishing" target="_blank">
                    <img src="{{ asset('images/instagram.png') }}" alt="Instagram Icon" style="width: 35.2px; height: 30px;">
                </a>
                <a href="https://www.tiktok.com/@moepipublishing" target="_blank">
                    <img src="{{ asset('images/tiktok.png') }}" alt="TikTok Icon" style="width: 35.2px; height: 30px;">
                </a>
            </div>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            const overlay = document.getElementById('mobile-menu-overlay');
            if (!mobileMenu || !overlay) return;

            const isOpen = mobileMenu.classList.contains('translate-x-0');

            if (!isOpen) {
                mobileMenu.classList.remove('translate-x-full');
                mobileMenu.classList.add('translate-x-0');
                overlay.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            } else {
                mobileMenu.classList.remove('translate-x-0');
                mobileMenu.classList.add('translate-x-full');
                overlay.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const closeMenuButton = document.getElementById('mobile-menu-close');
            const overlay = document.getElementById('mobile-menu-overlay');

            if (mobileMenuButton) mobileMenuButton.addEventListener('click', toggleMobileMenu);
            if (closeMenuButton) closeMenuButton.addEventListener('click', toggleMobileMenu);
            if (overlay) overlay.addEventListener('click', toggleMobileMenu);
        });
    </script>
</body>
</html>