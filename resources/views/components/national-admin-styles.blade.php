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

/* Sidebar visuals live in public/css/national-admin-sidebar.css */

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

/* PDF export: expand clipped scroll areas and hide interactive chrome */
html.na-exporting,
html.na-exporting body,
html.na-exporting body.na-app {
    overflow: visible !important;
    height: auto !important;
    max-height: none !important;
    background: #fff !important;
}
html.na-exporting body.na-app .main-panel,
html.na-exporting body.na-app main,
html.na-exporting body.na-app .dashboard-scroll,
html.na-exporting body.na-app main#main-content {
    overflow: visible !important;
    overflow-x: visible !important;
    overflow-y: visible !important;
    height: auto !important;
    max-height: none !important;
    flex: 0 0 auto !important;
}
html.na-exporting #main-content {
    min-width: 1280px !important;
    width: 1280px !important;
    max-width: 1280px !important;
    background: #fff !important;
    padding-left: 1.5rem !important;
    padding-right: 1.5rem !important;
}

/* Beat mobile media queries while capturing so the PDF matches desktop */
html.na-exporting .chart-grid,
#na-pdf-capture-host .chart-grid {
    display: grid !important;
    grid-template-columns: repeat(2, 1fr) !important;
    gap: 1.5rem !important;
}
html.na-exporting .chart-monthly,
#na-pdf-capture-host .chart-monthly {
    grid-column: 1 / 2 !important;
    grid-row: 1 !important;
    width: 100% !important;
}
html.na-exporting .chart-abuse-pie,
#na-pdf-capture-host .chart-abuse-pie {
    grid-column: 2 / 3 !important;
    grid-row: 1 !important;
    width: 100% !important;
}
html.na-exporting .chart-anonymous,
#na-pdf-capture-host .chart-anonymous {
    grid-column: 1 / 2 !important;
    grid-row: 2 !important;
    width: 100% !important;
}
html.na-exporting .chart-schools,
#na-pdf-capture-host .chart-schools {
    grid-column: 2 / 3 !important;
    grid-row: 2 !important;
    width: 100% !important;
}
html.na-exporting .chart-status,
#na-pdf-capture-host .chart-status {
    grid-column: 1 / 3 !important;
    grid-row: 3 !important;
    width: 70% !important;
    justify-self: center !important;
}
html.na-exporting form.filters,
#na-pdf-capture-host form.filters {
    flex-direction: row !important;
    flex-wrap: wrap !important;
}
html.na-exporting .metrics-row > .metric-card,
#na-pdf-capture-host .metrics-row > .metric-card {
    flex: 0 0 115px !important;
    min-width: 115px !important;
    max-width: 115px !important;
}
html.na-exporting .table-wrap,
html.na-exporting .heatmap-wrap,
html.na-exporting .schools-table-wrap,
html.na-exporting .district-map-key-rows {
    overflow: visible !important;
    max-height: none !important;
}
html.na-exporting .table-wrap table {
    width: 100% !important;
    min-width: 100% !important;
    table-layout: auto !important;
}
html.na-exporting .table-wrap th,
html.na-exporting .table-wrap td {
    overflow: visible !important;
    text-overflow: clip !important;
    white-space: normal !important;
    word-break: break-word !important;
}
html.na-exporting .pagination,
html.na-exporting .heatmap-toolbar,
html.na-exporting .heatmap-view-toggle,
html.na-exporting .filter-clear,
html.na-exporting #refreshBtn,
html.na-exporting .district-map-tooltip,
html.na-exporting .menu-icon,
html.na-exporting .na-pdf-hide {
    display: none !important;
}
html.na-exporting .na-pdf-canvas-snapshot,
html.na-exporting .na-pdf-svg-snapshot,
#na-pdf-capture-host .na-pdf-canvas-snapshot,
#na-pdf-capture-host .na-pdf-svg-snapshot {
    display: block !important;
    max-width: 100%;
}

#na-pdf-capture-host {
    position: fixed;
    left: 0;
    top: 0;
    width: 1280px;
    padding: 24px 28px;
    background: #fff;
    z-index: 99990;
    box-sizing: border-box;
    overflow: visible;
    pointer-events: none;
}
#na-pdf-capture-host .pagination,
#na-pdf-capture-host .heatmap-toolbar,
#na-pdf-capture-host .heatmap-view-toggle,
#na-pdf-capture-host .filter-clear,
#na-pdf-capture-host #refreshBtn,
#na-pdf-capture-host .district-map-tooltip,
#na-pdf-capture-host .menu-icon,
#na-pdf-capture-host .na-pdf-hide {
    display: none !important;
}
#na-pdf-capture-host .table-wrap,
#na-pdf-capture-host .heatmap-wrap,
#na-pdf-capture-host .schools-table-wrap,
#na-pdf-capture-host .district-map-key-rows {
    overflow: visible !important;
    max-height: none !important;
}

#na-pdf-overlay {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 99999;
    align-items: center;
    justify-content: center;
    background: rgba(37, 63, 88, 0.45);
    pointer-events: all;
}
#na-pdf-overlay.is-visible {
    display: flex;
}
.na-pdf-overlay-card {
    background: #fff;
    border: 3px solid #c7da30;
    border-radius: 12px;
    padding: 1.25rem 1.75rem;
    min-width: 260px;
    text-align: center;
    font-family: 'Montserrat', sans-serif;
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.18);
}
.na-pdf-overlay-card strong {
    display: block;
    color: #38b6ff;
    font-size: 18px;
    font-weight: 800;
    margin-bottom: 0.35rem;
}
.na-pdf-overlay-card span {
    display: block;
    color: #545454;
    font-size: 14px;
    font-weight: 600;
}
body.na-pdf-busy {
    cursor: wait;
}
</style>
<link rel="stylesheet" href="{{ asset('css/national-admin-sidebar.css') }}">
