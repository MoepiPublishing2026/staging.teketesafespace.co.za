<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SafeSpace National Dashboard</title>
    <!-- Fonts -->
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



.sidebar-link, button, select, input, label {
  font-size: 15px !important;
  font-weight: 900 !important;
  color: #545454 !important;
  font-family: 'Montserrat', sans-serif !important;
}

.metric-card .card-value {
   font-weight: 800 !important;
  font-size: 30px !important;
  color: inherit !important;
  font-family: 'Montserrat', sans-serif !important;
}

.card-title {
  font-weight: 900 !important;
  font-size: 14px !important;
  font-family: 'Montserrat', sans-serif !important;
}

button:hover, .sidebar-link:hover, .sidebar-link.active {
  /*color: #fff !important;*/
  background: linear-gradient(to right, #38b6ff, #38b6ff) !important;
}
h2 {
  color: #38b6ff !important;
  font-family: 'Montserrat', sans-serif;
  font-weight: 900;
}


body {
    display: flex;
    min-height: 100vh;
    width: 100vw;
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
    font-weight: 900 !important;
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


button {
  background-color: white !important;
  color: #38b6ff !important;
  border: 2px solid #c7da30 !important;
  font-weight: 900 !important;
  font-family: 'Montserrat', sans-serif !important;
  padding: 0.75rem 1rem !important;
  border-radius: 0.5rem !important;
  cursor: pointer !important;
  transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
}

button:hover, button:focus {
  background-color: #c7da30 !important; /* Green background on hover for contrast */
  color: white !important; /* White text on hover */
  border-color: #38b6ff !important; /* Blue border on hover */
  outline: none;
}


button.active{
    background: var(--theme-gradient);
    color: var(--theme-dark);
}

.topbar {
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

.profile .meta {
    text-align: right;
}
.profile .meta > span:first-child {
    color: #38b6ff; /* Theme blue */
    font-size: 18px; /* Increase font size */
    font-weight: 700; /* Bold for emphasis */
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

.main-panel {
    flex: 1 1 0;
    display: flex;
    flex-direction: column;
    min-width: 0;
    height: 100vh;
    background: white;
}

/* Main content scrollable omitted as no styles provided */

.metrics-row > .metric-card {
    flex: 0 0 100px; /* fixed width */
    max-width: 115px;
    min-width: 115px; /* prevent shrinking smaller */
}

.dashboard-scroll {
    flex: 1 1 0;
    overflow-y: auto;
    overflow-x: hidden;
    padding: 2.5rem;
    max-width: 1280px;
    margin: 0 auto;
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
/* Extras cards with white background, box shadow, and thick border on left */
/* Update the extras cards styling - blue numbers only, no titles colored */
.extras-anonymous, .extras-identified, .extras-abuse, .extras-schools {
    background: white;
    color: #1f2933;
    font-family: 'Century Gothic';
    box-shadow: 0 4px 8px rgba(199, 218, 48, 0.2);
    border: 1px solid #c7da30;
    border-left-width: 1px;
    border-left-color: #c7da30;
}

.extras-anonymous .card-title,
.extras-identified .card-title,
.extras-abuse .card-title,
.extras-schools .card-title {
    color: #1f2933 !important; /* Dark text for titles only */
    font-size: 14px;
    font-weight: 500;
}

.extras-anonymous .card-value,
.extras-identified .card-value,
.extras-abuse .card-value,
.extras-schools .card-value {
    font-size: 40px;
    font-weight: 800;
    margin-bottom: 0.17rem;
    color: #38b6ff !important; /* Blue color for numbers only */
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
/* Container wrapping the charts */
.chart-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr); /* 2 cards per row */
  grid-template-rows: repeat(3, auto);  /* 3 rows */
  gap: 1.5rem;                         /* space between cards */
  max-width: 1280px;
  margin: 0 auto;
}
.chart-grid > .chart-card:last-child {
  grid-column: span 1.5;
}


/* Each chart container/card inside */
.chart-card {
  background: white;
  padding: 1rem;
  border-radius: 1rem;
 
  min-height: 280px;
  display: flex;
  flex-direction: column;
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
    height: 280px !important;
}

.modal-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(17, 24, 39, 0.58);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 50;
}

.modal-backdrop.active {
    display: flex;
}

.modal-card {
    width: min(960px, 92vw);
    max-height: 85vh;
    overflow-y: auto;
    background: white;
    border-radius: 1.25rem;
    padding: 2rem;
    box-shadow: 0 32px 64px rgba(15, 23, 42, 0.35);
}

.modal-card h3 {
    margin: 0 0 1rem;
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

.filters button#refreshBtn:hover {
    background: linear-gradient(to right, #38b6ff, #38b6ff);
}

/* Responsive sidebar and elements */
@media (max-width: 900px) {
    .menu-icon {
        display: block;
        position: fixed;
        top: 15px;
        left: 15px;
        font-size: 24px;
        cursor: pointer;
        z-index: 1001;
    }
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 0;
        height: 100vh;
        background: white;
        overflow-x: hidden;
        transition: width 0.3s ease;
        z-index: 1000;
        box-shadow: 2px 0 5px rgba(0,0,0,0.1);
    }
    .sidebar.open {
        width: 220px;
    }
    .main-panel {
        margin-left: 0 !important;
        transition: margin-left 0.3s ease;
    }
    .main-panel.shifted {
        margin-left: 220px;
    }

    /* Hide menu icon on desktop */
    .menu-icon {
        display: none;
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
        padding: 0 1rem;
        height: 56px;
    }
    h1, .subtitle {
        font-size: 14px;
        padding: 0 1rem;
        text-align: center;
    }
}

    /* Force black text color for card-title in extras-row metric cards */
    .extras-row .metric-card .card-title {
        color: #000 !important;
    }
    
    /* Maintain black text on hover and active states */
    .extras-row .metric-card:hover .card-title,
    .extras-row .metric-card.active .card-title {
        color: #000 !important;
    }

    </style>
</head>
<body>
   
<aside class="sidebar">
     <div style="position: fixed; top: 10px; left: 60px; width: 100px; height: auto;">
        <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Safe Space Logo" style="width: 90px; height: auto;"></div>
    <ul class="sidebar-list">
        <a href="<?php echo e(url('/national-admin/dashboard')); ?>" class="sidebar-link <?php echo e(request()->is('national-admin/dashboard') ? 'active' : ''); ?>">Dashboard</a>
        <a href="<?php echo e(url('/national-admin/reports')); ?>" class="sidebar-link <?php echo e(request()->is('national-admin/reports') ? 'active' : ''); ?>">Reports</a>
        <a href="<?php echo e(url('/national-admin/settings')); ?>" class="sidebar-link <?php echo e(request()->is('national-admin/settings') ? 'active' : ''); ?>">My Profile</a>
        <a href="#" onclick="event.preventDefault(); exportPDF();" class="sidebar-link">Export PDF</a>

        <!-- Sign Out as a styled form -->
        <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="sidebar-link">
    Sign Out
</a>

<form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
    <?php echo csrf_field(); ?>
</form>

    </ul>
</aside>


    <!-- Main dashboard (topbar + scrollable dashboard) -->
    <div class="main-panel">
        <!-- Top bar with profile only (sticky) -->
        <div class="topbar">
            <div class="profile">
                <div class="meta">
                    <span>
                        <?php echo e(auth()->user()->name ?? 'Administrator'); ?>

                    </span>
                    <span class="role">
                        Administrator
                    </span>
                </div>
                <div class="profile-avatar">
                    <?php
                        $currentUser = auth()->user()->fresh();
                    ?>
                    <?php if($currentUser && $currentUser->profile_picture): ?>
                       <img src="<?php echo e($currentUser->profile_picture_url); ?>" alt="Profile Picture" class="profile-pic">
                    <?php else: ?>
                        <!-- Default gray circle, nothing inside -->
                    <?php endif; ?>
                </div>
            </div>
        </div>


        
        <!-- Scrollable dashboard content -->
        <div class="dashboard-scroll" id="main-content">
            <h1>SafeSpace National Dashboard</h1>
            <p class="subtitle">Nation-wide case intelligence and live report monitoring.</p>

            <section class="panel" aria-label="Filters">
    <h2>Filters</h2>
    <hr class="filter-separator"/>
    <form method="GET" action="<?php echo e(url()->current()); ?>" class="filters" id="filtersForm">
        <input type="hidden" name="tab" value="<?php echo e($activeTab); ?>">
        <select name="province" id="provinceSelect" onchange="this.form.submit()">
            <option value="">All Provinces</option>
            <?php $__currentLoopData = $provinces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $province): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($province->id); ?>" <?php echo e($provinceFilter == $province->id ? 'selected' : ''); ?>>
                    <?php echo e($province->name); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <select name="district" id="districtSelect" onchange="this.form.submit()" <?php echo e($provinceFilter ? '' : 'disabled'); ?>>
            <option value="">All Districts</option>
            <?php $__currentLoopData = $districts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $district): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($district->id); ?>" <?php echo e($districtFilter == $district->id ? 'selected' : ''); ?>>
                    <?php echo e($district->name); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <select name="school" id="schoolSelect" onchange="this.form.submit()" <?php echo e(($districtFilter && $provinceFilter) ? '' : 'disabled'); ?>>
            <option value="">All Schools</option>
            <?php $__currentLoopData = $schools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $school): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($school->school_id); ?>" <?php echo e($schoolFilter == $school->school_id ? 'selected' : ''); ?>>
                    <?php echo e($school->school_name); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <select name="abuse_type" onchange="this.form.submit()">
            <option value="">Any Abuse Type</option>
            <?php $__currentLoopData = $abuseTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($type->id); ?>" <?php echo e($abuseTypeFilter == $type->id ? 'selected' : ''); ?>>
                    <?php echo e($type->type_name); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <select name="age_range" onchange="this.form.submit()">
            <option value="">Any Age</option>
            <?php $__currentLoopData = ['0-10','11-15','16-20','21-25','26-30','30+']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $range): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($range); ?>" <?php echo e($ageRange == $range ? 'selected' : ''); ?>>
                    <?php echo e($range); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <label>
            From
            <input type="date" name="from_date" value="<?php echo e($fromDate); ?>" onchange="this.form.submit()">
        </label>
        <label>
            To
            <input type="date" name="to_date" value="<?php echo e($toDate); ?>" onchange="this.form.submit()">
        </label>
      
        <button type="button" id="refreshBtn">Refresh Table</button>
    </form>
    <?php if(!empty($activeFilters)): ?>
        <div class="filter-chips" aria-label="Active filters">
            <?php $__currentLoopData = $activeFilters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <span><?php echo e($chip); ?></span>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
  
</section>
            <!-- Metrics Cards (Clickable, themed, open modal, auto-active) -->
            <section class="metrics-row" aria-label="Headline metrics">
                <div class="metric-card status-total" onclick="navigateWithFilter('total')">
                    <span class="card-title">Total Reports</span>
                    <div class="card-value"><?php echo e(number_format($summaryCounts['total'] ?? 0)); ?></div>
                </div>
                <div class="metric-card status-awaiting" onclick="navigateWithFilter('awaiting-resolution')">
                    <span class="card-title">Awaiting Resolution</span>
                    <div class="card-value"><?php echo e(number_format($summaryCounts['statuses']['awaiting-resolution'] ?? 0)); ?></div>
                </div>
                <div class="metric-card status-forwarded" onclick="navigateWithFilter('forwarded')">
                    <span class="card-title">Forwarded</span>
                    <div class="card-value"><?php echo e(number_format($summaryCounts['statuses']['forwarded'] ?? 0)); ?></div>
                </div>
                <div class="metric-card status-review" onclick="navigateWithFilter('under-review')">
                    <span class="card-title">Under Review</span>
                    <div class="card-value"><?php echo e(number_format($summaryCounts['statuses']['under-review'] ?? 0)); ?></div>
                </div>
                <div class="metric-card status-closed" onclick="navigateWithFilter('closed')">
                    <span class="card-title">Closed</span>
                    <div class="card-value"><?php echo e(number_format($summaryCounts['statuses']['closed'] ?? 0)); ?></div>
                </div>
                <div class="metric-card status-unresolved" onclick="navigateWithFilter('unresolved')">
                    <span class="card-title">Unresolved</span>
                    <div class="card-value"><?php echo e(number_format($summaryCounts['statuses']['unresolved'] ?? 0)); ?></div>
                </div>
                <div class="metric-card status-false" onclick="navigateWithFilter('false-report')">
                    <span class="card-title">False-Report</span>
                    <div class="card-value"><?php echo e(number_format($summaryCounts['statuses']['false-report'] ?? 0)); ?></div>
                </div>
            </section>
            <section class="extras-row" aria-label="Extra metrics">
                <div class="metric-card extras-anonymous" onclick="navigateWithFilterByAnonymous(true)">
                    <span class="card-title" >Anonymous</span>
                    <div class="card-value"><?php echo e(number_format($anonymousCounts['anonymous'] ?? 0)); ?></div>
                    <span class="card-subtext"></span>
                </div>
                <div class="metric-card extras-identified" onclick="navigateWithFilterByAnonymous(false)">
                    <span class="card-title">Identified</span>
                    <div class="card-value"><?php echo e(number_format($anonymousCounts['identified'] ?? 0)); ?></div>
                </div>
                <div class="metric-card extras-abuse" onclick="navigateToAbuseTypes()">
                    <span class="card-title">Abuse Types Tracked</span>
                    <div class="card-value"><?php echo e(count($abuseTypeLabels)); ?></div>
                    <span class="card-subtext"></span>
                </div>
                <div class="metric-card extras-schools" onclick="navigateToTopSchools()">
                    <span class="card-title">Active Schools</span>
                    <div class="card-value"><?php echo e(count($topSchools)); ?></div>
                    <span class="card-subtext"></span>
                </div>
            </section>
           <!-- Filters panel with 'Refresh Table' button and silver line -->


            <section class="panel" aria-label="Analytics">
             <section class="chart-grid" aria-label="Dashboard charts overview">
  <div class="chart-card">
    <h2>Monthly Trends</h2>
    <canvas id="monthlyTrendChart"></canvas>
  </div>
  <div class="chart-card">
    <h2>Abuse Type Distribution</h2>
    <canvas id="abuseTypeChart"></canvas>
  </div>
 
  <div class="chart-card">
    <h2>Anonymous vs Identified</h2>
    <canvas id="anonymousChart"></canvas>
  </div>
  <div class="chart-card">
    <h2>Top Reporting Schools</h2>
    <canvas id="topSchoolsChart"></canvas>
  </div>
   <div class="chart-card">
    <h2>Status Breakdown</h2>
    <canvas id="statusChart"></canvas>
  </div>
  <!-- <div class="chart-card">
    <h2>Age Group</h2>
    <canvas id="agePyramidChart"></canvas>
  </div> -->
</section>

    <!-- You can add two more charts here if needed, or leave empty containers -->
    <div></div>
    <div></div>
</div>

            </section>
        </div>
    </div>

    <!-- Modal for report details -->
    <div class="modal-backdrop" id="statusModal" aria-hidden="true">
        <div class="modal-card">
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <h3 id="statusModalTitle">Reports</h3>
                <button class="modal-close" onclick="closeStatusModal()" aria-label="Close">&times;</button>
            </div>
            <div style="overflow-x:auto;">
                <table>
                    <thead>
                        <tr>
                            <th>Case</th>
                            <th>Abuse Type</th>
                            <th>Status</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody id="statusModalBody"></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Chart Data -->
    <script id="dashboard-data" type="application/json">
    <?php echo json_encode([
        'months' => $months,
        'monthlyCounts' => $monthlyCounts,
        'abuseLabels' => $abuseTypeLabels,
        'abuseCounts' => $abuseTypeCounts,
        'statusCounts' => $statusCounts,
        'anonymousCounts' => $anonymousCounts,
        'topSchools' => $topSchools,
        'statusReports' => $statusReportPayload,
        'allReports' => $allReportsPayload,
    ]); ?>

    </script>
   <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script>
Chart.register(ChartDataLabels);

document.getElementById('refreshBtn').addEventListener('click', function () {
  const form = document.getElementById('filtersForm');
  // Clear all selects except hidden inputs
  form.querySelectorAll('select').forEach(select => {
    select.selectedIndex = 0;
    select.disabled = false; // enable in case disabled
  });
  // Clear all date inputs
  form.querySelectorAll('input[type="date"]').forEach(input => {
    input.value = '';
  });
  // Submit the form after clearing
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
  let reports;
  if (status === 'total') {
    reports = allReportsList;
  } else if (statusReportsMap[status]) {
    reports = statusReportsMap[status];
  } else if (status === 'anonymous') {
    reports = statusReportsMap['anonymous'];
  } else if (status === 'identified') {
    reports = statusReportsMap['identified'];
  } else if (status === 'abuse-type') {
    reports = statusReportsMap['abuse-type'];
  } else if (status === 'active-schools') {
    reports = statusReportsMap['active-schools'];
  } else {
    reports = [];
  }

  const tbody = document.getElementById('statusModalBody');
  const title = document.getElementById('statusModalTitle');
  tbody.innerHTML = '';

  if (!reports.length) {
    const emptyRow = document.createElement('tr');
    emptyRow.innerHTML = '<td colspan="4" style="text-align:center; padding:1.25rem;">No reports for this selection.</td>';
    tbody.appendChild(emptyRow);
  } else {
    reports.forEach(report => {
      const row = document.createElement('tr');
      row.innerHTML = `
        <td>${report.case_number ?? 'N/A'}</td>
        <td>${report.abuse_type ?? 'N/A'}</td>
        <td>${report.status ?? 'N/A'}</td>
        <td>${report.created_at ?? 'N/A'}</td>`;
      tbody.appendChild(row);
    });
  }

  if (status === 'total') {
    title.textContent = 'All Reports';
  } else if (status === 'false-report') {
    title.textContent = 'False Report';
  } else {
    title.textContent = status.replace(/-/g, ' ').replace(/\b\w/g, c => c.toUpperCase()) + ' Reports';
  }

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

function renderOverviewCharts(dataset) {
  const ctx = document.getElementById("statusChart")?.getContext("2d");

  const customColors = [
    '#99c4d3',
    '#fcb825',
    '#00c382',
    '#9b57cc',
    '#81acef',
    '#38b6ff',
    '#ff66c4'
  ];

  // Create gradients for bar colors on statusChart
  const barColors = [];
  const capColors = [];
  if(ctx){
    customColors.forEach(color => {
      const gradient = ctx.createLinearGradient(0, 0, 600, 0);
      gradient.addColorStop(0, color);
      gradient.addColorStop(1, color);
      barColors.push(gradient);
      capColors.push(color);
    });
  }

  // Monthly Trends - line chart
  createChart('monthlyTrendChart', {
    type: 'line',
    data: {
      labels: dataset.months || [],
      datasets: [{
        label: 'Reports',
        data: dataset.monthlyCounts || [],
        borderColor: '#ff66c4',
        backgroundColor: 'rgba(236, 144, 224, 0.2)',
        fill: true,
        tension: 0.3,
        borderWidth: 2,
        pointRadius: 4,
        pointHoverRadius: 6
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: true, position: 'top' } },
      scales: {
        x: { ticks: { color: '#4b5664' } },
        y: {
          beginAtZero: true,
          ticks: { precision: 0 },
          grid: { drawBorder: false }
        }
      }
    }
  });

  // Abuse Type Distribution - pie chart with custom colors
  createChart('abuseTypeChart', {
    type: 'pie',
    data: {
      labels: dataset.abuseLabels || [],
      datasets: [{
        data: dataset.abuseCounts || [],
        backgroundColor: customColors
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { position: 'bottom' },
        tooltip: {
          callbacks: {
            label: ctx => `${ctx.label}: ${ctx.parsed}`
          }
        },
        datalabels: {
          color: 'white',
          anchor: 'center',
          align: 'center',
          font: {
            weight: 'bold',
            size: 13,
            family: 'Montserrat'
          },
          display: function(ctx) {
            const dataArr = ctx.chart.data.datasets[0].data;
            const total = dataArr.reduce((a, b) => a + b, 0);
            const percent = total ? ((ctx.dataset.data[ctx.dataIndex] / total) * 100) : 0;
            // Only show percentage if segment is large enough (> 5%)
            return percent > 5;
          },
          formatter: (value, ctx) => {
            const dataArr = ctx.chart.data.datasets[0].data;
            const total = dataArr.reduce((a, b) => a + b, 0);
            const percent = total ? ((value / total) * 100).toFixed(1) : 0;
            return `${percent}%`;
          }
        }
      }
    }
  });

  // Status Breakdown - horizontal stacked bar chart with custom colors and caps
  if(!ctx) return;

  const barPlugin = {
    id: "barPlugin",
    afterDatasetDraw(chart) {
      const { ctx, chartArea } = chart;
      const datasetMeta = chart.getDatasetMeta(0);
      const total = chart.data.datasets[0].data.reduce((sum, val) => sum + val, 0);

      datasetMeta.data.forEach((bar, i) => {
        const value = chart.data.datasets[0].data[i];
        const percentage = total ? ((value / total) * 100).toFixed(1) : 0;

        const fullX = chart.scales.x.getPixelForValue(100);
        const chartWidth = fullX - chartArea.left;

        const filledX = chartArea.left + (percentage / 100) * chartWidth;

        const y = bar.y;
        const h = bar.height;

        const emptyBarColors = [
    '#c1e6f3ff',
    '#fdf0d4ff',
    '#cbffeeff',
    '#e6c8fcff',
    '#c5d7f5ff',
    '#cfeafaff',
    '#f7bfe1ff'
        ];
        ctx.fillStyle = emptyBarColors[i % emptyBarColors.length];
        ctx.fillRect(chartArea.left, y - h / 2, fullX - chartArea.left, h);

        ctx.fillStyle = barColors[i % barColors.length];
        ctx.fillRect(chartArea.left, y - h / 2, filledX - chartArea.left, h);

        const capWidth = 40;
        const capHeight = 24;
        const left = filledX;
        const right = filledX + capWidth;
        const top = y - capHeight / 2;
        const bottom = y + capHeight / 2;
        const mid = y;

        ctx.beginPath();
        ctx.moveTo(left, top);
        ctx.lineTo(right - 8, top);
        ctx.lineTo(right, mid);
        ctx.lineTo(right - 8, bottom);
        ctx.lineTo(left, bottom);
        ctx.closePath();
        ctx.fillStyle = capColors[i % capColors.length];
        ctx.fill();

        ctx.fillStyle = "#fff";
        ctx.font = "12px Montserrat";
        ctx.textAlign = "center";
        ctx.textBaseline = "middle";
        ctx.fillText(percentage + "%", left + capWidth / 2 - 4, mid);
      });
    }
  };

  const statuses = Object.entries(dataset.statusCounts || {}).sort((a, b) => b[1] - a[1]);
  const labels = statuses.map(s => s[0]);
  const values = statuses.map(s => s[1]);

  createChart("statusChart", {
    type: "bar",
    plugins: [barPlugin],
    data: {
      labels,
      datasets: [{
        data: values,
        backgroundColor: barColors,
        borderRadius: { topLeft: 20, bottomLeft: 20, topRight: 0, bottomRight: 0 },
        borderWidth: 0,
        barPercentage: 0.55,
        categoryPercentage: 0.55
      }]
    },
    options: {
      indexAxis: "y",
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        x: { display: false, max: 100 },
        y: { ticks: { color: "#333", font: { size: 13, weight: "600" } } }
      },
      plugins: {
        legend: { display: false },
        datalabels: { display: false }
      }
    }
  });

  // Anonymous vs Identified - doughnut chart with complementary colors
  createChart('anonymousChart', {
    type: 'doughnut',
    data: {
      labels: ['Anonymous', 'Identified'],
      datasets: [{
        data: [
          getValue(dataset.anonymousCounts, 'anonymous', 0),
          getValue(dataset.anonymousCounts, 'identified', 0)
        ],
        backgroundColor: ['#9b57cc', '#99c4d3'] // Main colors from your palette
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { position: 'bottom' },
        tooltip: { callbacks: { label: ctx => `${ctx.label}: ${ctx.parsed}` } },
        datalabels: {
          color: 'white',
          anchor: 'center',
          align: 'center',
          font: {
            weight: 'bold',
            size: 14,
            family: 'Montserrat'
          },
          display: function(ctx) {
            return ctx.dataset.data[ctx.dataIndex] > 0;
          },
          formatter: (value, ctx) => {
            const dataArr = ctx.chart.data.datasets[0].data;
            const total = dataArr.reduce((a, b) => a + b, 0);
            const percent = total ? ((value / total) * 100).toFixed(1) : 0;
            return `${percent}%`;
          }
        }
      }
    }
  });

  // Top Reporting Schools - horizontal bar chart
  createChart('topSchoolsChart', {
    type: 'bar',
    data: {
      labels: Object.keys(dataset.topSchools || {}),
      datasets: [{
        label: 'Reports',
        data: Object.values(dataset.topSchools || {}),
        backgroundColor: '#fcb825' // Purple from your color palette for distinction
      }]
    },
    options: {
      indexAxis: 'y',
      responsive: true,
      maintainAspectRatio: false,
      plugins: { datalabels: { display: false } },
      scales: {
        x: { beginAtZero: true, ticks: { precision: 0 } },
        y: { ticks: { align: 'start', padding: 10 } }
      }
    }
  });
}
// SPHERE / RADAR CHART REPLACEMENT
const ageGroups = ["0-10", "11-15", "16-20", "21-25", "26-30", "30+"];
  const ageCounts = [30, 45, 20, 25, 15, 10];

  // Function to create and render the bubble (sphere) chart
  function renderSphereChart(ageGroups, ageCounts) {
    const ctx = document.getElementById('agePyramidChart').getContext('2d');

    // If chart already exists (to re-render), destroy it first
    if (window.agePyramidChartInstance) {
      window.agePyramidChartInstance.destroy();
    }

    // Prepare data formatted for bubble chart
    const bubbleData = ageCounts.map((count, index) => ({
      x: index,             // X-axis position as index
      y: count,             // Y-axis is count value
      r: Math.max(10, count / 2) // Radius of bubble, minimum 10 for visibility
    }));

    window.agePyramidChartInstance = new Chart(ctx, {
      type: 'bubble',
      data: {
        labels: ageGroups,
        datasets: [{
          label: "Age Group Bubble (Sphere) Chart",
          data: bubbleData,
          backgroundColor: "rgba(100, 213, 143, 0.6)",
          borderColor: "rgba(100, 213, 143, 1)",
          borderWidth: 2,
          hoverBackgroundColor: "rgba(100, 213, 143, 0.9)"
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false
          }
        },
        scales: {
          x: {
            ticks: {
              callback: function(value) {
                return ageGroups[value] || '';
              },
              maxRotation: 45,
              minRotation: 45
            },
            title: {
              display: true,
              text: 'Age Groups'
            },
            beginAtZero: true,
            min: 0,
            max: ageGroups.length - 1
          },
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: 'Number of Reports'
            }
          }
        }
      }
    });
  }

document.addEventListener('DOMContentLoaded', function () {
  const dataElem = document.getElementById('dashboard-data');
  const parsedDataset = dataElem ? JSON.parse(dataElem.textContent || '{}') : {};

  const dataset = {
      ...parsedDataset,
      ageGroups: window.agePyramidData.ageGroups,
      leftData: window.agePyramidData.leftData,
      rightData: window.agePyramidData.rightData
  };

  statusReportsMap = dataset.statusReports || {};
  allReportsList = dataset.allReports || [];

  renderOverviewCharts(dataset);
  renderSphereChart(ageGroups, ageCounts);

  const firstCard = document.querySelector('.metric-card.status-total');
  if (firstCard) firstCard.classList.add('active');
});




// Navigation helpers to preserve filter states

function navigateWithFilter(status) {
  const url = new URL("<?php echo e(url('/national-admin/reports')); ?>", window.location.origin);
  const params = new URLSearchParams(window.location.search);

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

function navigateWithFilterByAnonymous(isAnonymous) {
  const url = new URL("<?php echo e(url('/national-admin/reports')); ?>", window.location.origin);
  const params = new URLSearchParams(window.location.search);

  params.forEach((value, key) => {
    if (key !== 'is_anonymous') {
      url.searchParams.append(key, value);
    }
  });

  url.searchParams.set('is_anonymous', isAnonymous ? 1 : 0);

  window.location.href = url.toString();
}

function navigateWithFilterByAbuseType(abuseTypeId) {
  const url = new URL("<?php echo e(url('/national-admin/reports')); ?>", window.location.origin);
  const params = new URLSearchParams(window.location.search);

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

const menuIcon = document.querySelector('.menu-icon');
const sidebar = document.querySelector('.sidebar');
const mainPanel = document.querySelector('.main-panel');

menuIcon.addEventListener('click', () => {
  sidebar.classList.toggle('open');
  mainPanel.classList.toggle('shifted');
});

function navigateWithFilterBySchool(schoolId) {
  const url = new URL("<?php echo e(url('/national-admin/reports')); ?>", window.location.origin);
  const params = new URLSearchParams(window.location.search);

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

function navigateToReportsUnfiltered() {
  window.location.href = "<?php echo e(url('/national-admin/reports')); ?>";
}

function exportPDF() {
  const element = document.getElementById('main-content'); 
  if (!element) {
    alert("Main content not found! Add id='main-content' to your <main> tag.");
    return;
  }

  html2pdf().from(element).set({
    margin: 10,
    filename: 'admin-dashboard.pdf',
    html2canvas: { scale: 2 },
    jsPDF: { unit: 'mm', format: 'a3', orientation: 'landscape' }
  }).save();
}
</script>
<script>
window.agePyramidData = {
    ageGroups: <?php echo json_encode($ageGroups, 15, 512) ?>,
    ageCounts: <?php echo json_encode($ageCounts, 15, 512) ?>   // NEW → single array
};


</script>
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
            filename: 'National-admin-dashboard.pdf',
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'mm', format: 'a3', orientation: 'landscape' }
        }).save();
    }
</script>
    
</body>
</html>
<?php /**PATH C:\xampp\htdocs\teketeApp\staging.teketesafespace.co.za\resources\views/national-admin-dashboard/index.blade.php ENDPATH**/ ?>