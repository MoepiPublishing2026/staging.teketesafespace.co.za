<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .icon-container {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .icon-container svg {
            color: #d1d5db;
            /* gray-400 */
        }

        .icon-container:hover svg {
            color: #9ca3af;
            /* gray-500 */
        }

        .password-input-wrapper {
            position: relative;
        }

        .password-requirements {
            border-left: 4px solid #c7da30;
            padding: 0.5rem 1rem;
            margin-top: 0.5rem;
            background-color: #f7ffe4;
            /* light green background */
        }
    </style>
</head>

<!-- Header -->
<header
    style="position: fixed; top: 0; left: 0; width: 100%; background-color: #ffffff; z-index: 50; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
    <div class="flex flex-row justify-between items-center px-8 py-2" style="max-width: 1280px; margin: 0 auto;">
        <!-- Logo -->
        <div>
            <img src="{{ asset('images/logo.png') }}" alt="Safe Space Logo" style="width: 110px; height: auto;">
        </div>

        <!-- Top Right Links -->
        <div class="flex gap-8" style="font-family: 'Montserrat', sans-serif; font-size: 17px; color: black;">
            <a href="{{ route('landing-page') }}" class="transition-colors hover:!text-[#c7da30]"
                style="color: black; text-decoration: none;">
                Home
            </a>
            <a href="{{ route('about-us') }}" class="transition-colors hover:!text-[#c7da30]"
                style="color: black; text-decoration: none;">
                About Us
            </a>
            <a href="{{ route('contact-us') }}" class="transition-colors hover:!text-[#c7da30]"
                style="color: black; text-decoration: none;">
                Contact Us
            </a>
        </div>
    </div>
</header>

<body class="min-h-screen bg-white flex flex-col items-center justify-center font-[Montserrat] px-4">
    <!-- Outer Box -->
    <div
        class="w-full max-w-[698px] border-2 border-[#c7da30] rounded-xl bg-white p-6 sm:p-10 flex flex-col items-center justify-center">

        <div class="w-full max-w-md mx-auto">
            <div class="bg-white p-8 rounded-lg shadow-md">

                <h2 class="text-2xl font-bold mb-6 text-gray-800 text-center">
                    Reset Password
                </h2>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <!-- EMAIL -->
                    <div class="mb-4">
                        <label for="email" class="block font-[Montserrat] text-gray-700 text-sm font-bold mb-2">
                            Email Address
                        </label>

                        <input id="email" type="email"
                            style="border: 3px solid #c7da30; font-family: 'Montserrat', sans-serif; font-size: 14px; background-color: white;"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline
                            @error('email') border-red-500 @enderror"
                            name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- PASSWORD -->
                    <div class="mb-4">
                        <label for="password" class="block font-[Montserrat] text-gray-700 text-sm font-bold mb-2">
                            Password
                        </label>

                        <div class="password-input-wrapper relative"
                            style="border: 3px solid #c7da30; font-family: 'Montserrat', sans-serif; font-size: 14px; background-color: white;">

                            <input id="password" type="password"
                                class="shadow appearance-none border rounded w-full py-2 px-3 pr-10 text-gray-700 leading-tight
                                    focus:outline-none focus:shadow-outline
                                    @error('password') border-red-500 @enderror"
                                name="password" required autocomplete="new-password">

                            <span class="icon-container" onclick="togglePasswordVisibility('password', this)">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-icon" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                                    <path fill-rule="evenodd" d="M.661 10.322l1.642-1.996C3.993 6.002
                                        6.784 4 10 4c3.216 0
                                        6.007 2.002 7.697 4.326l1.642 1.996a.75.75
                                        0 010 1.356l-1.642 1.996C16.007 16.998
                                        13.216 19 10 19c-3.216 0-6.007-2.002-7.697-4.326l-1.642-1.996a.75.75
                                        0 010-1.356zM10 17.5a6.5 6.5 0
                                        100-13 6.5 6.5 0 000 13z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </div>

                        <!-- ADDED: Password Requirements List -->
                        @error('password')
                            <!-- Display the actual error message -->
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>

                            <!-- Check if the error is the generic confirmation error -->
                            @php
                                $isConfirmationError = strpos($message, 'confirmation does not match') !== false;
                            @endphp

                            <!-- Display detailed requirements only if it's NOT the confirmation error -->
                            @if (!$isConfirmationError)
                                <div class="password-requirements text-sm text-gray-700 rounded-lg">
                                    <p class="font-bold text-gray-800 mb-1">Password Requirements:</p>
                                    <ul class="list-disc list-inside space-y-0">
                                        <li>Minimum 8 characters, maximum 50 characters.</li>
                                        <li>Must contain at least one uppercase letter.</li>
                                        <li>Must contain at least one number.</li>
                                        <li>Must contain at least one special character.</li>
                                    </ul>
                                </div>
                            @endif
                        @enderror
                    </div>


                    <!-- CONFIRM PASSWORD -->
                    <div class="mb-6">
                        <label for="password-confirm"
                            class="block font-[Montserrat] text-gray-700 text-sm font-bold mb-2">
                            Confirm Password
                        </label>

                        <div class="password-input-wrapper relative">
                            <input id="password-confirm" type="password"
                                class="shadow appearance-none border rounded w-full py-2 px-3 pr-10 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                style="border: 3px solid #c7da30; font-family: 'Montserrat', sans-serif; font-size: 14px; background-color: white;"
                                name="password_confirmation" required autocomplete="new-password">

                            <span class="icon-container" onclick="togglePasswordVisibility('password-confirm', this)">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-icon" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                                    <path fill-rule="evenodd" d="M.661 10.322l1.642-1.996C3.993 6.002 6.784
                                        4 10 4c3.216 0 6.007 2.002 7.697
                                        4.326l1.642 1.996a.75.75 0 010
                                        1.356l-1.642 1.996C16.007 16.998
                                        13.216 19 10 19c-3.216 0-6.007-2.002-7.697-4.326l-1.642-1.996a.75.75
                                        0 010-1.356zM10 17.5a6.5 6.5 0
                                        100-13 6.5 6.5 0 000 13z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </div>
                    </div>

                    <!-- SUBMIT BUTTON -->
                    <button type="submit"
                        class="w-full font-[Montserrat] py-4 px-4 border-4 border-[#c7da30]
                           rounded-[100px] text-lg text-[#38b6ff] transition hover:opacity-90">
                        Reset Password
                    </button>
                </form>

            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer style="width: 100%; background-color: #808080; color: white; padding: 1.5rem 0; margin-top: 4rem;">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 px-6"
            style="max-width: 1280px; margin: 0 auto; font-family: 'Montserrat', sans-serif; font-size: 16px;">
            <div>
                <p>&copy; {{ date('Y') }} Tekete SafeSpace from Moepi Publishing. All rights reserved.</p>
            </div>
            <div class="flex items-center gap-4 order-2">
                <a href=" https://www.youtube.com/@matauramapuputla6836"target="_blank">
                    <img src="{{ asset('images/youtube.png') }}" alt="YouTube Icon"
                        style="width: 30px; height: 30px; left:1024.8; top: 701.8
;">
                </a>
                <a href="https://www.X.com/moepipublishing" target="_blank">
                    <img src="{{ asset('images/X.png') }}" alt="X Icon"
                        style="width: 30px; height: 30px;left:1024.8 ; top:701.8; ">
                </a>

                <a href="https://www.linkedin.com/company/moepi-publishing/" target="_blank">
                    <img src="{{ asset('images/linkedIn.png') }}" alt="LinkedIn Icon"
                        style="width: 30px; height: 30px;left: 1128.6
; top:701.1;">
                </a>
                <a href="https://www.facebook.com/MoepiPublishing" target="_blank">
                    <img src="{{ asset('images/facebook.png') }}" alt="Facebook Icon"
                        style="width: 35.2px; height: 30px;left: 1179.7;top: 701.1;">
                </a>

                <a href="https://www.instagram.com/moepi_pub?igsh=MWJ0NWFueWM2MDZ3YQ==" target="_blank">
                    <img src="{{ asset('images/instagram.png') }}" alt="Instagram Icon"
                        style="width: 35.2px; height: 30px; left: 1225.7px; top: 701.1px;">
                </a>
                <a href="https://www.tiktok.com/@moepipublishing" target="_blank">
                    <img src="{{ asset('images/tiktok.png') }}" alt="TikTok Icon"
                        style="width: 35.2px; height: 30px;left:1271.7 ;top:700.1;"></a>
            </div>

    </footer>
    <script>
        function togglePasswordVisibility(inputId, iconContainer) {
            const passwordInput = document.getElementById(inputId);

            const icon = iconContainer.querySelector('.eye-icon');

            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';

            passwordInput.setAttribute('type', type);

            if (type === 'password') {
                icon.innerHTML =
                    `<path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                         <path fill-rule="evenodd" d="M.661 10.322l1.642-1.996C3.993 6.002 6.784 4 10 4c3.216 0 6.007 2.002 7.697 4.326l1.642 1.996a.75.75 0 010 1.356l-1.642 1.996C16.007 16.998 13.216 19 10 19c-3.216 0-6.007-2.002-7.697-4.326l-1.642-1.996a.75.75 0 010-1.356zM10 17.5a6.5 6.5 0 100-13 6.5 6.5 0 000 13z" clip-rule="evenodd" />`;
            } else {
                icon.innerHTML =
                    `<path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                         <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14.5 10a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z" clip-rule="evenodd" />`;
            }
        }
    </script>

</body>

</html>

</script>
</body>

</html>
