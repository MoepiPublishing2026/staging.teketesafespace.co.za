{{-- School admin sidebar toggle — include once per page, before </body> --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    var toggle = document.getElementById('sidebarToggle') || document.querySelector('.menu-icon');
    var sidebar = document.getElementById('sa-sidebar');
    var overlay = document.getElementById('sidebarOverlay');
    var mainPanel = document.querySelector('.main-panel');

    function setSidebarOpen(open) {
        if (!sidebar || !mainPanel) return;
        sidebar.classList.toggle('open', open);
        mainPanel.classList.toggle('shifted', open);
        document.body.classList.toggle('sa-sidebar-open', open);
        if (overlay) {
            overlay.classList.toggle('active', open);
            overlay.setAttribute('aria-hidden', open ? 'false' : 'true');
        }
        if (toggle) {
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            toggle.setAttribute('aria-label', open ? 'Close navigation menu' : 'Open navigation menu');
        }
    }

    function toggleSidebar() {
        if (!sidebar) return;
        setSidebarOpen(!sidebar.classList.contains('open'));
    }

    window.toggleSidebar = toggleSidebar;

    if (toggle) toggle.addEventListener('click', toggleSidebar);
    if (overlay) overlay.addEventListener('click', function () { setSidebarOpen(false); });

    window.addEventListener('resize', function () {
        if (window.innerWidth > 900 && sidebar && sidebar.classList.contains('open')) {
            setSidebarOpen(false);
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key !== 'Escape' || !sidebar || !sidebar.classList.contains('open')) return;
        var reportModal = document.getElementById('reportModal');
        if (reportModal && reportModal.getAttribute('aria-hidden') === 'false') return;
        var statusModal = document.getElementById('statusModal');
        var extrasModal = document.getElementById('extrasModal');
        if (statusModal && statusModal.classList.contains('active')) return;
        if (extrasModal && extrasModal.classList.contains('active')) return;
        e.preventDefault();
        setSidebarOpen(false);
    }, true);

    if (sidebar) {
        sidebar.querySelectorAll('.sidebar-link').forEach(function (link) {
            link.addEventListener('click', function () {
                if (window.innerWidth <= 900 && sidebar.classList.contains('open')) {
                    setSidebarOpen(false);
                }
            });
        });
    }
});
</script>
