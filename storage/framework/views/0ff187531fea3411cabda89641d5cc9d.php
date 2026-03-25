
<aside class="sidebar school-admin-sidebar" id="schoolAdminSidebar">
    <div class="sidebar-logo">
        <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Safe Space Logo" style="width: 150px; height: auto;"></div>
    <ul class="sidebar-list">
        <a href="<?php echo e(url('/admin/dashboard')); ?>" class="sidebar-link <?php echo e(request()->is('admin/dashboard') ? 'active' : ''); ?>">Dashboard</a>
        <a href="<?php echo e(url('/admin/reports')); ?>" class="sidebar-link <?php echo e(request()->is('admin/reports*') ? 'active' : ''); ?>">Reports</a>
        <a href="<?php echo e(url('/admin/false-reports')); ?>" class="sidebar-link <?php echo e(request()->is('admin/false-reports*') ? 'active' : ''); ?>">False Reports</a>
        <a href="<?php echo e(url('/admin/settings')); ?>" class="sidebar-link <?php echo e(request()->is('admin/settings') ? 'active' : ''); ?>">My Profile</a>
        
            <?php if(request()->is('admin/dashboard')): ?>
                <a href="#" 
                   onclick="event.preventDefault(); if(typeof exportPDF === 'function') exportPDF();" 
                   class="sidebar-link">
                   Export PDF
                </a>
            <?php endif; ?>
        <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="sidebar-link">Sign Out</a>
        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;"><?php echo csrf_field(); ?></form>
    </ul>
</aside>
<button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle menu" type="button">
    <svg class="toggle-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
</button>
<div class="sidebar-overlay" id="sidebarOverlay" aria-hidden="true"></div>
<?php /**PATH C:\xampp\htdocs\staging.teketesafespace.co.za\resources\views/components/school-admin-sidebar.blade.php ENDPATH**/ ?>