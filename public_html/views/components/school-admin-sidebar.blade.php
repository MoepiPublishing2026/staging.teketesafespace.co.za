{{-- Shared School Admin Sidebar - Use across Dashboard, Reports, False Reports, Settings --}}
<aside class="sidebar school-admin-sidebar" id="schoolAdminSidebar">
    <div class="sidebar-logo">
        <img src="{{ asset('images/logo.png') }}" alt="Safe Space Logo" style="width: 150px; height: auto;"></div>
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
<button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle menu" type="button">
    <svg class="toggle-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
</button>
<div class="sidebar-overlay" id="sidebarOverlay" aria-hidden="true"></div>
