<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>False Reports Analysis | Tekete SafeSpace</title>
    <x-favicon />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400&display=swap" rel="stylesheet">
    <style>
       :root {
   --theme-gradient: linear-gradient(to right, #38b6ff, #38b6ff);
   --theme-dark: #0c8cb3ff;
   --red: #ef4444;
   --yellow: #eab308;
   --blue: #3b82f6;
   --orange: #f97316;
   --gray: #2a2e32;
   --green: #22c55e;
   --bg: white;
   --text: #253f58ff;
   --sidebar-bg: white;
   --sidebar-hover: var(--theme-gradient);
   --sidebar-active: linear-gradient(to right, #38b6ff, #38b6ff);
   --sidebar-border: #c7da30;
}

* {
    box-sizing: border-box;
}

html, body {
  font-family: 'Montserrat', sans-serif !important;
  color: #545454 !important;
}

html {
    overflow-x: hidden;
}

body {
    display: flex;
    min-height: 100vh;
    width: 100%;
    max-width: 100vw;
    overflow: hidden;
}

.sidebar {
    width: 235px;
    background-color: white;
    border-right: 1px solid #eaeaea;
    display: flex;
    flex-direction: column;
    padding-top: 120px;
}

.sidebar-list {
    list-style: none;
    padding: 0 0 0 22px;
}

.sidebar-link {
    display: block;
    width: 92%;
  font-size: 15px !important;
  font-weight: 600 !important;
  color: #545454 !important;
  font-family: 'Montserrat', sans-serif !important;
    padding: 11px 18px;
    margin-bottom: 17px;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.25s ease;
}

.sidebar-link:hover,
.sidebar-link.active {
    background: var(--theme-gradient);
    color: #000;
}

.main-panel {
    flex: 1 1 0;
    display: flex;
    flex-direction: column;
    min-width: 0;
    max-width: calc(100vw - 235px);
    height: 100vh;
    min-height: 0;
    background: white;
    overflow: hidden;
}

.topbar {
    flex-shrink: 0;
    width: 100%;
    background: white;
    border-bottom: 1px solid white;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    padding: 1rem 2.5rem;
    position: sticky;
    top: 0;
    z-index: 10;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    min-height: 64px;
}

.profile {
    display: flex;
    align-items: center;
    gap: 0.8rem;
}

.profile-avatar {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: #ececec;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 1px 6px rgba(51, 51, 63, 0.08);
}

.profile-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.profile-avatar-initial {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #9ca3af, #6b7280);
    color: white;
    font-size: 1.25rem;
    font-weight: 700;
    font-family: 'Montserrat', sans-serif;
}

button:hover, .sidebar-link:hover, .sidebar-link.active {
  color: #fff !important;
  background: linear-gradient(to right, #38b6ff, #38b6ff) !important;
}
.profile .meta {
    text-align: right;
}
.profile .meta > span:first-child {
    color: #38b6ff;
    font-size: 18px;
    font-weight: 700;
}

.profile .meta span {
    display: block;
    line-height: 1.3;
    font-weight: 700;
    color: #232323;
}

.profile .meta .role {
    font-weight: 400;
    color: #333030ff;
    font-size: 0.9rem;
}

.dashboard-scroll {
    flex: 1 1 0;
    min-width: 0;
    min-height: 0;
    overflow-y: auto;
    overflow-x: auto;
    padding: 2.5rem;
    width: 100%;
    max-width: 100%;
}

h1 {
    margin: 0 0 0.5rem;
   font-weight: 900 !important;
  font-size: 32px  !important;
   font-family: 'Montserrat', sans-serif !important;
    letter-spacing: 0.03em;
    text-transform: uppercase !important;
  color: #545454 !important;
    text-align: center;
}

h2 {
  color: #38b6ff !important;
  font-family: 'Montserrat', sans-serif;
  font-weight: 900;
  margin-top: 2rem;
  margin-bottom: 1rem;
}

.panel {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    border: 2px solid var(--sidebar-border);
    box-shadow: 0 4px 8px rgba(199, 218, 48, 0.2);
    min-width: 0;
    max-width: 100%;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
    margin-bottom: 2rem;
    align-items: stretch;
}

.stat-card {
    background: white;
    border: 2px solid var(--sidebar-border);
    border-radius: 1rem;
    padding: 1.5rem;
    text-align: center;
    box-shadow: 0 4px 8px rgba(199, 218, 48, 0.2);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 120px;
}
us
.stat-card .stat-value {
    font-size: 2.5rem;
    font-weight: 900;
    color: #38b6ff;
    margin-bottom: 0.5rem;
    line-height: 1.1;
}

.stat-card .stat-label {
    font-size: 0.9rem;
    color: #545454;
    font-weight: 600;
    line-height: 1.3;
}

.filter-tabs {
    display: flex;
    gap: 1rem;
    margin-bottom: 1.5rem;
    border-bottom: 2px solid #eaeaea;
    padding-bottom: 1rem;
}

.filter-tab {
    padding: 0.75rem 1.5rem;
    background: white;
    border: 2px solid var(--sidebar-border);
    border-radius: 0.5rem;
    cursor: pointer;
    font-weight: 700;
    color: #545454;
    transition: all 0.3s ease;
    text-decoration: none;
}

.filter-tab:hover {
    background: var(--sidebar-border);
    color: white;
}

.filter-tab.active {
    background: var(--theme-gradient);
    color: white;
    border-color: #38b6ff;
}

.pattern-group {
    margin-bottom: 2rem;
}

.pattern-header {
    background: #f3f4f6;
    padding: 1rem;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.pattern-header h3 {
    margin: 0;
    color: #38b6ff;
    font-weight: 900;
}

.pattern-count {
    background: var(--theme-gradient);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    font-weight: 700;
}

.reports-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
}

.reports-table th {
    background: linear-gradient(to right, var(--sidebar-border), #d7e47a);
    padding: 0.75rem;
    text-align: left;
    font-weight: 700;
    color: #232323;
    border-bottom: 2px solid #e5e7eb;
}

.reports-table td {
    padding: 0.75rem;
    border-bottom: 1px solid #e5e7eb;
}

.reports-table tr:hover {
    background: #f9fafb;
}

.table-wrap {
    width: 100%;
    max-width: 100%;
    overflow-x: auto;
    border-radius: 0.75rem;
    -webkit-overflow-scrolling: touch;
}

.reports-table {
    min-width: 600px;
}

.desc-cell {
    max-width: 260px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.muted {
    color: #6b7280;
}

.subtitle {
    text-align: center;
    margin-bottom: 2rem;
}

.section-desc {
    margin-bottom: 1.5rem;
}

.badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 999px;
    font-size: 0.75rem;
    font-weight: 600;
}

.badge-danger {
    background: #fee2e2;
    color: #991b1b;
}

.badge-warning {
    background: #fef3c7;
    color: #92400e;
}

.empty-state {
    text-align: center;
    padding: 3rem;
    color: #9ca3af;
}

.empty-state h3 {
    color: #9ca3af;
    margin-bottom: 0.5rem;
}

/* Tablet: 2 columns for stats, wrap filter tabs */
@media (max-width: 1024px) {
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 900px) {
    body { overflow-x: hidden; }
    .main-panel { max-width: 100%; }
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 0;
        height: 100vh;
        overflow-x: hidden;
        transition: width 0.3s ease;
        z-index: 1000;
        box-shadow: 2px 0 5px rgba(0,0,0,0.1);
    }
    .sidebar.open { width: 220px; }
    .main-panel.shifted { margin-left: 220px; }
    .filter-tabs { flex-wrap: wrap; gap: 0.5rem; }
    .filter-tab { padding: 0.5rem 1rem; font-size: 0.9rem; }
    .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 0.75rem; }
    .stat-card { min-height: 100px; padding: 1rem; }
    .stat-card .stat-value { font-size: 2rem; }
    .stat-card .stat-label { font-size: 0.85rem; }
    .dashboard-scroll { padding: 1rem; }
    h1 { font-size: 1.25rem; }
    .panel { padding: 1rem; }
    .pattern-header { flex-wrap: wrap; gap: 0.5rem; }
    .pattern-header h3 { word-break: break-word; }
}

/* Mobile: 1 column for stats, stacked filter tabs */
@media (max-width: 480px) {
    .stats-grid { grid-template-columns: 1fr; gap: 0.75rem; }
    .stat-card { min-height: 90px; padding: 1rem; }
    .stat-card .stat-value { font-size: 1.75rem; }
    .filter-tabs { flex-direction: column; align-items: stretch; }
    .filter-tab { text-align: center; }
    .topbar { padding: 0.75rem 1rem; }
    .profile .meta > span:first-child { font-size: 0.95rem; }
    .profile-avatar { width: 36px; height: 36px; }
}

/* Table horizontal scroll on small screens */
@media (max-width: 768px) {
    .table-wrap { -webkit-overflow-scrolling: touch; }
    .reports-table { min-width: 600px; font-size: 0.85rem; }
    .reports-table th, .reports-table td { padding: 0.5rem 0.5rem; }
}

    </style>
    @include('components.school-admin-styles')
    <link rel="stylesheet" href="{{ asset('css/school-admin-mobile.css') }}">
</head>
<body class="sa-app">
@include('components.school-admin-sidebar')

    <div class="main-panel">
        <div class="topbar">
            <div class="profile">
                <div class="meta">
                    <span>
                        {{ auth()->user()->name ?? 'Administrator' }}
                    </span>
                    <span class="role">
                        Administrator
                    </span>
                </div>
                <div class="profile-avatar">
                    @php
                        $currentUser = auth()->user()->fresh();
                    @endphp
                    @if($currentUser && $currentUser->profile_picture)
                        <img src="{{ $currentUser->profile_picture_url }}" alt="Profile Picture" class="profile-pic">
                    @else
                        <span class="profile-avatar-initial">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="dashboard-scroll">
            <h1>False Reports Analysis - {{ $school->school_name }}</h1>
            <p class="muted subtitle">Identify patterns and suspicious activity in false reports</p>

            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value">{{ $totalFalseReports }}</div>
                    <div class="stat-label">Total False Reports</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">{{ $totalSuspiciousEmails }}</div>
                    <div class="stat-label">Emails with 2+ False</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">{{ $totalSuspiciousNames }}</div>
                    <div class="stat-label">Names with 2+ False</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">{{ $totalSuspiciousPhones ?? 0 }}</div>
                    <div class="stat-label">Phones with 2+ False</div>
                </div>
            </div>

            <!-- Filter Tabs -->
            <div class="filter-tabs">
                <a href="{{ url('/admin/false-reports?action=all') }}" class="filter-tab {{ $actionFilter === 'all' ? 'active' : '' }}">All Reports</a>
                <a href="{{ url('/admin/false-reports?action=email') }}" class="filter-tab {{ $actionFilter === 'email' ? 'active' : '' }}">By Email</a>
                <a href="{{ url('/admin/false-reports?action=name') }}" class="filter-tab {{ $actionFilter === 'name' ? 'active' : '' }}">By Name</a>
                <a href="{{ url('/admin/false-reports?action=phone') }}" class="filter-tab {{ $actionFilter === 'phone' ? 'active' : '' }}">By Phone</a>
            </div>

            @if($actionFilter === 'email' || $actionFilter === 'all')
                @if(count($suspiciousEmails) > 0)
                    <div class="panel">
                        <h2>Suspicious Email Patterns</h2>
                        <p class="muted section-desc">Emails with multiple false reports</p>
                        
                        @foreach($suspiciousEmails as $email => $reports)
                            <div class="pattern-group">
                                <div class="pattern-header">
                                    <h3>{{ $email }}</h3>
                                    <span class="pattern-count">{{ count($reports) }} Reports</span>
                                </div>
                                <div class="table-wrap">
                                    <table class="reports-table">
                                        <thead>
                                            <tr>
                                                <th>Case Number</th>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                <th>Report Type</th>
                                                <th>Description</th>
                                                <th>Date</th>
                                                <th>Status Reason</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($reports as $report)
                                                <tr>
                                                    <td><strong>{{ $report->case_number }}</strong></td>
                                                    <td>{{ $report->full_name ?? 'N/A' }}</td>
                                                    <td>{{ $report->phone_number ?? 'N/A' }}</td>
                                                    <td>{{ $report->abuseType->type_name ?? 'N/A' }}</td>
                                                    <td class="desc-cell" title="{{ $report->description ?? '' }}">{{ \Illuminate\Support\Str::limit($report->description ?? 'N/A', 60) }}</td>
                                                    <td>{{ $report->created_at->format('Y M d') }}</td>
                                                    <td>{{ $report->latest_status_reason ?? 'N/A' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="panel">
                        <div class="empty-state">
                            <h3>No Suspicious Email Patterns Found</h3>
                            <p>All false reports have unique email addresses.</p>
                        </div>
                    </div>
                @endif
            @endif

            @if($actionFilter === 'name' || $actionFilter === 'all')
                @if(count($suspiciousNames) > 0)
                    <div class="panel">
                        <h2>Suspicious Name Patterns</h2>
                        <p class="muted section-desc">Names with multiple false reports</p>
                        
                        @foreach($suspiciousNames as $name => $reports)
                            <div class="pattern-group">
                                <div class="pattern-header">
                                    <h3>{{ ucwords($name) }}</h3>
                                    <span class="pattern-count">{{ count($reports) }} Reports</span>
                                </div>
                                <div class="table-wrap">
                                    <table class="reports-table">
                                        <thead>
                                            <tr>
                                                <th>Case Number</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Report Type</th>
                                                <th>Description</th>
                                                <th>Date</th>
                                                <th>Status Reason</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($reports as $report)
                                                <tr>
                                                    <td><strong>{{ $report->case_number }}</strong></td>
                                                    <td>{{ $report->reporter_email ?? 'N/A' }}</td>
                                                    <td>{{ $report->phone_number ?? 'N/A' }}</td>
                                                    <td>{{ $report->abuseType->type_name ?? 'N/A' }}</td>
                                                    <td class="desc-cell" title="{{ $report->description ?? '' }}">{{ \Illuminate\Support\Str::limit($report->description ?? 'N/A', 60) }}</td>
                                                    <td>{{ $report->created_at->format('Y M d') }}</td>
                                                    <td>{{ $report->latest_status_reason ?? 'N/A' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="panel">
                        <div class="empty-state">
                            <h3>No Suspicious Name Patterns Found</h3>
                            <p>All false reports have unique names.</p>
                        </div>
                    </div>
                @endif
            @endif

            @if($actionFilter === 'phone' || $actionFilter === 'all')
                @if(isset($suspiciousPhones) && count($suspiciousPhones) > 0)
                    <div class="panel">
                        <h2>Suspicious Phone Patterns</h2>
                        <p class="muted section-desc">Phone numbers with multiple false reports</p>

                        @foreach($suspiciousPhones as $phone => $reports)
                            <div class="pattern-group">
                                <div class="pattern-header">
                                    <h3>{{ $phone }}</h3>
                                    <span class="pattern-count">{{ count($reports) }} Reports</span>
                                </div>
                                <div class="table-wrap">
                                    <table class="reports-table">
                                        <thead>
                                            <tr>
                                                <th>Case Number</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Report Type</th>
                                                <th>Description</th>
                                                <th>Date</th>
                                                <th>Status Reason</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($reports as $report)
                                                <tr>
                                                    <td><strong>{{ $report->case_number }}</strong></td>
                                                    <td>{{ $report->full_name ?? 'N/A' }}</td>
                                                    <td>{{ $report->reporter_email ?? 'N/A' }}</td>
                                                    <td>{{ $report->abuseType->type_name ?? 'N/A' }}</td>
                                                    <td class="desc-cell" title="{{ $report->description ?? '' }}">{{ \Illuminate\Support\Str::limit($report->description ?? 'N/A', 60) }}</td>
                                                    <td>{{ $report->created_at->format('Y M d') }}</td>
                                                    <td>{{ $report->latest_status_reason ?? 'N/A' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="panel">
                        <div class="empty-state">
                            <h3>No Suspicious Phone Patterns Found</h3>
                            <p>All false reports have unique phone numbers.</p>
                        </div>
                    </div>
                @endif
            @endif

            @if($actionFilter === 'all')
                <div class="panel">
                    <h2>All False Reports</h2>
                    <p class="muted section-desc">Complete list of all false reports for this school</p>
                    
                    @if($falseReports->count() > 0)
                        <div class="table-wrap">
                            <table class="reports-table">
                                <thead>
                                    <tr>
                                        <th>Case Number</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Report Type</th>
                                        <th>Description</th>
                                        <th>Date</th>
                                        <th>Status Reason</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($falseReports as $report)
                                        <tr>
                                            <td><strong>{{ $report->case_number }}</strong></td>
                                            <td>{{ $report->full_name ?? 'N/A' }}</td>
                                            <td>{{ $report->reporter_email ?? 'N/A' }}</td>
                                            <td>{{ $report->phone_number ?? 'N/A' }}</td>
                                            <td>{{ $report->abuseType->type_name ?? 'N/A' }}</td>
                                            <td class="desc-cell" title="{{ $report->description ?? '' }}">{{ \Illuminate\Support\Str::limit($report->description ?? 'N/A', 60) }}</td>
                                            <td>{{ $report->created_at->format('Y M d') }}</td>
                                            <td>{{ $report->latest_status_reason ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <h3>No False Reports</h3>
                            <p>There are no false reports for this school at this time.</p>
                        </div>
                    @endif
                </div>
            @endif

        </div>
    </div>
    @include('components.school-admin-sidebar-script')
</body>
</html>
