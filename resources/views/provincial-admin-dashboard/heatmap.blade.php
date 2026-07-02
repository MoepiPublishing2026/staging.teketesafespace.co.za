<!DOCTYPE html>
<html lang="en" class="pa-app-root">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Tekete SafeSpace – Heat-Map</title>
    <x-favicon />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400&display=swap" rel="stylesheet">

    <style>
        :root {
            --theme-gradient: linear-gradient(to right, #38b6ff, #38b6ff);
            --theme-dark: #0c8cb3ff;
            --red: #ed1c24;
            --yellow: #fbbf0f;
            --blue: #3b82f6;
            --green: #d1cb23;
            --bg: white;
            --text: #253f58ff;
        }

        * { box-sizing: border-box; }
        html { overflow-x: hidden; }
        html, body {
            font-family: 'Montserrat', sans-serif !important;
            color: #545454 !important;
            background-color: #ffffff !important;
            color-scheme: light;
        }
        body.pa-app {
            display: flex;
            min-height: 100vh;
            width: 100%;
            min-width: 0;
            overflow-x: hidden;
            overflow-y: hidden;
            margin: 0;
        }

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
        .filter-chips span {
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            border-radius: 999px;
            padding: 0.35rem 0.75rem;
            font-size: 12px;
            font-weight: 700;
            color: #374151;
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
        .heatmap-row { background: #fff; font-weight: 600; text-align: left !important; padding-left: 0.75rem; min-width: 140px; }
        .heatmap-cell { font-weight: 600; cursor: pointer; min-width: 50px; position: relative; color: #fff !important; text-shadow: 0 1px 2px rgba(0,0,0,0.25); }
        .heatmap-cell.heatmap-cell-dark { color: #fff; text-shadow: 0 1px 2px rgba(0,0,0,0.25); }
        .heatmap-cell:hover { outline: 2px solid #38b6ff; z-index: 2; }
        .heatmap-cell.heat-band-0 { background-color: #d1cb23; }
        .heatmap-cell.heat-band-1 { background-color: #fbbf0f; }
        .heatmap-cell.heat-band-2 { background-color: #ed1c24; }
        .heatmap-table tr.heatmap-row-active th.heatmap-row { background: #38b6ff; color: #fff; }
        .heatmap-scale-wrap { display: flex; flex-wrap: wrap; align-items: center; gap: 1rem; margin-top: 1rem; }
        .heatmap-scale { display: flex; align-items: center; gap: 0.5rem; font-size: 12px; color: #6b7280; }
        .heatmap-scale-bar { height: 14px; width: 180px; border-radius: 7px; background: linear-gradient(to right, #d1cb23 0%, #fbbf0f 50%, #ed1c24 100%); border: 1px solid #111827; }

        .map-panel { background: white; border-radius: 1rem; padding: 1.25rem; border: 2px solid #c7da30; }
        .district-map-container {
            height: 640px;
            width: 100%;
            max-width: 100%;
            min-height: 420px;
            border-radius: 0.5rem;
            overflow: hidden;
            position: relative;
            background: #f6f7f2;
        }
        .district-map-svg { position: absolute; inset: 0; width: 100%; height: 100%; display: block; overflow: visible; z-index: 1; }
        .heat-glow-layer { pointer-events: none; overflow: visible; }
        .district-map-shape {
            stroke: rgba(255,255,255,0.95);
            stroke-width: 1.25;
            stroke-linejoin: round;
            vector-effect: non-scaling-stroke;
            transition: stroke 0.12s ease;
        }
        .district-map-shape.is-hover,
        .district-map-shape.is-key-hover { stroke: #111827; stroke-width: 1.25; }
        .district-map-shape.is-selected { stroke: #38b6ff; stroke-width: 1.75; filter: drop-shadow(0 0 4px rgba(56,182,255,0.45)); }
        .district-map-province-border {
            fill: none;
            stroke: #111827;
            stroke-width: 1.5;
            stroke-linejoin: round;
            stroke-linecap: round;
            vector-effect: non-scaling-stroke;
            pointer-events: none;
        }
        .map-label-layer { pointer-events: none; user-select: none; }
        .map-label-layer text {
            font-family: 'Montserrat', system-ui, sans-serif;
            font-weight: 900;
            paint-order: stroke fill;
            stroke: #ffffff;
            stroke-width: 0.5px;
            stroke-linejoin: round;
        }
        .map-label-layer .map-label-district {
            fill: #111827;
            stroke-width: 0.65px;
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
        .map-legend-swatch.low { background: radial-gradient(circle, #a8d05f 0%, #a8d05f 100%); }
        .map-legend-swatch.medium { background: radial-gradient(circle, #f9c80e 0%, #f9c80e 70%, #a8d05f 100%); }
        .map-legend-swatch.high { background: radial-gradient(circle, #d80f18 0%, #ef2b2d 35%, #f26a21 52%, #f9c80e 78%, #a8d05f 100%); }

        @media (max-width: 900px) {
            .main-panel { margin-left: 0 !important; width: 100%; }
            .dashboard-scroll { padding: 1rem; }
            .district-map-container { height: 380px; min-height: 320px; }
            h1 { font-size: 22px !important; padding: 0 0.5rem; }
            .heatmap-wrap { -webkit-overflow-scrolling: touch; overflow-x: auto; }
            .heatmap-table { font-size: 11px; }
            .heatmap-table th, .heatmap-table td { padding: 0.35rem 0.45rem; }
        }
    </style>
    <x-provincial-admin-styles />
</head>
<body class="pa-app">

<x-provincial-admin-sidebar />

<div class="main-panel">
    <button class="menu-icon" id="sidebarToggle" aria-label="Open navigation menu" aria-expanded="false" aria-controls="pa-sidebar" type="button">&#9776;</button>

    <div class="topbar">
        <div class="profile">
            <div class="meta">
                @php
                    $currentUser = auth()->user()->fresh();
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
        <h1>Tekete SafeSpace Provincial Heatmap</h1>
        <p class="subtitle">District-level intensity by report type — {{ $province->province_name }}.</p>

        <section class="filter-panel" aria-label="Filters">
            <div style="display:flex;align-items:center;flex-wrap:wrap;gap:0.75rem;">
                <h2 style="margin:0;">Filters</h2>
                @if(!empty($activeFilters))
                    <a href="{{ url('/provincial/heatmap') }}" class="filter-clear">Clear all filters</a>
                @endif
            </div>
            <hr>
            <form method="GET" action="{{ url('/provincial/heatmap') }}" class="filters" id="heatmapFiltersForm">
                <select name="district" id="districtSelect" onchange="this.form.submit()">
                    <option value="">All Districts</option>
                    @foreach ($districts as $district)
                        <option value="{{ $district->id }}" {{ (string) $districtFilter === (string) $district->id ? 'selected' : '' }}>
                            {{ $district->name }}
                        </option>
                    @endforeach
                </select>
                <select name="school" id="schoolSelect" onchange="this.form.submit()" {{ $districtFilter ? '' : 'disabled' }}>
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

        <div class="heatmap-summary" aria-label="Summary">
            <div class="heatmap-summary-card">
                <div class="label">Total reports</div>
                <div class="value">{{ number_format($filteredReportsTotal ?? $heatmapGrandTotal) }}</div>
            </div>
            <div class="heatmap-summary-card">
                <div class="label">Districts with data</div>
                <div class="value">{{ $districtsWithReports }} <span style="font-size:14px;font-weight:700;color:#6b7280;">/ {{ count($districts) }}</span></div>
            </div>
            <div class="heatmap-summary-card">
                <div class="label">Report types</div>
                <div class="value">{{ count($heatmapAbuseTypes) }}</div>
            </div>
        </div>

        <section class="heatmap-panel" id="districtHeatmapPanel" aria-label="Reports by District and Type">
            <h2>Reports by District &amp; Report Type</h2>
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
                            <th class="heatmap-corner">District</th>
                            @foreach($heatmapAbuseTypes as $atype)
                                <th class="heatmap-col">{{ $atype }}</th>
                            @endforeach
                            <th class="heatmap-col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($heatmapMatrix as $districtName => $row)
                            @php
                                $rowDistrictId = $heatmapDistrictNameToId[$districtName] ?? null;
                                $isActiveDistrict = $districtFilter && (string) $rowDistrictId === (string) $districtFilter;
                            @endphp
                            <tr class="{{ $isActiveDistrict ? 'heatmap-row-active' : '' }}">
                                <th class="heatmap-row">{{ $districtName }}</th>
                                @foreach($row as $colIdx => $count)
                                    @php
                                        $atype = $heatmapAbuseTypes[$colIdx] ?? '';
                                        $districtId = $heatmapDistrictNameToId[$districtName] ?? null;
                                        $abuseTypeId = $heatmapAbuseTypeNameToId[$atype] ?? null;
                                        $pct = $heatmapPercentages[$districtName][$colIdx] ?? 0;
                                        $intensity = ($heatmapMax ?? 1) > 0 ? min(1, $count / ($heatmapMax ?? 1)) : 0;
                                        $colorIdx = $intensity >= 0.67 ? 2 : ($intensity >= 0.34 ? 1 : 0);
                                        $isDark = $colorIdx === 2;
                                        $isHotspot = in_array($colIdx, $heatmapHotspots[$districtName] ?? []);
                                    @endphp
                                    <td class="heatmap-cell heat-band-{{ $colorIdx }} {{ $isDark ? 'heatmap-cell-dark' : '' }} {{ $isHotspot ? 'heatmap-hotspot' : '' }}"
                                        data-count="{{ $count }}"
                                        data-percent="{{ $pct }}"
                                        data-district="{{ $districtName }}"
                                        data-abuse-type="{{ $atype }}"
                                        data-district-id="{{ $districtId }}"
                                        data-abuse-type-id="{{ $abuseTypeId }}"
                                        role="button"
                                        tabindex="0"
                                        title="{{ $districtName }} × {{ $atype }}: {{ $count }} reports ({{ $pct }}% of district) — Click to view reports">
                                        <span class="heatmap-cell-count">{{ $count }}</span>
                                        <span class="heatmap-cell-pct" style="display:none;">{{ $pct }}%</span>
                                    </td>
                                @endforeach
                                <td class="heatmap-row" style="font-weight:800;">{{ number_format($heatmapRowTotals[$districtName] ?? 0) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($heatmapAbuseTypes) + 2 }}" style="text-align:center;padding:2rem;color:#6b7280;">No report data for the selected filters.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if(!empty($heatmapMatrix))
                    <tfoot>
                        <tr class="heatmap-total-row">
                            <th class="heatmap-row">Total</th>
                            @foreach($heatmapColumnTotals as $colTotal)
                                <td>{{ number_format($colTotal) }}</td>
                            @endforeach
                            <td>{{ number_format($heatmapGrandTotal) }}</td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>

            <div class="heatmap-scale-wrap">
                <div class="heatmap-scale" id="districtHeatmapScaleCount">
                    <span>LOW</span>
                    <div class="heatmap-scale-bar" aria-hidden="true"></div>
                    <span>HIGH</span>
                </div>
                <div class="heatmap-scale" id="districtHeatmapScalePct" style="display:none;">
                    <span>0%</span>
                    <div class="heatmap-scale-bar" aria-hidden="true"></div>
                    <span>100%</span>
                </div>
            </div>
        </section>

        <section class="panel map-panel" aria-label="Reports by District Geographic Heatmap">
            <h2>Geographic Distribution — {{ $province->province_name }}</h2>
            <div id="district-map" class="district-map-container">
                <div class="district-map-status" id="districtMapStatus">Loading map…</div>
                <div class="district-map-tooltip" id="districtMapTooltip" style="display:none;">
                    <div class="tt-title" id="districtMapTooltipTitle"></div>
                    <div class="tt-sub" id="districtMapTooltipSub"></div>
                </div>
                <div class="map-legend" aria-label="Heatmap legend">
                    <div class="map-legend-row"><span class="map-legend-swatch low" aria-hidden="true"></span><span>Low</span></div>
                    <div class="map-legend-row"><span class="map-legend-swatch medium" aria-hidden="true"></span><span>Medium</span></div>
                    <div class="map-legend-row"><span class="map-legend-swatch high" aria-hidden="true"></span><span>High</span></div>
                </div>
            </div>
        </section>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
(function () {
    const reportsUrl = "{{ url('/provincial-admin/reports') }}";
    const panel = document.getElementById('districtHeatmapPanel');
    if (!panel) return;

    const viewBtns = panel.querySelectorAll('.heatmap-view-btn');
    const scaleCount = panel.querySelector('#districtHeatmapScaleCount');
    const scalePct = panel.querySelector('#districtHeatmapScalePct');

    function mergeHeatmapQueryParams(url) {
        const params = new URLSearchParams(window.location.search);
        ['district', 'school', 'abuse_type', 'from_date', 'to_date', 'age_range'].forEach(function (k) {
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

    panel.querySelectorAll('.heatmap-cell[data-district-id]').forEach(function (cell) {
        cell.addEventListener('click', function () {
            const did = this.dataset.districtId;
            const aid = this.dataset.abuseTypeId;

            const url = new URL(reportsUrl, window.location.origin);
            mergeHeatmapQueryParams(url);
            if (did) url.searchParams.set('district', did);
            if (aid && aid !== '0' && aid !== 'null' && aid !== 'undefined') url.searchParams.set('abuse_type', aid);
            window.location.href = url.toString();
        });

        cell.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); this.click(); }
        });
    });
})();
</script>

<script type="application/json" id="pa-map-asset-base">@json(rtrim(asset('geojson'), '/'))</script>
<script type="application/json" id="pa-province-slug">@json($mapProvinceSlug ?? '')</script>
<script type="application/json" id="pa-district-counts">@json($mapDistrictCounts ?? new \stdClass())</script>
<script type="application/json" id="pa-district-name-to-id">@json($mapDistrictNameToId ?? [])</script>
<script type="application/json" id="pa-map-band-low-max">@json((int) ($mapDistrictBandLowMax ?? 0))</script>
<script type="application/json" id="pa-map-band-medium-max">@json((int) ($mapDistrictBandMediumMax ?? 0))</script>
<script type="application/json" id="pa-filtered-total">@json((int) ($filteredReportsTotal ?? 0))</script>

<script>
(function () {
    const container = document.getElementById('district-map');
    if (!container) return;

    const mapAssetBase = JSON.parse(document.getElementById('pa-map-asset-base')?.textContent || '""');
    const provinceSlug = JSON.parse(document.getElementById('pa-province-slug')?.textContent || '""');
    const districtCounts = JSON.parse(document.getElementById('pa-district-counts')?.textContent || '{}');
    const districtNameToId = JSON.parse(document.getElementById('pa-district-name-to-id')?.textContent || '{}');
    const mapBandLowMax = Number(JSON.parse(document.getElementById('pa-map-band-low-max')?.textContent || '0')) || 0;
    const mapBandMediumMax = Number(JSON.parse(document.getElementById('pa-map-band-medium-max')?.textContent || '0')) || 0;
    const filteredTotal = Number(JSON.parse(document.getElementById('pa-filtered-total')?.textContent || '0')) || 0;

    const statusEl = document.getElementById('districtMapStatus');
    const tooltipEl = document.getElementById('districtMapTooltip');
    const tooltipTitleEl = document.getElementById('districtMapTooltipTitle');
    const tooltipSubEl = document.getElementById('districtMapTooltipSub');

    let districtLayer = null;

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

    function cleanLabel(name) {
        return String(name || '').trim()
            .replace(/\s+District Municipality$/i, '')
            .replace(/\s+Metropolitan Municipality$/i, '')
            .trim();
    }

    function titleCaseLabel(name) {
        return String(name || '').trim().toLowerCase().replace(/\b\w/g, function (c) {
            return c.toUpperCase();
        });
    }

    function mapDisplayLabel(name) {
        return titleCaseLabel(cleanLabel(name))
            .replace(/^city of\s+/i, '')
            .replace(/ekhurhuleni/i, 'Ekurhuleni');
    }

    function heatGradientStops(bandIdx) {
        if (bandIdx === 2) {
            return [
                { offset: '0%', color: '#d80f18' },
                { offset: '35%', color: '#ef2b2d' },
                { offset: '52%', color: '#f26a21' },
                { offset: '78%', color: '#f9c80e' },
                { offset: '100%', color: '#a8d05f' },
            ];
        }
        if (bandIdx === 1) {
            return [
                { offset: '0%', color: '#f9c80e' },
                { offset: '80%', color: '#f9c80e' },
                { offset: '100%', color: '#a8d05f' },
            ];
        }
        return [
            { offset: '0%', color: '#a8d05f' },
            { offset: '100%', color: '#a8d05f' },
        ];
    }

    function bandSolidColor(bandIdx) {
        if (bandIdx === 2) return '#d80f18';
        if (bandIdx === 1) return '#f9c80e';
        return '#a8d05f';
    }

    function districtGradientRadius(bb) {
        const cx = bb.x + bb.width / 2;
        const cy = bb.y + bb.height / 2;
        const corners = [
            [bb.x, bb.y],
            [bb.x + bb.width, bb.y],
            [bb.x, bb.y + bb.height],
            [bb.x + bb.width, bb.y + bb.height],
        ];
        let maxDist = 0;
        corners.forEach(function (pt) {
            const d = Math.hypot(pt[0] - cx, pt[1] - cy);
            if (d > maxDist) maxDist = d;
        });
        return Math.max(maxDist * 1.12, 8);
    }

    function applyDistrictRadialFill(path, bandIdx, defs, svgNS, gradSeq) {
        let bb;
        try {
            bb = path.getBBox();
        } catch (e) {
            path.setAttribute('fill', bandSolidColor(bandIdx));
            return gradSeq;
        }

        const cx = bb.x + bb.width / 2;
        const cy = bb.y + bb.height / 2;
        const r = districtGradientRadius(bb);
        const gradId = 'pa-dg-' + gradSeq;

        const grad = document.createElementNS(svgNS, 'radialGradient');
        grad.setAttribute('id', gradId);
        grad.setAttribute('gradientUnits', 'userSpaceOnUse');
        grad.setAttribute('cx', String(cx));
        grad.setAttribute('cy', String(cy));
        grad.setAttribute('r', String(r));
        grad.setAttribute('spreadMethod', 'pad');

        heatGradientStops(bandIdx).forEach(function (stopDef) {
            const stop = document.createElementNS(svgNS, 'stop');
            stop.setAttribute('offset', stopDef.offset);
            stop.setAttribute('stop-color', stopDef.color);
            grad.appendChild(stop);
        });
        defs.appendChild(grad);
        path.setAttribute('fill', 'url(#' + gradId + ')');

        return gradSeq + 1;
    }

    function heatBandIndexFromCount(count) {
        const c = Number(count) || 0;
        if (c <= 0 || c <= mapBandLowMax) return 0;
        if (c <= mapBandMediumMax) return 1;
        return 2;
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
        return fetchJson(mapAssetBase + '/' + provinceSlug + '.json');
    }

    const countsByNorm = {};
    Object.keys(districtCounts || {}).forEach(function (dbName) {
        countsByNorm[keyName(dbName)] = Number(districtCounts[dbName]) || 0;
    });
    const districtIdByNorm = {};
    Object.keys(districtNameToId || {}).forEach(function (dbName) {
        districtIdByNorm[keyName(dbName)] = districtNameToId[dbName];
    });

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
        'city of ekhurhuleni': ['ekurhuleni'],
        'city of tshwane': ['tshwane', 'gauteng north'],
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
        const dbNames = Object.keys(districtNameToId || {});
        for (let i = 0; i < dbNames.length; i++) {
            if (keyName(dbNames[i]) === geoKey) return cleanLabel(dbNames[i]);
        }
        return cleanLabel(rawGeoName);
    }

    function appendDistrictShape(it, layer, svgNS) {
        const pathD = it && it.path ? String(it.path) : '';
        const rawName = (it && it.name) ? String(it.name).trim() : '';
        if (!pathD || !rawName) return null;

        const count = countForGeo(rawName);
        const displayLabel = mapDisplayLabel(resolveDbDistrictLabel(rawName));
        const bandIdx = heatBandIndexFromCount(count);

        const path = document.createElementNS(svgNS, 'path');
        path.setAttribute('d', pathD);
        path.setAttribute('class', 'district-map-shape' + (bandIdx === 2 ? ' district-map-shape-dark' : ''));
        path.setAttribute('data-heat-band', String(bandIdx));
        path.setAttribute('fill', '#a8d05f');
        path.setAttribute('fill-opacity', '1');
        path.setAttribute('data-shape-kind', 'district');
        path.setAttribute('data-district-id', primaryDistrictIdForGeo(rawName) ? String(primaryDistrictIdForGeo(rawName)) : '');
        path.setAttribute('data-district-label', displayLabel);
        path.setAttribute('data-count', String(count));
        path.style.cursor = 'default';
        layer.appendChild(path);
        return path;
    }

    function appendDistrictBorder(it, borderLayer, svgNS) {
        const pathD = it && it.path ? String(it.path) : '';
        if (!pathD) return;

        const border = document.createElementNS(svgNS, 'path');
        border.setAttribute('d', pathD);
        border.setAttribute('class', 'district-map-province-border');
        border.setAttribute('fill', 'none');
        borderLayer.appendChild(border);
    }

    loadMapItems()
        .then(function (districtItems) {
            districtItems = (districtItems || []).filter(function (it) {
                return it && it.path && it.name;
            });
            if (!districtItems.length) throw new Error('Empty map data');

            const svgNS = 'http://www.w3.org/2000/svg';
            const svg = document.createElementNS(svgNS, 'svg');
            svg.setAttribute('class', 'district-map-svg');
            svg.setAttribute('preserveAspectRatio', 'xMidYMid meet');
            const defs = document.createElementNS(svgNS, 'defs');
            svg.appendChild(defs);
            const g = document.createElementNS(svgNS, 'g');
            g.setAttribute('class', 'za-map-root');
            svg.appendChild(g);

            districtLayer = document.createElementNS(svgNS, 'g');
            districtLayer.setAttribute('class', 'district-layer');
            const borderLayer = document.createElementNS(svgNS, 'g');
            borderLayer.setAttribute('class', 'district-border-layer');
            g.appendChild(districtLayer);
            g.appendChild(borderLayer);

            districtItems.forEach(function (it) {
                appendDistrictShape(it, districtLayer, svgNS);
                appendDistrictBorder(it, borderLayer, svgNS);
            });

            const oldSvg = container.querySelector('svg.district-map-svg');
            if (oldSvg) oldSvg.remove();
            container.insertBefore(svg, container.firstChild);

            requestAnimationFrame(function () {
                try {
                    const mapBb = g.getBBox();
                    if (mapBb.width > 0 && mapBb.height > 0) {
                        const pad = 36;
                        svg.setAttribute('viewBox',
                            (mapBb.x - pad) + ' ' + (mapBb.y - pad) + ' ' +
                            (mapBb.width + pad * 2) + ' ' + (mapBb.height + pad * 2));
                    }
                } catch (e) {}

                let gradSeq = 0;
                districtLayer.querySelectorAll('.district-map-shape').forEach(function (path) {
                    const bandIdx = Number(path.getAttribute('data-heat-band') || 0);
                    gradSeq = applyDistrictRadialFill(path, bandIdx, defs, svgNS, gradSeq);
                });

                const labelLayer = document.createElementNS(svgNS, 'g');
                labelLayer.setAttribute('class', 'map-label-layer');
                labelLayer.setAttribute('aria-hidden', 'true');
                g.appendChild(labelLayer);

                districtLayer.querySelectorAll('.district-map-shape').forEach(function (pathEl) {
                    let bb;
                    try { bb = pathEl.getBBox(); } catch (e) { return; }
                    if (bb.width < 28 || bb.height < 18) return;

                    const text = String(pathEl.getAttribute('data-district-label') || '').trim();
                    if (!text) return;

                    const cx = bb.x + bb.width / 2;
                    const cy = bb.y + bb.height / 2;
                    const len = text.length;
                    let fs = len > 18 ? 9 : (len > 14 ? 10.5 : (len > 11 ? 11.5 : 13));
                    fs = Math.min(fs, bb.height * 0.14, bb.width / (len * 0.62));
                    if (fs < 5) return;

                    const textEl = document.createElementNS(svgNS, 'text');
                    textEl.setAttribute('x', String(cx));
                    textEl.setAttribute('y', String(cy));
                    textEl.setAttribute('text-anchor', 'middle');
                    textEl.setAttribute('dominant-baseline', 'middle');
                    textEl.setAttribute('font-size', String(fs));
                    textEl.setAttribute('class', 'map-label-district');
                    textEl.textContent = text;
                    labelLayer.appendChild(textEl);
                });

                let hovered = null;
                svg.addEventListener('mousemove', function (event) {
                    const target = event.target;
                    const isDistrict = (target instanceof SVGGeometryElement) && target.classList.contains('district-map-shape');
                    if (!isDistrict) {
                        if (hovered) hovered.classList.remove('is-hover');
                        hovered = null;
                        hideTooltip();
                        return;
                    }
                    if (hovered && hovered !== target) hovered.classList.remove('is-hover');
                    hovered = target;
                    hovered.classList.add('is-hover');
                    const lbl = target.getAttribute('data-district-label') || '';
                    const cnt = Number(target.getAttribute('data-count') || 0);
                    showTooltip(event.clientX, event.clientY, lbl, cnt);
                });
                svg.addEventListener('mouseleave', function () {
                    if (hovered) hovered.classList.remove('is-hover');
                    hovered = null;
                    hideTooltip();
                });

                if (statusEl) statusEl.style.display = 'none';
            });
        })
        .catch(function (err) {
            if (statusEl) statusEl.textContent = 'Map unavailable';
            if (typeof console !== 'undefined' && console.error) {
                console.error('Provincial heatmap map failed:', err);
            }
        });
})();
</script>

<script>
function exportPDF() {
    const el = document.getElementById('main-content');
    if (!el) return;
    html2pdf().from(el).set({
        margin: 10,
        filename: 'heatmap-{{ Str::slug($province->province_name ?? "province") }}.pdf',
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'mm', format: 'a3', orientation: 'landscape' }
    }).save();
}
</script>

<x-provincial-admin-sidebar-script />

</body>
</html>
 