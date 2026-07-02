{{-- Shared Provincial Admin sidebar styles — include last in <head> on Dashboard, Reports, Heat-map, Settings --}}
<link rel="stylesheet" href="{{ asset('css/provincial-admin-sidebar.css') }}">
<link rel="stylesheet" href="{{ asset('css/provincial-admin-mobile.css') }}">
<style>
/* Inline block loads after linked CSS so these rules always win */
body.pa-app #pa-sidebar.provincial-admin-sidebar,
body.pa-app .provincial-admin-sidebar.sidebar {
    width: 235px !important;
    background-color: #ffffff !important;
    border-right: 1px solid #eaeaea;
    display: flex;
    flex-direction: column;
    padding-top: 120px;
    flex-shrink: 0;
}
body.pa-app #pa-sidebar .sidebar-logo {
    position: fixed;
    top: 40px;
    left: 40px;
    width: 100px;
    height: auto;
    z-index: 1001;
}
body.pa-app #pa-sidebar .sidebar-logo img {
    width: 115px;
    height: auto;
    display: block;
}
body.pa-app #pa-sidebar .sidebar-list {
    list-style: none;
    padding: 0 0 0 22px;
    margin: 0;
}
body.pa-app #pa-sidebar .sidebar-list li {
    list-style: none;
    margin: 0;
    padding: 0;
}
body.pa-app #pa-sidebar .sidebar-link,
body.pa-app .provincial-admin-sidebar .sidebar-link {
    display: block !important;
    width: 92% !important;
    font-size: 15px !important;
    font-weight: 900 !important;
    color: #545454 !important;
    font-family: 'Montserrat', sans-serif !important;
    padding: 11px 18px !important;
    margin-bottom: 17px !important;
    border-radius: 8px !important;
    text-decoration: none !important;
    transition: all 0.25s ease;
    box-sizing: border-box;
    background: transparent !important;
}
body.pa-app #pa-sidebar .sidebar-link:hover,
body.pa-app #pa-sidebar .sidebar-link.active,
body.pa-app .provincial-admin-sidebar .sidebar-link:hover,
body.pa-app .provincial-admin-sidebar .sidebar-link.active {
    color: #ffffff !important;
    background: linear-gradient(to right, #38b6ff, #38b6ff) !important;
}
body.pa-app .menu-icon {
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
body.pa-app .menu-icon:hover {
    background: #f3f4f6 !important;
    border-color: #38b6ff !important;
}
body.pa-app .sidebar-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.3);
    z-index: 999;
    opacity: 0;
    transition: opacity 0.2s ease;
}
body.pa-app .sidebar-overlay.active {
    display: block;
    opacity: 1;
}
@media (min-width: 901px) {
    body.pa-app .sidebar-overlay { display: none !important; }
}
@media (max-width: 900px) {
    body.pa-app .menu-icon { display: flex !important; }
}
</style>
