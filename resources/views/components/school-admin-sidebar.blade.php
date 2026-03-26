{{-- Shared School Admin Sidebar - Use across Dashboard, Reports, False Reports, Settings --}}
<aside class="sidebar school-admin-sidebar" id="schoolAdminSidebar">
    <div class="sidebar-logo">
        <img src="{{ asset('images/logo.png') }}" alt="Safe Space Logo">
    </div>
    <ul class="sidebar-list">
        <a href="{{ url('/admin/dashboard') }}" class="sidebar-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ url('/admin/reports') }}" class="sidebar-link {{ request()->is('admin/reports*') ? 'active' : '' }}">Reports</a>
        <a href="{{ url('/admin/false-reports') }}" class="sidebar-link {{ request()->is('admin/false-reports*') ? 'active' : '' }}">False Reports</a>
        <a href="{{ url('/admin/settings') }}" class="sidebar-link {{ request()->is('admin/settings') ? 'active' : '' }}">My Profile</a>
        {{-- Show Export PDF only on Dashboard --}}
            @if(request()->is('admin/dashboard'))
                <a href="#" 
                   onclick="event.preventDefault(); if(typeof exportPDF === 'function') exportPDF();" 
                   class="sidebar-link">
                   Export PDF
                </a>
            @endif
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="sidebar-link">Sign Out</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
    </ul>
</aside>
<button class="menu-icon" id="sidebarToggle" aria-label="Toggle menu" type="button">&#9776;</button>
<div class="sidebar-overlay" id="sidebarOverlay" aria-hidden="true"></div>
