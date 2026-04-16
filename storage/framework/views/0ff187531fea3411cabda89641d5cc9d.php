
<aside class="sidebar school-admin-sidebar" id="schoolAdminSidebar">
    <div class="sidebar-logo">
        <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Tekete SafeSpace">
    </div>
    <ul class="sidebar-list">
        <a href="<?php echo e(url('/admin/dashboard')); ?>" class="sidebar-link <?php echo e(request()->is('admin/dashboard') ? 'active' : ''); ?>">Dashboard</a>
        <a href="<?php echo e(url('/admin/reports')); ?>" class="sidebar-link <?php echo e(request()->is('admin/reports*') ? 'active' : ''); ?>">Reports</a>
        <a href="<?php echo e(url('/admin/false-reports')); ?>" class="sidebar-link <?php echo e(request()->is('admin/false-reports*') ? 'active' : ''); ?>">False Reports</a>
        <a href="<?php echo e(url('/admin/settings')); ?>" class="sidebar-link <?php echo e(request()->is('admin/settings') ? 'active' : ''); ?>">My Profile</a>
        
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request()->is('admin/dashboard')): ?>
                <a href="#"
                   onclick="event.preventDefault(); if(typeof exportPDF === 'function') exportPDF();"
                   class="sidebar-link">
                   Export PDF
                </a>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="sidebar-link">Sign Out</a>
        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;"><?php echo csrf_field(); ?></form>
    </ul>
</aside>
<button class="menu-icon" id="sidebarToggle" type="button" aria-label="Toggle menu" aria-expanded="false" aria-controls="schoolAdminSidebar">&#9776;</button>
<div class="sidebar-overlay" id="sidebarOverlay" aria-hidden="true"></div>
<?php /**PATH C:\xampp\htdocs\staging.teketesafespace.co.za\resources\views/components/school-admin-sidebar.blade.php ENDPATH**/ ?>