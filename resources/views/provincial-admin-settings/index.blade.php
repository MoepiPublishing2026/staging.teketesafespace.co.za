<!DOCTYPE html>
<html lang="en" class="pa-app-root">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <title>Settings | Tekete SafeSpace – Provincial Admin</title>
    <x-favicon />
   
     <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
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
        h2,h3 { font-family: 'Montserrat', sans-serif; color: #000; margin-bottom: 1rem; }

       button:not(.menu-icon):not(.submit-btn):not(.delete-btn){
            background-color: white !important;
            color: #38b6ff !important;
            border: 2px solid #c7da30 !important;
            font-weight: 700 !important;
            font-size: 15px !important;
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

        /* Main Panel */
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

            .main-panel {
                margin-left: 0 !important;
                width: 100%;
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
                height: 60px;
                flex-basis: 60px;
                padding: 10px 16px 0 60px;
                box-shadow: none;
                border: 0;
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
    background-color: #f5f5f5 !important;
    color: #4aa3df !important;
    border: 3px solid #c7da30 !important;

    border-radius: 999px !important; /* FULL pill shape */
    padding: 0.75rem 4rem !important;

    font-weight: 900;
    font-size: 1rem;
    cursor: pointer;

    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    transition: all 0.2s ease;
}
            
            .profile-pic, .profile-placeholder {
                width: 100px;
                height: 100px;
            }
        }
.delete-btn {
    background-color: #ef4444 !important; /* red */
    color: #fff !important;
    border: none !important;

    border-radius: 999px; /* pill shape */
    padding: 0.5rem 1.5rem;
    margin-top: 0.5rem;

    font-weight: 900;
    cursor: pointer;

    transition: background-color 0.2s ease;
}

.delete-btn:hover {
    background-color: #dc2626 !important; /* darker red */
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
                height: 60px;
                flex-basis: 60px;
                padding: 10px 16px 0 60px;
                box-shadow: none;
                border: 0;
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
        .main-panel { flex: 1 1 0; display: flex; flex-direction: column; height: 100vh; min-height: 0; min-width: 0; background: #fff; overflow: hidden; }
        .topbar {
            width: 100%;
            background: #fff;
            border: 0;
            display: flex;
            justify-content: flex-end;
            align-items: flex-start;
            padding: 24px 39px 0;
            position: relative;
            z-index: 10;
            box-shadow: none;
            height: 78px;
            flex: 0 0 78px;
            min-height: 0;
        }
        .profile { display: flex; align-items: flex-start; gap: 12px; }
        .profile-avatar {
            width: 52px; height: 52px; flex: 0 0 52px; border-radius: 50%;
            background: transparent; overflow: hidden;
            display: flex; align-items: center; justify-content: center;
            box-shadow: none;
        }
        .profile-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .profile .meta { text-align: right; padding-top: 4px; line-height: 1.08; }
        .profile .meta > span:first-child { color: #38b6ff; font-size: 18px; font-weight: 700; }
        .profile .meta span { display: block; line-height: 1.3; font-weight: 700; color: #232323; }
        .profile .meta .role { margin-top: 2px; font-weight: 400; color: #4a4a4a; font-size: 13px; }

        /* Main Content */
        main { flex: 1; padding: 3px 2rem 2rem; background: #fff; overflow-y: auto; min-height: 0; min-width: 0; }
        h1 {
            font-size: 32px;
            font-weight: 900;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            text-align: center;
            margin-bottom: 1.5rem;
            color: #545454;
        }

        .card {
            background: #fff;
            border-radius: 2rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 2rem;
            border: 4px solid var(--lime);
            margin-bottom: 2rem;
        }

        .form-group { margin-bottom: 1.5rem; }
        label { display: block; font-size: 13px; font-weight: 700; margin-bottom: 0.5rem; color: #545454; }
        input {
            width: 100%;
            padding: 1rem;
            font-size: 15px;
            font-weight: 400;
            font-family: 'Montserrat', sans-serif;
            color: #545454;
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
            font-size: 15px;
            font-weight: 700;
            border-radius: 9999px;
            padding: 0.5rem 1.5rem;
            user-select: none;
            margin-top: 0.5rem;
        }

button.submit-btn {
    border: 4px solid #c7da30;
    border-radius: 100px;
    color: #38b6ff !important;
    font-weight: 700;
    padding: 0.75rem 5rem;
    font-size: 15px;
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
    <x-provincial-admin-styles />
</head>
<body class="pa-app">

<x-provincial-admin-sidebar />

    <!-- Main dashboard (topbar + scrollable dashboard) -->
    <div class="main-panel">
        <button class="menu-icon" id="sidebarToggle" aria-label="Open navigation menu" aria-expanded="false" aria-controls="pa-sidebar" type="button">&#9776;</button>
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
                            <p style="margin-bottom:0.75rem; font-size:15px; font-weight:700; color:#545454;">Update Profile Picture</p>
                            <label class="file-label">
                                 Choose File
                                        <input type="file" name="profile_picture" id="profile-picture-input" accept="image/*" style="display:none;">
                                    </label>
                                    
                                    @if($user->profile_picture)
                                        <button type="button" onclick="deleteProfilePicture()" class="delete-btn">
    Delete Picture
</button>
                                    @endif
                                    
                                    @error('profile_picture')
                                        <p style="color:#dc2626; font-size:13px;">{{ $message }}</p>
                                    @enderror
                        </div>
                    </div>

                    <div style="text-align:right; flex: 1; min-width: 150px;">
                        <h2 style="margin:0;">{{ $user->name }}</h2>
                        <p style="color:#4b5563; margin:0; font-size:13px;">Administrator</p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input id="name" name="name" 
                    pattern="[A-Za-z ]+"
                    title="Only letters and spaces are allowed"
                    type="text" value="{{ old('name', $user->name) }}" 
                    placeholder="Enter your full name">
                    @error('name')
                        <p style="color:#dc2626; font-size:13px;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input id="email" name="email" type="email" value="{{ $user->email }}" readonly>
                </div>

                <div class="form-group">
    <label for="phone_number">Phone Number</label>

    <input
        id="phone_number"
        name="phone_number"
        type="text"
        value="{{ old('phone_number', $user->phone_number ?? '') }}"
        placeholder="0821234567"
        pattern="[0-9]{10}"
        title="Only 10 numbers are allowed"
        inputmode="numeric"
        required
    >

    @error('phone_number')
        <p style="color:#dc2626; font-size:13px;">{{ $message }}</p>
    @enderror
</div>

                <h3 style="text-align:center; margin-bottom:1.5rem;">Update Password</h3>

                <div class="form-group">
                    <label for="current_password">Old Password</label>
                    <input id="current_password" name="current_password" type="password">
                    @error('current_password')
                        <p style="color:#dc2626; font-size:13px;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input id="new_password" name="new_password" type="password">
                    @error('new_password')
                        <p style="color:#dc2626; font-size:13px;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="new_password_confirmation">Confirm Password</label>
                    <input id="new_password_confirmation" name="new_password_confirmation" type="password">
                    @error('new_password_confirmation')
                        <p style="color:#dc2626; font-size:13px;">{{ $message }}</p>
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

<x-provincial-admin-sidebar-script />

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
    
    // Delete profile picture function
    function deleteProfilePicture() {
        if (confirm('Are you sure you want to delete your profile picture?')) {
            fetch('{{ route("national-admin.settings.delete-picture") }}', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Failed to delete profile picture');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while deleting the profile picture');
            });
        }
    }
</script>

</body>
</html>

