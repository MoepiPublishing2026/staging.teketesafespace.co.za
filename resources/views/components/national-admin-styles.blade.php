{{-- Shared National Admin styles — include in <head> on Dashboard, Reports, Heat-map, Settings --}}
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<style>
/*
 * National Admin type scale (matches provincial/school)
 * xs 11 | sm 13 | base 15 | md 18 | lg 22 | xl 32
 * regular 400 | semibold 600 | bold 700 | black 900
 */
body.na-app {
    --na-font: 'Montserrat', sans-serif;
    --na-text: #545454;
    --na-text-muted: #5f6b7b;
    --na-accent: #38b6ff;
    --na-size-xs: 11px;
    --na-size-sm: 13px;
    --na-size-base: 15px;
    --na-size-md: 18px;
    --na-size-lg: 22px;
    --na-size-xl: 32px;
    --na-weight-regular: 400;
    --na-weight-semibold: 600;
    --na-weight-bold: 700;
    --na-weight-black: 900;
}

body.na-app,
body.na-app .main-panel,
body.na-app main,
body.na-app .dashboard-scroll,
body.na-app button,
body.na-app select,
body.na-app input,
body.na-app textarea,
body.na-app label,
body.na-app table,
body.na-app th,
body.na-app td,
body.na-app h1,
body.na-app h2,
body.na-app h3,
body.na-app h4,
body.na-app p,
body.na-app span,
body.na-app a,
body.na-app .subtitle {
    font-family: var(--na-font) !important;
}

body.na-app {
    font-size: var(--na-size-base) !important;
    font-weight: var(--na-weight-regular) !important;
    color: var(--na-text) !important;
    line-height: 1.5;
}

body.na-app .main-panel,
body.na-app main,
body.na-app .dashboard-scroll {
    font-size: var(--na-size-base) !important;
    font-weight: var(--na-weight-regular) !important;
    color: var(--na-text) !important;
}

body.na-app h1 {
    margin: 0 0 1.5rem !important;
    font-size: var(--na-size-xl) !important;
    font-weight: var(--na-weight-black) !important;
    letter-spacing: 0.03em !important;
    text-transform: uppercase !important;
    color: var(--na-text) !important;
    text-align: center !important;
    line-height: 1.25 !important;
}

body.na-app h2 {
    font-size: var(--na-size-md) !important;
    font-weight: var(--na-weight-bold) !important;
    color: var(--na-accent) !important;
    line-height: 1.3 !important;
}
body.na-app h3 {
    font-size: var(--na-size-base) !important;
    font-weight: var(--na-weight-bold) !important;
    color: var(--na-text) !important;
    line-height: 1.3 !important;
}

body.na-app .subtitle {
    font-size: var(--na-size-sm) !important;
    font-weight: var(--na-weight-regular) !important;
    color: var(--na-text-muted) !important;
    margin-bottom: 2rem !important;
    text-align: center;
}

body.na-app .profile .meta > span:first-child {
    color: var(--na-accent) !important;
    font-size: var(--na-size-md) !important;
    font-weight: var(--na-weight-bold) !important;
}
body.na-app .profile .meta span {
    font-size: var(--na-size-md) !important;
    font-weight: var(--na-weight-bold) !important;
    color: #232323 !important;
    line-height: 1.3 !important;
}
body.na-app .profile .meta .role {
    font-size: var(--na-size-sm) !important;
    font-weight: var(--na-weight-regular) !important;
    color: #4a4a4a !important;
}

body.na-app label {
    font-size: var(--na-size-sm) !important;
    font-weight: var(--na-weight-bold) !important;
    color: var(--na-text) !important;
}
body.na-app select,
body.na-app input,
body.na-app textarea {
    font-size: var(--na-size-base) !important;
    font-weight: var(--na-weight-regular) !important;
    font-family: var(--na-font) !important;
    color: var(--na-text) !important;
}
body.na-app button:not(.menu-icon) {
    font-size: var(--na-size-base) !important;
    font-weight: var(--na-weight-bold) !important;
    font-family: var(--na-font) !important;
}

body.na-app table {
    font-size: var(--na-size-sm) !important;
    font-weight: var(--na-weight-regular) !important;
}
body.na-app thead,
body.na-app th {
    font-size: var(--na-size-xs) !important;
    font-weight: var(--na-weight-bold) !important;
}

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
    body.na-app h1 {
        font-size: var(--na-size-lg) !important;
    }
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
