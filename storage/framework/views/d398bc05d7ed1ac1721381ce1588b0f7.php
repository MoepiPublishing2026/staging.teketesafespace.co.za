
<style>
:root {
    --school-theme-gradient: linear-gradient(to right, #38b6ff, #38b6ff);
    --school-sidebar-border: #c7da30;
}

/* Sidebar logo positioning */
.sidebar-logo {
    position: absolute;
    top: 18px;
    left: 22px;
    height: auto;
    z-index: 1;
}

 /*from the data dic*/
/*1. width: 431.8px*/
/*2. height: 227.1px*/
.sidebar-logo img {
    margin-top: 0;
    width: 180px;
    height: auto;
}

.sidebar.school-admin-sidebar {
    position: relative;
    overflow-x: hidden;
}


.sidebar-list {
    margin-top:0px !important;
}


/* Sidebar toggle - hidden on desktop */
.sidebar-toggle {
    display: none;
    position: fixed;
    top: 15px;
    left: 15px;
    width: 44px;
    height: 44px;
    background: white;
    border: 2px solid var(--school-sidebar-border);
    border-radius: 8px;
    cursor: pointer;
    z-index: 1002;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
.sidebar-toggle .toggle-icon {
    width: 24px;
    height: 24px;
}

.sidebar-overlay {
    display: none;
}

.main-panel.shifted {
    margin-left: 0 !important;
}

.school-admin-sidebar.open {
    position: fixed;
    top: 0;
    left: 0;
    width: 220px;
    min-width: 220px;
    height: 100vh;
    z-index: 1000;
}

.sidebar-overlay.active {
    display: block;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.35);
    z-index: 999;
}

/* Responsive: Mobile sidebar */
@media (max-width: 900px) {
    .sidebar-toggle {
        display: flex;
    }
    .school-admin-sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 0;
        min-width: 0;
        height: 100vh;
        overflow-x: hidden;
        transition: width 0.3s ease, min-width 0.3s ease;
        z-index: 1000;
        box-shadow: 2px 0 12px rgba(0,0,0,0.15);
    }
    .school-admin-sidebar .sidebar-logo {
        left: auto;
        right: 16px;
        top: 16px;
    }
    .school-admin-sidebar .sidebar-logo img {
        width: 120px;
    }
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
<?php /**PATH /home/teketeq9v8o0/staging.teketesafespace.co.za/resources/views/components/school-admin-styles.blade.php ENDPATH**/ ?>