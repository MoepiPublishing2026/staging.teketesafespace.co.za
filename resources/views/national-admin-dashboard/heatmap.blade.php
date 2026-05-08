<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Tekete SafeSpace – Heatmap</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">

    <style>
        :root {
            --theme-gradient: linear-gradient(to right, #38b6ff, #38b6ff);
            --theme-dark: #0c8cb3ff;
            --blue: #38b6ff;
            --green: #8BC34A;
            --yellow: #FFC107;
            --red: #E53935;
            --sidebar-border: #c7da30;
            --bg: white;
            --text: #545454;
        }

        * { box-sizing: border-box; }

        html, body {
            font-family: 'Montserrat', sans-serif;
            color: var(--text);
            margin: 0;
            padding: 0;
        }

        body {
            display: flex;
            min-height: 100vh;
            width: 100%;
            overflow-x: hidden;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: 235px;
            background: white;
            border-right: 1px solid #eaeaea;
            display: flex;
            flex-direction: column;
            padding-top: 120px;
            flex-shrink: 0;
        }

        .sidebar-logo {
            position: fixed;
            top: 40px;
            left: 40px;
        }

        .sidebar-logo img {
            width: 115px;
            height: auto;
            display: block;
        }

        .sidebar-list {
            list-style: none;
            padding: 0 0 0 22px;
            margin: 0;
        }

        .sidebar-link {
            display: block;
            width: 92%;
            font-size: 15px;
            font-weight: 900;
            color: var(--text);
            font-family: 'Montserrat', sans-serif;
            padding: 11px 18px;
            margin-bottom: 17px;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.25s ease;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            background: var(--theme-gradient);
            color: #fff !important;
        }

        /* ── TOP BAR ── */
        .topbar {
            width: 100%;
            background: white;
            border-bottom: 1px solid #eaeaea;
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
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile .meta { text-align: right; }
        .profile .meta > span:first-child { color: #38b6ff; font-size: 18px; font-weight: 700; display: block; }
        .profile .meta .role { font-weight: 400; color: #333; font-size: 0.9rem; display: block; }

        /* ── MAIN PANEL ── */
        .main-panel {
            flex: 1 1 0;
            display: flex;
            flex-direction: column;
            min-width: 0;
            min-height: 100vh;
            background: white;
            overflow-x: hidden;
        }

        .dashboard-scroll {
            flex: 1 1 0;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 1.5rem;
            max-width: 1280px;
            margin: 0 auto;
            width: 100%;
        }

        h1 {
            margin: 0 0 0.5rem;
            font-weight: 900;
            font-size: 32px;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            color: var(--text);
            text-align: center;
        }

        .subtitle {
            margin-bottom: 2rem;
            color: #5f6b7b;
            text-align: center;
        }

        h2 {
            color: #38b6ff;
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            margin: 0 0 1rem;
        }

        /* ── HEATMAP ── */
        .heatmap-panel {
            background: #fff;
            border-radius: 10px;
            padding: 1.25rem;
            overflow-x: auto;
            width: 100%;
            border: 2px solid #c7da30;
            margin-bottom: 2rem;
        }

        .heatmap-toolbar {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

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

        .heatmap-view-toggle button:hover,
        .heatmap-view-toggle button.active {
            background: #c7da30;
            color: #fff;
        }

        .heatmap-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }

        .heatmap-table { border-collapse: collapse; font-size: 13px; min-width: 100%; }
        .heatmap-table th, .heatmap-table td { border: 1px solid #111827; padding: 0.5rem 0.65rem; text-align: center; }

        .heatmap-corner {
            background: #d1d5db; font-weight: 700;
            text-align: left !important; min-width: 140px;
        }

        .heatmap-col { background: #d1d5db; font-weight: 700; white-space: nowrap; min-width: 90px; }
        .heatmap-row { background: #d1d5db; font-weight: 600; text-align: left !important; padding-left: 0.75rem; min-width: 140px; }

        .heatmap-cell {
            font-weight: 600;
            cursor: pointer;
            min-width: 50px;
            position: relative;
        }

        .heatmap-cell.heatmap-cell-dark { color: #fff; text-shadow: 0 1px 2px rgba(0,0,0,0.25); }
        .heatmap-cell:hover { outline: 2px solid #38b6ff; z-index: 2; }

        .heatmap-total-cell, .heatmap-total-col, .heatmap-total-row { display: none; }

        .heatmap-scale-wrap { display: flex; flex-wrap: wrap; align-items: center; gap: 1rem; margin-top: 1rem; }
        .heatmap-scale { display: flex; align-items: center; gap: 0.5rem; font-size: 12px; color: #6b7280; }
        .heatmap-scale-bar {
            height: 14px; width: 180px; border-radius: 7px;
            background: linear-gradient(to right, #8BC34A 0%, #FFC107 50%, #E53935 100%);
            border: 1px solid #111827;
        }

        /* ── MAP ── */
        .map-panel {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            border: 2px solid #c7da30;
            margin-bottom: 2rem;
        }

        .sa-map-container {
            height: 480px; width: 100%;
            border-radius: 0.5rem; overflow: hidden;
            border: 1px solid #e5e7eb; position: relative;
            background: #f1f5f9;
        }

        .map-legend {
            position: absolute; bottom: 20px; right: 20px; z-index: 1000;
            background: rgba(255,255,255,0.97); padding: 10px 14px; border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15); font-size: 12px;
            font-family: 'Montserrat', sans-serif; display: none;
        }

        .map-legend-title { font-weight: 700; margin-bottom: 6px; color: #1f2937; }
        .map-legend-row { display: flex; align-items: center; gap: 8px; font-size: 11px; color: #111827; margin-top: 4px; }
        .map-legend-swatch { width: 14px; height: 10px; border: 1px solid #111827; }
        .map-legend-swatch.low { background: #8BC34A; }
        .map-legend-swatch.medium { background: #FFC107; }
        .map-legend-swatch.high { background: #E53935; }

        .map-key-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            margin-top: 1rem;
        }

        .map-key-table th {
            text-align: left;
            padding: 0.4rem 0.75rem;
            border-bottom: 2px solid #e5e7eb;
            font-weight: 700;
            color: #545454;
        }

        .map-key-table td {
            padding: 0.4rem 0.75rem;
            border-bottom: 1px solid #f0f0f0;
            color: #545454;
        }

        .map-key-table td:last-child { font-weight: 700; color: #38b6ff; }

        .map-key-swatch {
            display: inline-block;
            width: 12px; height: 12px;
            border-radius: 2px;
            border: 1px solid #aaa;
            margin-right: 6px;
            vertical-align: middle;
        }

        .heatmap-legend { margin-top: 0.5rem; font-size: 12px; color: #6b7280; }

        .leaflet-tooltip.map-label {
            background: transparent; border: none; box-shadow: none;
            color: #111827; font-weight: 900; font-size: 9px;
            text-transform: uppercase; letter-spacing: 0.02em;
        }

        /* ── MOBILE ── */
        .menu-icon {
            display: none;
            position: fixed; top: 12px; left: 12px;
            width: 44px; height: 44px; padding: 0;
            border: 2px solid #e5e7eb; background: white;
            border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            cursor: pointer; z-index: 1001;
            align-items: center; justify-content: center;
            font-size: 22px; color: #38b6ff;
        }

        .sidebar-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.3); z-index: 999;
        }

        .sidebar-overlay.active { display: block; }

        @media (max-width: 900px) {
            .menu-icon { display: flex !important; }

            .sidebar {
                position: fixed; top: 0; left: 0; width: 0; height: 100vh;
                overflow: hidden; transition: width 0.3s ease; z-index: 1000;
                box-shadow: 2px 0 12px rgba(0,0,0,0.15); padding-top: 70px;
            }

            .sidebar.open { width: 240px; }
            .sidebar-logo { display: none; }
            .sidebar.open .sidebar-logo { display: block; position: static; padding: 0 12px 12px; }

            .main-panel { margin-left: 0 !important; }
            .dashboard-scroll { padding: 1rem; }
            .topbar { padding: 0.75rem 1rem; }
            h1 { font-size: 22px !important; }
            .sa-map-container { height: 320px; }
            .heatmap-table { font-size: 11px; }
            .heatmap-corner, .heatmap-row { min-width: 90px; }
            .heatmap-col { min-width: 65px; font-size: 10px; }
        }

        @media (max-width: 600px) {
            h1 { font-size: 18px !important; }
            .sa-map-container { height: 260px; }
            .map-legend { bottom: 8px; right: 8px; padding: 6px 8px; font-size: 10px; }
        }
    </style>
</head>
<body>

{{-- ── SIDEBAR ── --}}
<aside class="sidebar" id="na-sidebar">
    <div class="sidebar-logo">
        <img src="{{ asset('images/logo.png') }}" alt="Tekete SafeSpace">
    </div>
    <ul class="sidebar-list">
        <a href="{{ url('/national-admin/dashboard') }}"
           class="sidebar-link {{ request()->is('national-admin/dashboard') ? 'active' : '' }}">Dashboard</a>

        <a href="{{ url('/national-admin/reports') }}"
           class="sidebar-link {{ request()->is('national-admin/reports') ? 'active' : '' }}">Reports</a>

        <a href="{{ url('/national-admin/heatmap') }}"
           class="sidebar-link {{ request()->is('national-admin/heatmap') ? 'active' : '' }}">Heat-map</a>

        <a href="{{ url('/national-admin/settings') }}"
           class="sidebar-link {{ request()->is('national-admin/settings') ? 'active' : '' }}">My Profile</a>

        <a href="#" onclick="event.preventDefault(); exportPDF();" class="sidebar-link">Export PDF</a>

        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           class="sidebar-link">Sign Out</a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
            @csrf
        </form>
    </ul>
</aside>

<div class="sidebar-overlay" id="sidebarOverlay" aria-hidden="true"></div>

{{-- ── MAIN PANEL ── --}}
<div class="main-panel">
    <button class="menu-icon" aria-label="Open navigation menu" aria-expanded="false"
            aria-controls="na-sidebar" type="button">&#9776;</button>

    {{-- Top bar --}}
    <div class="topbar">
        <div class="profile">
            <div class="meta">
                <span>{{ auth()->user()->name ?? 'Administrator' }}</span>
                <span class="role">Administrator</span>
            </div>
            <div class="profile-avatar">
                @php $currentUser = auth()->user()?->fresh(); @endphp
                @if($currentUser && $currentUser->profile_picture)
                    <img src="{{ $currentUser->profile_picture_url }}" alt="Profile Picture">
                @endif
            </div>
        </div>
    </div>

    <div class="dashboard-scroll" id="main-content">
        <h1>Tekete SafeSpace – Heatmap</h1>
        <p class="subtitle">Reports by Province &amp; District, with geographic breakdown.</p>

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
                            <th class="heatmap-total-col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($provinceHeatmapMatrix ?? [] as $provinceName => $row)
                            @php $rowIdx = $loop->index; @endphp
                            <tr>
                                <th class="heatmap-row">{{ $provinceName }}</th>
                                @foreach($row as $colIdx => $count)
                                    @php
                                        $intensity = ($provinceHeatmapMax ?? 1) > 0 ? min(1, $count / ($provinceHeatmapMax ?? 1)) : 0;
                                        $colors = ['#8BC34A', '#FFC107', '#E53935'];
                                        $colorIdx = $intensity >= 0.67 ? 2 : ($intensity >= 0.34 ? 1 : 0);
                                        $bgColor = $colors[$colorIdx];
                                        $isDark = $colorIdx === 2;
                                        $pct = $provinceHeatmapPercentages[$provinceName][$colIdx] ?? 0;
                                        $atype = $provinceHeatmapAbuseTypes[$colIdx] ?? '';
                                        $isHotspot = in_array($colIdx, $provinceHeatmapHotspots[$provinceName] ?? []);
                                        $provinceId = $provinceHeatmapProvinceNameToId[$provinceName] ?? null;
                                        $abuseTypeId = $provinceHeatmapAbuseTypeNameToId[$atype] ?? null;
                                        $animDelay = ($rowIdx * count($row) + $colIdx) * 0.02;
                                    @endphp
                                    <td class="heatmap-cell {{ $isDark ? 'heatmap-cell-dark' : '' }} {{ $isHotspot ? 'heatmap-hotspot' : '' }}"
                                        style="background-color: {{ $bgColor }}; animation-delay: {{ $animDelay }}s;"
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
                                <td class="heatmap-total-cell">{{ $provinceHeatmapRowTotals[$provinceName] ?? 0 }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($provinceHeatmapAbuseTypes ?? []) + 2 }}"
                                    style="text-align:center; padding:2rem; color:#6b7280;">
                                    No report data available.
                                </td>
                            </tr>
                        @endforelse

                        @if(!empty($provinceHeatmapMatrix))
                            <tr class="heatmap-total-row">
                                <th class="heatmap-corner">Total</th>
                                @foreach($provinceHeatmapColumnTotals ?? [] as $colTotal)
                                    <td class="heatmap-total-col">{{ $colTotal }}</td>
                                @endforeach
                                <td class="heatmap-total-cell">{{ $provinceHeatmapGrandTotal ?? 0 }}</td>
                            </tr>
                        @endif
                    </tbody>
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

        {{-- ── MAP: Province choropleth (districts have no coordinates, so aggregated to province) ── --}}
        <section class="map-panel" aria-label="Reports by Province Map">
            <h2>Reports by Province (Geographic)</h2>
            <div id="sa-map" class="sa-map-container">
                <div id="map-legend" class="map-legend">
                    <div class="map-legend-title">HEATMAP LEGEND</div>
                    <div class="map-legend-row">
                        <span class="map-legend-swatch low" aria-hidden="true"></span><span>LOW</span>
                    </div>
                    <div class="map-legend-row">
                        <span class="map-legend-swatch medium" aria-hidden="true"></span><span>MEDIUM</span>
                    </div>
                    <div class="map-legend-row">
                        <span class="map-legend-swatch high" aria-hidden="true"></span><span>HIGH</span>
                    </div>
                </div>
            </div>

            {{-- Province key table --}}
            @php
                // Aggregate district counts up to province level for the key table
                $provinceKeyData = [];
                foreach ($mapDistrictCounts as $dName => $info) {
                    $prov = $info['province'] ?? '—';
                    $provinceKeyData[$prov] = ($provinceKeyData[$prov] ?? 0) + ($info['count'] ?? 0);
                }
                arsort($provinceKeyData);
                $provinceKeyMax = max(array_values($provinceKeyData) ?: [1]);
            @endphp
            @if(!empty($provinceKeyData))
            <table class="map-key-table" aria-label="Province report counts">
                <thead>
                    <tr>
                        <th>Province</th>
                        <th style="text-align:right;">Reports</th>
                        <th style="text-align:right;">Level</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($provinceKeyData as $provinceName => $cnt)
                        @php
                            $ratio = $provinceKeyMax > 0 ? $cnt / $provinceKeyMax : 0;
                            $level = $ratio >= 0.67 ? 'High' : ($ratio >= 0.34 ? 'Medium' : 'Low');
                            $swatchColor = $ratio >= 0.67 ? '#E53935' : ($ratio >= 0.34 ? '#FFC107' : '#8BC34A');
                        @endphp
                        <tr>
                            <td>{{ $provinceName }}</td>
                            <td style="text-align:right;">{{ number_format($cnt) }}</td>
                            <td style="text-align:right;">
                                <span class="map-key-swatch" style="background:{{ $swatchColor }};"></span>
                                {{ $level }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endif

            <p class="heatmap-legend">Low / Medium / High show relative report volume across provinces (district counts aggregated). Hover a province for a district breakdown.</p>
        </section>
    </div>
</div>

{{-- ── SCRIPTS ── --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
(function () {
    const reportsUrl = "{{ url('/national-admin/reports') }}";
    const panel = document.getElementById('provinceHeatmapPanel');
    if (!panel) return;

    const viewBtns = panel.querySelectorAll('.heatmap-view-btn');
    const scaleCount = panel.querySelector('#provinceHeatmapScaleCount');
    const scalePct = panel.querySelector('#provinceHeatmapScalePct');

    viewBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const view = this.dataset.view;
            viewBtns.forEach(b => { b.classList.remove('active'); b.setAttribute('aria-pressed', 'false'); });
            this.classList.add('active');
            this.setAttribute('aria-pressed', 'true');

            panel.querySelectorAll('.heatmap-cell').forEach(cell => {
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

    panel.querySelectorAll('.heatmap-cell[data-province-id]').forEach(cell => {
        cell.addEventListener('click', function () {
            const pid = this.dataset.provinceId;
            const aid = this.dataset.abuseTypeId;
            const count = parseInt(this.dataset.count, 10);
            if (count === 0) return;

            const url = new URL(reportsUrl, window.location.origin);
            if (pid) url.searchParams.set('province', pid);
            if (aid) url.searchParams.set('abuse_type', aid);
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
    const menuIcon = document.querySelector('.menu-icon');
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.getElementById('sidebarOverlay');

    function toggle() {
        const isOpen = sidebar.classList.toggle('open');
        if (menuIcon) menuIcon.setAttribute('aria-expanded', isOpen);
        if (overlay) overlay.classList.toggle('active', isOpen);
    }

    if (menuIcon) menuIcon.addEventListener('click', toggle);
    if (overlay) overlay.addEventListener('click', toggle);
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && sidebar.classList.contains('open')) toggle();
    });
})();

function exportPDF() {
    const element = document.getElementById('main-content');
    if (!element) { alert('Main content not found!'); return; }
    // html2pdf is loaded externally; guard in case it isn't
    if (typeof html2pdf === 'undefined') { window.print(); return; }
    html2pdf().from(element).set({
        margin: 10,
        filename: 'heatmap-dashboard.pdf',
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'mm', format: 'a3', orientation: 'landscape' }
    }).save();
}
</script>

{{-- Geographic map: province choropleth coloured by aggregated district reports --}}
<script>
(function () {
    const mapEl = document.getElementById('sa-map');
    if (!mapEl) return;

    // Build province → total reports by summing district counts
    const districtData = @json($mapDistrictCounts ?? []);
    const provinceTotals = {};
    Object.values(districtData).forEach(({ province, count }) => {
        if (!province) return;
        provinceTotals[province] = (provinceTotals[province] ?? 0) + (count ?? 0);
    });

    const maxCount = Math.max(1, ...Object.values(provinceTotals));

    function normalizeName(name) {
        return String(name ?? '').trim().toLowerCase().replace(/[-\s]+/g, ' ');
    }

    function getCountForProvince(geoName) {
        const g = normalizeName(geoName);
        for (const [dbName, count] of Object.entries(provinceTotals)) {
            if (normalizeName(dbName) === g) return count;
        }
        return 0;
    }

    function getColor(count) {
        const ratio = count / maxCount;
        if (ratio >= 0.67) return '#E53935';
        if (ratio >= 0.34) return '#FFC107';
        return '#8BC34A';
    }

    const map = L.map('sa-map', {
        zoomControl: false,
        dragging: false,
        scrollWheelZoom: false,
        doubleClickZoom: false,
        boxZoom: false,
        keyboard: false,
        tap: false,
        touchZoom: false,
    }).setView([-29, 24], 5);

    const legendEl = document.getElementById('map-legend');
    if (legendEl) legendEl.style.display = 'block';

    const geoJsonUrl = 'https://gist.githubusercontent.com/MeganBeckett/9101ba77bd0af06fd003ea5c99d051ab/raw/sa-provinces.json';

    fetch(geoJsonUrl)
        .then(r => r.text())
        .then(text => {
            let geojson;
            try { geojson = JSON.parse(text); } catch { return; }
            L.geoJSON(geojson, {
                style: function (feature) {
                    const name  = feature.properties?.name || '';
                    const count = getCountForProvince(name);
                    return {
                        fillColor: getColor(count),
                        weight: 1.2,
                        opacity: 1,
                        color: '#c7da30',
                        fillOpacity: 0.88,
                    };
                },
                onEachFeature: function (feature, layer) {
                    const name  = feature.properties?.name || 'Unknown';
                    const count = getCountForProvince(name);

                    // Tooltip: province name + total reports across its districts
                    const districtLines = Object.entries(districtData)
                        .filter(([, info]) => normalizeName(info.province) === normalizeName(name))
                        .sort((a, b) => (b[1].count ?? 0) - (a[1].count ?? 0))
                        .map(([d, info]) => `&nbsp;&nbsp;${d}: <strong>${(info.count ?? 0).toLocaleString()}</strong>`)
                        .join('<br>');

                    layer.bindTooltip(
                        `<strong>${name.toUpperCase()}</strong><br>Total: <strong>${count.toLocaleString()}</strong>` +
                        (districtLines ? `<br><small>${districtLines}</small>` : ''),
                        { sticky: true, maxWidth: 260 }
                    );

                    layer.bindTooltip(name.toUpperCase(), {
                        permanent: true,
                        direction: 'center',
                        className: 'map-label',
                    });

                    layer.on({
                        mouseover: e => { e.target.setStyle({ weight: 2.5, color: '#38b6ff' }); e.target.bringToFront(); },
                        mouseout:  e => { e.target.setStyle({ weight: 1.2, color: '#c7da30' }); },
                    });
                },
            }).addTo(map);
        })
        .catch(err => console.warn('Map GeoJSON failed to load:', err));
})();
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
</body>
</html>
