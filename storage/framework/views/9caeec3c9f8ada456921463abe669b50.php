<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>National Admin Settings</title>
   
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
        body { font-family: 'Montserrat', sans-serif; color: var(--gray-dark); background: white; display: flex; min-height: 100vh; }
        a { text-decoration: none; }
        h2,h3 { font-family: 'Poppins', sans-serif; color: #000; margin-bottom: 1rem; }

        /* Sidebar */
        .sidebar {
    width: 240px;
    background-color: white;
    border-right: 1px solid #eaeaea;
    display: flex;
    flex-direction: column;
    padding-top: 140px;
    position: sticky;
    top: 0;
    height: 100vh;
    overflow-y: auto;
    z-index: 100;
    flex-shrink: 0;
}
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
        .sidebar-list { list-style: none; padding-left: 22px; }
        .sidebar-link {
            display: block;
            width: 92%;
            padding: 11px 18px;
            margin-bottom: 17px;
            font-size: 15px;
            font-weight: 900;
            color: #222;
            border-radius: 8px;
            transition: all 0.25s ease;
        }
        .sidebar-link:hover,
.sidebar-link.active {
    background: var(--theme-gradient);
    color: white;
}

        button{
            margin: 10px;
            display: block;
            padding: 0.75rem 1rem;
            margin-bottom: 0.5rem;
            text-decoration: none;
            color: #222;
            font-weight: 400;
            border-radius: 0.5rem;
            transition: background 0.2s, color 0.2s;
            border:#c7da30;
            background: none;
            font-size: 16px;
            padding-right: 110px;
        }

        button.active,
        button:hover {
            background: white;
            color: white;
        }

        /* Hide menu icon on desktop */
        .menu-icon {
            display: none;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }

        .overlay.active {
            display: block;
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
                display: block;
                position: fixed;
                top: 15px;
                left: 15px;
                font-size: 28px;
                cursor: pointer;
                z-index: 1001;
                background: rgba(255, 255, 255, 0.9);
                padding: 8px 12px;
                border-radius: 4px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.15);
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
                padding-top: 60px;
                border-right: 1px solid #eaeaea;
            }
            
            .sidebar.open {
                width: 240px;
            }
            
            .main-panel {
                margin-left: 0 !important;
                transition: margin-left 0.3s ease;
                width: 100%;
            }
            
            .main-panel.shifted {
                margin-left: 0;
            }
            
            main {
                padding: 1rem;
                overflow-x: auto;
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
                font-size: 24px;
                padding: 6px 10px;
            }
            
            .sidebar.open {
                width: 220px;
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
        .main-panel { flex: 1; display: flex; flex-direction: column; min-height: 100vh; }
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
            box-shadow: 0 4px 10px rgba(199,218,48,0.25);
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
        main { flex: 1; padding: 2rem; background: #fff; overflow-y: auto; }
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
    color: #38b6ff;
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
</head>
<body>
    <div class="menu-icon">&#9776;</div>
    <div class="overlay"></div>

<aside class="sidebar">
      <div style="position: fixed; top: 40px; left: 40px; width: 100px; height: auto;">
        <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Safe Space Logo" style="width: 150px; height: auto;"></div>
    <ul class="sidebar-list">
        <a href="<?php echo e(url('/national-admin/dashboard')); ?>" class="sidebar-link <?php echo e(request()->is('national-admin/dashboard') ? 'active' : ''); ?>">Dashboard</a>
        <a href="<?php echo e(url('/national-admin/reports')); ?>" class="sidebar-link <?php echo e(request()->is('national-admin/reports') ? 'active' : ''); ?>">Reports</a>
        <a href="<?php echo e(url('/national-admin/settings')); ?>" class="sidebar-link <?php echo e(request()->is('national-admin/settings') ? 'active' : ''); ?>">My Profile</a>

        <!-- Sign Out as a styled form -->
        <form method="POST" action="<?php echo e(route('logout')); ?>" style="margin:0;">
            <?php echo csrf_field(); ?>
            <button type="submit">
                Sign Out
            </button>
        </form>
    </ul>
</aside>

    <!-- Main dashboard (topbar + scrollable dashboard) -->
    <div class="main-panel">
        <!-- Top bar with profile only (sticky) -->
       

    <main>
        <h1>MY PROFILE</h1>

        <?php if(session('success_message')): ?>
            <div class="alert-success"><?php echo e(session('success_message')); ?></div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="alert-error">
                <ul style="margin:0; padding-left:1.25rem;">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="card">
            <form method="POST" action="<?php echo e(route('national-admin.settings.update')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem; flex-wrap: wrap; gap: 1rem;">
                            <div style="display:flex; gap:1.5rem; align-items:center; flex-wrap: wrap;">
                                <div>
                                    <!-- Image preview (shown after upload or if picture exists) -->
                                    <img id="profile-picture-preview" 
                                         <?php if($user->profile_picture): ?>
                                            src="<?php echo e(Storage::url($user->profile_picture)); ?>"
                                         <?php else: ?>
                                             src=""
                                             style="display:none;"
                                         <?php endif; ?>
                                         class="profile-pic" 
                                         alt="Profile Picture">
                                    
                                    <!-- Placeholder (shown when no picture exists) -->
                                    <div id="profile-picture-placeholder" 
                                         class="profile-placeholder" 
                                         <?php if($user->profile_picture): ?> style="display:none;" <?php endif; ?>>
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
                                    
                                    <?php if($user->profile_picture): ?>
                                        <button type="button" onclick="deleteProfilePicture()" 
                                                style="background: #ef4444; color: white; border: none; margin-top: 0.5rem; padding: 0.5rem 1rem; border-radius: 9999px; cursor: pointer; font-weight: 600;">
                                            Delete Picture
                                        </button>
                                    <?php endif; ?>
                                    
                                    <?php $__errorArgs = ['profile_picture'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p style="color:#dc2626; font-size:0.875rem;"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        
                            <div style="text-align:right; flex: 1; min-width: 150px;">
                                <h2 style="font-size:1.5rem; font-weight:900; margin:0;"><?php echo e($user->name); ?></h2>
                                <p style="color:#4b5563; margin:0;">Administrator</p>
                            </div>
                        </div>    
           
                    <!--<div style="text-align:right; flex: 1; min-width: 150px;">-->
                    <!--    <h2 style="font-size:1.5rem; font-weight:900; margin:0;"><?php echo e($user->name); ?></h2>-->
                    <!--    <p style="color:#4b5563; margin:0;">Administrator</p>-->
                    <!--</div>-->
                </div>

                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input id="name" name="name" type="text" value="<?php echo e(old('name', $user->name)); ?>" placeholder="Enter your full name">
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p style="color:#dc2626; font-size:0.875rem;"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input id="email" name="email" type="email" value="<?php echo e($user->email); ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input id="phone_number" name="phone_number" type="text" value="<?php echo e(old('phone', $user->phone_number ?  $user->phone_number : '')); ?>" placeholder="0821234567">
                    <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p style="color:#dc2626; font-size:0.875rem;"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <h3 style="font-size:1.5rem; font-weight:900; text-align:center; margin-bottom:1.5rem;">Update Password</h3>

                <div class="form-group">
                    <label for="current_password">Old Password</label>
                    <input id="current_password" name="current_password" type="password">
                    <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p style="color:#dc2626; font-size:0.875rem;"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input id="new_password" name="new_password" type="password">
                    <?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p style="color:#dc2626; font-size:0.875rem;"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label for="new_password_confirmation">Confirm Password</label>
                    <input id="new_password_confirmation" name="new_password_confirmation" type="password">
                    <?php $__errorArgs = ['new_password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p style="color:#dc2626; font-size:0.875rem;"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div style="display:flex; justify-content:center;">
                    <button type="submit" class="submit-btn">Update</button>
                </div>
            </form>
        </div>
    </main>
    </div>

<script src="https://kit.fontawesome.com/2c36e9b7b9.js" crossorigin="anonymous"></script>

<script>
    // Mobile menu toggle
    const menuIcon = document.querySelector('.menu-icon');
    const sidebar = document.querySelector('.sidebar');
    const mainPanel = document.querySelector('.main-panel');
    const overlay = document.querySelector('.overlay');

    if (menuIcon && sidebar && mainPanel && overlay) {
        function openMenu() {
            sidebar.classList.add('open');
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        
        function closeMenu() {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }
        
        menuIcon.addEventListener('click', () => {
            if (sidebar.classList.contains('open')) {
                closeMenu();
            } else {
                openMenu();
            }
        });
        
        overlay.addEventListener('click', closeMenu);
        
        // Close menu when clicking sidebar links on mobile
        const sidebarLinks = sidebar.querySelectorAll('.sidebar-link');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 900) {
                    closeMenu();
                }
            });
        });
        
        // Close menu when clicking logout button on mobile
        const logoutButton = sidebar.querySelector('button[type="submit"]');
        if (logoutButton) {
            logoutButton.addEventListener('click', () => {
                if (window.innerWidth <= 900) {
                    closeMenu();
                }
            });
        }
    }

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
            fetch('<?php echo e(route("national-admin.settings.delete-picture")); ?>', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
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
</script>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\staging.teketesafespace.co.za\resources\views/national-admin-settings/index.blade.php ENDPATH**/ ?>