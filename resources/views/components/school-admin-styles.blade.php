{{-- Shared School Admin sidebar styles — include last in <head> on Dashboard, Reports, False Reports, Settings --}}
<link rel="stylesheet" href="{{ asset('css/school-admin-sidebar.css') }}">
<link rel="stylesheet" href="{{ asset('css/school-admin-mobile.css') }}">
<style>
/* Inline block loads after linked CSS so these rules always win */
body.sa-app #sa-sidebar.school-admin-sidebar,
body.sa-app .school-admin-sidebar.sidebar {
    width: 185px !important;
    min-width: 185px !important;
    height: 100vh;
    background-color: #ffffff !important;
    border-right: 3px solid #d7d7d7;
    display: flex;
    flex-direction: column;
    padding-top: 151px;
    flex-shrink: 0;
}
body.sa-app #sa-sidebar .sidebar-logo {
    position: absolute;
    top: 46px;
    left: 28px;
    width: 140px;
    height: auto;
    z-index: 1001;
}
body.sa-app #sa-sidebar .sidebar-logo img {
    width: 140px;
    height: auto;
    display: block;
}
body.sa-app #sa-sidebar .sidebar-list {
    list-style: none;
    padding: 0 0 0 28px;
    margin: 0;
}
body.sa-app #sa-sidebar .sidebar-list li {
    list-style: none;
    margin: 0;
    padding: 0;
}
body.sa-app #sa-sidebar .sidebar-link,
body.sa-app .school-admin-sidebar .sidebar-link {
    display: block !important;
    width: 118px !important;
    min-height: 31px !important;
    font-size: 15px !important;
    font-weight: 400 !important;
    color: #545454 !important;
    font-family: 'Montserrat', sans-serif !important;
    padding: 5px 8px !important;
    margin-bottom: 8px !important;
    border-radius: 4px !important;
    line-height: 21px !important;
    text-decoration: none !important;
    transition: all 0.25s ease;
    box-sizing: border-box;
    background: transparent !important;
    -webkit-text-fill-color: #545454 !important;
}
body.sa-app #sa-sidebar .sidebar-link:not(.active):not(:hover) {
    color: #545454 !important;
    background: transparent !important;
    font-weight: 400 !important;
    -webkit-text-fill-color: #545454 !important;
}
body.sa-app #sa-sidebar .sidebar-link:hover,
body.sa-app #sa-sidebar .sidebar-link.active {
    color: #ffffff !important;
    background: linear-gradient(to right, #38b6ff, #38b6ff) !important;
    font-weight: 400 !important;
    -webkit-text-fill-color: #ffffff !important;
}
body.sa-app .menu-icon {
    display: none;
    position: fixed;
    top: 12px;
    left: 12px;
    width: 44px;
    height: 44px;
    padding: 0;
    border: 2px solid #e5e7eb;
    background: #ffffff !important;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    cursor: pointer;
    z-index: 1002;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    color: #38b6ff !important;
}
body.sa-app .menu-icon:hover {
    background: #f3f4f6 !important;
    border-color: #38b6ff !important;
}
body.sa-app .sidebar-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.3);
    z-index: 999;
    opacity: 0;
    transition: opacity 0.2s ease;
}
body.sa-app .sidebar-overlay.active {
    display: block;
    opacity: 1;
}
@media (min-width: 901px) {
    body.sa-app #sa-sidebar.school-admin-sidebar {
        position: relative;
    }

    body.sa-app .sidebar-overlay { display: none !important; }
}
@media (max-width: 900px) {
    body.sa-app #sa-sidebar.school-admin-sidebar {
        position: fixed;
        width: min(300px, 88vw) !important;
        min-width: min(300px, 88vw) !important;
        padding-top: max(0.75rem, env(safe-area-inset-top, 0px)) !important;
    }

    body.sa-app #sa-sidebar .sidebar-link {
        width: 92% !important;
        min-height: 0 !important;
        padding: 0.85rem 18px !important;
        margin-bottom: 0.35rem !important;
        border-radius: 10px !important;
    }

    body.sa-app .menu-icon { display: flex !important; }
}

/* Seamless topbar — flush with page content (no bar/border/shadow) */
body.sa-app .topbar {
    width: 100% !important;
    height: 78px !important;
    flex: 0 0 78px !important;
    min-height: 0 !important;
    padding: 24px 39px 0 !important;
    border: 0 !important;
    background: #fff !important;
    box-shadow: none !important;
    position: relative !important;
    top: auto !important;
    display: flex !important;
    align-items: flex-start !important;
    justify-content: flex-end !important;
    z-index: 10;
}
body.sa-app .profile {
    display: flex !important;
    align-items: flex-start !important;
    gap: 12px !important;
}
body.sa-app .profile .meta {
    text-align: right !important;
    padding-top: 4px !important;
    line-height: 1.08 !important;
}
body.sa-app .profile .meta .role {
    margin-top: 2px !important;
}
body.sa-app .profile-avatar {
    width: 52px !important;
    height: 52px !important;
    flex: 0 0 52px !important;
    border-radius: 50% !important;
    background: transparent !important;
    box-shadow: none !important;
    overflow: hidden !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
}
body.sa-app .main-panel {
    background: #fff !important;
    overflow: hidden !important;
}
body.sa-app main,
body.sa-app .dashboard-scroll {
    background: #fff !important;
    padding-top: 3px !important;
}
@media (max-width: 900px) {
    body.sa-app .topbar {
        height: 60px !important;
        flex-basis: 60px !important;
        padding: 10px 16px 0 60px !important;
        box-shadow: none !important;
        border: 0 !important;
    }
}
</style>
