
<style>
:root {
    --school-theme-gradient: linear-gradient(to right, #38b6ff, #38b6ff);
    --school-sidebar-border: #c7da30;
}

/* Sidebar logo positioning */
.sidebar-logo { position: fixed; top: 40px; left: 40px; width: 100px; height: auto; }
.sidebar-logo img { width: 90px; height: auto; max-width: 100%; display: block; }


.sidebar-list {
    margin-top:0px !important;
}


/* Mobile menu button */
.menu-icon {
    display: none;
    position: fixed;
    top: 12px;
    left: 12px;
    width: 44px;
    height: 44px;
    padding: 0;
    border: 2px solid #e5e7eb;
    background: white !important;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    cursor: pointer;
    z-index: 1001;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    color: #38b6ff !important;
}
.menu-icon:hover { background: #f3f4f6 !important; border-color: #38b6ff !important; }

.sidebar-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.3);
    z-index: 999;
    opacity: 0;
    transition: opacity 0.2s ease;
}
.sidebar-overlay.active { display: block; opacity: 1; }
@media (min-width: 901px) { .sidebar-overlay { display: none !important; } }

/* Responsive: Mobile sidebar */
@media (max-width: 900px) {
    .menu-icon { display: flex !important; }
    .school-admin-sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 0;
        min-width: 0;
        height: 100vh;
        overflow-x: hidden;
        overflow-y: auto;
        transition: width 0.3s ease, min-width 0.3s ease;
        z-index: 1000;
        box-shadow: 2px 0 12px rgba(0,0,0,0.15);
        padding-top: 0;
    }
    .school-admin-sidebar.open { width: 240px; min-width: 240px; }
    .main-panel.shifted { margin-left: 240px; }
    .sidebar-logo { display: none; position: sticky; top: 0; left: 0; width: 100%; padding: 12px 12px 0; background: white; justify-content: flex-end; }
    .school-admin-sidebar.open .sidebar-logo { display: flex; }
    .sidebar-logo img { width: 55px; height: auto; }
}

@media (max-width: 600px) {
    .menu-icon { top: 10px; left: 10px; width: 40px; height: 40px; font-size: 20px; }
    .school-admin-sidebar.open { width: 100%; max-width: 280px; min-width: 0; }
    .main-panel.shifted { margin-left: 0; }
    .sidebar-logo img { width: 48px; height: auto; }
}

/* Table overflow for mobile */
@media (max-width: 768px) {
    .table-wrap,
    .reports-table-wrap {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .reports-table {
        min-width: 600px;
    }
}
</style>
<?php /**PATH C:\xampp\htdocs\staging.teketesafespace.co.za\resources\views/components/school-admin-styles.blade.php ENDPATH**/ ?>