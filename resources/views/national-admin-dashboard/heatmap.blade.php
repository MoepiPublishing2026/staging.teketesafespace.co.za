<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Tekete SafeSpace – National Heatmap</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --theme-gradient: linear-gradient(to right, #38b6ff, #38b6ff);
            --theme-dark: #0c8cb3ff;
            --red: #ed1c24;
            --yellow: #fbbf0f;
            --blue: #3b82f6;
            --orange: #f97316;
            --gray: #2a2e32;
            --green: #d1cb23;
            --bg: white;
            --text: #253f58ff;
            --sidebar-bg: white;
            --sidebar-hover: var(--theme-gradient);
            --sidebar-active: linear-gradient(to right, #38b6ff, #38b6ff);
            --sidebar-border: #c7da30;
        }

        * { box-sizing: border-box; }
        html { overflow-x: hidden; }
        html, body {
            font-family: 'Montserrat', sans-serif !important;
            color: #545454 !important;
        }
        body {
            display: flex;
            min-height: 100vh;
            width: 100%;
            min-width: 0;
            overflow-x: hidden;
            overflow-y: hidden;
        }

        .sidebar {
            width: 235px;
            background-color: white;
            border-right: 1px solid #eaeaea;
            display: flex;
            flex-direction: column;
            padding-top: 120px;
        }
        .sidebar-logo { position: fixed; top: 40px; left: 40px; width: 100px; height: auto; }
        .sidebar-logo img { width: 115px; height: auto; display: block; }
        .sidebar-list { list-style: none; padding: 0 0 0 22px; }
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
        .sidebar-link:hover, .sidebar-link.active {
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
            background-color: #c7da30 !important;
            color: white !important;
            border-color: #38b6ff !important;
            outline: none;
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
        .profile { display: flex; align-items: center; gap: 0.8rem; }
        .profile-avatar {
            width: 42px; height: 42px; border-radius: 50%; background: #ececec;
            overflow: hidden; display: flex; align-items: center; justify-content: center;
            box-shadow: 0 1px 6px rgba(51,51,63,0.08);
        }
        .profile-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .profile .meta { text-align: right; }
        .profile .meta > span:first-child { color: #38b6ff; font-size: 18px; font-weight: 700; }
        .profile .meta span { display: block; line-height: 1.3; font-weight: 700; color: #232323; }
        .profile .meta .role { font-weight: 400; color: #333030ff; font-size: 0.9rem; }

        .main-panel {
            flex: 1 1 0;
            display: flex;
            flex-direction: column;
            min-width: 0;
            min-height: 100vh;
            height: auto;
            background: white;
            overflow-x: hidden;
        }
        .dashboard-scroll {
            flex: 1 1 0;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 2.5rem;
            max-width: 1280px;
            width: 100%;
            margin: 0 auto;
        }

        h1 {
            margin: 0 0 0.5rem;
            font-weight: 900 !important;
            font-size: 32px !important;
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
            margin: 0 0 1rem;
        }
        .subtitle { margin-bottom: 2rem; color: #5f6b7b; text-align: center; }
        .panel { background: white; border-radius: 1rem; padding: 0; max-width: 100%; }
        .panel + .panel { margin-top: 1.8rem; }

        .filter-panel {
            background: #fff;
            border-radius: 10px;
            padding: 1.25rem;
            width: 100%;
            border: 2px solid #c7da30;
            margin-bottom: 1.8rem;
        }
        .filter-panel hr {
            border: none;
            border-top: 1px solid #eaeaea;
            margin: 0.75rem 0 1rem;
        }
        .filters {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            align-items: flex-end;
        }
        .filters select,
        .filters input[type="date"] {
            font-family: 'Montserrat', sans-serif;
            font-size: 13px;
            font-weight: 600;
            padding: 0.5rem 0.65rem;
            border: 1px solid #111827;
            border-radius: 6px;
            background: #fff;
            color: #111827;
            min-width: 140px;
        }
        .filters label {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            font-size: 12px;
            font-weight: 700;
            color: #4b5563;
        }
        .filter-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 1rem;
        }
        .filter-clear {
            font-size: 12px;
            font-weight: 700;
            color: #38b6ff;
            text-decoration: none;
        }
        .filter-clear:hover { text-decoration: underline; }
        .heatmap-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 1rem;
            margin-bottom: 1.8rem;
        }
        .heatmap-summary-card {
            background: #fff;
            border: 2px solid #c7da30;
            border-radius: 10px;
            padding: 1rem 1.15rem;
        }
        .heatmap-summary-card .label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #6b7280;
            margin-bottom: 0.35rem;
        }
        .heatmap-summary-card .value {
            font-size: 26px;
            font-weight: 900;
            color: #111827;
            line-height: 1.1;
        }
        .heatmap-total-row th,
        .heatmap-total-row td {
            background: #e5e7eb;
            font-weight: 800;
        }
        .filter-chips span {
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            border-radius: 999px;
            padding: 0.35rem 0.75rem;
            font-size: 12px;
            font-weight: 700;
            color: #374151;
        }

        .menu-icon {
            display: none;
            position: fixed;
            top: 12px; left: 12px;
            width: 44px; height: 44px;
            padding: 0;
            border: 2px solid #e5e7eb;
            background: white !important;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            cursor: pointer;
            z-index: 1001;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: #38b6ff !important;
        }
        .menu-icon:hover { background: #f3f4f6 !important; border-color: #38b6ff !important; }
        .sidebar-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.3); z-index: 999;
            opacity: 0; transition: opacity 0.2s ease;
        }
        .sidebar-overlay.active { display: block; opacity: 1; }
        @media (min-width: 901px) { .sidebar-overlay { display: none !important; } }

        .heatmap-panel {
            background: #fff;
            border-radius: 10px;
            padding: 1.25rem;
            overflow-x: auto;
            width: 100%;
            border: 2px solid #c7da30;
            margin-bottom: 2rem;
        }
        .heatmap-toolbar { display: flex; flex-wrap: wrap; align-items: center; gap: 1rem; margin-bottom: 1rem; }
        .heatmap-view-toggle { display: flex; gap: 0.5rem; }
        .heatmap-view-toggle button {
            padding: 0.35rem 0.75rem;
            border: 2px solid #c7da30;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 900;
            font-family: 'Montserrat', sans-serif;
            cursor: pointer;
            background: #fff;
            color: #545454;
        }
        .heatmap-view-toggle button:hover { background: #c7da30; color: #fff; }
        .heatmap-view-toggle button.active { background: #c7da30; color: #fff; }
        .heatmap-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .heatmap-table { border-collapse: collapse; font-size: 13px; min-width: 100%; }
        .heatmap-table th, .heatmap-table td { border: 1px solid #111827; padding: 0.5rem 0.65rem; text-align: center; }
        .heatmap-corner { background: #d1d5db; font-weight: 700; text-align: left !important; min-width: 140px; }
        .heatmap-col { background: #d1d5db; font-weight: 700; white-space: nowrap; min-width: 90px; }
        .heatmap-row { background: #d1d5db; font-weight: 600; text-align: left !important; padding-left: 0.75rem; min-width: 140px; }
        .heatmap-cell { font-weight: 600; cursor: pointer; min-width: 50px; position: relative; }
        .heatmap-cell.heatmap-cell-dark { color: #fff; text-shadow: 0 1px 2px rgba(0,0,0,0.25); }
        .heatmap-cell:hover { outline: 2px solid #38b6ff; z-index: 2; }
        .heatmap-cell.heat-band-0 { background-color: #d1cb23; }
        .heatmap-cell.heat-band-1 { background-color: #fbbf0f; }
        .heatmap-cell.heat-band-2 { background-color: #ed1c24; }
        .heatmap-scale-wrap { display: flex; flex-wrap: wrap; align-items: center; gap: 1rem; margin-top: 1rem; }
        .heatmap-scale { display: flex; align-items: center; gap: 0.5rem; font-size: 12px; color: #6b7280; }
        .heatmap-scale-bar { height: 14px; width: 180px; border-radius: 7px; background: linear-gradient(to right, #d1cb23 0%, #fbbf0f 50%, #ed1c24 100%); border: 1px solid #111827; }

        .map-panel { background: white; border-radius: 1rem; padding: 1.25rem; border: 2px solid #c7da30; }
        .district-map-container {
            height: 520px;
            width: 100%;
            max-width: 100%;
            min-height: 320px;
            border-radius: 0.5rem;
            overflow: hidden;
            position: relative;
            background: #f6f7f2;
        }
        .district-map-svg { position: absolute; inset: 0; width: 100%; height: 100%; display: block; overflow: visible; z-index: 1; }
        .heat-glow-layer { pointer-events: none; overflow: visible; }
        .district-map-shape { stroke: rgba(255,255,255,0.9); stroke-width: 1.2; transition: stroke 0.15s ease, stroke-width 0.15s ease; }
        .district-map-shape.is-hover,
        .district-map-shape.is-key-hover { stroke: #111827; stroke-width: 2.2; }
        .district-map-shape.is-selected { stroke: #38b6ff; stroke-width: 3; filter: drop-shadow(0 0 4px rgba(56,182,255,0.45)); }
        .district-map-province-border {
            fill: none;
            stroke: #111827;
            stroke-width: 2.25;
            stroke-linejoin: round;
            stroke-linecap: round;
            vector-effect: non-scaling-stroke;
        }
        .heatmap-table tr.heatmap-row-active th.heatmap-row { background: #38b6ff; color: #fff; }
        .map-label-layer { pointer-events: none; user-select: none; }
        .map-label-layer text {
            font-family: 'Montserrat', system-ui, sans-serif;
            font-weight: 900;
            paint-order: stroke fill;
            stroke: #ffffff;
            stroke-width: 0.5px;
            stroke-linejoin: round;
        }
        .map-label-layer .map-label-province {
            fill: #111827;
            stroke-width: 0.65px;
        }
        .map-label-layer .map-label-district {
            fill: #1f2937;
            stroke-width: 0.4px;
        }
        .district-map-status {
            position: absolute; inset: 0;
            display: grid; place-items: center;
            font-weight: 800; color: #4b5563;
            background: rgba(246, 247, 242, 0.65);
            z-index: 5;
        }
        .district-map-tooltip {
            position: absolute; left: 0; top: 0;
            transform: translate(-9999px, -9999px);
            background: rgba(255,255,255,0.98);
            border: 1px solid rgba(17,24,39,0.2);
            border-radius: 10px;
            padding: 8px 10px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
            font-size: 12px;
            color: #111827;
            pointer-events: none;
            z-index: 25;
            max-width: 260px;
            line-height: 1.2;
        }
        .district-map-tooltip .tt-title { font-weight: 900; font-size: 12px; }
        .district-map-tooltip .tt-sub { font-weight: 700; font-size: 11px; color: #4b5563; margin-top: 2px; }
        .district-map-key {
            position: absolute; top: 12px; left: 12px; z-index: 20;
            background: rgba(255,255,255,0.96);
            border: 1px solid rgba(17,24,39,0.2);
            border-radius: 10px;
            padding: 10px 10px 8px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
            max-height: calc(100% - 24px);
            overflow: auto;
            min-width: 210px;
        }
        .district-map-key-title {
            font-weight: 900;
            font-size: 11px;
            color: #111827;
            margin-bottom: 6px;
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }
        .district-map-key-title .map-key-meta { font-weight: 700; color: #6b7280; text-transform: none; letter-spacing: 0; }
        .map-key-tools { display: flex; flex-direction: column; gap: 6px; margin-bottom: 8px; }
        .map-key-search {
            width: 100%;
            font-family: 'Montserrat', sans-serif;
            font-size: 11px;
            font-weight: 600;
            padding: 5px 8px;
            border: 1px solid rgba(17,24,39,0.25);
            border-radius: 6px;
            background: #fff;
        }
        .map-key-sort { display: flex; gap: 4px; }
        .map-key-sort-btn {
            flex: 1;
            padding: 4px 6px !important;
            font-size: 10px !important;
            border-radius: 5px !important;
            min-height: 0 !important;
        }
        .map-key-sort-btn.active { background: #c7da30 !important; color: #fff !important; }
        .district-map-key-rows { max-height: 340px; overflow-y: auto; }
        .district-map-key-row.is-zero .district-map-key-name,
        .district-map-key-row.is-zero .district-map-key-count { color: #9ca3af; font-weight: 700; }
        .district-map-key-row {
            display: grid;
            grid-template-columns: 14px 1fr auto;
            gap: 8px;
            align-items: center;
            font-size: 11px;
            color: #111827;
            padding: 4px 0;
            border-top: 1px solid rgba(17,24,39,0.08);
            cursor: pointer;
            user-select: none;
        }
        .district-map-key-row:first-of-type { border-top: none; }
        .district-map-key-row:hover { background: rgba(56,182,255,0.10); border-radius: 6px; }
        .district-map-key-swatch { width: 14px; height: 10px; border: 1px solid rgba(17,24,39,0.35); border-radius: 3px; }
        .district-map-key-name { font-weight: 800; color: #111827; }
        .district-map-key-count { font-weight: 900; color: #4b5563; white-space: nowrap; }
        .map-legend {
            position: absolute;
            bottom: 18px;
            right: 18px;
            z-index: 20;
            background: rgba(255,255,255,0.96);
            padding: 10px 12px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.15);
            font-size: 12px;
            font-family: 'Montserrat', sans-serif;
        }
        .map-legend-row { display: flex; align-items: center; gap: 8px; font-size: 12px; color: #111827; margin-top: 6px; }
        .map-legend-swatch { width: 16px; height: 16px; border-radius: 2px; border: 1px solid rgba(17,24,39,0.35); }
        .map-legend-swatch.none { background: #d1cb23; opacity: 0.85; }
        .map-legend-swatch.low { background: #d1cb23; }
        .map-legend-swatch.medium { background: #fbbf0f; }
        .map-legend-swatch.high { background: #ed1c24; }

        @media (max-width: 900px) {
            .menu-icon { display: flex !important; }
            .sidebar {
                position: fixed; top: 0; left: 0; width: 0; height: 100vh;
                background: white; overflow-x: hidden; overflow-y: auto;
                transition: width 0.3s ease; z-index: 1000;
                box-shadow: 2px 0 12px rgba(0,0,0,0.15); padding-top: 0;
            }
            .sidebar.open { width: 240px; }
            .sidebar-logo { display: none; position: sticky; top: 0; left: 0; width: 100%; padding: 12px 12px 0; background: white; justify-content: flex-end; }
            .sidebar.open .sidebar-logo { display: flex; }
            .main-panel { margin-left: 0 !important; width: 100%; }
            .dashboard-scroll { padding: 1rem; }
            .district-map-container { height: 320px; min-height: 280px; }
            h1 { font-size: 22px !important; padding: 0 0.5rem; }
            .heatmap-wrap { -webkit-overflow-scrolling: touch; overflow-x: auto; }
            .heatmap-table { font-size: 11px; }
            .heatmap-table th, .heatmap-table td { padding: 0.35rem 0.45rem; }
        }
    </style>
</head>
<body>

<aside class="sidebar" id="na-sidebar">
    <div class="sidebar-logo">
        <img src="{{ asset('images/logo.png') }}" alt="Tekete SafeSpace">
    </div>
    <ul class="sidebar-list">
        <a href="{{ url('/national-admin/dashboard') }}" class="sidebar-link {{ request()->is('national-admin/dashboard') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ url('/national-admin/reports') }}" class="sidebar-link {{ request()->is('national-admin/reports') ? 'active' : '' }}">Reports</a>
        <a href="{{ url('/national-admin/heatmap') }}" class="sidebar-link {{ request()->is('national-admin/heatmap') ? 'active' : '' }}">Heat-Map</a>
        <a href="{{ url('/national-admin/settings') }}" class="sidebar-link {{ request()->is('national-admin/settings') ? 'active' : '' }}">My Profile</a>
        <a href="#" onclick="event.preventDefault(); exportPDF();" class="sidebar-link">Export PDF</a>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="sidebar-link">Sign Out</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </ul>
</aside>

<div class="sidebar-overlay" id="sidebarOverlay" aria-hidden="true"></div>

<div class="main-panel">
    <button class="menu-icon" id="sidebarToggle" aria-label="Toggle menu" type="button">&#9776;</button>

    <div class="topbar">
        <div class="profile">
            <div class="meta">
                @php
                    $currentUser = auth()->user()?->fresh();
                    $fullName = $currentUser->name ?? 'Administrator';
                    $nameParts = explode(' ', $fullName, 2);
                    $firstName = $nameParts[0] ?? '';
                    $surname = $nameParts[1] ?? '';
                @endphp
                <span>{{ $firstName }} {{ $surname }}</span>
                <span class="role">Administrator</span>
            </div>
            <div class="profile-avatar">
                @if($currentUser && $currentUser->profile_picture)
                    <img src="{{ $currentUser->profile_picture_url }}" alt="Profile Picture"
                         onerror="this.style.display='none'; this.parentElement.style.background='#ececec';">
                @else
                    <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24" style="color: #999;">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                @endif
            </div>
        </div>
    </div>

    <div class="dashboard-scroll" id="main-content">
        <h1>Tekete SafeSpace National Heatmap</h1>
        <p class="subtitle">Province-level intensity by report type, aligned with the provincial heat-map experience.</p>

        <section class="filter-panel" aria-label="Filters">
            <div style="display:flex;align-items:center;flex-wrap:wrap;gap:0.75rem;">
                <h2 style="margin:0;">Filters</h2>
                @if(!empty($activeFilters))
                    <a href="{{ url('/national-admin/heatmap') }}" class="filter-clear">Clear all filters</a>
                @endif
            </div>
            <hr>
            <form method="GET" action="{{ url('/national-admin/heatmap') }}" class="filters" id="heatmapFiltersForm">
                <select name="province" id="provinceSelect" onchange="this.form.submit()">
                    <option value="">All Provinces</option>
                    @foreach ($provinces as $province)
                        <option value="{{ $province->id }}" {{ (string) $provinceFilter === (string) $province->id ? 'selected' : '' }}>
                            {{ $province->name }}
                        </option>
                    @endforeach
                </select>
                <select name="district" id="districtSelect" onchange="this.form.submit()" {{ $provinceFilter ? '' : 'disabled' }}>
                    <option value="">All Districts</option>
                    @foreach ($districts as $district)
                        <option value="{{ $district->id }}" {{ (string) $districtFilter === (string) $district->id ? 'selected' : '' }}>
                            {{ $district->name }}
                        </option>
                    @endforeach
                </select>
                <select name="school" id="schoolSelect" onchange="this.form.submit()" {{ ($districtFilter && $provinceFilter) ? '' : 'disabled' }}>
                    <option value="">All Schools</option>
                    @foreach ($schools as $school)
                        <option value="{{ $school->school_id }}" {{ (string) $schoolFilter === (string) $school->school_id ? 'selected' : '' }}>
                            {{ $school->school_name }}
                        </option>
                    @endforeach
                </select>
                <select name="abuse_type" onchange="this.form.submit()">
                    <option value="">Any Report Type</option>
                    @foreach ($abuseTypes as $type)
                        <option value="{{ $type->id }}" {{ (string) $abuseTypeFilter === (string) $type->id ? 'selected' : '' }}>
                            {{ $type->type_name }}
                        </option>
                    @endforeach
                </select>
                <select name="age_range" onchange="this.form.submit()">
                    <option value="">Any Age</option>
                    @foreach (['0-10','11-15','16-20','21-22','30+'] as $range)
                        <option value="{{ $range }}" {{ $ageRange === $range ? 'selected' : '' }}>{{ $range }}</option>
                    @endforeach
                </select>
                <label>
                    From
                    <input type="date" name="from_date" value="{{ $fromDate }}" onchange="this.form.submit()">
                </label>
                <label>
                    To
                    <input type="date" name="to_date" value="{{ $toDate }}" onchange="this.form.submit()">
                </label>
            </form>
            @if(!empty($activeFilters))
                <div class="filter-chips" aria-label="Active filters">
                    @foreach ($activeFilters as $chip)
                        <span>{{ $chip }}</span>
                    @endforeach
                </div>
            @endif
        </section>

        @php
            $nationalDistrictsWithReports = collect($mapDistrictCounts ?? [])->filter(fn ($c) => (int) $c > 0)->count();
            $nationalProvincesWithReports = collect($provinceHeatmapRowTotals ?? [])->filter(fn ($c) => (int) $c > 0)->count();
        @endphp
        <div class="heatmap-summary" aria-label="Summary">
            <div class="heatmap-summary-card">
                <div class="label">Total reports</div>
                <div class="value">{{ number_format($filteredReportsTotal ?? ($provinceHeatmapGrandTotal ?? 0)) }}</div>
            </div>
            <div class="heatmap-summary-card">
                <div class="label">Provinces with data</div>
                <div class="value">{{ $nationalProvincesWithReports }} <span style="font-size:14px;font-weight:700;color:#6b7280;">/ {{ count($provinces ?? []) }}</span></div>
            </div>
            <div class="heatmap-summary-card">
                <div class="label">Districts with data</div>
                <div class="value">{{ $nationalDistrictsWithReports }} <span style="font-size:14px;font-weight:700;color:#6b7280;">/ {{ count($mapDistrictCounts ?? []) }}</span></div>
            </div>
        </div>

        <section class="heatmap-panel" id="provinceHeatmapPanel" aria-label="Reports by Province and Type">
            <h2>Reports by Province &amp; Report Type</h2>
            <div class="heatmap-toolbar">
                <div class="heatmap-view-toggle" role="group" aria-label="View mode">
                    <button type="button" class="heatmap-view-btn active" data-view="count" aria-pressed="true">COUNTS</button>
                    <button type="button" class="heatmap-view-btn" data-view="percent" aria-pressed="false">ROW%</button>
                </div>
            </div>

            <div class="heatmap-wrap">
                <table class="heatmap-table" role="table">
                    <thead>
                        <tr>
                            <th class="heatmap-corner">Province</th>
                            @foreach($provinceHeatmapAbuseTypes ?? [] as $atype)
                                <th class="heatmap-col">{{ $atype }}</th>
                            @endforeach
                            <th class="heatmap-col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($provinceHeatmapMatrix ?? [] as $provinceName => $row)
                            @php
                                $rowIdx = $loop->index;
                                $rowProvinceId = $provinceHeatmapProvinceNameToId[$provinceName] ?? null;
                                $isActiveProvince = $provinceFilter && (string) $rowProvinceId === (string) $provinceFilter;
                            @endphp
                            <tr class="{{ $isActiveProvince ? 'heatmap-row-active' : '' }}">
                                <th class="heatmap-row">{{ $provinceName }}</th>
                                @foreach($row as $colIdx => $count)
                                    @php
                                        $atype = $provinceHeatmapAbuseTypes[$colIdx] ?? '';
                                        $provinceId = $provinceHeatmapProvinceNameToId[$provinceName] ?? null;
                                        $abuseTypeId = $provinceHeatmapAbuseTypeNameToId[$atype] ?? null;
                                        $pct = $provinceHeatmapPercentages[$provinceName][$colIdx] ?? 0;
                                        $intensity = ($provinceHeatmapMax ?? 1) > 0 ? min(1, $count / ($provinceHeatmapMax ?? 1)) : 0;
                                        $colors = ['#d1cb23', '#fbbf0f', '#ed1c24'];
                                        $colorIdx = $intensity >= 0.67 ? 2 : ($intensity >= 0.34 ? 1 : 0);
                                        $bgColor = $colors[$colorIdx];
                                        $isDark = $colorIdx === 2;
                                        $isHotspot = in_array($colIdx, $provinceHeatmapHotspots[$provinceName] ?? []);
                                        $animDelay = ($rowIdx * count($row) + $colIdx) * 0.02;
                                    @endphp
                                    <td class="heatmap-cell heat-band-{{ $colorIdx }} {{ $isDark ? 'heatmap-cell-dark' : '' }} {{ $isHotspot ? 'heatmap-hotspot' : '' }}"
                                        data-heat-band="{{ $colorIdx }}"
                                        data-count="{{ $count }}"
                                        data-percent="{{ $pct }}"
                                        data-province="{{ $provinceName }}"
                                        data-abuse-type="{{ $atype }}"
                                        data-province-id="{{ $provinceId }}"
                                        data-abuse-type-id="{{ $abuseTypeId }}"
                                        role="button"
                                        tabindex="0"
                                        title="{{ $provinceName }} × {{ $atype }}: {{ $count }} reports ({{ $pct }}% of province) — Click to view reports">
                                        <span class="heatmap-cell-count">{{ $count }}</span>
                                        <span class="heatmap-cell-pct" style="display:none;">{{ $pct }}%</span>
                                    </td>
                                @endforeach
                                <td class="heatmap-row" style="font-weight:800;">{{ number_format($provinceHeatmapRowTotals[$provinceName] ?? 0) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($provinceHeatmapAbuseTypes ?? []) + 2 }}" style="text-align:center; padding:2rem; color:#6b7280;">No report data for the selected filters.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if(!empty($provinceHeatmapMatrix))
                    <tfoot>
                        <tr class="heatmap-total-row">
                            <th class="heatmap-row">Total</th>
                            @foreach($provinceHeatmapColumnTotals ?? [] as $colTotal)
                                <td>{{ number_format($colTotal) }}</td>
                            @endforeach
                            <td>{{ number_format($provinceHeatmapGrandTotal ?? 0) }}</td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>

            <div class="heatmap-scale-wrap">
                <div class="heatmap-scale" id="provinceHeatmapScaleCount">
                    <span>LOW</span>
                    <div class="heatmap-scale-bar" aria-hidden="true"></div>
                    <span>HIGH</span>
                </div>
                <div class="heatmap-scale" id="provinceHeatmapScalePct" style="display:none;">
                    <span>0%</span>
                    <div class="heatmap-scale-bar" aria-hidden="true"></div>
                    <span>100%</span>
                </div>
            </div>
        </section>

        <section class="panel map-panel" aria-label="Reports by District Geographic Heatmap">
            <h2>Reports by Province &amp; District (Geographic)</h2>
            <div id="province-map" class="district-map-container">
                <div class="district-map-status" id="provinceMapStatus">Loading map…</div>
                <div class="district-map-key" id="provinceMapKey" style="display:none;">
                    <div class="district-map-key-title">Districts <span class="map-key-meta" id="provinceMapKeyMeta"></span></div>
                    <div class="map-key-tools">
                        <input type="search" class="map-key-search" id="provinceMapKeySearch" placeholder="Search districts…" aria-label="Search districts">
                        <div class="map-key-sort">
                            <button type="button" class="map-key-sort-btn active" data-sort="name">A–Z</button>
                            <button type="button" class="map-key-sort-btn" data-sort="count">By reports</button>
                        </div>
                    </div>
                    <div class="district-map-key-rows" id="provinceMapKeyRows"></div>
                </div>
                <div class="district-map-tooltip" id="provinceMapTooltip" style="display:none;">
                    <div class="tt-title" id="provinceMapTooltipTitle"></div>
                    <div class="tt-sub" id="provinceMapTooltipSub"></div>
                </div>
                <div class="map-legend" aria-label="Heatmap legend">
                    <div class="map-legend-row"><span class="map-legend-swatch none" aria-hidden="true"></span><span>No reports</span></div>
                    <div class="map-legend-row"><span class="map-legend-swatch high" aria-hidden="true"></span><span>High</span></div>
                    <div class="map-legend-row"><span class="map-legend-swatch medium" aria-hidden="true"></span><span>Medium</span></div>
                    <div class="map-legend-row"><span class="map-legend-swatch low" aria-hidden="true"></span><span>Low</span></div>
                </div>
            </div>
        </section>
    </div>
</div>

<script>
(function () {
    const reportsUrl = "{{ url('/national-admin/reports') }}";
    const panel = document.getElementById('provinceHeatmapPanel');
    if (!panel) return;

    const viewBtns = panel.querySelectorAll('.heatmap-view-btn');
    const scaleCount = panel.querySelector('#provinceHeatmapScaleCount');
    const scalePct = panel.querySelector('#provinceHeatmapScalePct');

    function mergeHeatmapQueryParams(url) {
        const params = new URLSearchParams(window.location.search);
        ['province', 'district', 'school', 'abuse_type', 'from_date', 'to_date', 'age_range'].forEach(function (k) {
            if (params.has(k)) url.searchParams.set(k, params.get(k));
        });
    }

    viewBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            const view = this.dataset.view;
            viewBtns.forEach(function (b) { b.classList.remove('active'); b.setAttribute('aria-pressed', 'false'); });
            this.classList.add('active');
            this.setAttribute('aria-pressed', 'true');

            panel.querySelectorAll('.heatmap-cell').forEach(function (cell) {
                const countEl = cell.querySelector('.heatmap-cell-count');
                const pctEl = cell.querySelector('.heatmap-cell-pct');
                if (countEl && pctEl) {
                    countEl.style.display = view === 'percent' ? 'none' : '';
                    pctEl.style.display = view === 'percent' ? '' : 'none';
                }
            });

            if (scaleCount && scalePct) {
                scaleCount.style.display = view === 'count' ? 'flex' : 'none';
                scalePct.style.display = view === 'percent' ? 'flex' : 'none';
            }
        });
    });

    panel.querySelectorAll('.heatmap-cell[data-province-id]').forEach(function (cell) {
        cell.addEventListener('click', function () {
            const pid = this.dataset.provinceId;
            const aid = this.dataset.abuseTypeId;

            const url = new URL(reportsUrl, window.location.origin);
            mergeHeatmapQueryParams(url);
            if (pid) url.searchParams.set('province', pid);
            if (aid && aid !== '0' && aid !== 'null' && aid !== 'undefined') url.searchParams.set('abuse_type', aid);
            window.location.href = url.toString();
        });

        cell.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); this.click(); }
        });
    });
})();
</script>

<script>
(function () {
    const menuIcon = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('na-sidebar');
    const overlay = document.getElementById('sidebarOverlay');

    function toggle() {
        if (!sidebar) return;
        const isOpen = sidebar.classList.toggle('open');
        if (menuIcon) menuIcon.setAttribute('aria-expanded', isOpen);
        if (overlay) overlay.classList.toggle('active', isOpen);
    }

    if (menuIcon) menuIcon.addEventListener('click', toggle);
    if (overlay) overlay.addEventListener('click', toggle);
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && sidebar && sidebar.classList.contains('open')) toggle();
    });
})();
</script>

<script type="application/json" id="na-map-asset-base">@json(rtrim(asset('geojson'), '/'))</script>
<script type="application/json" id="na-province-counts">@json($provinceHeatmapRowTotals ?? [])</script>
<script type="application/json" id="na-province-name-to-id">@json($provinceHeatmapProvinceNameToId ?? [])</script>
<script type="application/json" id="na-district-counts">@json($mapDistrictCounts ?? [])</script>
<script type="application/json" id="na-district-name-to-id">@json($mapDistrictNameToId ?? [])</script>
<script type="application/json" id="na-map-band-low-max">@json((int) ($mapDistrictBandLowMax ?? 0))</script>
<script type="application/json" id="na-map-band-medium-max">@json((int) ($mapDistrictBandMediumMax ?? 0))</script>
<script type="application/json" id="na-filtered-total">@json((int) ($filteredReportsTotal ?? 0))</script>

<script>
(function () {
    const container = document.getElementById('province-map');
    if (!container) return;

    // Values are embedded as JSON (non-JS script tags) so this file stays valid JS for tooling.
    const mapAssetBase = JSON.parse(document.getElementById('na-map-asset-base')?.textContent || '""');
    const PROVINCE_GEO_SLUGS = [
        'easterncape', 'freestate', 'gauteng', 'kwazulunatal', 'limpopo',
        'mpumalanga', 'northerncape', 'northwest', 'westerncape'
    ];
    const provinceCounts = JSON.parse(document.getElementById('na-province-counts')?.textContent || '{}');
    const districtCounts = JSON.parse(document.getElementById('na-district-counts')?.textContent || '{}');
    const districtNameToId = JSON.parse(document.getElementById('na-district-name-to-id')?.textContent || '{}');
    let mapBandLowMax = Number(JSON.parse(document.getElementById('na-map-band-low-max')?.textContent || '0')) || 0;
    let mapBandMediumMax = Number(JSON.parse(document.getElementById('na-map-band-medium-max')?.textContent || '0')) || 0;
    const filteredTotal = Number(JSON.parse(document.getElementById('na-filtered-total')?.textContent || '0')) || 0;

    const statusEl = document.getElementById('provinceMapStatus');
    const tooltipEl = document.getElementById('provinceMapTooltip');
    const tooltipTitleEl = document.getElementById('provinceMapTooltipTitle');
    const tooltipSubEl = document.getElementById('provinceMapTooltipSub');

    function keyName(name) {
        return String(name || '').toLowerCase()
            .replace(/&/g, 'and')
            .replace(/[^a-z0-9\s]/g, ' ')
            .replace(/\s+/g, ' ')
            .trim()
            .replace(/^city of\s+/, '')
            .replace(/ekhurhuleni/g, 'ekurhuleni')
            .replace(/\s+district municipality$/, '')
            .replace(/\s+metropolitan municipality$/, '')
            .replace(/\s+metro$/, '')
            .replace(/\s*\([^)]*\)/g, '')
            .trim();
    }

    function compactProvinceKey(s) {
        return String(s || '').toLowerCase().replace(/&/g, 'and').replace(/[^a-z0-9]/g, '');
    }

    function resolveDbProvinceName(geoName) {
        const raw = String(geoName || '').trim();
        if (!raw) return null;
        const provinceNameToId = JSON.parse(document.getElementById('na-province-name-to-id')?.textContent || '{}');
        const candidates = Object.keys(provinceNameToId || {});
        const cKey = compactProvinceKey(raw);
        if (cKey === 'kzn') {
            for (let i = 0; i < candidates.length; i++) {
                const ck = compactProvinceKey(candidates[i]);
                if (ck.indexOf('kwazulu') !== -1 && ck.indexOf('natal') !== -1) return candidates[i];
            }
        }
        for (let i = 0; i < candidates.length; i++) {
            if (compactProvinceKey(candidates[i]) === cKey) return candidates[i];
        }
        for (let i = 0; i < candidates.length; i++) {
            const dk = compactProvinceKey(candidates[i]);
            if (dk.length < 8) continue;
            if (cKey.includes(dk) || dk.includes(cKey)) return candidates[i];
        }
        return null;
    }

    // Percentages should reflect the same filtered dataset as the dashboard/heatmap totals.
    const mappedTotal = Object.values(districtCounts || {}).reduce(function (sum, c) { return sum + (Number(c) || 0); }, 0);
    const grandTotal = filteredTotal > 0 ? filteredTotal : mappedTotal;

    function cleanLabel(name) {
        return String(name || '').trim()
            .replace(/\s+District Municipality$/i, '')
            .replace(/\s+Metropolitan Municipality$/i, '')
            .trim();
    }

    const HEAT_LOW = '#b2cd16';
    const HEAT_MEDIUM = '#fbbf0f';
    const HEAT_HIGH = '#ed1c24';

    function computeHeatBandThresholds(counts) {
        const positive = (counts || []).map(function (c) { return Number(c) || 0; })
            .filter(function (c) { return c > 0; })
            .sort(function (a, b) { return a - b; });
        const n = positive.length;
        if (n === 0) return { lowMax: 0, mediumMax: 0 };
        if (n === 1) return { lowMax: 0, mediumMax: positive[0] };
        const iLow = Math.max(0, Math.floor(n / 3) - 1);
        const iMed = Math.max(iLow, Math.floor((2 * n) / 3) - 1);
        return { lowMax: positive[iLow], mediumMax: positive[iMed] };
    }

    function heatBandIndexFromCount(count) {
        const c = Number(count) || 0;
        if (c <= 0 || c <= mapBandLowMax) return 0;
        if (c <= mapBandMediumMax) return 1;
        return 2;
    }

    function heatColorForBand(bandIdx) {
        return bandIdx === 2 ? HEAT_HIGH : (bandIdx === 1 ? HEAT_MEDIUM : HEAT_LOW);
    }

    function moveTooltip(clientX, clientY) {
        if (!tooltipEl) return;
        const rect = container.getBoundingClientRect();
        const pad = 12;
        const x = Math.min(rect.width - pad, Math.max(pad, clientX - rect.left + 12));
        const y = Math.min(rect.height - pad, Math.max(pad, clientY - rect.top + 12));
        tooltipEl.style.transform = 'translate(' + Math.round(x) + 'px,' + Math.round(y) + 'px)';
    }

    function showTooltip(clientX, clientY, title, count) {
        if (!tooltipEl || !tooltipTitleEl || !tooltipSubEl) return;
        tooltipTitleEl.textContent = String(title || '');
        tooltipSubEl.textContent = '';
        tooltipEl.style.display = 'block';
        moveTooltip(clientX, clientY);
    }

    function hideTooltip() {
        if (!tooltipEl) return;
        tooltipEl.style.display = 'none';
        tooltipEl.style.transform = 'translate(-9999px, -9999px)';
    }

    async function fetchJson(url) {
        const response = await fetch(url, { credentials: 'same-origin' });
        if (!response.ok) throw new Error('HTTP ' + response.status);
        const data = await response.json();
        return Array.isArray(data) ? data : [];
    }

    async function loadMapItems() {
        const districtBundles = await Promise.all(
            PROVINCE_GEO_SLUGS.map(function (slug) {
                return fetchJson(mapAssetBase + '/' + slug + '.json').catch(function () { return []; });
            })
        );
        const districts = districtBundles.flat().filter(function (it) {
            return it && it.path && it.name && it.province;
        });

        let outlines = [];
        try {
            outlines = await fetchJson(mapAssetBase + '/map_data.json');
        } catch (e) { /* optional */ }

        return { districts: districts, outlines: outlines };
    }

    // Normalized lookups so geojson name → DB district is stable.
    const countsByNorm = {};
    Object.keys(districtCounts || {}).forEach(function (dbName) {
        countsByNorm[keyName(dbName)] = Number(districtCounts[dbName]) || 0;
    });
    const districtIdByNorm = {};
    Object.keys(districtNameToId || {}).forEach(function (dbName) {
        districtIdByNorm[keyName(dbName)] = districtNameToId[dbName];
    });

    // Controlled alias/prefix matching for known district naming differences.
    const GEO_DB_PREFIXES = {
        'buffalo city': ['buffalo city'],
        'amathole': ['amathole'],
        'alfred nzo': ['alfred nzo'],
        'or tambo': ['or tambo'],
        'chris hani': ['chris hani'],
        'joe gqabi': ['joe gqabi'],
        'manguang': ['motheo', 'metro central'],
        'motheo': ['motheo', 'metro central'],
        'lejweleputswa': ['lejweleputswa', 'letjweleputswa'],
        'thabo mofutsanyana': ['thabo mofutsanyana'],
        'fezile dabi': ['fezile dabi'],
        'xhariep': ['xhariep'],
        'city of johannesburg': ['johannesburg', 'gauteng east'],
        'city of ekhurhuleni': ['ekurhuleni', 'ekhurhuleni'],
        'city of tshwane': ['tshwane'],
        'sedibeng': ['sedibeng'],
        'west rand': ['gauteng west', 'west rand'],
        'ethekwini': ['ethekwini', 'pinetown', 'umlazi'],
        'amajuba': ['amajuba'],
        'harry gwala': ['harry gwala'],
        'ilembe': ['ilembe'],
        'king cetshwayo': ['king cetshwayo'],
        'umgungundlovu': ['umgungundlovu'],
        'umkhanyakude': ['umkhanyakude'],
        'umzinyathi': ['umzinyathi'],
        'uthukela': ['uthukela'],
        'zululand': ['zululand'],
        'ehlanzeni': ['ehlanzeni'],
        'gert sibande': ['gert sibande'],
        'nkangala': ['nkangala'],
        'capricorn': ['capricorn'],
        'mopani': ['mopani'],
        'sekhukhune': ['sekhukhune'],
        'vhembe': ['vhembe'],
        'waterberg': ['waterberg'],
        'cape winelands': ['cape winelands'],
        'central karoo': ['eden and central karoo', 'central karoo'],
        'eden': ['eden and central karoo', 'eden'],
        'overberg': ['overberg'],
        'west coast': ['west coast'],
        'frances baard': ['frances baard'],
        'john taolo gaetsewe': ['john taolo gaetsewe'],
        'namakwa': ['namakwa'],
        'pixley ka seme': ['pixley ka seme'],
        'zf mgcawu': ['zf mgcawu'],
        'ngaka modiri molema': ['ngaka modiri molema'],
        'bojanala platinum': ['bojanala'],
        'dr kenneth kaunda': ['dr kenneth kaunda'],
        'dr ruth segomotsi mompati': ['dr ruth s mompati', 'dr ruth segomotsi mompati'],
    };

    function matchesGeoDistrict(geoNorm, dbNorm) {
        if (!geoNorm || !dbNorm) return false;
        if (geoNorm === dbNorm) return true;

        const prefixes = GEO_DB_PREFIXES[geoNorm];
        if (prefixes) {
            for (let i = 0; i < prefixes.length; i++) {
                const p = keyName(prefixes[i]);
                if (dbNorm === p || dbNorm.indexOf(p + ' ') === 0) return true;
            }
        }
        if (dbNorm.indexOf(geoNorm + ' ') === 0 || geoNorm.indexOf(dbNorm + ' ') === 0) return true;
        if (geoNorm.length >= 5 && dbNorm.indexOf(geoNorm) !== -1) return true;
        if (dbNorm.length >= 5 && geoNorm.indexOf(dbNorm) !== -1) return true;
        return false;
    }

    const geoCountCache = {};
    function countForGeo(rawGeoName) {
        const geoKey = keyName(rawGeoName);
        if (geoCountCache[geoKey] !== undefined) return geoCountCache[geoKey];

        // Fast path: exact normalized match.
        if (countsByNorm[geoKey] !== undefined) {
            geoCountCache[geoKey] = Number(countsByNorm[geoKey]) || 0;
            return geoCountCache[geoKey];
        }

        let total = 0;
        Object.keys(countsByNorm || {}).forEach(function (dbNorm) {
            if (matchesGeoDistrict(geoKey, dbNorm)) {
                total += Number(countsByNorm[dbNorm]) || 0;
            }
        });
        geoCountCache[geoKey] = total;
        return total;
    }

    function primaryDistrictIdForGeo(rawGeoName) {
        const geoKey = keyName(rawGeoName);
        if (districtIdByNorm[geoKey]) return districtIdByNorm[geoKey];
        const norms = Object.keys(districtIdByNorm || {});
        for (let i = 0; i < norms.length; i++) {
            if (matchesGeoDistrict(geoKey, norms[i])) return districtIdByNorm[norms[i]];
        }
        return null;
    }

    function resolveDbDistrictLabel(rawGeoName) {
        const geoKey = keyName(rawGeoName);
        // If exact match exists, show the original DB district name casing where possible.
        const dbNames = Object.keys(districtNameToId || {});
        for (let i = 0; i < dbNames.length; i++) {
            if (keyName(dbNames[i]) === geoKey) return cleanLabel(dbNames[i]);
        }
        // Otherwise, keep geo label (stable) rather than picking a possibly-wrong DB name.
        return cleanLabel(rawGeoName);
    }

    function appendDistrictShape(it, districtLayer, svgNS) {
        const pathD = it && it.path ? String(it.path) : '';
        const rawName = (it && it.name) ? String(it.name).trim() : '';
        if (!pathD || !rawName) return;

        const count = countForGeo(rawName);
        const displayLabel = resolveDbDistrictLabel(rawName);
        const bandIdx = heatBandIndexFromCount(count);
        const fillColor = heatColorForBand(bandIdx);

        const path = document.createElementNS(svgNS, 'path');
        path.setAttribute('d', pathD);
        path.setAttribute('class', 'district-map-shape' + (bandIdx === 2 ? ' district-map-shape-dark' : ''));
        path.setAttribute('fill', fillColor);
        path.setAttribute('fill-opacity', '1');
        path.setAttribute('data-shape-kind', 'district');
        path.setAttribute('data-district-id', primaryDistrictIdForGeo(rawName) ? String(primaryDistrictIdForGeo(rawName)) : '');
        path.setAttribute('data-district-label', displayLabel);
        path.setAttribute('data-count', String(count));
        path.style.cursor = 'default';
        districtLayer.appendChild(path);
    }

    function appendProvinceBorder(it, borderLayer, svgNS, pathsForLabels) {
        const pathD = it && it.path ? String(it.path) : '';
        const rawName = (it && it.name) ? String(it.name).trim() : '';
        if (!pathD || !rawName) return;

        const dbProvince = resolveDbProvinceName(rawName);
        const displayLabel = dbProvince || cleanLabel(rawName);
        const count = dbProvince ? (Number(provinceCounts[dbProvince]) || 0) : 0;

        const border = document.createElementNS(svgNS, 'path');
        border.setAttribute('d', pathD);
        border.setAttribute('class', 'district-map-province-border');
        border.setAttribute('fill', 'none');
        border.setAttribute('data-shape-kind', 'province');
        border.setAttribute('data-db-province', dbProvince || '');
        border.setAttribute('data-district-label', displayLabel);
        border.setAttribute('data-count', String(count));
        borderLayer.appendChild(border);

        pathsForLabels.push({ pathEl: border, label: displayLabel, kind: 'province' });
    }

    loadMapItems()
        .then(function (payload) {
            const districtItems = payload.districts || [];
            const outlineItems = payload.outlines || [];
            if (!districtItems.length && !outlineItems.length) throw new Error('Empty map data');

            const svgNS = 'http://www.w3.org/2000/svg';
            const svg = document.createElementNS(svgNS, 'svg');
            svg.setAttribute('class', 'district-map-svg');
            svg.setAttribute('preserveAspectRatio', 'xMidYMid meet');
            const g = document.createElementNS(svgNS, 'g');
            g.setAttribute('class', 'za-map-root');
            svg.appendChild(g);

            const pathsForLabels = [];
            const districtLayer = document.createElementNS(svgNS, 'g');
            districtLayer.setAttribute('class', 'district-layer');
            const provinceBorderLayer = document.createElementNS(svgNS, 'g');
            provinceBorderLayer.setAttribute('class', 'province-border-layer');
            g.appendChild(districtLayer);
            g.appendChild(provinceBorderLayer);

            // Use backend-provided band thresholds (computed from the filtered dataset).

            districtItems.forEach(function (it) {
                appendDistrictShape(it, districtLayer, svgNS);
            });
            outlineItems.forEach(function (it) {
                appendProvinceBorder(it, provinceBorderLayer, svgNS, pathsForLabels);
            });

            const oldSvg = container.querySelector('svg.district-map-svg');
            if (oldSvg) oldSvg.remove();
            container.insertBefore(svg, container.firstChild);

            requestAnimationFrame(function () {
                try {
                    const mapBb = g.getBBox();
                    const pad = 24;
                    svg.setAttribute('viewBox',
                        (mapBb.x - pad) + ' ' + (mapBb.y - pad) + ' ' +
                        (mapBb.width + pad * 2) + ' ' + (mapBb.height + pad * 2));
                } catch (e) {}

                const labelLayer = document.createElementNS(svgNS, 'g');
                labelLayer.setAttribute('class', 'map-label-layer');
                labelLayer.setAttribute('aria-hidden', 'true');
                g.appendChild(labelLayer);

                pathsForLabels.forEach(function (item) {
                    let bb;
                    try { bb = item.pathEl.getBBox(); } catch (e3) { return; }

                    const isProvince = item.kind === 'province';
                    const cx = bb.x + bb.width / 2;
                    const cy = bb.y + bb.height / 2;
                    if (!isProvince) return;
                    const text = String(item.label || '');
                    if (!text) return;

                    const len = text.length;
                    const fs = len > 18 ? 9 : (len > 14 ? 10.5 : (len > 11 ? 11.5 : 13));

                    const textEl = document.createElementNS(svgNS, 'text');
                    textEl.setAttribute('x', String(cx));
                    textEl.setAttribute('y', String(cy));
                    textEl.setAttribute('text-anchor', 'middle');
                    textEl.setAttribute('dominant-baseline', 'middle');
                    textEl.setAttribute('font-size', String(fs));
                    textEl.setAttribute('class', isProvince ? 'map-label-province' : 'map-label-district');
                    textEl.textContent = text;
                    labelLayer.appendChild(textEl);
                });

                let hovered = null;
                svg.addEventListener('mousemove', function (event) {
                    const target = event.target;
                    const isDistrict = (target instanceof SVGPathElement) && target.classList.contains('district-map-shape');
                    const isProvince = (target instanceof SVGPathElement) && target.classList.contains('district-map-province-border');
                    if (!isDistrict && !isProvince) {
                        if (hovered) hovered.classList.remove('is-hover');
                        hovered = null;
                        hideTooltip();
                        return;
                    }
                    if (hovered && hovered !== target) hovered.classList.remove('is-hover');
                    hovered = target;
                    if (isDistrict) hovered.classList.add('is-hover');
                    const lbl = target.getAttribute('data-district-label') || '';
                    const cnt = Number(target.getAttribute('data-count') || 0);
                    showTooltip(event.clientX, event.clientY, lbl, cnt);
                });
                svg.addEventListener('mouseleave', function () {
                    if (hovered) hovered.classList.remove('is-hover');
                    hovered = null;
                    hideTooltip();
                });
                // Map is hover-only (no click navigation).

                if (statusEl) statusEl.style.display = 'none';
            });
        })
        .catch(function () {
            if (statusEl) statusEl.textContent = 'Map unavailable';
        });
})();
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
function exportPDF() {
    const element = document.getElementById('main-content');
    if (!element) { alert('Main content not found!'); return; }
    if (typeof html2pdf === 'undefined') { window.print(); return; }
    html2pdf().from(element).set({
        margin: 10,
        filename: 'national-admin-heatmap.pdf',
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'mm', format: 'a3', orientation: 'landscape' }
    }).save();
}
</script>

</body>
</html>
