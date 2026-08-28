{{-- Shared National Admin Sidebar — Dashboard, Reports, Heat-map, Settings --}}
@php
    $showExportPdf = request()->is('national-admin/dashboard', 'national-admin/heatmap');
@endphp

<aside class="sidebar national-admin-sidebar" id="na-sidebar">
    <div class="sidebar-logo">
        <img src="{{ asset('images/logo.png') }}" alt="Tekete SafeSpace">
    </div>
    <nav aria-label="National admin navigation">
        <ul class="sidebar-list">
            <li>
                <a href="{{ url('/national-admin/dashboard') }}"
                   class="sidebar-link {{ request()->is('national-admin/dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ url('/national-admin/reports') }}"
                   class="sidebar-link {{ request()->is('national-admin/reports*') ? 'active' : '' }}">
                    Reports
                </a>
            </li>
            <li>
                <a href="{{ url('/national-admin/heatmap') }}"
                   class="sidebar-link {{ request()->is('national-admin/heatmap') ? 'active' : '' }}">
                    Heat-Map
                </a>
            </li>
            <li>
                <a href="{{ url('/national-admin/settings') }}"
                   class="sidebar-link {{ request()->is('national-admin/settings') ? 'active' : '' }}">
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
