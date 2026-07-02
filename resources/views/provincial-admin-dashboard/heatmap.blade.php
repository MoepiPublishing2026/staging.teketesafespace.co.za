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
            --theme-dark: #0c8cb3;
            --blue:       #38b6ff;
            --green:      #d1cb23;
            --yellow:     #fbbf0f;
            --red:        #ed1c24;
            --sidebar-border: #c7da30;
            --bg:         white;
            --card:       #ffffff;
            --border:     #eaeaea;
            --text:       #545454;
            --muted:      #6b7280;
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

        /* ══ MAIN PANEL ══ */
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
 
        /* ── Top bar (match dashboard) ── */
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
        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
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
 
        /* ── Scroll area ── */
        .dashboard-scroll {
            flex: 1 1 0;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 2.5rem;
            max-width: 1280px;
            width: 100%;
            margin: 0 auto;
        }
 
        /* ── Page title ── */
        .page-header {
            margin-bottom: 1.75rem; display: flex;
            align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 1rem;
        }
        .page-title {
            font-size: 22px; font-weight: 900; color: var(--text);
            letter-spacing: 0.02em; text-transform: uppercase;
        }
        .page-title span { color: var(--blue); }
        h2 { color: #38b6ff; font-family: 'Montserrat', sans-serif; font-weight: 900; margin: 0 0 1rem; }
 
        /* ══ CARD ══ */
        .card {
            background: var(--card); border-radius: 10px;
            border: 2px solid #c7da30; margin-bottom: 2rem; overflow: hidden;
        }
        .card-header {
            padding: 1.1rem 1.5rem 0.8rem; border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 0.5rem;
        }
        .card-title {
            font-size: 14px; font-weight: 900; color: var(--blue);
            letter-spacing: 0.04em; text-transform: uppercase;
        }
        .card-body { padding: 1.25rem 1.5rem; }
 
        /* ══ FILTERS ══ */
        .filters-grid { display: flex; flex-wrap: wrap; gap: 0.75rem; align-items: flex-end; }
        .filter-group { display: flex; flex-direction: column; gap: 4px; min-width: 150px; }
        .filter-label {
            font-size: 10px; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.07em; color: var(--muted);
        }
        .filter-control {
            padding: 8px 12px; border: 1.5px solid var(--border);
            border-radius: 8px; font-family: 'Montserrat', sans-serif;
            font-size: 12px; font-weight: 600; color: var(--text);
            background: #fff; cursor: pointer; transition: border-color 0.2s; outline: none;
        }
        .filter-control:focus { border-color: var(--blue); }
        .btn {
            padding: 8px 18px; border-radius: 8px;
            font-family: 'Montserrat', sans-serif; font-size: 12px; font-weight: 700;
            cursor: pointer; border: none; transition: all 0.2s; letter-spacing: 0.03em;
        }
        .btn-primary { background: var(--blue); color: #fff; }
        .btn-primary:hover { background: #1a9fe0; }
        .btn-outline { background: #fff; color: var(--muted); border: 1.5px solid var(--border); }
        .btn-outline:hover { border-color: var(--blue); color: var(--blue); }
        .filter-chips { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 12px; }
        .chip {
            background: rgba(56,182,255,0.1); color: var(--blue);
            border: 1px solid rgba(56,182,255,0.25); border-radius: 999px;
            padding: 3px 12px; font-size: 11px; font-weight: 700;
        }
 
        /* ══ HEATMAP TABLE ══ */
        .heatmap-toolbar { display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem; }
        .toggle-btn {
            padding: 0.35rem 0.75rem; border-radius: 6px;
            font-size: 11px; font-weight: 900; font-family: 'Montserrat', sans-serif;
            border: 2px solid #c7da30; background: #fff; color: var(--text);
            cursor: pointer; transition: all 0.2s;
        }
        .toggle-btn.active, .toggle-btn:hover { background: #c7da30; color: #fff; }
        .heatmap-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .heatmap-table { border-collapse: collapse; font-size: 13px; min-width: 100%; }
        .heatmap-table th, .heatmap-table td {
            border: 1px solid #111827; padding: 0.5rem 0.65rem;
            text-align: center; white-space: nowrap;
        }
        .heatmap-corner { background: #d1d5db; font-weight: 700; font-size: 13px; text-align: left !important; min-width: 140px; }
        .heatmap-col { background: #d1d5db; font-weight: 700; white-space: nowrap; min-width: 90px; }
        .heatmap-row { background: #fff; font-weight: 600; text-align: left !important; padding-left: 0.75rem; min-width: 140px; }
        .heatmap-cell {font-weight: 600; cursor: pointer; min-width: 50px; position: relative;color: #fff !important; text-shadow: 0 1px 2px rgba(0,0,0,0.25);}
        .heatmap-cell.heatmap-cell-dark { color: #fff; text-shadow: 0 1px 2px rgba(0,0,0,0.25); }
        .heatmap-cell:hover { outline: 2px solid var(--blue); z-index: 2; }
        .heatmap-scale-wrap { display: flex; align-items: center; gap: 0.5rem; margin-top: 1rem; font-size: 12px; color: var(--muted); font-weight: 700; }
        .heatmap-scale-bar {
            height: 14px; width: 180px; border-radius: 7px;
            background: linear-gradient(to right, #d1cb23 0%, #fbbf0f 50%, #ed1c24 100%);
            border: 1px solid #111827;
        }
 
        /* ══ GEOGRAPHIC MAP ══ */
        .map-outer {
            position: relative; width: 100%;
            background: #f1f5f9; border-radius: 8px;
            overflow: hidden; min-height: 460px;
        }
        .district-map-container { height: 480px; width: 100%; position: relative; }
        .district-map-svg { width: 100%; height: 100%; display: block; }
 
        /* ── THINNER borders between districts (key change from v1) ── */
        .district-map-shape {
            stroke: rgba(255,255,255,0.55);   /* soft white seam instead of lime */
            stroke-width: 0.6;                 /* was 1.2 — half as thick */
            transition: stroke 0.15s, stroke-width 0.15s, opacity 0.2s;
        }
        .district-map-shape:hover {
            stroke: #38b6ff;
            stroke-width: 1.8;
            opacity: 0.82;
        }
 
        /* Tooltip */
        .map-tooltip {
            position: absolute; pointer-events: none; z-index: 200;
            background: rgba(255,255,255,0.97); border: 1px solid #e5e7eb;
            border-radius: 8px; padding: 12px 14px;
            min-width: 220px; max-width: 280px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15); display: none;
            font-family: 'Montserrat', sans-serif;
        }
        .tt-district {
            font-size: 13px; font-weight: 900; color: #1f2937;
            border-bottom: 1px solid #e5e7eb; padding-bottom: 8px; margin-bottom: 8px;
        }
        .tt-total { font-size: 11px; font-weight: 700; color: var(--muted); margin-bottom: 6px; }
        .tt-row {
            display: flex; justify-content: space-between; align-items: center;
            gap: 10px; padding: 3px 0; font-size: 11px; border-bottom: 1px solid #f0f0f0;
        }
        .tt-row:last-child { border-bottom: none; }
        .tt-type { color: var(--text); font-weight: 600; }
        .tt-count {
            font-weight: 900; color: #1f2937; background: #f3f4f6;
            border-radius: 4px; padding: 1px 7px; font-size: 11px;
        }
        .tt-bar { height: 3px; border-radius: 2px; margin-top: 2px; }
 
        /* Legend */
        .map-legend {
            position: absolute; bottom: 20px; right: 20px; z-index: 100;
            background: rgba(255,255,255,0.97); border: 1px solid #e5e7eb;
            border-radius: 8px; padding: 10px 14px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            font-family: 'Montserrat', sans-serif; font-size: 12px;
        }
        .legend-title { font-size: 10px; font-weight: 900; color: #1f2937; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 8px; }
        .legend-row { display: flex; align-items: center; gap: 8px; font-size: 11px; font-weight: 700; color: #111827; margin-bottom: 5px; }
        .legend-row:last-child { margin-bottom: 0; }
        .legend-dot { width: 14px; height: 14px; border-radius: 50%; border: 1px solid #111827; flex-shrink: 0; }
        .legend-dot.high   { background: #ed1c24; }
        .legend-dot.medium { background: #fbbf0f; }
        .legend-dot.low    { background: #d1cb23; }
 
        /* Key panel */
        .map-key {
            position: absolute; top: 16px; left: 16px; z-index: 100;
            background: rgba(255,255,255,0.97); border: 1px solid #e5e7eb;
            border-radius: 8px; padding: 12px;
            max-height: calc(100% - 32px); overflow-y: auto;
            min-width: 190px; box-shadow: 0 2px 8px rgba(0,0,0,0.12); display: none;
        }
        .map-key-title { font-size: 9px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.1em; color: var(--muted); margin-bottom: 8px; }
        .key-row {
            display: grid; grid-template-columns: 12px 20px 1fr auto;
            gap: 6px; align-items: center; padding: 4px 0;
            border-top: 1px solid #f0f0f0; font-size: 10px; color: var(--text);
        }
        .key-row:first-of-type { border-top: none; }
        .key-swatch { width: 12px; height: 12px; border-radius: 50%; border: 1px solid #aaa; }
        .key-num  { font-weight: 900; color: var(--muted); }
        .key-name { font-weight: 700; }
        .key-cnt  { font-weight: 900; color: var(--blue); white-space: nowrap; }
 
        /* ── Mobile (heatmap page layout) ── */
        @media (max-width: 900px) {
            .dashboard-scroll { padding: 1rem; }
            .filters-grid { flex-direction: column; }
            .filter-group { min-width: 100%; }
            .district-map-container { height: 320px; }
            .map-key { display: none !important; }
        }
        @media (max-width: 600px) {
            .district-map-container { height: 260px; }
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
 
        {{-- ── Filters ── --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">Filters</div>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ url()->current() }}" class="filters-grid" id="filtersForm">
                    <div class="filter-group">
                        <label class="filter-label">District</label>
                        <select name="district" class="filter-control" onchange="this.form.submit()">
                            <option value="">All Districts</option>
                            @foreach ($districts as $district)
                                <option value="{{ $district->id }}"
                                    {{ $districtFilter == $district->id ? 'selected' : '' }}>
                                    {{ $district->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">School</label>
                        <select name="school" class="filter-control" onchange="this.form.submit()">
                            <option value="">All Schools</option>
                            @foreach ($schools as $school)
                                <option value="{{ $school->school_id }}"
                                    {{ $schoolFilter == $school->school_id ? 'selected' : '' }}>
                                    {{ $school->school_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Report Type</label>
                        <select name="abuse_type" class="filter-control" onchange="this.form.submit()">
                            <option value="">Any Report Type</option>
                            @foreach ($abuseTypes as $type)
                                <option value="{{ $type->id }}"
                                    {{ $abuseTypeFilter == $type->id ? 'selected' : '' }}>
                                    {{ $type->type_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Age Range</label>
                        <select name="age_range" class="filter-control" onchange="this.form.submit()">
                            <option value="">Any Age</option>
                            @foreach (['0-10','11-15','16-20','21-22','30+'] as $range)
                                <option value="{{ $range }}" {{ $ageRange == $range ? 'selected' : '' }}>
                                    {{ $range }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">From</label>
                        <input type="date" name="from_date" class="filter-control"
                               value="{{ $fromDate }}" onchange="this.form.submit()">
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">To</label>
                        <input type="date" name="to_date" class="filter-control"
                               value="{{ $toDate }}" onchange="this.form.submit()">
                    </div>
                    <div class="filter-group" style="justify-content:flex-end;">
                        <label class="filter-label">&nbsp;</label>
                        <button type="button" class="btn btn-outline"
                                onclick="window.location='{{ url()->current() }}'">
                            Reset Filters
                        </button>
                    </div>
                </form>
                @if(!empty($activeFilters))
                    <div class="filter-chips" style="margin-top:12px;">
                        @foreach ($activeFilters as $chip)
                            <span class="chip">{{ $chip }}</span>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
 
        {{-- ── Heatmap table ── --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">Reports by District &amp; Report Type</div>
                <div class="heatmap-toolbar">
                    <button type="button" class="toggle-btn active" data-view="count">COUNTS</button>
                    <button type="button" class="toggle-btn"        data-view="percent">ROWS%</button>
                </div>
            </div>
            <div class="card-body" style="padding:1rem 1rem 1.25rem;">
                <div class="heatmap-wrap">
                    <table class="heatmap-table">
                        <thead>
                            <tr>
                                <th class="heatmap-corner">District</th>
                                @foreach($heatmapAbuseTypes as $atype)
                                    <th class="heatmap-col">{{ $atype }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($heatmapMatrix as $district => $row)
                                <tr>
                                    <th class="heatmap-row">{{ $district }}</th>
                                    @foreach($row as $colIdx => $count)
                                        @php
                                            $intensity   = ($heatmapMax > 0) ? min(1, $count / $heatmapMax) : 0;
                                            $pct         = $heatmapPercentages[$district][$colIdx] ?? 0;
                                            $atype       = $heatmapAbuseTypes[$colIdx] ?? '';
                                            $districtId  = $heatmapDistrictNameToId[$district] ?? null;
                                            $abuseTypeId = $heatmapAbuseTypeNameToId[$atype] ?? null;
                                            if ($intensity >= 0.67) {
                                                $bg = '#ed1c24'; $textClass = 'heatmap-cell-dark';
                                            } elseif ($intensity >= 0.34) {
                                                $bg = '#fbbf0f'; $textClass = 'heatmap-cell-dark';
                                            } elseif ($intensity > 0) {
                                                $bg = '#d1cb23'; $textClass = 'heatmap-cell-dark';
                                            } else {
                                                $bg = '#d1cb23'; $textClass = '';
                                            }
                                        @endphp
                                        <td class="heatmap-cell {{ $textClass }}"
                                            style="background-color:{{ $bg }};"
                                            data-count="{{ $count }}"
                                            data-percent="{{ $pct }}"
                                            data-district="{{ $district }}"
                                            data-abuse-type="{{ $atype }}"
                                            data-district-id="{{ $districtId }}"
                                            data-abuse-type-id="{{ $abuseTypeId }}"
                                            role="button" tabindex="0"
                                            title="{{ $district }} — {{ $atype }}: {{ $count }} ({{ $pct }}%)">
                                            <span class="cell-count">{{ $count }}</span>
                                            <span class="cell-pct"  style="display:none;">{{ $pct }}%</span>
                                        </td>
                                    @endforeach
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ count($heatmapAbuseTypes) + 1 }}"
                                        style="text-align:center;padding:2rem;color:#6b7280;">
                                        No report data for the selected filters.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="heatmap-scale-wrap">
                    <span>LOW</span>
                    <div class="heatmap-scale-bar"></div>
                    <span>HIGH</span>
                </div>
            </div>
        </div>
 
        {{-- ── Geographic map ── --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">Geographic Distribution — {{ $province->province_name }}</div>
            </div>
            <div class="card-body" style="padding:0;">
                <div class="map-outer">
                    <div id="district-map" class="district-map-container">
 
                        <div id="map-key" class="map-key">
                            <div class="map-key-title">Districts</div>
                            <div id="map-key-rows"></div>
                        </div>
 
                        <div class="map-legend">
                            <div class="legend-title">Legend</div>
                            <div class="legend-row"><span class="legend-dot high"></span>High</div>
                            <div class="legend-row"><span class="legend-dot medium"></span>Medium</div>
                            <div class="legend-row"><span class="legend-dot low"></span>Low</div>
                        </div>
 
                        <div id="map-tooltip" class="map-tooltip">
                            <div class="tt-district" id="tt-district"></div>
                            <div class="tt-total"    id="tt-total"></div>
                            <div id="tt-breakdown"></div>
                        </div>
 
                    </div>
                </div>
            </div>
        </div>
 
    </div>{{-- /.dashboard-scroll --}}
</div>{{-- /.main-panel --}}
 
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
 
<script>
/* ════════════════════════════════════════
   PDF export
════════════════════════════════════════ */
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

<script>
/* ════════════════════════════════════════
   Heatmap view toggle
════════════════════════════════════════ */
document.querySelectorAll('.toggle-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        document.querySelectorAll('.toggle-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        const view = this.dataset.view;
        document.querySelectorAll('.cell-count').forEach(el => el.style.display = view === 'count'   ? '' : 'none');
        document.querySelectorAll('.cell-pct')  .forEach(el => el.style.display = view === 'percent' ? '' : 'none');
    });
});
 
/* ════════════════════════════════════════
   Geographic map  ← upgraded from v2
════════════════════════════════════════ */
(function () {
    const container  = document.getElementById('district-map');
    const tooltipEl  = document.getElementById('map-tooltip');
    const ttDistrict = document.getElementById('tt-district');
    const ttTotal    = document.getElementById('tt-total');
    const ttBreak    = document.getElementById('tt-breakdown');
    const keyEl      = document.getElementById('map-key');
    const keyRowsEl  = document.getElementById('map-key-rows');
    if (!container) return;
 
    /* PHP → JS data */
    const provinceSlug      = @json($mapProvinceSlug ?? '');
    const districtCounts    = @json($mapDistrictCounts ?? []);
    const heatmapTotals     = @json($heatmapRowTotals ?? []);
    const heatmapMatrix     = @json($heatmapMatrix ?? []);
    const heatmapAbuseTypes = @json($heatmapAbuseTypes ?? []);
    const tableNames        = @json(array_keys($heatmapMatrix ?? []));
 
    /* ── Name normalisation ── */
    function norm(name) {
        return String(name || '').toLowerCase()
            .replace(/&/g, 'and').replace(/[^a-z0-9\s]/g, ' ')
            .replace(/\s+/g, ' ').trim()
            .replace(/^city of\s+/, '')
            .replace(/\s+district municipality$/, '')
            .replace(/\s+metropolitan municipality$/, '')
            .replace(/\s+local municipality$/, '');
    }
    function resolveKey(name) {
        const n = norm(name);
        const mappings = [
            ['tshwane','tshwane'], ['johannesburg','johannesburg'],
            ['ekurhuleni','ekurhuleni'], ['sedibeng','sedibeng'],
            ['gauteng east','gauteng east'], ['gauteng north','gauteng north'],
            ['gauteng west','gauteng west'],
        ];
        for (const [kw, key] of mappings) if (n.includes(kw)) return key;
        return n;
    }
    function fmtName(name) {
        return String(name || '').trim()
            .replace(/\s+District Municipality$/i, '')
            .replace(/\s+Metropolitan Municipality$/i, '')
            .replace(/\s+Local Municipality$/i, '').trim();
    }
 
    /* ── Aggregate totals ── */
    const countByKey = {};
    Object.entries(districtCounts || {}).forEach(([n, c]) => {
        const k = resolveKey(n);
        countByKey[k] = (countByKey[k] || 0) + (Number(c) || 0);
    });
    Object.entries(heatmapTotals || {}).forEach(([n, c]) => {
        const k = resolveKey(n);
        if (!countByKey[k]) countByKey[k] = 0;
        if ((Number(c) || 0) > countByKey[k]) countByKey[k] = Number(c) || 0;
    });
 
    const max = Math.max(1, ...Object.values(countByKey));
 
    /* ── Heat colour: lime-yellow → amber → red ── */
    function heatColor(count) {
        if (!count || count <= 0) return '#d1cb23';
        const t = Math.min(1, count / max);
        if (t < 0.34) return '#d1cb23';
        if (t < 0.67) return '#fbbf0f';
        return '#ed1c24';
    }
    function legendColor(count) {
        if (!count || count <= 0) return '#d1cb23';
        const t = count / max;
        if (t <= 0.33) return '#d1cb23';
        if (t <= 0.66) return '#fbbf0f';
        return '#ed1c24';
    }
    function barColor(count) {
        const t = count / max;
        if (t <= 0.33) return '#d1cb23';
        if (t <= 0.66) return '#fbbf0f';
        return '#ed1c24';
    }
 
    /* ── Rich tooltip (v1 style: per-type breakdown) ── */
    function showTooltip(cx, cy, rawName, count) {
        ttDistrict.textContent = fmtName(rawName);
        const matchKey = Object.keys(heatmapMatrix).find(k =>
            resolveKey(k) === resolveKey(rawName)
        );
        ttBreak.innerHTML = '';
        if (matchKey && heatmapMatrix[matchKey]) {
            const row   = heatmapMatrix[matchKey];
            const total = row.reduce((a, b) => a + b, 0);
            ttTotal.textContent = `Total: ${total.toLocaleString()} report(s)`;
            const rowMax = Math.max(1, ...row);
            heatmapAbuseTypes.forEach((type, i) => {
                const c = row[i] || 0;
                if (c === 0) return;
                const pct = Math.round(c / rowMax * 100);
                const div = document.createElement('div');
                div.className = 'tt-row';
                div.innerHTML = `
                    <div style="flex:1;">
                        <div class="tt-type">${type}</div>
                        <div class="tt-bar" style="width:${pct}%;background:${barColor(c)};"></div>
                    </div>
                    <span class="tt-count">${c.toLocaleString()}</span>`;
                ttBreak.appendChild(div);
            });
            if (!ttBreak.children.length) ttTotal.textContent = 'No reports recorded.';
        } else {
            ttTotal.textContent = `${Number(count).toLocaleString()} report(s)`;
        }
        tooltipEl.style.display = 'block';
        const rect = container.getBoundingClientRect();
        const tx = Math.min(rect.width  - 300, Math.max(12, cx - rect.left + 18));
        const ty = Math.min(rect.height - 200, Math.max(12, cy - rect.top  + 12));
        tooltipEl.style.left = tx + 'px';
        tooltipEl.style.top  = ty + 'px';
    }
    function hideTooltip() { tooltipEl.style.display = 'none'; }
 
    const svgNS = 'http://www.w3.org/2000/svg';
    const urls  = [
        `https://raw.githubusercontent.com/datawizzards/zadmaps/master/geojson/${provinceSlug}.json`,
        `https://raw.githubusercontent.com/datawizzards/zadmaps/main/geojson/${provinceSlug}.json`,
    ];
 
    function tryFetch(arr, idx) {
        if (idx >= arr.length) {
            container.innerHTML = `<div style="display:flex;align-items:center;justify-content:center;height:100%;color:#6b7280;font-size:13px;font-family:Montserrat,sans-serif;">Map data unavailable for "${provinceSlug}".</div>`;
            return;
        }
        fetch(arr[idx])
            .then(r => { if (!r.ok) throw new Error('HTTP ' + r.status); return r.json(); })
            .then(items => renderMap(items))
            .catch(() => tryFetch(arr, idx + 1));
    }
 
    function renderMap(items) {
        if (!items || !items.length) {
            container.innerHTML = `<div style="display:flex;align-items:center;justify-content:center;height:100%;color:#6b7280;">No shapes found.</div>`;
            return;
        }
 
        /* Build SVG */
        const svg  = document.createElementNS(svgNS, 'svg');
        svg.setAttribute('class', 'district-map-svg');
        svg.setAttribute('preserveAspectRatio', 'xMidYMid meet');
 
        /* Defs: arrow marker + drop-shadow filter */
        const defs = document.createElementNS(svgNS, 'defs');
        const filt = document.createElementNS(svgNS, 'filter');
        filt.setAttribute('id', 'map-shadow');
        filt.innerHTML = '<feDropShadow dx="0" dy="1" stdDeviation="2" flood-color="rgba(0,0,0,0.15)"/>';
        defs.appendChild(filt);
        svg.appendChild(defs);
 
        const gShapes = document.createElementNS(svgNS, 'g');     /* layer 1: shapes */
        const gGlows  = document.createElementNS(svgNS, 'g');     /* layer 2: radial glows */
        const gLabels = document.createElementNS(svgNS, 'g');     /* layer 3: city names */
        gGlows.style.pointerEvents  = 'none';
        gLabels.style.pointerEvents = 'none';
        svg.append(gShapes, gGlows, gLabels);
 
        container.querySelector('svg.district-map-svg')?.remove();
        container.insertBefore(svg, container.firstChild);
 
        const shapeByKey = {};
 
        items.forEach(it => {
            const rawName = it?.name ?? '';
            const key     = resolveKey(rawName);
            const count   = countByKey[key] ?? 0;
 
            const path = document.createElementNS(svgNS, 'path');
            path.setAttribute('d',     it?.path ?? '');
            path.setAttribute('class', 'district-map-shape');
            path.setAttribute('fill',  heatColor(count));
            path.setAttribute('aria-label', `${fmtName(rawName)}: ${count.toLocaleString()} reports`);
 
            path.addEventListener('mouseenter', e => {
                showTooltip(e.clientX, e.clientY, rawName, count);
            });
            path.addEventListener('mousemove',  e => showTooltip(e.clientX, e.clientY, rawName, count));
            path.addEventListener('mouseleave', () => hideTooltip());
            gShapes.appendChild(path);
 
            if (!shapeByKey[key] || count > (shapeByKey[key].count || 0)) {
                shapeByKey[key] = { rawName, path, count };
            }
        });
 
        /* Post-render: viewBox + city labels + radial glows + key */
        requestAnimationFrame(() => {
            setTimeout(() => {
 
                /* Set viewBox */
                try {
                    const bb = gShapes.getBBox();
                    if (bb.width > 0) {
                        svg.setAttribute('viewBox',
                            `${bb.x - 8} ${bb.y - 8} ${bb.width + 16} ${bb.height + 16}`);
                    }
                } catch (e) {}
 
                /* Collect centres */
                const centers = {};
                Object.entries(shapeByKey).forEach(([key, val]) => {
                    try {
                        const bb = val.path.getBBox();
                        centers[key] = { x: bb.x + bb.width / 2, y: bb.y + bb.height / 2 };
                    } catch {}
                });
 
                /* ── Radial glow (from v2) ── */
                Object.entries(shapeByKey).forEach(([key, val]) => {
                    const c     = centers[key];
                    const count = val.count;
                    if (!c || !count) return;
 
                    const t      = Math.min(1, count / max);
                    const gradId = `glow-${key.replace(/[^a-z0-9]/g, '-')}`;
                    const radius = Math.max(20, 45 * t);
                    const color  = legendColor(count);
 
                    const grad  = document.createElementNS(svgNS, 'radialGradient');
                    grad.setAttribute('id', gradId);
                    grad.setAttribute('gradientUnits', 'userSpaceOnUse');
                    grad.setAttribute('cx', c.x); grad.setAttribute('cy', c.y);
                    grad.setAttribute('r',  radius);
 
                    const s1 = document.createElementNS(svgNS, 'stop');
                    s1.setAttribute('offset', '0%');
                    s1.setAttribute('stop-color', color);
                    s1.setAttribute('stop-opacity', '0.52');
 
                    const s2 = document.createElementNS(svgNS, 'stop');
                    s2.setAttribute('offset', '100%');
                    s2.setAttribute('stop-color', color);
                    s2.setAttribute('stop-opacity', '0');
 
                    grad.append(s1, s2);
                    defs.appendChild(grad);
 
                    const glow = document.createElementNS(svgNS, 'circle');
                    glow.setAttribute('cx', c.x); glow.setAttribute('cy', c.y);
                    glow.setAttribute('r',  radius);
                    glow.setAttribute('fill', `url(#${gradId})`);
                    gGlows.appendChild(glow);
                });
 
                /* ── City name labels — white pill badge style ── */
                Object.entries(shapeByKey).forEach(([key, val]) => {
                    const c = centers[key];
                    if (!c) return;
                    const title = fmtName(val.rawName);
                    const fs    = 2.4;   /* SVG user-unit font size */
 
                    /* Estimate text width to size the pill.
                       Approx 1.28 user-units per character at fs=2.4 */
                    const charW   = fs * 0.62;
                    const textW   = title.length * charW;
                    const padX    = 1.8;
                    const padY    = 0.9;
                    const pillW   = textW + padX * 2;
                    const pillH   = fs + padY * 2;
                    const pillX   = c.x - pillW / 2;
                    /* Offset pill upward slightly from centre dot */
                    const pillY   = c.y - pillH - 1.2;
 
                    /* White rounded pill background */
                    const pill = document.createElementNS(svgNS, 'rect');
                    pill.setAttribute('x',      pillX);
                    pill.setAttribute('y',      pillY);
                    pill.setAttribute('width',  pillW);
                    pill.setAttribute('height', pillH);
                    pill.setAttribute('rx',     pillH / 2);  /* fully rounded ends */
                    pill.setAttribute('fill',   'rgba(255,255,255,0.92)');
                    pill.setAttribute('stroke', 'rgba(200,200,200,0.5)');
                    pill.setAttribute('stroke-width', '0.3');
                    /* Subtle drop shadow via filter */
                    pill.setAttribute('filter', 'url(#map-shadow)');
 
                    /* Label text centred in pill */
                    const textEl = document.createElementNS(svgNS, 'text');
                    textEl.setAttribute('x',                c.x);
                    textEl.setAttribute('y',                pillY + pillH / 2);
                    textEl.setAttribute('text-anchor',      'middle');
                    textEl.setAttribute('dominant-baseline','middle');
                    textEl.setAttribute('font-size',        fs);
                    textEl.setAttribute('font-weight',      '700');
                    textEl.setAttribute('font-family',      'Montserrat, sans-serif');
                    textEl.setAttribute('fill',             '#1f2937');
                    textEl.textContent = title;
 
                    /* Small black centre dot marker */
                    const dot = document.createElementNS(svgNS, 'circle');
                    dot.setAttribute('cx',   c.x);
                    dot.setAttribute('cy',   c.y);
                    dot.setAttribute('r',    '0.7');
                    dot.setAttribute('fill', 'rgba(0,0,0,0.6)');
 
                    gLabels.append(pill, textEl, dot);
                });
 
                /* ── Key panel ── */
                buildKey(shapeByKey);
 
            }, 140);
        });
    }
 
    function buildKey(shapeByKey) {
        const dedup = new Map();
        tableNames.forEach(n => {
            const k = resolveKey(n);
            if (!dedup.has(k)) dedup.set(k, n);
        });
        Object.entries(shapeByKey).forEach(([k, v]) => {
            if (!dedup.has(k)) dedup.set(k, v.rawName);
        });
 
        const data = Array.from(dedup.entries()).map(([k, orig]) => ({
            key:   k,
            label: fmtName(shapeByKey[k]?.rawName ?? orig),
            count: Number(shapeByKey[k]?.count ?? countByKey[k] ?? 0),
        }));
        data.sort((a, b) => b.count - a.count || a.label.localeCompare(b.label));
 
        if (!keyEl || !keyRowsEl) return;
        keyRowsEl.innerHTML = '';
        keyEl.style.display = 'block';
        data.forEach((d, idx) => {
            const row = document.createElement('div');
            row.className = 'key-row';
            const swatch = document.createElement('span');
            swatch.className = 'key-swatch';
            swatch.style.background = legendColor(d.count);
            row.innerHTML = `
                <span class="key-num">${idx + 1}</span>
                <span class="key-name">${d.label}</span>
                <span class="key-cnt">${d.count.toLocaleString()}</span>`;
            row.insertAdjacentElement('afterbegin', swatch);
            keyRowsEl.appendChild(row);
        });
    }
 
    tryFetch(urls, 0);
})();
</script>
 
</body>
</html>
 