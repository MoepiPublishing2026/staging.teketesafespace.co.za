{{-- Shared Provincial Admin sidebar styles — include last in <head> on Dashboard, Reports, Heat-map, Settings --}}
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/provincial-admin-sidebar.css') }}">
<link rel="stylesheet" href="{{ asset('css/provincial-admin-mobile.css') }}">
<style>
/*
 * Provincial Admin type scale (sidebar = source of truth for base)
 * xs 11 | sm 13 | base 15 | md 18 | lg 22 | xl 32
 * regular 400 | semibold 600 | bold 700 | black 900
 */
body.pa-app {
    --pa-font: 'Montserrat', sans-serif;
    --pa-text: #545454;
    --pa-text-muted: #5f6b7b;
    --pa-accent: #38b6ff;
    --pa-size-xs: 11px;
    --pa-size-sm: 13px;
    --pa-size-base: 15px;
    --pa-size-md: 18px;
    --pa-size-lg: 22px;
    --pa-size-xl: 32px;
    --pa-weight-regular: 400;
    --pa-weight-semibold: 600;
    --pa-weight-bold: 700;
    --pa-weight-black: 900;
}

body.pa-app,
body.pa-app .main-panel,
body.pa-app main,
body.pa-app .dashboard-scroll,
body.pa-app button,
body.pa-app select,
body.pa-app input,
body.pa-app textarea,
body.pa-app label,
body.pa-app table,
body.pa-app th,
body.pa-app td,
body.pa-app h1,
body.pa-app h2,
body.pa-app h3,
body.pa-app h4,
body.pa-app p,
body.pa-app span,
body.pa-app a,
body.pa-app .subtitle {
    font-family: var(--pa-font) !important;
}

body.pa-app {
    font-size: var(--pa-size-base) !important;
    font-weight: var(--pa-weight-regular) !important;
    color: var(--pa-text) !important;
    line-height: 1.5;
}

body.pa-app .main-panel,
body.pa-app main,
body.pa-app .dashboard-scroll {
    font-size: var(--pa-size-base) !important;
    font-weight: var(--pa-weight-regular) !important;
    color: var(--pa-text) !important;
}

/* Page title */
body.pa-app h1 {
    margin: 0 0 1.5rem !important;
    font-size: var(--pa-size-xl) !important;
    font-weight: var(--pa-weight-black) !important;
    letter-spacing: 0.03em !important;
    text-transform: uppercase !important;
    color: var(--pa-text) !important;
    text-align: center !important;
    line-height: 1.25 !important;
}

/* Section headings */
body.pa-app h2 {
    font-size: var(--pa-size-md) !important;
    font-weight: var(--pa-weight-bold) !important;
    color: var(--pa-accent) !important;
    line-height: 1.3 !important;
}
body.pa-app h3 {
    font-size: var(--pa-size-base) !important;
    font-weight: var(--pa-weight-bold) !important;
    color: var(--pa-text) !important;
    line-height: 1.3 !important;
}

body.pa-app .subtitle {
    font-size: var(--pa-size-sm) !important;
    font-weight: var(--pa-weight-regular) !important;
    color: var(--pa-text-muted) !important;
    margin-bottom: 2rem !important;
    text-align: center;
}

/* Chrome: profile, form controls, buttons */
body.pa-app .profile .meta > span:first-child {
    color: var(--pa-accent) !important;
    font-size: var(--pa-size-md) !important;
    font-weight: var(--pa-weight-bold) !important;
}
body.pa-app .profile .meta span {
    font-size: var(--pa-size-md) !important;
    font-weight: var(--pa-weight-bold) !important;
    color: #232323 !important;
    line-height: 1.3 !important;
}
body.pa-app .profile .meta .role {
    font-size: var(--pa-size-sm) !important;
    font-weight: var(--pa-weight-regular) !important;
    color: #4a4a4a !important;
}

/* Seamless topbar — flush with page content (no bar/border/shadow) */
body.pa-app .topbar {
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
body.pa-app .profile {
    display: flex !important;
    align-items: flex-start !important;
    gap: 12px !important;
}
body.pa-app .profile .meta {
    text-align: right !important;
    padding-top: 4px !important;
    line-height: 1.08 !important;
}
body.pa-app .profile .meta .role {
    margin-top: 2px !important;
}
body.pa-app .profile-avatar {
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
body.pa-app .main-panel {
    background: #fff !important;
    overflow: hidden !important;
}
body.pa-app main,
body.pa-app .dashboard-scroll {
    background: #fff !important;
    padding-top: 3px !important;
}

body.pa-app label {
    font-size: var(--pa-size-sm) !important;
    font-weight: var(--pa-weight-bold) !important;
    color: var(--pa-text) !important;
}
body.pa-app select,
body.pa-app input,
body.pa-app textarea {
    font-size: var(--pa-size-base) !important;
    font-weight: var(--pa-weight-regular) !important;
    font-family: var(--pa-font) !important;
    color: var(--pa-text) !important;
}
body.pa-app button:not(.menu-icon) {
    font-size: var(--pa-size-base) !important;
    font-weight: var(--pa-weight-bold) !important;
    font-family: var(--pa-font) !important;
}

body.pa-app table {
    font-size: var(--pa-size-sm) !important;
    font-weight: var(--pa-weight-regular) !important;
}
body.pa-app thead,
body.pa-app th {
    font-size: var(--pa-size-xs) !important;
    font-weight: var(--pa-weight-bold) !important;
}

@media (max-width: 900px) {
    body.pa-app h1 {
        font-size: var(--pa-size-lg) !important;
    }
    body.pa-app .topbar {
        height: 60px !important;
        flex-basis: 60px !important;
        padding: 10px 16px 0 60px !important;
        box-shadow: none !important;
        border: 0 !important;
    }
}

/* Inline block loads after linked CSS so these rules always win */
body.pa-app #pa-sidebar.provincial-admin-sidebar,
body.pa-app .provincial-admin-sidebar.sidebar {
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
body.pa-app #pa-sidebar .sidebar-logo {
    position: absolute;
    top: 46px;
    left: 28px;
    width: 140px;
    height: auto;
    z-index: 1001;
}
body.pa-app #pa-sidebar .sidebar-logo img {
    width: 140px;
    height: auto;
    display: block;
}
body.pa-app #pa-sidebar .sidebar-list {
    list-style: none;
    padding: 0 0 0 28px;
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
body.pa-app #pa-sidebar .sidebar-link:not(.active):not(:hover) {
    color: #545454 !important;
    background: transparent !important;
    font-weight: 400 !important;
    -webkit-text-fill-color: #545454 !important;
}
body.pa-app #pa-sidebar .sidebar-link:hover,
body.pa-app #pa-sidebar .sidebar-link.active,
body.pa-app .provincial-admin-sidebar .sidebar-link:hover,
body.pa-app .provincial-admin-sidebar .sidebar-link.active {
    color: #ffffff !important;
    background: linear-gradient(to right, #38b6ff, #38b6ff) !important;
    font-weight: 400 !important;
    -webkit-text-fill-color: #ffffff !important;
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
    body.pa-app #pa-sidebar.provincial-admin-sidebar {
        position: relative;
    }

    body.pa-app .sidebar-overlay { display: none !important; }
}
@media (max-width: 900px) {
    body.pa-app #pa-sidebar.provincial-admin-sidebar {
        position: fixed;
        width: min(300px, 88vw) !important;
        min-width: min(300px, 88vw) !important;
        padding-top: max(0.75rem, env(safe-area-inset-top, 0px)) !important;
    }

    body.pa-app #pa-sidebar .sidebar-link {
        width: 92% !important;
        min-height: 0 !important;
        padding: 0.85rem 18px !important;
        margin-bottom: 0.35rem !important;
        border-radius: 10px !important;
    }

    body.pa-app .menu-icon { display: flex !important; }
}
</style>
