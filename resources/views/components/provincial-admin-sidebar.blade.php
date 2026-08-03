{{-- Shared Provincial Admin Sidebar — Dashboard, Reports, Heat-map, Settings --}}
@php
    $currentRoute = request()->route()?->getName() ?? '';
    $isDashboard = $currentRoute === 'provincial.admin.dashboard';
    $isReports = in_array($currentRoute, ['provincial-admin.reports', 'provincial-admin.reports.show'], true);
    $isHeatmap = $currentRoute === 'provincial.heatmap';
    $isSettings = $currentRoute === 'provincial-admin.settings';
    $showExportPdf = $isDashboard || $isReports || $isHeatmap;
@endphp

@once
<style>
/* Loaded with sidebar in <body> so page-level head CSS cannot override link colors */
body.pa-app aside#pa-sidebar.provincial-admin-sidebar {
    position: relative !important;
    width: 185px !important;
    min-width: 185px !important;
    height: 100vh !important;
    background-color: #ffffff !important;
    border-right: 3px solid #d7d7d7 !important;
    display: flex !important;
    flex-direction: column !important;
    padding-top: 151px !important;
    flex-shrink: 0 !important;
}
body.pa-app aside#pa-sidebar .sidebar-logo {
    position: absolute !important;
    top: 46px !important;
    left: 28px !important;
    width: 140px !important;
    height: auto !important;
    z-index: 1001 !important;
}
body.pa-app aside#pa-sidebar .sidebar-logo img {
    width: 140px !important;
    height: auto !important;
    display: block !important;
}
body.pa-app aside#pa-sidebar .sidebar-list {
    list-style: none !important;
    padding: 0 0 0 28px !important;
    margin: 0 !important;
}
body.pa-app aside#pa-sidebar .sidebar-list li {
    list-style: none !important;
    margin: 0 !important;
    padding: 0 !important;
}
body.pa-app aside#pa-sidebar nav a.sidebar-link {
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
    transition: all 0.25s ease !important;
    box-sizing: border-box !important;
    background: transparent !important;
    -webkit-text-fill-color: #545454 !important;
}
body.pa-app aside#pa-sidebar nav a.sidebar-link:visited {
    color: #545454 !important;
    -webkit-text-fill-color: #545454 !important;
}
body.pa-app aside#pa-sidebar nav a.sidebar-link:hover,
body.pa-app aside#pa-sidebar nav a.sidebar-link.active {
    color: #ffffff !important;
    -webkit-text-fill-color: #ffffff !important;
    background: linear-gradient(to right, #38b6ff, #38b6ff) !important;
    font-weight: 400 !important;
}
@media (max-width: 900px) {
    body.pa-app aside#pa-sidebar.provincial-admin-sidebar {
        position: fixed !important;
        width: min(300px, 88vw) !important;
        min-width: min(300px, 88vw) !important;
        padding-top: max(0.75rem, env(safe-area-inset-top, 0px)) !important;
        border-right: 1px solid rgba(226, 232, 240, 0.95) !important;
    }

    body.pa-app aside#pa-sidebar .sidebar-logo {
        display: none !important;
        position: sticky !important;
        top: 0 !important;
        left: auto !important;
        width: 100% !important;
        padding: 12px 12px 0 !important;
        justify-content: flex-end !important;
    }

    body.pa-app aside#pa-sidebar.open .sidebar-logo {
        display: flex !important;
    }

    body.pa-app aside#pa-sidebar .sidebar-logo img {
        width: 95px !important;
    }

    body.pa-app aside#pa-sidebar nav a.sidebar-link {
        width: 92% !important;
        min-height: 0 !important;
        padding: 0.85rem 18px !important;
        margin-bottom: 0.35rem !important;
        border-radius: 10px !important;
    }
}
</style>
@endonce

<aside class="sidebar provincial-admin-sidebar" id="pa-sidebar">
    <div class="sidebar-logo">
        <img src="{{ asset('images/logo.png') }}" alt="Tekete SafeSpace">
    </div>
    <nav aria-label="Provincial admin navigation">
        <ul class="sidebar-list">
            <li>
                <a href="{{ url('/provincial-admin/dashboard') }}"
                   class="sidebar-link{{ $isDashboard ? ' active' : '' }}">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ url('/provincial-admin/reports') }}"
                   class="sidebar-link{{ $isReports ? ' active' : '' }}">
                    Reports
                </a>
            </li>
            <li>
                <a href="{{ url('/provincial/heatmap') }}"
                   class="sidebar-link{{ $isHeatmap ? ' active' : '' }}">
                    Heat-map
                </a>
            </li>
            <li>
                <a href="{{ url('/provincial-admin/settings') }}"
                   class="sidebar-link{{ $isSettings ? ' active' : '' }}">
                    My Profile
                </a>
            </li>
            @if ($showExportPdf)
                <li>
                    <a href="#"
                       class="sidebar-link"
                       onclick="event.preventDefault(); if (typeof exportPDF === 'function') exportPDF();">
                        Export PDF
                    </a>
                </li>
            @endif
            <li>
                <a href="{{ route('logout') }}"
                   class="sidebar-link"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Sign Out
                </a>
            </li>
        </ul>
    </nav>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" hidden>@csrf</form>
</aside>

<div class="sidebar-overlay" id="sidebarOverlay" aria-hidden="true"></div>
