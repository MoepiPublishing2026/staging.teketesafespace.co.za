{{-- Shared National Admin sidebar styles — include in <head> on Dashboard, Reports, Heat-map, Settings --}}
<style>
.sidebar {
    width: 235px;
    background-color: white;
    border-right: 1px solid #eaeaea;
    display: flex;
    flex-direction: column;
    padding-top: 120px;
    flex-shrink: 0;
}
.sidebar-logo { position: fixed; top: 40px; left: 40px; width: 100px; height: auto; z-index: 1001; }
.sidebar-logo img { width: 115px; height: auto; display: block; }
.sidebar-list { list-style: none; padding: 0 0 0 22px; margin: 0; }
.sidebar-list li { list-style: none; margin: 0; padding: 0; }
.sidebar-link {
    display: block;
    width: 92%;
    font-size: 15px !important;
    font-weight: 900 !important;
    color: #545454 !important;
    font-family: 'Montserrat', sans-serif !important;
    padding: 11px 18px;
    margin-bottom: 17px;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.25s ease;
}
.sidebar-link:hover, .sidebar-link.active {
    background: linear-gradient(to right, #38b6ff, #38b6ff);
    color: #fff !important;
}
.menu-icon {
    display: none;
    position: fixed;
    top: 12px; left: 12px;
    width: 44px; height: 44px;
    padding: 0;
    border: 2px solid #e5e7eb;
    background: white !important;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    cursor: pointer;
    z-index: 1002;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    color: #38b6ff !important;
}
.menu-icon:hover { background: #f3f4f6 !important; border-color: #38b6ff !important; }
.sidebar-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(0,0,0,0.3); z-index: 999;
    opacity: 0; transition: opacity 0.2s ease;
}
.sidebar-overlay.active { display: block; opacity: 1; }
@media (min-width: 901px) { .sidebar-overlay { display: none !important; } }

/* Seamless topbar — flush with page content (no bar/border/shadow) */
body.na-app .topbar {
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
body.na-app .profile {
    display: flex !important;
    align-items: flex-start !important;
    gap: 12px !important;
}
body.na-app .profile .meta {
    text-align: right !important;
    padding-top: 4px !important;
    line-height: 1.08 !important;
}
body.na-app .profile .meta .role {
    margin-top: 2px !important;
}
body.na-app .profile-avatar {
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
body.na-app .main-panel {
    background: #fff !important;
    overflow: hidden !important;
}
body.na-app main,
body.na-app .dashboard-scroll {
    background: #fff !important;
    padding-top: 3px !important;
}
@media (max-width: 900px) {
    body.na-app .topbar {
        height: 60px !important;
        flex-basis: 60px !important;
        padding: 10px 16px 0 60px !important;
        box-shadow: none !important;
        border: 0 !important;
    }
}
</style>
<link rel="stylesheet" href="{{ asset('css/national-admin-sidebar.css') }}">
