<!DOCTYPE html>
<html lang="en" class="sa-app-root">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Tekete SafeSpace School Admin Dashboard</title>
    <x-favicon />
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

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

body {
    display: flex;
    min-height: 100vh;
    min-height: 100dvh;
    width: 100%;
    max-width: 100%;
    overflow: hidden;
}

button {
 background-color: white !important;
  color: #38b6ff !important;
  border: 2px solid #c7da30 !important;
  font-weight: 600 !important;
  font-family: 'Montserrat', sans-serif !important;
  padding: 0.75rem 1rem !important;
  border-radius: 0.5rem !important;
  cursor: pointer !important;
  transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
}

button:hover, button:focus {
  background-color: #c7da30 !important;
  color: white !important;
  border-color: #38b6ff !important;
  outline: none;
}

.topbar {
    width: 100%;
    background: #fff;
    border: 0;
    display: flex;
    align-items: flex-start;
    justify-content: flex-end;
    padding: 24px 39px 0;
    position: relative;
    z-index: 10;
    box-shadow: none;
    height: 78px;
    flex: 0 0 78px;
    min-height: 0;
}

.profile {
    display: flex;
    align-items: flex-start;
    gap: 12px;
}

.profile-avatar {
    width: 52px;
    height: 52px;
    flex: 0 0 52px;
    border-radius: 50%;
    background: transparent;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: none;
}
.charts-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);  /* 2 equal columns */
  grid-template-rows: auto auto auto;     /* 3 rows */
  gap: 20px;
  width: 100%;
}

/* Chart cards: Status Breakdown pattern — flex column, title + host + canvas fills host */
.charts-grid > .chart-card {
    width: 100%;
    height: auto;
    min-width: 0;
    background: white;
    padding: 20px;
    border-radius: 12px;
    display: flex;
    flex-direction: column;
    min-height: 320px;
}

.chart-top-abuse     { grid-column: 1 / 2; grid-row: 1; }
.chart-monthly       { grid-column: 2 / 3; grid-row: 1; }
.chart-anonymous     { grid-column: 1 / 2; grid-row: 2; }
.chart-abuse-pie     { grid-column: 2 / 3; grid-row: 2; }

.chart-card.chart-abuse-pie {
    min-height: 370px;
}
.chart-abuse-pie .chart-canvas-host,
.chart-top-abuse .chart-canvas-host,
.chart-monthly .chart-canvas-host,
.chart-anonymous .chart-canvas-host {
    position: relative;
    width: 100%;
    flex: 1 1 auto;
    min-height: 280px;
}

.charts-grid .chart-canvas-host canvas,
.charts-grid .chart-status-host canvas {
    display: block;
    width: 100% !important;
    height: 100% !important;
    min-height: 0 !important;
}

.chart-status {
  grid-column: 1 / 3;
  grid-row: 4;
  width: 70%;
  justify-self: center;
  min-height: 320px;
}
.chart-status .chart-status-host {
  position: relative;
  width: 100%;
  flex: 1 1 auto;
  min-height: 280px;
}

.profile-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.profile .meta {
    text-align: right;
    padding-top: 4px;
    line-height: 1.08;
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
    margin-top: 2px;
    font-weight: 400;
    color: #4a4a4a;
    font-size: 13px;
}

 .main-panel {
     flex: 1 1 0;
     display: flex;
     flex-direction: column;
     min-width: 0;
     height: 100vh;
     background: #fff;
     overflow: hidden;
 }

.metrics-row > .metric-card {
    flex: 0 0 100px; /* fixed width */
    max-width: 115px;
    min-width: 115px; /* prevent shrinking smaller */
}

.dashboard-scroll {
    flex: 1 1 0;
    overflow-y: auto;
    overflow-x: hidden;
    padding: 3px 2.5rem 2.5rem;
    max-width: 1280px;
    margin: 0 auto;
    background: #fff;
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
}
.subtitle {
    margin-bottom: 2rem;
    color: #5f6b7b;
}

.metrics-row, .extras-row {
    display: flex;
    gap: 1.2rem;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
}

.metric-card {
    flex: 1;
    background: #fff;
    border-radius: 1rem;
    justify-content: flex-start;
    align-items: center;
    text-align: center;
    padding: 12px 15px;
    min-width: 110px;
    height: 110px;
    display: flex;
    flex-direction: column;
    cursor: pointer;
    transition: background .18s, color .15s;
    position: relative;
}

.metric-card.active,
.metric-card:active {
    /*color: #fff !important;*/
}

.metric-card .card-value {
   font-weight: 800 !important;
  font-size: 30px !important;
  color: inherit !important;
  font-family: 'Montserrat', sans-serif !important;
    display: flex;
    justify-content: center;
    align-items: center;
    flex: 1;
    line-height: 1;
}

.card-title {
  font-weight: 900 !important;
  font-size: 14px !important;
  font-family: 'Montserrat', sans-serif !important;
    margin-bottom: 0;
    color: inherit;
    min-height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    line-height: 1.2;
}

/* Colored status cards */
.metrics-row > .metric-card.status-total {
    background-color: #38b6ff;
    color: white;
}

.metrics-row > .metric-card.status-awaiting {
    background-color: #fcb825;
    color: white;
}

.metrics-row > .metric-card.status-forwarded {
    background-color: #64d58f;
    color: white;
}

.metrics-row > .metric-card.status-review {
    background-color: #9b57cc;
    color: white;
}

.metrics-row > .metric-card.status-closed {
    background-color: #81acef;
    color: white;
}

.metrics-row > .metric-card.status-unresolved {
    background-color: #99c4d3;
    color: white;
}

.metrics-row > .metric-card.status-false {
    background-color: #ff66c4;
    color: white;
}

/* Extras cards with white background, box shadow, and border matching Filter section */
.extras-anonymous, .extras-identified, .extras-abuse, .extras-schools {
    background: white;
    color: #1f2933;
    cursor: default;
    font-family: 'Montserrat', sans-serif;
    box-shadow: 0 4px 8px rgba(199, 218, 48, 0.2);
    border: 2px solid var(--sidebar-border);
}

.metric-card.extras-anonymous .card-value,
.metric-card.extras-identified .card-value,
.metric-card.extras-abuse .card-value,
.metric-card.extras-schools .card-value {
    font-size: 40px;
    font-weight: 800;
    margin-bottom: 0.17rem;
    color: #38b6ff !important;
    font-family: 'Montserrat', sans-serif;
    line-height: 1;
}

.card-subtext {
    font-size: 0.8rem;
    color: #080808ff;
    margin-bottom: 0.25rem;
}

/* Panel styles */
.panel {
    background: white;
    border-radius: 1rem;
    padding: 0px;
}

.panel + .panel {
    margin-top: 1.8rem;
}

.chart-title-left {
    text-align: left !important;
    margin-left: 0 !important;
    padding-left: 0 !important;
}

/* Filters panel */
section[aria-label="Filters"] {
    border: 2px solid var(--sidebar-border);
    padding: 1rem 1.5rem;
    border-radius: 1rem;
    margin-bottom: 1.5rem;
}

form.filters {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    align-items: flex-end;
}

form.filters select,
form.filters input[type="date"],
form.filters input[type="number"],
form.filters input[type="text"],
form.filters button {
    padding: 0.65rem 0.85rem;
    border-radius: 0.75rem;
    border: 2px solid #c9db41ff;
    font-weight: 600;
    background: white;
    min-width: 160px;
    box-shadow: inset 0 1px 3px rgba(92, 120, 88, 0.08);
    cursor: pointer;
}

form.filters label {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
    font-size: 14px;
    font-weight: 600;
    color: #545454;
    min-width: 160px;
}

form.filters label input[type="date"] {
    margin: 0;
}

form.filters button {
    background: linear-gradient(90deg, var(--green) 0%, var(--green-light) 100%);
    border: none;
    color: white;
}

.filter-chips {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    margin-top: 1.25rem;
}

.filter-chips span {
    background: rgba(47, 123, 52, 0.08);
    color: var(--green);
    border-radius: 999px;
    padding: 0.4rem 0.85rem;
    font-size: 0.78rem;
    font-weight: 600;
}

.grid-two {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 0.5rem;
}

.grid-three {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 1.5rem;
}

canvas {
    width: 100% !important;
    height: 100% !important;
}

.modal-backdrop {
   position: fixed;
    inset: 0;
    background: rgba(0, 12, 12, 0.42); 
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 50;
     border: 3px solid #38b6ff !important;
}

.modal-backdrop.active {
    display: flex;
}

.modal-card {
    background: #fff;
    border: 2.5px solid #d7e47a;
    border-radius: 16px;
    width: 1000px;
    max-width: 95vw;
    box-shadow: 0 6px 40px rgba(46,56,64,0.18),
                0 1.5px 3px rgba(140,160,145,0.05);
    padding: 2rem;  /* Adds space inside card for text */
    position: relative;
    font-family: 'Montserrat', sans-serif;
    color: #333;
}

.modal-card h3 {
    margin: 0 0 1.5rem;  /* Extra space below heading */
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--green-dark);
}


.modal-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    color: #ef4444;
    cursor: pointer;
}
.extras-modal-btn {
    padding: 0.5rem 1rem;
    background: #38b6ff;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    font-family: 'Montserrat', sans-serif;
}
.extras-modal-btn:hover {
    background: #0c8cb3;
}
.filter-separator {
    border: none;
    border-bottom: 2px solid silver;
    margin: 0 0 1rem 0;
}

.filters button#refreshBtn {
    
    color: white;
    border: none;
    padding: 0.65rem 0.85rem;
    border-radius: 0.75rem;
    font-weight: 600;
    cursor: pointer;
    margin-left: 0.5rem;
    transition: background-color 0.2s;
}


/* Responsive sidebar and elements */
/* Tablet breakpoint (768px - 1024px) */
@media (max-width: 1024px) {
    .metrics-row {
        flex-wrap: wrap;
        gap: 1rem;
    }
    .metric-card {
        flex: 1 1 calc(50% - 0.5rem);
        min-width: calc(50% - 0.5rem);
        max-width: calc(50% - 0.5rem);
    }
    .extras-row {
        flex-direction: column;
    }
    .extras-card {
        width: 100%;
        margin-bottom: 1rem;
    }
    .dashboard-scroll {
        padding: 1.5rem;
    }
    .chart-container {
        width: 100%;
        margin-bottom: 1.5rem;
    }
}

/* Mobile breakpoint (max-width: 900px) */
@media (max-width: 900px) {
    body {
        overflow-x: hidden;
    }
    .main-panel {
        margin-left: 0 !important;
        transition: margin-left 0.3s ease;
    }
    .main-panel.shifted {
        margin-left: 0 !important;
    }

    .metric-card {
        min-width: 100%;
        max-width: 100%;
        font-size: 16px;
        height: auto;
        padding: 15px;
    }
    form.filters {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }
    .topbar {
        height: 60px;
        flex-basis: 60px;
        padding: 10px 16px 0 60px;
        box-shadow: none;
        border: 0;
    }
    /* Title alignment: padding comes from .dashboard-scroll in school-admin-mobile.css */
    h1, .subtitle {
        text-align: left;
    }
    .charts-grid {
        grid-template-columns: 1fr;
    }
    .chart-top-abuse { grid-column: 1; grid-row: 1; }
    .chart-monthly { grid-column: 1; grid-row: 2; }
    .chart-anonymous { grid-column: 1; grid-row: 3; }
    .chart-abuse-pie { grid-column: 1; grid-row: 4; }
    .chart-status { grid-column: 1; grid-row: 5; width: 100%; }
    .charts-grid .chart-canvas-host,
    .charts-grid .chart-status-host { min-height: 220px; }
    .chart-status .chart-status-host { min-height: 240px; }
}

/* Small mobile (max-width: 480px) */
@media (max-width: 480px) {
    .menu-icon {
        font-size: 24px;
        padding: 6px 10px;
    }
    
    .metric-card {
        padding: 10px;
    }
    
    .metric-card .card-value {
        font-size: 20px;
    }
    
    .metric-card .card-title {
        font-size: 12px;
    }
    
    .dashboard-scroll {
        padding: 0.75rem;
    }
    
    .chart-container {
        height: 200px !important;
        padding: 5px;
    }
    
    h1 {
        font-size: 16px;
    }
    
    .topbar {
        padding: 0.5rem;
    }
    
    .profile {
        gap: 0.5rem;
    }
    
    .profile-avatar {
        width: 32px;
        height: 32px;
    }
}

    </style>
    <x-school-admin-styles />
</head>
<body class="sa-app">
<x-school-admin-sidebar />


    <!-- Main dashboard (topbar + scrollable dashboard) -->
    <div class="main-panel">
        <button class="menu-icon" id="sidebarToggle" aria-label="Open navigation menu" aria-expanded="false" aria-controls="sa-sidebar" type="button">&#9776;</button>
        <!-- Top bar with profile only (sticky) -->
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
                        <!-- Default gray circle, nothing inside -->
                    @endif
                </div>
            </div>
        </div>


        
        <!-- Scrollable dashboard content -->
        <div class="dashboard-scroll" id="main-content">
           <h1>
 Tekete SafeSpace School Admin Dashboard - 
  <span class="school-name">{{ $school->school_name }}</span>
</h1>

            <p class="subtitle">School case intelligence and live report monitoring.</p>
            
           <!-- Filters panel with 'Refresh Table' button and silver line -->
<section class="panel" aria-label="Filters">
    <h2>Filters</h2>
    <hr class="filter-separator"/>
    <form method="GET" action="{{ url()->current() }}" class="filters" id="filtersForm">
       <select name="abuse_type" onchange="this.form.submit()">
            <option value="">Any Reports Type</option>
            @foreach ($abuseTypes->sortBy('type_name') as $type)
                <option value="{{ $type->id }}" {{ $abuseTypeFilter == $type->id ? 'selected' : '' }}>
                    {{ $type->type_name }}
                </option>
            @endforeach
        </select>
        <div>
            <label class="filter-label">Age</label>
            <input type="number" class="filter-input" name="age_range"
                id="ageInput"
                placeholder="e.g. 14"
                min="5" max="18"
                value="{{ request('age') }}"
                oninput="syncGradeFromAge(this.value)">
        </div>

        <div>
            <label class="filter-label">Grade</label>
            <input type="hidden" id="gradeHidden" value="{{ request('grade') }}">
            <input type="text" name="grade" class="filter-input" id="gradeDisplay"
                placeholder="Auto-filled from age"
                readonly
                style="background:#f3f4f6; cursor:not-allowed; opacity:0.7;"
                value="{{ request('grade') }}">
        </div>
        <label>
            From
            <input type="date" name="date_from" value="{{ $fromDate }}" onchange="this.form.submit()">
        </label>
        <label>
            To
            <input type="date" name="date_to" value="{{ $toDate }}" onchange="this.form.submit()">
        </label>
        <button type="button" id="refreshBtn">Refresh Table</button>
    </form>

    <script>
        const ageToGrade = {
            5: 'Grade R',  6: 'Grade 1',  7: 'Grade 2',  8: 'Grade 3',
            9: 'Grade 4',  10: 'Grade 5', 11: 'Grade 6', 12: 'Grade 7',
            13: 'Grade 8', 14: 'Grade 9', 15: 'Grade 10', 16: 'Grade 11',
            17: 'Grade 12', 18: 'Grade 12'
        };

        function syncGradeFromAge(age) {
            const grade   = ageToGrade[parseInt(age)] ?? '';
            document.getElementById('gradeDisplay').value = grade;
            document.getElementById('gradeHidden').value  = grade;
        }

        // Run on page load to sync if age is already in URL
        (function() {
            const ageInput = document.getElementById('ageInput');
            if (ageInput && ageInput.value) syncGradeFromAge(ageInput.value);
        })();

    </script>

    @if(!empty($activeFilters))
        <div class="filter-chips" aria-label="Active filters">
            @foreach ($activeFilters as $chip)
                <span>{{ $chip }}</span>
            @endforeach
        </div>
    @endif
  
</section>
            
            <!-- Metrics Cards (Clickable, themed, open modal, auto-active) -->
            <section class="metrics-row" aria-label="Headline metrics">
                <div class="metric-card status-total" onclick="activateCard(this, 'total')">
                    <span class="card-title">Total Reports</span>
                    <div class="card-value">{{ number_format($summaryCounts['total'] ?? 0) }}</div>
                </div>
                <div class="metric-card status-awaiting" onclick="activateCard(this, 'awaiting-resolution')">
                    <span class="card-title">Awaiting Resolution</span>
                    <div class="card-value">{{ number_format($summaryCounts['statuses']['awaiting-resolution'] ?? 0) }}</div>
                </div>
                <div class="metric-card status-forwarded" onclick="activateCard(this, 'forwarded')">
                    <span class="card-title">Forwarded</span>
                    <div class="card-value">{{ number_format($summaryCounts['statuses']['forwarded'] ?? 0) }}</div>
                </div>
                <div class="metric-card status-review" onclick="activateCard(this, 'under-review')">
                    <span class="card-title">Under Review</span>
                    <div class="card-value">{{ number_format($summaryCounts['statuses']['under-review'] ?? 0) }}</div>
                </div>
                <div class="metric-card status-closed" onclick="activateCard(this, 'closed')">
                    <span class="card-title">Closed</span>
                    <div class="card-value">{{ number_format($summaryCounts['statuses']['closed'] ?? 0) }}</div>
                </div>
                <div class="metric-card status-unresolved" onclick="activateCard(this, 'unresolved')">
                    <span class="card-title">Unresolved</span>
                    <div class="card-value">{{ number_format($summaryCounts['statuses']['unresolved'] ?? 0) }}</div>
                </div>
                <div class="metric-card status-false" onclick="activateCard(this, 'false-report')">
                    <span class="card-title">False-Report</span>
                    <div class="card-value">{{ number_format($summaryCounts['statuses']['false-report'] ?? 0) }}</div>
                </div>
            </section>
            <section class="extras-row" aria-label="Extra metrics">
                <div class="metric-card extras-anonymous" onclick="openExtrasModal('anonymous')">
                    <span class="card-title">Anonymous</span>
                    <div class="card-value">{{ number_format($anonymousCounts['anonymous'] ?? 0) }}</div>
                </div>
                <div class="metric-card extras-identified" onclick="openExtrasModal('identified')">
                    <span class="card-title">Identified</span>
                    <div class="card-value">{{ number_format($anonymousCounts['identified'] ?? 0) }}</div>
                </div>
                <div class="metric-card extras-abuse" onclick="openExtrasModal('abuse-types')">
                    <span class="card-title">Types Of Report Tracked</span>
                    <div class="card-value">{{ count($abuseTypeLabels) }}</div>
                </div>
                <div class="metric-card extras-schools" onclick="openExtrasModal('top-types')">
                    <span class="card-title">Top Report Types</span>
                    <div class="card-value">{{ count($topAbuseTypes ?? []) }}</div>
                </div>
            </section>

            <!-- False Reports summary card: identify repeat reporters -->
            <!--@php $fr = $falseReportSummary ?? ['total' => 0, 'repeat_emails' => 0, 'repeat_names' => 0, 'repeat_phones' => 0]; @endphp-->
            <!--@if($fr['total'] > 0)-->
            <!--<section class="panel" aria-label="False Reports Summary">-->
            <!--    <h2>False Reports &amp; Repeat Reporters</h2>-->
            <!--    <p class="subtext" style="color: #6b7280; margin-bottom: 1rem;">Identify people who have submitted multiple false reports (by email, name, or phone).</p>-->
            <!--    <div class="stats-grid" style="display: flex; flex-wrap: wrap; gap: 1rem; align-items: center;">-->
            <!--        <div class="stat-card" style="min-width: 140px;">-->
            <!--            <div class="stat-value" style="font-size: 1.75rem;">{{ $fr['total'] }}</div>-->
            <!--            <div class="stat-label">Total False Reports</div>-->
            <!--        </div>-->
            <!--        <div class="stat-card" style="min-width: 140px;">-->
            <!--            <div class="stat-value" style="font-size: 1.75rem;">{{ $fr['repeat_emails'] }}</div>-->
            <!--            <div class="stat-label">Emails with 2+ false</div>-->
            <!--        </div>-->
            <!--        <div class="stat-card" style="min-width: 140px;">-->
            <!--            <div class="stat-value" style="font-size: 1.75rem;">{{ $fr['repeat_names'] }}</div>-->
            <!--            <div class="stat-label">Names with 2+ false</div>-->
            <!--        </div>-->
            <!--        <div class="stat-card" style="min-width: 140px;">-->
            <!--            <div class="stat-value" style="font-size: 1.75rem;">{{ $fr['repeat_phones'] }}</div>-->
            <!--            <div class="stat-label">Phones with 2+ false</div>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--    <p style="margin-top: 1rem;"><a href="{{ url('/admin/false-reports') }}" class="sidebar-link" style="display: inline-block; padding: 0.75rem 1.5rem;">View False Reports Analysis &rarr;</a></p>-->
            <!--</section>-->
            <!--@endif-->

          <section class="panel" aria-label="Analytics">
    @php
        $topAbuseBarCount = max(count(array_keys($topAbuseTypes ?? [])), 1);
        $topAbuseHostH = (int) max(280, min(520, 120 + $topAbuseBarCount * 36));
        $monthlyPointCount = max(count($months ?? []), 1);
        $monthlyTrendHostH = (int) max(260, min(440, 170 + $monthlyPointCount * 12));
        $anonymousHostH = (int) max(280, min(400, 300));
        $abuseTypeCount = max(count($abuseTypeLabels ?? []), 1);
        $abusePieHostHeight = max(360, min(520, 220 + $abuseTypeCount * 18));
    @endphp
    <div class="charts-grid">

        <div class="chart-card chart-top-abuse">
            <h2>Top Report Types</h2>
            <div class="chart-canvas-host" style="height: {{ $topAbuseHostH }}px;">
                <canvas id="topAbuseTypesChart"></canvas>
            </div>
        </div>

        <div class="chart-card chart-monthly">
            <h2>Monthly Trends</h2>
            <div class="chart-canvas-host" style="height: {{ $monthlyTrendHostH }}px;">
                <canvas id="monthlyTrendChart"></canvas>
            </div>
        </div>

        <div class="chart-card chart-anonymous">
            <h2>Anonymous vs Identified</h2>
            <div class="chart-canvas-host" style="height: {{ $anonymousHostH }}px;">
                <canvas id="anonymousChart"></canvas>
            </div>
        </div>

        <div class="chart-card chart-abuse-pie">
            <h2>Report Types Distribution</h2>
            <div class="chart-canvas-host" style="height: {{ $abusePieHostHeight }}px;">
                <canvas id="abuseTypeChart"></canvas>
            </div>
        </div>

        @php
            $statusBreakdownN = max(count($statusCounts ?? []), 1);
            $statusChartHostH = max(300, min(680, 110 + $statusBreakdownN * 54));
        @endphp
        <div class="chart-card chart-status">
            <h2>Status Breakdown</h2>
            <div class="chart-status-host" style="height: {{ $statusChartHostH }}px;">
                <canvas id="statusChart" aria-label="Reports by status"></canvas>
            </div>
        </div>

    </div>
</section>

        </div>
    </div>

    <!-- Modal for report details -->
    <div class="modal-backdrop" id="statusModal" aria-hidden="true" onclick="if(event.target === this) closeStatusModal();">
        <div class="modal-card">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 1rem;">
                <h3 id="statusModalTitle">Reports</h3>
                <button class="modal-close" onclick="closeStatusModal()" aria-label="Close">&times;</button>
            </div>
            <div style="overflow-x:auto; max-height: 60vh;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background-color: #f3f4f6;">
                            <th style="padding: 0.75rem; text-align: left; border-bottom: 2px solid #e5e7eb; font-weight: 600;">Case Number</th>
                            <th style="padding: 0.75rem; text-align: left; border-bottom: 2px solid #e5e7eb; font-weight: 600;">Abuse Type</th>
                            <th style="padding: 0.75rem; text-align: left; border-bottom: 2px solid #e5e7eb; font-weight: 600;">Status</th>
                            <th style="padding: 0.75rem; text-align: left; border-bottom: 2px solid #e5e7eb; font-weight: 600;">Created Date</th>
                        </tr>
                    </thead>
                    <tbody id="statusModalBody">
                        <tr>
                            <td colspan="4" style="text-align:center; padding:1.25rem;">Loading reports...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal for extras cards (Anonymous, Identified, Types Of Report Tracked, Top Report Types) -->
    <div class="modal-backdrop" id="extrasModal" aria-hidden="true" onclick="if(event.target === this) closeExtrasModal();">
        <div class="modal-card">
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <h3 id="extrasModalTitle">Details</h3>
                <button class="modal-close" onclick="closeExtrasModal()" aria-label="Close">&times;</button>
            </div>
            <div id="extrasModalBody" style="max-height: 60vh; overflow-y: auto;"></div>
        </div>
    </div>

    <!-- Chart Data -->
    <script id="dashboard-data" type="application/json">
    {!! json_encode([
        'months' => $months,
        'monthlyCounts' => $monthlyCounts,
        'abuseLabels' => $abuseTypeLabels,
        'abuseCounts' => $abuseTypeCounts,
        'abuseTypePercentages' => $abuseTypePercentages ?? [],
        'statusCounts' => $statusCounts,
        'anonymousCounts' => $anonymousCounts,
        'topAbuseTypes' => $topAbuseTypes,
        'statusReports' => $statusReportPayload,
        'allReports' => $allReportsPayload,
        'anonymousReports' => $anonymousReportsPayload ?? [],
        'identifiedReports' => $identifiedReportsPayload ?? [],
    ]) !!}
    </script>
   <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script>

        Chart.register(ChartDataLabels);

document.getElementById('refreshBtn').addEventListener('click', function () {
    const form = document.getElementById('filtersForm');
    if (!form) return;

    // Reset all select dropdowns to default option
    form.querySelectorAll('select').forEach(select => {
        select.selectedIndex = 0;
        select.disabled = false;
    });

    // Clear date, number, and text inputs
    form.querySelectorAll('input[type="date"], input[type="number"], input[type="text"]').forEach(input => {
        input.value = '';
    });

    // Submit the form to reload clean data
    form.submit();
});

    const chartRegistry = {};
let statusReportsMap = {};
let allReportsList = [];

function activateCard(el, status) {
    document.querySelectorAll('.metric-card').forEach(card => card.classList.remove('active'));
    el.classList.add('active');
    openStatusModal(status);
}

function openStatusModal(status) {
    let reports = [];
    
    if (status === 'total') {
        reports = allReportsList;
    } else if (status === 'anonymous') {
        reports = statusReportsMap['anonymous'] || [];
    } else if (status === 'identified') {
        reports = statusReportsMap['identified'] || [];
    } else if (status === 'abuse-type') {
        // For abuse types, show all reports (or you can filter if needed)
        reports = allReportsList;
    } else if (status === 'active-schools') {
        // For abuse types, show all reports (or you can filter if needed)
        reports = allReportsList;
    } else if (statusReportsMap[status]) {
        reports = statusReportsMap[status];
    }

    const tbody = document.getElementById('statusModalBody');
    const title = document.getElementById('statusModalTitle');
    tbody.innerHTML = '';

    if (!reports || reports.length === 0) {
        const emptyRow = document.createElement('tr');
        emptyRow.innerHTML = '<td colspan="4" style="text-align:center; padding:1.25rem;">No reports for this selection.</td>';
        tbody.appendChild(emptyRow);
    } else {
        reports.forEach(report => {
            const row = document.createElement('tr');
            row.style.cursor = 'pointer';
            row.style.borderBottom = '1px solid #e5e7eb';
            row.onmouseover = function() { this.style.backgroundColor = '#f9fafb'; };
            row.onmouseout = function() { this.style.backgroundColor = ''; };
            row.innerHTML = `
                <td style="padding: 0.75rem;">${report.case_number ?? 'N/A'}</td>
                <td style="padding: 0.75rem;">${report.abuse_type ?? 'N/A'}</td>
                <td style="padding: 0.75rem;">${report.status ? report.status.replace(/-/g, ' ').replace(/\b\w/g, c => c.toUpperCase()) : 'N/A'}</td>
                <td style="padding: 0.75rem;">${report.created_at ?? 'N/A'}</td>`;
            tbody.appendChild(row);
        });
    }

    // Format title based on status
    let titleText = 'Reports';
    if (status === 'total') {
        titleText = 'All Reports (' + reports.length + ')';
    } else if (status === 'anonymous') {
        titleText = 'Anonymous Reports (' + reports.length + ')';
    } else if (status === 'identified') {
        titleText = 'Identified Reports (' + reports.length + ')';
    } else if (status === 'abuse-type') {
        titleText = 'Abuse Type Reports (' + reports.length + ')';
    } else if (status === 'active-schools') {
        titleText = 'Top Abuse Types Reports (' + reports.length + ')';
    } else if (status === 'false-report') {
        titleText = 'False Reports (' + reports.length + ')';
    } else {
        titleText = status.replace(/-/g, ' ').replace(/\b\w/g, c => c.toUpperCase()) + ' Reports (' + reports.length + ')';
    }
    
    title.textContent = titleText;

    const modal = document.getElementById('statusModal');
    modal.classList.add('active');
    modal.setAttribute('aria-hidden', 'false');
}

function closeStatusModal() {
    const modal = document.getElementById('statusModal');
    modal.classList.remove('active');
    modal.setAttribute('aria-hidden', 'true');
}

function createChart(id, config) {
    const canvas = document.getElementById(id);
    if (!canvas) return;
    if (chartRegistry[id]) chartRegistry[id].destroy();
    chartRegistry[id] = new Chart(canvas.getContext('2d'), config);
}

function getValue(source, key, fallback) {
    return source && Object.prototype.hasOwnProperty.call(source, key) && source[key] != null
        ? source[key]
        : fallback;
}

/** Returns percentages that sum to exactly 100% (largest remainder method) */
function percentagesTo100(values) {
    const arr = values.map(Number);
    const total = arr.reduce((a, b) => a + b, 0);
    if (total === 0) return arr.map(() => 0);
    const raw = arr.map(v => (v / total) * 100);
    const floored = raw.map((r, i) => ({ i, floor: Math.floor(r), rem: r - Math.floor(r) }));
    let sum = floored.reduce((s, x) => s + x.floor, 0);
    const diff = 100 - sum;
    floored.sort((a, b) => b.rem - a.rem);
    for (let d = 0; d < diff; d++) floored[d].floor += 1;
    floored.sort((a, b) => a.i - b.i);
    return floored.map(x => x.floor);
}

/** Human-readable status for chart axis + tooltips */
function formatStatusLabel(slug) {
    if (slug == null || slug === '') return '';
    const key = String(slug);
    const map = {
        'awaiting-resolution': 'Awaiting Resolution',
        'under-review': 'Under Review',
        'forwarded': 'Forwarded',
        'closed': 'Closed',
        'unresolved': 'Unresolved',
        'false-report': 'False Report',
    };
    if (map[key]) return map[key];
    return key.replace(/-/g, ' ').replace(/\b\w/g, (c) => c.toUpperCase());
}

function renderOverviewCharts(dataset) {
    const isMobile = window.matchMedia('(max-width: 480px)').matches;
    const statusCtx = document.getElementById('statusChart')?.getContext('2d');
    const statusGradientColors = ['#99c4d3', '#fcb825', '#00c382', '#9b57cc', '#81acef', '#38b6ff', '#ff66c4'];
    const statusBarColors = [];
    const statusCapColors = [];
    statusGradientColors.forEach((color) => {
        if (statusCtx) {
            const gradient = statusCtx.createLinearGradient(0, 0, 600, 0);
            gradient.addColorStop(0, color);
            gradient.addColorStop(1, color);
            statusBarColors.push(gradient);
        } else {
            statusBarColors.push(color);
        }
        statusCapColors.push(color);
    });
    
    
    
    
    
    
    
    // Monthly Trends - vertical bar chart
   createChart('monthlyTrendChart', {
    type: 'line',  // Changed from 'bar' to 'line'
    data: {
        labels: dataset.months || [],
        datasets: [{
            label: 'Reports',
            data: dataset.monthlyCounts || [],
            borderColor: '#ff66c4',
            backgroundColor: 'rgba(236, 144, 224, 0.2)',
            fill: true,
            tension: 0.3,  // smooth curves
            borderWidth: 2,
            pointRadius: 4,
            pointHoverRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        layout: {
            padding: { top: 4, bottom: 22, left: 2, right: 6 }
        },
        plugins: { legend: { display: true, position: 'top' } },
        scales: {
            x: {
                ticks: { color: '#4b5664', padding: 4 },
                grid: { drawBorder: false }
            },
            y: {
                beginAtZero: true,
                ticks: { precision: 0 },
                grid: { drawBorder: false }
            }
        }
    }
});

    // Abuse Type Distribution - pie chart (Report Type Distribution)
    const abuseLabels = dataset.abuseLabels || [];
    const abuseCountsRaw = dataset.abuseCounts || [];
    const abuseCounts = abuseLabels.map((_, i) => abuseCountsRaw[i] ?? 0);
    const abuseColors = ['#004c99', '#fcb825', '#00c382', '#9b57cc', '#81acef', '#38b6ff', '#ff66c4', '#C0C0C0', '#FF0000', '#FFFF00'];

    const abuseLegendPosition = 'bottom';
    createChart('abuseTypeChart', {
        type: 'pie',
        data: {
            labels: abuseLabels,
            datasets: [{
                data: abuseCounts,
                backgroundColor: abuseColors.slice(0, Math.max(abuseLabels.length, 1))
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: {
                padding: abuseLegendPosition === 'right'
                    ? { top: 8, right: 8, bottom: 8, left: 8 }
                    : { top: 4, right: 12, bottom: 4, left: 12 }
            },
            plugins: {
                legend: {
                    position: abuseLegendPosition,
                    align: 'center',
                    fullSize: true,
                    labels: {
                             padding: isMobile ? 14 : (abuseLegendPosition === 'right' ? 10 : 14),
                             boxWidth: isMobile ? 14 : 14,
                             boxHeight: isMobile ? 14 : 14,
                             usePointStyle: true,
                             maxWidth: isMobile ? window.innerWidth - 60 : (abuseLegendPosition === 'bottom' ? 520 : 220),
                             font: { size: isMobile ? 12 : (abuseLabels.length > 10 ? 12 : 13), family: 'Montserrat' },
                        generateLabels: function(chart) {
                            const data = chart.data;
                            const ds = data.datasets[0];
                            const pcts = percentagesTo100(ds.data);
                            return data.labels.map((label, i) => ({
                                text: (label || '—') + ' (' + pcts[i] + '%)',
                                fillStyle: ds.backgroundColor[i],
                                strokeStyle: ds.borderColor ? ds.borderColor[i] : ds.backgroundColor[i],
                                lineWidth: 1,
                                hidden: false,
                                index: i
                            }));
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: ctx => {
                            const pcts = percentagesTo100(ctx.dataset.data);
                            return `${ctx.label}: ${ctx.parsed} (${pcts[ctx.dataIndex]}%)`;
                        }
                    }
                },
                datalabels: { display: false }
            }
        }
    });
    // Status Breakdown — share of total (0–100%), gradients + caps (national admin pattern)
    const statusOrder = [
    'awaiting-resolution',
    'forwarded',
    'under-review',
    'closed',
    'unresolved',
    'false-report'
];

const statuses = Object.entries(dataset.statusCounts || {})
    .sort((a, b) => {
        const aIndex = statusOrder.indexOf(a[0]);
        const bIndex = statusOrder.indexOf(b[0]);

        return (aIndex === -1 ? 999 : aIndex) - (bIndex === -1 ? 999 : bIndex);
    });
    const statusLabels = statuses.map(s => s[0]);
    const statusValues = statuses.map(s => s[1]);
    const reportTotal = statusValues.reduce((a, b) => a + b, 0);
    const statusPctBars = statusValues.map((v) => (reportTotal > 0 ? (v / reportTotal) * 100 : 0));
    const tickFontSize = window.matchMedia('(max-width: 600px)').matches ? 11 : 13;
    const statusLayoutPad = window.matchMedia('(max-width: 600px)').matches ? 36 : 50;

    const statusBarPlugin = {
        id: 'schoolStatusBarPlugin',
        afterDatasetDraw(chart) {
            const { ctx, chartArea } = chart;
            const datasetMeta = chart.getDatasetMeta(0);
            datasetMeta.data.forEach((bar, i) => {
                const pct = parseFloat(chart.data.datasets[0].data[i]) || 0;
                const percentage = pct.toFixed(1);
                const fullX = chart.scales.x.getPixelForValue(100);
                const filledX = chartArea.left + (parseFloat(percentage) / 100) * (fullX - chartArea.left);
                const y = bar.y;
                const h = bar.height;
                const emptyBarColors = ['#c1e6f3ff', '#fdf0d4ff', '#cbffeeff', '#e6c8fcff', '#c5d7f5ff', '#cfeafaff', '#f7bfe1ff'];
                ctx.fillStyle = emptyBarColors[i % emptyBarColors.length];
                ctx.fillRect(chartArea.left, y - h / 2, fullX - chartArea.left, h);
                ctx.fillStyle = statusBarColors[i % statusBarColors.length];
                ctx.fillRect(chartArea.left, y - h / 2, filledX - chartArea.left, h);
                const capWidth = 40;
                const capHeight = 24;
                let left = filledX;
                if (filledX + capWidth > chartArea.right - 5) left = Math.max(chartArea.left, chartArea.right - capWidth - 5);
                const mid = y;
                ctx.beginPath();
                ctx.moveTo(left, y - capHeight / 2);
                ctx.lineTo(left + capWidth - 8, y - capHeight / 2);
                ctx.lineTo(left + capWidth, mid);
                ctx.lineTo(left + capWidth - 8, y + capHeight / 2);
                ctx.lineTo(left, y + capHeight / 2);
                ctx.closePath();
                ctx.fillStyle = statusCapColors[i % statusCapColors.length];
                ctx.fill();
                ctx.fillStyle = '#fff';
                ctx.font = '12px Montserrat';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillText(percentage + '%', left + capWidth / 2 - 4, mid);
            });
        }
    };

    createChart('statusChart', {
        type: 'bar',
        plugins: [statusBarPlugin],
        data: {
            labels: statusLabels,
            datasets: [{
                label: '',
                data: statusPctBars,
                backgroundColor: statusLabels.map((_, i) => statusBarColors[i % statusBarColors.length]),
                borderRadius: { topLeft: 20, bottomLeft: 20, topRight: 0, bottomRight: 0 },
                borderWidth: 0,
                barPercentage: 0.55,
                categoryPercentage: 0.55
            }]
        },
       options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            layout: { padding: { right: statusLayoutPad, left: 4 } },
            interaction: {
                mode: 'nearest',
                intersect: false,
                axis: 'y'
            },
            scales: {
                x: {
                    display: false,
                    beginAtZero: true,
                    max: 100
                },
                y: {
                    ticks: {
                        color: '#333',
                        font: { size: tickFontSize, weight: '600', family: 'Montserrat' },
                        callback: function(value, index) {
                            const raw = statusLabels[index] !== undefined ? statusLabels[index] : statusLabels[value];
                            return raw != null ? formatStatusLabel(raw) : '';
                        }
                    }
                }
            },
            plugins: {
                legend: { display: false },
                datalabels: { display: false },
                tooltip: {
                    displayColors: false,
                    backgroundColor: 'rgba(15, 23, 42, 0.94)',
                    titleFont: { size: 13, weight: '600', family: 'Montserrat' },
                    bodyFont: { size: 17, weight: '700', family: 'Montserrat' },
                    titleSpacing: 6,
                    bodySpacing: 4,
                    padding: 12,
                    cornerRadius: 10,
                    callbacks: {
                        title: (items) => (items.length ? formatStatusLabel(items[0].label) : ''),
                        label: (item) => {
                            const n = statusValues[item.dataIndex];
                            return n != null ? Number(n).toLocaleString() : '';
                        }
                    }
                }
            }
        }
    });

    // Anonymous vs Identified - doughnut chart
    createChart('anonymousChart', {
        type: 'doughnut',
        data: {
            labels: ['Anonymous', 'Identified'],
            datasets: [{
                data: [
                    getValue(dataset.anonymousCounts, 'anonymous', 0),
                    getValue(dataset.anonymousCounts, 'identified', 0)
                ],
                backgroundColor: ['#9b57cc', '#99c4d3']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: { padding: 15 },
            plugins: {
                legend: { position: 'bottom' },
                tooltip: {
                    callbacks: {
                        label: ctx => {
                            const pcts = percentagesTo100(ctx.dataset.data);
                            return `${ctx.label}: ${ctx.parsed} (${pcts[ctx.dataIndex]}%)`;
                        }
                    }
                },
                datalabels: {
                    color: '#fff',
                    anchor: 'center',
                    align: 'center',
                    font: { weight: '600', size: 12, family: 'Montserrat' },
                    display: function(ctx) {
                        return ctx.dataset.data[ctx.dataIndex] > 0;
                    },
                    formatter: (value, ctx) => {
                        const pcts = percentagesTo100(ctx.chart.data.datasets[0].data);
                        return pcts[ctx.dataIndex] + '%';
                    }
                }
            }
        }
    });


    // Top Abuse Types - horizontal bar chart left-aligned y-axis labels
    createChart('topAbuseTypesChart', {
        type: 'bar',
        data: {
            labels: Object.keys(dataset.topAbuseTypes || {}),
            datasets: [{
                label: 'Reports',
                data: Object.values(dataset.topAbuseTypes || {}),
                backgroundColor: '#fcb825' // Yellow from your color palette for distinction
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                datalabels: { display: false }
            },
            scales: {
                x: { beginAtZero: true, ticks: { precision: 0 } },
                y: { ticks: { align: 'start', padding: 10 } }
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    const dataElement = document.getElementById('dashboard-data');
    const dataset = dataElement ? JSON.parse(dataElement.textContent || '{}') : {};
    statusReportsMap = dataset.statusReports || {};
    allReportsList = dataset.allReports || [];
    
    // Add anonymous and identified reports to the map
    if (dataset.anonymousReports) {
        statusReportsMap['anonymous'] = dataset.anonymousReports;
    }
    if (dataset.identifiedReports) {
        statusReportsMap['identified'] = dataset.identifiedReports;
    }
    
    renderOverviewCharts(dataset);

    const firstCard = document.querySelector('.metric-card.status-total');
    if (firstCard) firstCard.classList.add('active');

    // Automatically submit form when filters change
    const filtersForm = document.getElementById('filtersForm');
    if (filtersForm) {
        let debounceTimer;

        // 1. Instant submit for Select dropdowns and Date pickers
        filtersForm.querySelectorAll('select, input[type="date"]').forEach(input => {
            input.addEventListener('change', function () {
                filtersForm.submit();
            });
        });

        // 2. Debounced submit for Age, Text, and Number inputs
        filtersForm.querySelectorAll('input[type="number"], input[type="text"]').forEach(input => {
            input.addEventListener('input', function () {
                clearTimeout(debounceTimer);
                // Waits 600ms after user stops typing before submitting
                debounceTimer = setTimeout(() => {
                    filtersForm.submit();
                }, 600);
            });
        });
    }
});
   
   // Navigate preserving all active filters and adding/updating 'status' filter
function navigateWithFilter(status) {
    const url = new URL("{{ url('/admin/reports') }}", window.location.origin);
    const params = new URLSearchParams(window.location.search);

    // Preserve all current filters except 'status'
    params.forEach((value, key) => {
        if (key !== 'status') {
            url.searchParams.append(key, value);
        }
    });

    if (status && status !== 'total') {
        url.searchParams.set('status', status);
    } else {
        url.searchParams.delete('status');
    }

    window.location.href = url.toString();
}

// Navigate preserving all active filters and adding/updating 'is_anonymous' filter
function navigateWithFilterByAnonymous(isAnonymous) {
    const url = new URL("{{ url('/admin/reports') }}", window.location.origin);
    const params = new URLSearchParams(window.location.search);

    // Preserve all current filters except 'is_anonymous'
    params.forEach((value, key) => {
        if (key !== 'is_anonymous') {
            url.searchParams.append(key, value);
        }
    });

    url.searchParams.set('is_anonymous', isAnonymous ? 1 : 0);

    window.location.href = url.toString();
}

// Navigate preserving all active filters, optionally adding abuse_type filter if needed
function navigateWithFilterByAbuseType(abuseTypeId) {
    const url = new URL("{{ url('/admin/reports') }}", window.location.origin);
    const params = new URLSearchParams(window.location.search);

    // Preserve all current filters except 'abuse_type_id' or similar keys
    params.forEach((value, key) => {
        if (key !== 'abuse_type_id' && key !== 'abuse_type') {
            url.searchParams.append(key, value);
        }
    });

    if (abuseTypeId) {
        url.searchParams.set('abuse_type_id', abuseTypeId);
    } else {
        url.searchParams.delete('abuse_type_id');
    }

    window.location.href = url.toString();
}

// Navigate preserving all active filters, optionally adding school filter if needed
function navigateWithFilterBySchool(schoolId) {
    const url = new URL("{{ url('/admin/reports') }}", window.location.origin);
    const params = new URLSearchParams(window.location.search);

    // Preserve all current filters except 'school_id'
    params.forEach((value, key) => {
        if (key !== 'school_id') {
            url.searchParams.append(key, value);
        }
    });

    if (schoolId) {
        url.searchParams.set('school_id', schoolId);
    } else {
        url.searchParams.delete('school_id');
    }

    window.location.href = url.toString();
}

// Navigate to reports page without filters (for exports or general navigation)
function navigateToReportsUnfiltered() {
    window.location.href = "{{ url('/admin/reports') }}";
}

function openExtrasModal(type) {
    const dataElem = document.getElementById('dashboard-data');
    const data = dataElem ? JSON.parse(dataElem.textContent || '{}') : {};
    const modal = document.getElementById('extrasModal');
    const titleEl = document.getElementById('extrasModalTitle');
    const bodyEl = document.getElementById('extrasModalBody');
    if (!modal || !titleEl || !bodyEl) return;

    if (type === 'anonymous') {
        titleEl.textContent = 'Anonymous Reports';
        const count = (data.anonymousCounts || {}).anonymous || 0;
        bodyEl.innerHTML = '<p style="margin-bottom:1rem;">Reports submitted anonymously: <strong>' + count.toLocaleString() + '</strong></p>' +
            '<button type="button" onclick="navigateWithFilterByAnonymous(1); closeExtrasModal();" class="extras-modal-btn">View Anonymous Reports</button>';
    } else if (type === 'identified') {
        titleEl.textContent = 'Identified Reports';
        const count = (data.anonymousCounts || {}).identified || 0;
        bodyEl.innerHTML = '<p style="margin-bottom:1rem;">Reports where the reporter was identified: <strong>' + count.toLocaleString() + '</strong></p>' +
            '<button type="button" onclick="navigateWithFilterByAnonymous(0); closeExtrasModal();" class="extras-modal-btn">View Identified Reports</button>';
    } else if (type === 'abuse-types') {
        titleEl.textContent = 'Types Of Report Tracked';
        const labels = data.abuseLabels || [];
        const counts = data.abuseCounts || [];
        const pcts = data.abuseTypePercentages || [];
        let html = '<table style="width:100%; border-collapse:collapse;"><thead><tr><th style="text-align:left; padding:0.5rem; border-bottom:2px solid #e5e7eb;">Report Type</th><th style="text-align:right; padding:0.5rem; border-bottom:2px solid #e5e7eb;">Count</th><th style="text-align:right; padding:0.5rem; border-bottom:2px solid #e5e7eb;">%</th></tr></thead><tbody>';
        labels.forEach((label, i) => {
            html += '<tr><td style="padding:0.5rem; border-bottom:1px solid #e5e7eb;">' + (label || 'N/A') + '</td><td style="text-align:right; padding:0.5rem; border-bottom:1px solid #e5e7eb;">' + (counts[i] || 0).toLocaleString() + '</td><td style="text-align:right; padding:0.5rem; border-bottom:1px solid #e5e7eb;">' + (pcts[i] ?? 0) + '%</td></tr>';
        });
        html += '</tbody></table>';
        bodyEl.innerHTML = html;
    } else if (type === 'top-types') {
        titleEl.textContent = 'Top Report Types';
        const topTypes = data.topAbuseTypes || {};
        const entries = Object.entries(topTypes);
        if (entries.length === 0) {
            bodyEl.innerHTML = '<p>No report types with reports in the selected period.</p>';
        } else {
            let html = '<table style="width:100%; border-collapse:collapse;"><thead><tr><th style="text-align:left; padding:0.5rem; border-bottom:2px solid #e5e7eb;">Report Type</th><th style="text-align:right; padding:0.5rem; border-bottom:2px solid #e5e7eb;">Reports</th></tr></thead><tbody>';
            entries.forEach(([name, count]) => {
                html += '<tr><td style="padding:0.5rem; border-bottom:1px solid #e5e7eb;">' + (name || 'N/A') + '</td><td style="text-align:right; padding:0.5rem; border-bottom:1px solid #e5e7eb;">' + Number(count).toLocaleString() + '</td></tr>';
            });
            html += '</tbody></table>';
            bodyEl.innerHTML = html;
        }
    }

    modal.classList.add('active');
    modal.setAttribute('aria-hidden', 'false');
}

function closeExtrasModal() {
    const modal = document.getElementById('extrasModal');
    if (modal) {
        modal.classList.remove('active');
        modal.setAttribute('aria-hidden', 'true');
    }
}

function navigateToAbuseTypes() {
    // Navigate to reports filtered by abuse types
    navigateToReportsUnfiltered();
}

function navigateToTopAbuseTypes() {
    // Navigate to reports filtered by top abuse types
    navigateToReportsUnfiltered();
}

if (isMobile) {
    const legendRows = Math.ceil(abuseLabels.length / 1); // 1 label per row on mobile
    const legendHeight = legendRows * 34; // ~34px per legend row at 13px font
    const pieHeight = 260; // fixed circle size
    const totalHeight = pieHeight + legendHeight + 40; // + padding
    document.querySelector('.chart-abuse-pie .chart-canvas-host').style.height = totalHeight + 'px';
}
    </script>
    <x-school-admin-sidebar-script />
<script src="{{ asset('js/mobile-select-modal.js') }}"></script>
<script src="https://kit.fontawesome.com/2c36e9b7b9.js" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    function exportPDF() {
        const element = document.getElementById('main-content'); // ✅ grabs main content only
        if (!element) {
            alert("Main content not found! Add id='main-content' to your <main> tag.");
            return;
        }

        html2pdf().from(element).set({
            margin: 10,
            filename: 'school-admin-dashboard.pdf',
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'mm', format: 'a3', orientation: 'landscape' }
        }).save();
    }
</script>

    
</body>
</html>
