{{-- Shared School Admin Sidebar — Dashboard, Reports, False Reports, Settings --}}
<x-admin-flash-messages />
@php
    $currentRoute = request()->route()?->getName() ?? '';
    $isDashboard = $currentRoute === 'admin.dashboard';
    $isReports = in_array($currentRoute, ['admin.reports', 'admin.reports.show'], true);
    $isFalseReports = $currentRoute === 'admin.false-reports';
    $isSettings = $currentRoute === 'admin.settings';
    $showExportPdf = $isDashboard || $isReports;
@endphp

@once
<style>
/* Loaded with sidebar in <body> so page-level head CSS cannot override link colors */
body.sa-app aside#sa-sidebar.school-admin-sidebar {
    width: 235px !important;
    background-color: #ffffff !important;
    border-right: 1px solid #eaeaea !important;
    display: flex !important;
    flex-direction: column !important;
    padding-top: 120px !important;
    flex-shrink: 0 !important;
}
body.sa-app aside#sa-sidebar .sidebar-logo {
    position: fixed !important;
    top: 40px !important;
    left: 40px !important;
    width: 100px !important;
    height: auto !important;
    z-index: 1001 !important;
}
body.sa-app aside#sa-sidebar .sidebar-logo img {
    width: 115px !important;
    height: auto !important;
    display: block !important;
}
body.sa-app aside#sa-sidebar .sidebar-list {
    list-style: none !important;
    padding: 0 0 0 22px !important;
    margin: 0 !important;
}
body.sa-app aside#sa-sidebar .sidebar-list li {
    list-style: none !important;
    margin: 0 !important;
    padding: 0 !important;
}
body.sa-app aside#sa-sidebar nav a.sidebar-link {
    display: block !important;
    width: 92% !important;
    font-size: 15px !important;
    font-weight: 600 !important;
    color: #545454 !important;
    font-family: 'Montserrat', sans-serif !important;
    padding: 11px 18px !important;
    margin-bottom: 17px !important;
    border-radius: 8px !important;
    text-decoration: none !important;
    transition: all 0.25s ease !important;
    box-sizing: border-box !important;
    background: transparent !important;
    -webkit-text-fill-color: #545454 !important;
}
body.sa-app aside#sa-sidebar nav a.sidebar-link:visited {
    color: #545454 !important;
    -webkit-text-fill-color: #545454 !important;
}
body.sa-app aside#sa-sidebar nav a.sidebar-link:hover,
body.sa-app aside#sa-sidebar nav a.sidebar-link.active {
    color: #ffffff !important;
    -webkit-text-fill-color: #ffffff !important;
    background: linear-gradient(to right, #38b6ff, #38b6ff) !important;
    font-weight: 600 !important;
}
</style>
@endonce

<aside class="sidebar school-admin-sidebar" id="sa-sidebar">
    <div class="sidebar-logo">
        <img src="{{ asset('images/logo.png') }}" alt="Tekete SafeSpace">
    </div>
    <nav aria-label="School admin navigation">
        <ul class="sidebar-list">
            <li>
                <a href="{{ url('/admin/dashboard') }}"
                   class="sidebar-link{{ $isDashboard ? ' active' : '' }}">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ url('/admin/reports') }}"
                   class="sidebar-link{{ $isReports ? ' active' : '' }}">
                    Reports
                </a>
            </li>
            <li>
                <a href="{{ url('/admin/false-reports') }}"
                   class="sidebar-link{{ $isFalseReports ? ' active' : '' }}">
                    False Reports
                </a>
            </li>
            <li>
                <a href="{{ url('/admin/settings') }}"
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
