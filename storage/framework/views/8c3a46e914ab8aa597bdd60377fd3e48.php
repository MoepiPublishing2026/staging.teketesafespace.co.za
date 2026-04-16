
<script>
document.addEventListener('DOMContentLoaded', function() {
    var toggle = document.getElementById('sidebarToggle');
    var sidebar = document.getElementById('schoolAdminSidebar');
    var overlay = document.getElementById('sidebarOverlay');
    var mainPanel = document.querySelector('.main-panel');

    function setSidebarOpen(open) {
        if (!sidebar || !mainPanel) return;
        sidebar.classList.toggle('open', open);
        mainPanel.classList.toggle('shifted', open);
        if (overlay) {
            overlay.classList.toggle('active', open);
            overlay.setAttribute('aria-hidden', open ? 'false' : 'true');
        }
        document.body.classList.toggle('sa-sidebar-open', open);
        if (toggle) {
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        }
    }

    function toggleSidebar() {
        if (!sidebar) return;
        setSidebarOpen(!sidebar.classList.contains('open'));
    }

    if (toggle) toggle.addEventListener('click', toggleSidebar);
    if (overlay) overlay.addEventListener('click', function() { setSidebarOpen(false); });

    window.addEventListener('resize', function() {
        if (window.innerWidth > 900 && sidebar && sidebar.classList.contains('open')) {
            setSidebarOpen(false);
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key !== 'Escape' || !sidebar || !sidebar.classList.contains('open')) return;
        var reportModal = document.getElementById('reportModal');
        if (reportModal && reportModal.style.display === 'flex') return;
        e.preventDefault();
        setSidebarOpen(false);
    });
});
</script>
<?php /**PATH C:\xampp\htdocs\staging.teketesafespace.co.za\resources\views/components/school-admin-sidebar-script.blade.php ENDPATH**/ ?>