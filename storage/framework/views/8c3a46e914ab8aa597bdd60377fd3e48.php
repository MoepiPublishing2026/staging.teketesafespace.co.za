
<script>
document.addEventListener('DOMContentLoaded', function() {
    var toggle = document.getElementById('sidebarToggle');
    var sidebar = document.getElementById('schoolAdminSidebar');
    var overlay = document.getElementById('sidebarOverlay');
    var mainPanel = document.querySelector('.main-panel');

    function toggleSidebar() {
        if (!sidebar || !mainPanel) return;
        sidebar.classList.toggle('open');
        mainPanel.classList.toggle('shifted');
        if (overlay) {
            overlay.classList.toggle('active', sidebar.classList.contains('open'));
            overlay.setAttribute('aria-hidden', !sidebar.classList.contains('open'));
        }
    }

    if (toggle) toggle.addEventListener('click', toggleSidebar);
    if (overlay) overlay.addEventListener('click', toggleSidebar);

    window.addEventListener('resize', function() {
        if (window.innerWidth > 900 && sidebar && sidebar.classList.contains('open')) {
            sidebar.classList.remove('open');
            if (mainPanel) mainPanel.classList.remove('shifted');
            if (overlay) {
                overlay.classList.remove('active');
                overlay.setAttribute('aria-hidden', 'true');
            }
        }
    });
});
</script>
<?php /**PATH C:\xampp\htdocs\staging.teketesafespace.co.za\resources\views/components/school-admin-sidebar-script.blade.php ENDPATH**/ ?>