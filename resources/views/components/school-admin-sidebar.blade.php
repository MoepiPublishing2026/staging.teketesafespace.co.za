{{-- Shared School Admin Sidebar — Dashboard, Reports, False Reports, Settings --}}
@php
    $currentRoute = request()->route()?->getName() ?? '';
    $isDashboard = $currentRoute === 'admin.dashboard';
    $isReports = in_array($currentRoute, ['admin.reports', 'admin.reports.show'], true);
    $isFalseReports = $currentRoute === 'admin.false-reports';
    $isSettings = $currentRoute === 'admin.settings';
    $showExportPdf = $isDashboard || $isReports;
@endphp

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
