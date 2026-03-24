{{-- Sidebar toggle script - include once per page --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    var toggle = document.getElementById('sidebarToggle');
    var sidebar = document.getElementById('schoolAdminSidebar');
    var overlay = document.getElementById('sidebarOverlay');
    var mainPanel = document.querySelector('.main-panel');
    var scrollEl = document.scrollingElement || document.documentElement;

    function isMobile() {
        return window.innerWidth <= 900;
    }

    function openSidebar() {
        sidebar.classList.add('open');
        if (overlay) overlay.classList.add('active');
        if (isMobile()) scrollEl.style.overflow = 'hidden';
    }

    function closeSidebar() {
        sidebar.classList.remove('open');
        if (overlay) overlay.classList.remove('active');
        if (mainPanel) mainPanel.classList.remove('shifted');
        scrollEl.style.overflow = '';
    }

    function toggleSidebar() {
        if (sidebar.classList.contains('open')) {
            closeSidebar();
            return;
        }
        openSidebar();
    }

    if (toggle && sidebar) {
        toggle.addEventListener('click', function() {
            toggleSidebar();
        });
        if (overlay) {
            overlay.addEventListener('click', function() {
                closeSidebar();
            });
        }
        document.addEventListener('click', function(e) {
            if (isMobile() && sidebar.classList.contains('open') &&
                !sidebar.contains(e.target) && !toggle.contains(e.target)) {
                closeSidebar();
            }
        });
        window.addEventListener('resize', function() {
            if (!isMobile() && overlay) overlay.classList.remove('active');
            if (!isMobile()) scrollEl.style.overflow = '';
        });
    }
});
</script>
