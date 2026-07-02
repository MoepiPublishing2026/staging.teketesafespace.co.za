{{-- Shared Provincial Admin Sidebar — Dashboard, Reports, Heat-map, Settings --}}
@php
    $currentRoute = request()->route()?->getName() ?? '';
    $isDashboard = $currentRoute === 'provincial.admin.dashboard';
    $isReports = in_array($currentRoute, ['provincial-admin.reports', 'provincial-admin.reports.show'], true);
    $isHeatmap = $currentRoute === 'provincial.heatmap';
    $isSettings = $currentRoute === 'provincial-admin.settings';
    $showExportPdf = $isDashboard || $isReports || $isHeatmap;
@endphp

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
