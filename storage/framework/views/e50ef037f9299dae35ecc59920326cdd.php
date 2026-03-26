<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tekete SafeSpace School Admin Dashboard</title>
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

button.active{
    background: var(--theme-gradient);
    color: var(--theme-dark);
}

button:hover, .sidebar-link:hover, .sidebar-link.active {
  color: #fff !important;
  background: linear-gradient(to right, #38b6ff, #38b6ff) !important;
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
.charts-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);  /* 2 equal columns */
  grid-template-rows: auto auto auto;     /* 3 rows */
  gap: 20px;
  width: 100%;
}

/* All chart cards same size */
.chart-card {
  width: 100%;
  height: 400px;              /* Ensures equal height */
  background:white;
  padding: 20px;
  border-radius: 12px;

}

/* Position each chart based on your order */
.chart-top-abuse     { grid-column: 1 / 2; grid-row: 1; }
.chart-monthly       { grid-column: 2 / 3; grid-row: 1; }

.chart-anonymous     { grid-column: 1 / 2; grid-row: 2; }

.chart-anonymous {
    height: 400px; /* Increase this value to make the whole card larger */
    display: flex;
    flex-direction: column;
}

#anonymousChart {
    flex-grow: 1; /* Forces the canvas to take up all remaining space below the H2 */
    width: 100% !important;
    height: 100% !important;
}

.chart-abuse-pie     { grid-column: 2 / 3; grid-row: 2; }

.chart-abuse-pie {
    height: 400px; /* Increase this value to make the whole card larger */
    display: flex;
    flex-direction: column;
}

#abuseTypeChart {
    flex-grow: 1; /* Forces the canvas to take up all remaining space below the H2 */
    width: 100% !important;
    height: 100% !important;
}

/* Last chart centered and alone in row 3 */
.chart-status {
  grid-column: 1 / 3;    /* spans both columns */
  grid-row: 4;
  width: 70%;            /* centered but still equal height */
  justify-self: center;
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
       
       .sidebar-link.active {
       background: linear-gradient(to right, #38b6ff, #38b6ff);
    color: #000;
    font-weight: 400;
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
    font-family: 'Century Gothic';
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
    height: 280px !important;
}

.modal-backdrop {
   position: fixed;
    inset: 0;
    background: rgba(0, 12, 12, 0.42); /* Subtle dark overlay */
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
    .charts-grid {
        grid-template-columns: 1fr;
    }
    .chart-top-abuse { grid-column: 1; grid-row: 1; }
    .chart-monthly { grid-column: 1; grid-row: 2; }
    .chart-anonymous { grid-column: 1; grid-row: 3; }
    .chart-abuse-pie { grid-column: 1; grid-row: 4; }
    .chart-status { grid-column: 1; grid-row: 5; width: 100%; }
}

/* Small mobile (max-width: 480px) */
@media (max-width: 480px) {
    .menu-icon {
        font-size: 24px;
        padding: 6px 10px;
    }
    
    .sidebar.open {
        width: 220px;
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
    <?php echo $__env->make('components.school-admin-styles', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>
<body>
<?php echo $__env->make('components.school-admin-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


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
           <h1>
 Tekete Safe Space School Admin Dashboard - 
  <span class="school-name"><?php echo e($school->school_name); ?></span>
</h1>

            <p class="subtitle">School case intelligence and live report monitoring.</p>
            
           <!-- Filters panel with 'Refresh Table' button and silver line -->
<section class="panel" aria-label="Filters">
    <h2>Filters</h2>
    <hr class="filter-separator"/>
    <form method="GET" action="<?php echo e(url()->current()); ?>" class="filters" id="filtersForm">
        <select name="abuse_type" onchange="this.form.submit()">
            <option value="">Any Reports Type</option>
            <?php $__currentLoopData = $abuseTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($type->id); ?>" <?php echo e($abuseTypeFilter == $type->id ? 'selected' : ''); ?>>
                    <?php echo e($type->type_name); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <select name="age_range" onchange="this.form.submit()">
            <option value="">Any Age</option>
            <?php $__currentLoopData = ['0-10','11-15','16-20','21-23']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $range): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($range); ?>" <?php echo e($ageRange == $range ? 'selected' : ''); ?>>
                    <?php echo e($range); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <select name="grade" onchange="this.form.submit()">
            <option value="" <?php echo e(empty($gradeFilter) ? 'selected' : ''); ?>>Any Grade</option>
            <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $gradeLower = strtolower(trim($grade));
                    $displayGrade = $grade;
                    
                    // Fix spelling: Cretch -> Creche
                    if (preg_match('/^cr[èe]?t?ch?e?$/i', $gradeLower) || $gradeLower === 'cretch') {
                        $displayGrade = 'Creche';
                    }
                    // Format Grade R
                    elseif ($gradeLower === 'r' || $gradeLower === 'grade r') {
                        $displayGrade = 'Grade R';
                    }
                    // Format numeric grades
                    elseif (is_numeric($grade)) {
                        $displayGrade = 'Grade ' . $grade;
                    }
                    // Format "Grade X" format (ensure proper capitalization)
                    elseif (preg_match('/^grade\s*(\d+)$/i', $gradeLower, $matches)) {
                        $displayGrade = 'Grade ' . $matches[1];
                    }
                    // Capitalize first letter for other grades
                    else {
                        $displayGrade = ucfirst($grade);
                    }
                ?>
                <option value="<?php echo e($grade); ?>" <?php echo e(!empty($gradeFilter) && $gradeFilter == $grade ? 'selected' : ''); ?>>
                    <?php echo e($displayGrade); ?>

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
                <div class="metric-card status-total" onclick="activateCard(this, 'total')">
                    <span class="card-title">Total Reports</span>
                    <div class="card-value"><?php echo e(number_format($summaryCounts['total'] ?? 0)); ?></div>
                </div>
                <div class="metric-card status-awaiting" onclick="activateCard(this, 'awaiting-resolution')">
                    <span class="card-title">Awaiting Resolution</span>
                    <div class="card-value"><?php echo e(number_format($summaryCounts['statuses']['awaiting-resolution'] ?? 0)); ?></div>
                </div>
                <div class="metric-card status-forwarded" onclick="activateCard(this, 'forwarded')">
                    <span class="card-title">Forwarded</span>
                    <div class="card-value"><?php echo e(number_format($summaryCounts['statuses']['forwarded'] ?? 0)); ?></div>
                </div>
                <div class="metric-card status-review" onclick="activateCard(this, 'under-review')">
                    <span class="card-title">Under Review</span>
                    <div class="card-value"><?php echo e(number_format($summaryCounts['statuses']['under-review'] ?? 0)); ?></div>
                </div>
                <div class="metric-card status-closed" onclick="activateCard(this, 'closed')">
                    <span class="card-title">Closed</span>
                    <div class="card-value"><?php echo e(number_format($summaryCounts['statuses']['closed'] ?? 0)); ?></div>
                </div>
                <div class="metric-card status-unresolved" onclick="activateCard(this, 'unresolved')">
                    <span class="card-title">Unresolved</span>
                    <div class="card-value"><?php echo e(number_format($summaryCounts['statuses']['unresolved'] ?? 0)); ?></div>
                </div>
                <div class="metric-card status-false" onclick="activateCard(this, 'false-report')">
                    <span class="card-title">False-Report</span>
                    <div class="card-value"><?php echo e(number_format($summaryCounts['statuses']['false-report'] ?? 0)); ?></div>
                </div>
            </section>
            <section class="extras-row" aria-label="Extra metrics">
                <div class="metric-card extras-anonymous" onclick="openExtrasModal('anonymous')">
                    <span class="card-title">Anonymous</span>
                    <div class="card-value"><?php echo e(number_format($anonymousCounts['anonymous'] ?? 0)); ?></div>
                </div>
                <div class="metric-card extras-identified" onclick="openExtrasModal('identified')">
                    <span class="card-title">Identified</span>
                    <div class="card-value"><?php echo e(number_format($anonymousCounts['identified'] ?? 0)); ?></div>
                </div>
                <div class="metric-card extras-abuse" onclick="openExtrasModal('abuse-types')">
                    <span class="card-title">Types Of Report Tracked</span>
                    <div class="card-value"><?php echo e(count($abuseTypeLabels)); ?></div>
                </div>
                <div class="metric-card extras-schools" onclick="openExtrasModal('top-types')">
                    <span class="card-title">Top Report Types</span>
                    <div class="card-value"><?php echo e(count($topAbuseTypes ?? [])); ?></div>
                </div>
            </section>

            <!-- False Reports summary card: identify repeat reporters -->
            <!--<?php $fr = $falseReportSummary ?? ['total' => 0, 'repeat_emails' => 0, 'repeat_names' => 0, 'repeat_phones' => 0]; ?>-->
            <!--<?php if($fr['total'] > 0): ?>-->
            <!--<section class="panel" aria-label="False Reports Summary">-->
            <!--    <h2>False Reports &amp; Repeat Reporters</h2>-->
            <!--    <p class="subtext" style="color: #6b7280; margin-bottom: 1rem;">Identify people who have submitted multiple false reports (by email, name, or phone).</p>-->
            <!--    <div class="stats-grid" style="display: flex; flex-wrap: wrap; gap: 1rem; align-items: center;">-->
            <!--        <div class="stat-card" style="min-width: 140px;">-->
            <!--            <div class="stat-value" style="font-size: 1.75rem;"><?php echo e($fr['total']); ?></div>-->
            <!--            <div class="stat-label">Total False Reports</div>-->
            <!--        </div>-->
            <!--        <div class="stat-card" style="min-width: 140px;">-->
            <!--            <div class="stat-value" style="font-size: 1.75rem;"><?php echo e($fr['repeat_emails']); ?></div>-->
            <!--            <div class="stat-label">Emails with 2+ false</div>-->
            <!--        </div>-->
            <!--        <div class="stat-card" style="min-width: 140px;">-->
            <!--            <div class="stat-value" style="font-size: 1.75rem;"><?php echo e($fr['repeat_names']); ?></div>-->
            <!--            <div class="stat-label">Names with 2+ false</div>-->
            <!--        </div>-->
            <!--        <div class="stat-card" style="min-width: 140px;">-->
            <!--            <div class="stat-value" style="font-size: 1.75rem;"><?php echo e($fr['repeat_phones']); ?></div>-->
            <!--            <div class="stat-label">Phones with 2+ false</div>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--    <p style="margin-top: 1rem;"><a href="<?php echo e(url('/admin/false-reports')); ?>" class="sidebar-link" style="display: inline-block; padding: 0.75rem 1.5rem;">View False Reports Analysis &rarr;</a></p>-->
            <!--</section>-->
            <!--<?php endif; ?>-->

          <section class="panel" aria-label="Analytics">
    <div class="charts-grid">

        <div class="chart-card chart-top-abuse">
            <h2>Top Report Types</h2>
            <canvas id="topAbuseTypesChart"></canvas>
        </div>

        <div class="chart-card chart-monthly">
            <h2>Monthly Trends</h2>
            <canvas id="monthlyTrendChart"></canvas>
        </div>

        <div class="chart-card chart-anonymous">
            <h2>Anonymous vs Identified</h2>
            <canvas id="anonymousChart"></canvas>
        </div>

        <div class="chart-card chart-abuse-pie">
            <h2>Report Types Distribution</h2>
            <canvas id="abuseTypeChart"></canvas>
        </div>

        <div class="chart-card chart-status">
            <h2>Status Breakdown</h2>
            <canvas id="statusChart"></canvas>
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
    <?php echo json_encode([
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
        select.disabled = false;  // enable in case disabled
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

function renderOverviewCharts(dataset) {
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

    // Abuse Type Distribution - pie chart (Report Type Distribution)
    const abuseLabels = dataset.abuseLabels || [];
    const abuseCountsRaw = dataset.abuseCounts || [];
    const abuseCounts = abuseLabels.map((_, i) => abuseCountsRaw[i] ?? 0);
    const abuseColors = ['#004c99', '#fcb825', '#00c382', '#9b57cc', '#81acef', '#38b6ff', '#ff66c4', '#C0C0C0', '#FF0000', '#FFFF00'];

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
            layout: { padding: 0 },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 12,
                        font: { size: 12, family: 'Montserrat' },
                        generateLabels: function(chart) {
                            const data = chart.data;
                            const ds = data.datasets[0];
                            const pcts = percentagesTo100(ds.data);
                            return data.labels.map((label, i) => ({
                                text: label + ' (' + pcts[i] + '%)',
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
   // Status Chart - SOLID (NO CURVES) BARS WITH CUSTOM COLORS
const statuses = Object.entries(dataset.statusCounts || {}).sort((a, b) => b[1] - a[1]);
const labels = statuses.map(s => s[0]);
const values = statuses.map(s => s[1]);

const customColors = ['#00c382', '#fcb825', '#99c4d3', '#9b57cc', '#81acef', '#38b6ff', '#ff66c4', '#C0C0C0', '#FF0000', '#FFFF00'];
const leftColors = labels.map((_, i) => customColors[i % customColors.length]);
const rightColors = leftColors.map(c => c);

createChart('statusChart', {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [
            {
                label: 'Left Side',
                data: values.map(v => -v),
                backgroundColor: leftColors,
                borderRadius: 0,
                borderWidth: 0,
                borderSkipped: false,
            },
            {
                label: 'Right Side',
                data: values,
                backgroundColor: rightColors,
                borderRadius: 0,
                borderWidth: 0,
                borderSkipped: false,
            }
        ]
    },
    options: {
        indexAxis: 'y',
        scales: {
            x: {
                stacked: true,
                ticks: { 
                    callback: val => Math.abs(val),
                    color: '#666',
                    font: { size: 12 }
                },
                grid: {
                    display: true,           // show vertical lines
                    drawTicks: false,
                    drawBorder: false,
                    color: 'rgba(0,0,0,0.08)',
                    borderDash: [0, 0],
                    lineWidth: 1
                },
                border: { display: false }
            },
            y: { 
                stacked: true,
                ticks: { font: { size: 13, weight: '600' } },
                grid: { display: false }  // remove horizontal lines
            }
        },
        plugins: {
            legend: { display: false },
            tooltip: { 
                backgroundColor: 'rgba(0,0,0,0.9)',
                titleColor: 'white',
                bodyColor: 'white',
                cornerRadius: 6,
                callbacks: { 
                    title: ctx => labels[ctx[0].dataIndex],
                    label: ctx => `${Math.abs(ctx.parsed.x)} reports`
                }
            },
            datalabels: { display: false } // remove any bar labels
        },
        responsive: true,
        maintainAspectRatio: false,
        animation: {
            duration: 1500,
            easing: 'easeOutQuart'
        },
        elements: {
            bar: {
                borderSkipped: false
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
}
,
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
});

   
   // Navigate preserving all active filters and adding/updating 'status' filter
function navigateWithFilter(status) {
    const url = new URL("<?php echo e(url('/admin/reports')); ?>", window.location.origin);
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
    const url = new URL("<?php echo e(url('/admin/reports')); ?>", window.location.origin);
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
    const url = new URL("<?php echo e(url('/admin/reports')); ?>", window.location.origin);
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
    const url = new URL("<?php echo e(url('/admin/reports')); ?>", window.location.origin);
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
    window.location.href = "<?php echo e(url('/admin/reports')); ?>";
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

    </script>
    <?php echo $__env->make('components.school-admin-sidebar-script', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<script src="<?php echo e(asset('js/mobile-select-modal.js')); ?>"></script>
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
<?php /**PATH C:\xampp\htdocs\staging.teketesafespace.co.za\resources\views/school-admin-dashboard/index.blade.php ENDPATH**/ ?>