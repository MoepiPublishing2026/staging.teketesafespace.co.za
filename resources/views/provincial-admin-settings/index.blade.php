<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <title>Settings | Tekete SafeSpace – Provincial Admin</title>
   
     <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400&display=swap" rel="stylesheet">
    <style>
        :root {
            --theme-gradient: linear-gradient(to right, #38b6ff, #38b6ff);
            --lime: #c7da30;
            --offwhite: #fffbf7;
            --gray-dark: #2a2e32;
            --gray-light: #f6f6f6;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Montserrat', sans-serif; color: var(--gray-dark); background: white; display: flex; min-height: 100vh; width: 100%; min-width: 0; overflow-x: hidden; overflow-y: hidden; }
        a { text-decoration: none; }
        h2,h3 { font-family: 'Poppins', sans-serif; color: #000; margin-bottom: 1rem; }

        /* Sidebar */
        .sidebar {
    width: 235px;
    background-color: white;
    border-right: 1px solid #eaeaea;
    display: flex;
    flex-direction: column;
    padding-top: 120px;
    position: sticky;
    top: 0;
    height: 100vh;
    overflow-y: auto;
    z-index: 100;
    flex-shrink: 0;
}
        .sidebar-logo { position: fixed; top: 40px; left: 40px; width: 100px; height: auto; }
        .sidebar-logo img { width: 115px; height: auto; display: block; }
        .sidebar::before {
            content: '';
            position: absolute;
            top: 75px;
            right: 0;
            width: 1px;
            height: calc(100% - 75px);
            background: #eaeaea;
            z-index: 1;
        }
        .sidebar-list { list-style: none; padding: 0 0 0 22px; }
        .sidebar-link {
            display: block;
            width: 92%;
            padding: 11px 18px;
            margin-bottom: 17px;
            font-size: 15px;
            font-weight: 900;
            color: #545454;
            border-radius: 8px;
            transition: all 0.25s ease;
        }
        .sidebar-link:hover,
        .sidebar-link.active {
            background: var(--theme-gradient);
            color: #000;
        }
        button:not(.menu-icon){
            background-color: white !important;
            color: #38b6ff !important;
            border: 2px solid #c7da30 !important;
            font-weight: 900 !important;
            font-family: 'Montserrat', sans-serif !important;
            padding: 0.75rem 1rem !important;
            border-radius: 0.5rem !important;
            cursor: pointer !important;
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
            margin: 0 !important;
        }

        button:not(.menu-icon):hover,
        button:not(.menu-icon):focus {
            background-color: #c7da30 !important;
            color: white !important;
            border-color: #38b6ff !important;
            outline: none;
        }

        /* Hide menu icon on desktop */
        .menu-icon {
            display: none;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.3);
            z-index: 999;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .sidebar-overlay.active {
            display: block;
            opacity: 1;
        }

        @media (min-width: 901px) {
            .sidebar-overlay {
                display: none !important;
            }
        }

        /* Responsive sidebar and elements */
        /* Tablet breakpoint (768px - 1024px) */
        @media (max-width: 1024px) {
            main {
                padding: 1.5rem;
            }
            
            .card {
                padding: 1.5rem;
            }
        }

        /* Mobile breakpoint (max-width: 900px) */
        @media (max-width: 900px) {
            body {
                overflow-x: hidden;
            }
            
            .menu-icon {
                display: flex !important;
                position: fixed;
                top: 12px;
                left: 12px;
                width: 44px;
                height: 44px;
                padding: 0;
                border: 2px solid #e5e7eb;
                background: white;
                border-radius: 8px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.15);
                cursor: pointer;
                z-index: 1001;
                align-items: center;
                justify-content: center;
                font-size: 22px;
                color: #38b6ff;
            }
            
            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                width: 0;
                height: 100vh;
                background: white;
                overflow-x: hidden;
                overflow-y: auto;
                transition: width 0.3s ease;
                z-index: 1000;
                box-shadow: 2px 0 10px rgba(0,0,0,0.15);
                padding-top: 0;
                border-right: 1px solid #eaeaea;
            }
            
            .sidebar.open {
                width: 240px;
            }

            .sidebar-logo { display: none; position: sticky; top: 0; left: 0; width: 100%; padding: 12px 12px 0; background: white; justify-content: flex-end; }
            .sidebar.open .sidebar-logo { display: flex; }
            .sidebar-logo img { width: 95px; height: auto; }
            
            .main-panel {
                margin-left: 0 !important;
                transition: margin-left 0.3s ease;
                width: 100%;
            }
            
            .main-panel.shifted {
                margin-left: 240px;
            }
            
            main {
                padding: 1rem;
                min-width: 0;
                min-height: 0;
            }
            
            h1 {
                font-size: 22px;
                margin-bottom: 1rem;
            }
            
            .card {
                padding: 1.5rem;
                border-radius: 1rem;
            }
            
            .form-group {
                margin-bottom: 1rem;
            }
            
            input {
                font-size: 14px;
                padding: 0.75rem;
            }
            
            label {
                font-size: 14px;
            }
            
            .topbar {
                padding: 0.75rem 1rem;
                height: auto;
                min-height: 56px;
            }
            
            .profile .meta span {
                font-size: 14px;
            }
            
            .profile .meta .role {
                font-size: 12px;
            }
            
            .profile-avatar {
                width: 36px;
                height: 36px;
            }
            
            button.submit-btn {
                width: 100%;
                padding: 0.75rem 2rem;
                font-size: 14px;
            }
            
            .profile-pic, .profile-placeholder {
                width: 100px;
                height: 100px;
            }
        }

        /* Small mobile (max-width: 480px) */
        @media (max-width: 480px) {
            .menu-icon {
                top: 10px;
                left: 10px;
                width: 40px;
                height: 40px;
                font-size: 20px;
            }

            .sidebar-logo img { width: 85px; height: auto; }
            
            .sidebar.open {
                width: 220px;
            }

            .main-panel.shifted {
                margin-left: 0;
            }
            
            main {
                padding: 0.75rem;
            }
            
            h1 {
                font-size: 18px;
            }
            
            .card {
                padding: 1rem;
            }
            
            .form-group {
                margin-bottom: 0.75rem;
            }
            
            input {
                font-size: 13px;
                padding: 0.6rem;
            }
            
            label {
                font-size: 13px;
            }
            
            .topbar {
                padding: 0.5rem;
            }
            
            .profile {
                gap: 0.5rem;
            }
            
            .profile-avatar {
                width: 32px;
                height: 32px;
            }
            
            button.submit-btn {
                padding: 0.6rem 1.5rem;
                font-size: 13px;
            }
            
            .profile-pic, .profile-placeholder {
                width: 80px;
                height: 80px;
            }
            
            .file-label {
                padding: 0.4rem 1rem;
                font-size: 13px;
            }
            
            div[style*="display:flex"] {
                flex-direction: column !important;
                align-items: flex-start !important;
            }
            
            div[style*="text-align:right"] {
                text-align: left !important;
                margin-top: 1rem;
            }
        }

        /* Main Panel */
        .main-panel { flex: 1 1 0; display: flex; flex-direction: column; height: 100vh; min-height: 0; min-width: 0; }
        .topbar {
            width: 100%;
            background: #fff;
            border-bottom: 1px solid #eaeaea;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 10;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .profile { display: flex; align-items: center; gap: 0.8rem; }
        .profile-avatar {
            width: 42px; height: 42px; border-radius: 50%;
            background: #ececec; overflow: hidden;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 1px 6px rgba(51,51,63,0.08);
        }
        .profile-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .profile .meta { text-align: right; }
        .profile .meta span { display: block; line-height: 1.3; font-weight: 700; color: #232323; }
        .profile .meta .role { font-weight: 400; color: #4a4a4a; font-size: 0.9rem; }

        /* Main Content */
        main { flex: 1; padding: 2rem; background: #fff; overflow-y: auto; min-height: 0; min-width: 0; }
        h1 { font-size: 28px; font-weight: 700; text-transform: uppercase; text-align: center; margin-bottom: 2rem; }

        .card {
            background: #fff;
            border-radius: 2rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 2rem;
            border: 4px solid var(--lime);
            margin-bottom: 2rem;
        }

        .form-group { margin-bottom: 1.5rem; }
        label { display: block; font-weight: 900; margin-bottom: 0.5rem; }
        input {
            width: 100%;
            padding: 1rem;
            font-size: 1rem;
            font-family: 'Montserrat', sans-serif;
            border: 3px solid var(--lime);
            border-radius: 0.5rem;
        }

        .profile-pic, .profile-placeholder {
            width: 128px; height: 128px; border-radius: 9999px; border: 3px solid var(--lime);
            object-fit: cover;
            display: flex; align-items: center; justify-content: center;
            background-color: #e5e7eb;
        }
        .profile-placeholder svg { width: 64px; height: 64px; color: #6b7280; }

        .file-label {
            cursor: pointer;
            display: inline-block;
            background:#c7da30;
            color: #000;
            font-weight: 900;
            border-radius: 9999px;
            padding: 0.5rem 1.5rem;
            user-select: none;
            margin-top: 0.5rem;
        }

button.submit-btn {
    border: 4px solid #c7da30;
    border-radius: 100px;
    color: #000;
    font-weight: 900;
    padding: 0.75rem 5rem;
    font-size: 1rem;
    cursor: pointer;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 1rem;
    transition: transform 0.2s ease, opacity 0.2s ease;
}


        .alert-success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 0.75rem 1.25rem;
            border-radius: 0.375rem;
            margin-bottom: 1.5rem;
        }
        .alert-error {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1.5rem;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/provincial-admin-mobile.css') }}">
</head>
<body class="pa-app">
    <button class="menu-icon" id="sidebarToggle" aria-label="Toggle menu" type="button">&#9776;</button>

<aside class="sidebar" id="provincialSidebar">
      <div class="sidebar-logo">
        <img src="{{ asset('images/logo.png') }}" alt="Tekete SafeSpace">
      </div>
    <ul class="sidebar-list">
        <a href="{{ url('/provincial-admin/dashboard') }}" class="sidebar-link {{ request()->is('provincial-admin/dashboard') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ url('/provincial-admin/reports') }}" class="sidebar-link {{ request()->is('provincial-admin/reports') ? 'active' : '' }}">Reports</a>
        <a href="{{ url('/provincial-admin/settings') }}" class="sidebar-link {{ request()->is('provincial-admin/settings') ? 'active' : '' }}">My Profile</a>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="sidebar-link">Sign Out</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
    </ul>
</aside>

<div class="sidebar-overlay" id="sidebarOverlay" aria-hidden="true"></div>

    <!-- Main dashboard (topbar + scrollable dashboard) -->
    <div class="main-panel">
        <div class="topbar">
            <div class="profile">
                <div class="meta">
                    <span>{{ auth()->user()->name ?? 'Administrator' }}</span>
                    <span class="role">Administrator</span>
                </div>
                <div class="profile-avatar">
                    @php $currentUser = auth()->user()->fresh(); @endphp
                    @if($currentUser && $currentUser->profile_picture)
                        <img src="{{ $currentUser->profile_picture_url }}" alt="Profile Picture" class="profile-pic">
                    @endif
                </div>
            </div>
        </div>

    <main>
        <h1>MY PROFILE</h1>

        @if(session('success_message'))
            <div class="alert-success">{{ session('success_message') }}</div>
        @endif

        @if($errors->any())
            <div class="alert-error">
                <ul style="margin:0; padding-left:1.25rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <form method="POST" action="{{ route('provincial-admin.settings.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem; flex-wrap: wrap; gap: 1rem;">
                    <div style="display:flex; gap:1.5rem; align-items:center; flex-wrap: wrap;">
                        <div>
                            <img id="profile-picture-preview" 
                                 @if($user->profile_picture)
                                     src="{{ $user->profile_picture_url }}"
                                 @else
                                     src=""
                                     style="display:none;"
                                 @endif
                                 class="profile-pic" 
                                 alt="Profile Picture">
                            <div id="profile-picture-placeholder" class="profile-placeholder" @if($user->profile_picture) style="display:none;" @endif>
                                <svg fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                        <div style="display:flex; flex-direction:column;">
                            <p style="margin-bottom:0.75rem; font-weight:900;">Update Profile Picture</p>
                            <label class="file-label">
                                Choose File
                                <input type="file" name="profile_picture" id="profile-picture-input" accept="image/*" style="display:none;">
                            </label>
                            @error('profile_picture')
                                <p style="color:#dc2626; font-size:0.875rem;">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div style="text-align:right; flex: 1; min-width: 150px;">
                        <h2 style="font-size:1.5rem; font-weight:900; margin:0;">{{ $user->name }}</h2>
                        <p style="color:#4b5563; margin:0;">Administrator</p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" placeholder="Enter your full name">
                    @error('name')
                        <p style="color:#dc2626; font-size:0.875rem;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input id="email" name="email" type="email" value="{{ $user->email }}" readonly>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input id="phone_number" name="phone_number" type="text" value="{{ old('phone', $user->phone_number ?  $user->phone_number : '') }}" placeholder="0821234567">
                    @error('phone')
                        <p style="color:#dc2626; font-size:0.875rem;">{{ $message }}</p>
                    @enderror
                </div>

                <h3 style="font-size:1.5rem; font-weight:900; text-align:center; margin-bottom:1.5rem;">Update Password</h3>

                <div class="form-group">
                    <label for="current_password">Old Password</label>
                    <input id="current_password" name="current_password" type="password">
                    @error('current_password')
                        <p style="color:#dc2626; font-size:0.875rem;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input id="new_password" name="new_password" type="password">
                    @error('new_password')
                        <p style="color:#dc2626; font-size:0.875rem;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="new_password_confirmation">Confirm Password</label>
                    <input id="new_password_confirmation" name="new_password_confirmation" type="password">
                    @error('new_password_confirmation')
                        <p style="color:#dc2626; font-size:0.875rem;">{{ $message }}</p>
                    @enderror
                </div>

                <div style="display:flex; justify-content:center;">
                    <button type="submit" class="submit-btn">Update</button>
                </div>
            </form>
        </div>
    </main>
    </div>

<script src="https://kit.fontawesome.com/2c36e9b7b9.js" crossorigin="anonymous"></script>

@include('components.provincial-admin-sidebar-script')

<script>
   // Profile picture preview functionality
    const profilePictureInput = document.getElementById('profile-picture-input');
    const profilePicturePreview = document.getElementById('profile-picture-preview');
    const profilePicturePlaceholder = document.getElementById('profile-picture-placeholder');

    if (profilePictureInput && profilePicturePreview && profilePicturePlaceholder) {
        profilePictureInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profilePicturePreview.src = e.target.result;
                    profilePicturePreview.style.display = 'block';
                    profilePicturePlaceholder.style.display = 'none';
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // South African phone number validation
    function validateSAPhoneNumber(phoneNumber) {
        // Remove all spaces, dashes, and other non-digit characters
        const cleaned = phoneNumber.replace(/\D/g, '');
        
        // South African phone numbers are 10 digits starting with 0
        // Format: 0XX XXX XXXX
        // Valid prefixes: 010-019 (Johannesburg), 02X (various), 03X-09X (various)
        // Mobile: 06X, 07X, 08X
        
        if (cleaned.length !== 10) {
            return {
                valid: false,
                message: 'Phone number must be 10 digits (e.g., 0821234567)'
            };
        }
        
        if (!cleaned.startsWith('0')) {
            return {
                valid: false,
                message: 'South African phone numbers must start with 0'
            };
        }
        
        // Check for valid second digit (1-8 are common in SA)
        const secondDigit = cleaned.charAt(1);
        if (!['1', '2', '3', '4', '5', '6', '7', '8'].includes(secondDigit)) {
            return {
                valid: false,
                message: 'Invalid South African phone number format'
            };
        }
        
        return { valid: true, message: '' };
    }

    // Form validation on submit
    const form = document.querySelector('form');
    const phoneInput = document.getElementById('phone');
    
    if (form && phoneInput) {
        form.addEventListener('submit', function(e) {
            const phoneValue = phoneInput.value.trim();
            
            // Only validate if phone number is provided
            if (phoneValue) {
                const validation = validateSAPhoneNumber(phoneValue);
                
                if (!validation.valid) {
                    e.preventDefault();
                    
                    // Remove any existing error message
                    const existingError = phoneInput.parentElement.querySelector('.phone-error');
                    if (existingError) {
                        existingError.remove();
                    }
                    
                    // Add error message
                    const errorMsg = document.createElement('p');
                    errorMsg.className = 'phone-error';
                    errorMsg.style.color = '#dc2626';
                    errorMsg.style.fontSize = '0.875rem';
                    errorMsg.style.marginTop = '0.25rem';
                    errorMsg.textContent = validation.message;
                    phoneInput.parentElement.appendChild(errorMsg);
                    
                    // Scroll to phone input
                    phoneInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    phoneInput.focus();
                }
            }
        });
        
        // Remove error message when user starts typing
        phoneInput.addEventListener('input', function() {
            const existingError = phoneInput.parentElement.querySelector('.phone-error');
            if (existingError) {
                existingError.remove();
            }
        });
    }
</script>

</body>
</html>

