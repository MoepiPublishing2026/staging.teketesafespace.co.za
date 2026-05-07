<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Tekete SafeSpace Provincial Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">

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
}
.subtitle { margin-bottom: 2rem; color: #5f6b7b; }
.panel { background: white; border-radius: 1rem; padding: 0px; max-width: 100%; }
.panel + .panel { margin-top: 1.8rem; }

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

/* Heatmap */
.heatmap-panel {
  background: #fff;
  border-radius: 10px;
  padding: 1.25rem;
  overflow-x: auto;
  width: 100%;
  max-width: 100%;
  border: 2px solid #c7da30;
  box-shadow: none;
}
.heatmap-panel h2 { margin-bottom: 0.5rem; }
.heatmap-toolbar { display: flex; flex-wrap: wrap; align-items: center; gap: 1rem; margin-bottom: 1rem; }
.heatmap-view-toggle { display: flex; gap: 0.5rem; }
.heatmap-view-toggle button {
  padding: 0.35rem 0.75rem !important;
  border: 2px solid #c7da30 !important;
  border-radius: 6px !important;
  font-size: 11px !important;
  font-weight: 900 !important;
  cursor: pointer;
  background: #fff !important;
  color: #545454 !important;
  box-shadow: none !important;
  transition: background-color 0.2s ease, color 0.2s ease;
}
.heatmap-view-toggle button:hover { background: #c7da30 !important; color: #fff !important; }
.heatmap-view-toggle button.active { background: #c7da30 !important; color: #fff !important; }
.heatmap-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
.heatmap-table { border-collapse: collapse; font-size: 13px; min-width: 100%; }
.heatmap-table th, .heatmap-table td {
  border: 1px solid #111827;
  padding: 0.5rem 0.65rem;
  text-align: center;
}
.heatmap-corner {
  background: #d1d5db; font-weight: 700; text-align: left !important;
  min-width: 120px;
}
.heatmap-col { background: #d1d5db; font-weight: 700; white-space: nowrap; min-width: 90px; }
.heatmap-row { background: #d1d5db; font-weight: 600; text-align: left !important; padding-left: 0.75rem; }
.heatmap-cell {
  font-weight: 600; cursor: pointer; min-width: 50px; position: relative;
}
.heatmap-cell.heatmap-cell-dark { color: #fff; text-shadow: 0 1px 2px rgba(0,0,0,0.25); }
.heatmap-scale-wrap { display: flex; flex-wrap: wrap; align-items: center; gap: 1rem; margin-top: 1rem; }
.heatmap-scale { display: flex; align-items: center; gap: 0.5rem; font-size: 12px; color: #6b7280; }
.heatmap-scale-bar {
  height: 14px; width: 180px; border-radius: 7px;
  background: linear-gradient(to right, #22c55e 0%, #38b6ff 50%, #ef4444 100%);
  border: 1px solid #111827;
}
.heatmap-scale-bar.heatmap-scale-pct {
  background: linear-gradient(to right, #22c55e 0%, #38b6ff 50%, #ef4444 100%);
}

/* Map */
.map-panel { background: white; border-radius: 1rem; padding: 1.5rem; }
.district-map-container {
  height: 450px; width: 100%; max-width: 100%; min-height: 350px;
  border-radius: 0.5rem; overflow: hidden; position: relative;
}
.district-map-svg { width: 100%; height: 100%; display: block; }
.district-map-shape { stroke: #111827; stroke-width: 1.1; transition: opacity 0.15s ease, stroke 0.15s ease, stroke-width 0.15s ease; }
.district-map-shape:hover { stroke: #38b6ff; stroke-width: 1.8; }
.district-map-label {
  pointer-events: none; fill: #111827; font-weight: 900; font-size: 9px;
  text-transform: uppercase; letter-spacing: 0.03em; text-anchor: middle;
  paint-order: stroke; stroke: rgba(255,255,255,0.9); stroke-width: 3px; opacity: 0.9;
}
.district-map-marker circle { fill: rgba(255,255,255,0.92); stroke: #111827; stroke-width: 1.4; }
.district-map-marker text { fill: #111827; font-weight: 900; font-size: 10px; dominant-baseline: middle; text-anchor: middle; }
.district-map-key {
  position: absolute; top: 12px; left: 12px; z-index: 15;
  background: rgba(255,255,255,0.96); border: 1px solid rgba(17,24,39,0.2);
  border-radius: 10px; padding: 10px 10px 8px;
  box-shadow: 0 8px 24px rgba(0,0,0,0.12);
  max-height: calc(100% - 24px); overflow: auto; min-width: 180px;
}
.district-map-key-title { font-weight: 900; font-size: 11px; color: #111827; margin-bottom: 6px; letter-spacing: 0.03em; text-transform: uppercase; }
.district-map-key-row {
  display: grid; grid-template-columns: 14px 26px 1fr auto;
  gap: 8px; align-items: center; font-size: 11px; color: #111827;
  padding: 4px 0; border-top: 1px solid rgba(17,24,39,0.08);
}
.district-map-key-row:first-of-type { border-top: none; }
.district-map-key-swatch { width: 14px; height: 10px; border: 1px solid #111827; border-radius: 3px; }
.district-map-key-num { font-weight: 900; color: #111827; }
.district-map-key-name { font-weight: 700; color: #111827; }
.district-map-key-count { font-weight: 900; color: #4b5563; white-space: nowrap; }
.district-map-tooltip {
  position: absolute; left: 0; top: 0;
  transform: translate(-9999px, -9999px);
  background: rgba(255,255,255,0.98); border: 1px solid rgba(17,24,39,0.2);
  border-radius: 10px; padding: 8px 10px;
  box-shadow: 0 8px 24px rgba(0,0,0,0.12);
  font-size: 12px; color: #111827; pointer-events: none; z-index: 20; max-width: 220px; line-height: 1.2;
}
.district-map-tooltip .tt-title { font-weight: 900; font-size: 12px; }
.district-map-tooltip .tt-sub { font-weight: 700; font-size: 11px; color: #4b5563; margin-top: 2px; }
.map-legend {
  position: absolute; bottom: 20px; right: 20px; z-index: 1000;
  background: rgba(255,255,255,0.95); padding: 10px 14px;
  border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.15);
  font-size: 12px; font-family: 'Montserrat', sans-serif;
}
.map-legend-title { font-weight: 700; margin-bottom: 6px; color: #1f2937; }
.map-legend-row { display: flex; align-items: center; gap: 8px; font-size: 11px; color: #111827; margin-top: 4px; }
.map-legend-swatch { width: 14px; height: 10px; border: 1px solid #111827; }
.map-legend-swatch.low { background: #22c55e; }
.map-legend-swatch.medium { background: #38b6ff; }
.map-legend-swatch.high { background: #ef4444; }

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

<aside class="sidebar" id="provincialSidebar">
    <div class="sidebar-logo">
        <img src="{{ asset('images/logo.png') }}" alt="Tekete SafeSpace">
    </div>
    <ul class="sidebar-list">
        <a href="{{ url('/provincial-admin/dashboard') }}" class="sidebar-link {{ request()->is('provincial-admin/dashboard') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ url('/provincial-admin/reports') }}" class="sidebar-link {{ request()->is('provincial-admin/reports') ? 'active' : '' }}">Reports</a>
        <a href="{{ url('/provincial/heatmap') }}"  class="sidebar-link {{ request()->is('provincial/heatmap') ? 'active' : '' }}">Heat-Map</a>
        <a href="{{ url('/provincial-admin/settings') }}" class="sidebar-link {{ request()->is('provincial-admin/settings') ? 'active' : '' }}">My Profile</a>
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
        <h1>
            Tekete SafeSpace Provincial Dashboard -
            <span class="province-name">{{ $province->province_name }}</span>
        </h1>
        <p class="subtitle">Provincial case intelligence and live report monitoring.</p>

        {{-- HEATMAP SECTION --}}
        <section class="panel heatmap-panel" aria-label="Reports by District and Type">
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
                            @foreach($heatmapAbuseTypes ?? [] as $atype)
                                <th class="heatmap-col">{{ $atype }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($heatmapMatrix ?? [] as $district => $row)
                            @php $rowIdx = $loop->index; @endphp
                            <tr>
                                <th class="heatmap-row">{{ $district }}</th>
                                @foreach($row as $colIdx => $count)
                                    @php
                                        $intensity = ($heatmapMax ?? 1) > 0 ? min(1, $count / ($heatmapMax ?? 1)) : 0;
                                        $colors = ['#22c55e', '#38b6ff', '#ef4444'];
                                        $colorIdx = $intensity >= 0.67 ? 2 : ($intensity >= 0.34 ? 1 : 0);
                                        $bgColor = $colors[$colorIdx];
                                        $isDark = $colorIdx === 2;
                                        $pct = $heatmapPercentages[$district][$colIdx] ?? 0;
                                        $atype = $heatmapAbuseTypes[$colIdx] ?? '';
                                        $isHotspot = in_array($colIdx, $heatmapHotspots[$district] ?? []);
                                        $districtId = $heatmapDistrictNameToId[$district] ?? null;
                                        $abuseTypeId = $heatmapAbuseTypeNameToId[$atype] ?? null;
                                        $animDelay = ($rowIdx * count($row) + $colIdx) * 0.02;
                                    @endphp
                                    <td class="heatmap-cell {{ $isDark ? 'heatmap-cell-dark' : '' }} {{ $isHotspot ? 'heatmap-hotspot' : '' }}"
                                        style="background-color: {{ $bgColor }}; animation-delay: {{ $animDelay }}s;"
                                        data-count="{{ $count }}"
                                        data-percent="{{ $pct }}"
                                        data-district="{{ $district }}"
                                        data-abuse-type="{{ $atype }}"
                                        data-district-id="{{ $districtId }}"
                                        data-abuse-type-id="{{ $abuseTypeId }}"
                                        data-view="count"
                                        role="button"
                                        tabindex="0"
                                        title="{{ $district }} × {{ $atype }}: {{ $count }} reports ({{ $pct }}% of district) — Click to view reports">
                                        <span class="heatmap-cell-count">{{ $count }}</span>
                                        <span class="heatmap-cell-pct" style="display:none;">{{ $pct }}%</span>
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($heatmapAbuseTypes ?? []) + 1 }}" style="text-align:center; padding:2rem; color:#6b7280;">No report data for the selected filters.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="heatmap-scale-wrap">
                <div class="heatmap-scale heatmap-scale-count" id="heatmapScaleCount">
                    <span>LOW</span>
                    <div class="heatmap-scale-bar" aria-hidden="true"></div>
                    <span>HIGH</span>
                </div>
                <div class="heatmap-scale heatmap-scale-pct" id="heatmapScalePct" style="display:none;">
                    <span>0%</span>
                    <div class="heatmap-scale-bar heatmap-scale-pct" aria-hidden="true"></div>
                    <span>100%</span>
                </div>
            </div>
        </section>

        {{-- GEOGRAPHIC MAP SECTION --}}
        <section class="panel map-panel" aria-label="Reports by Province Map">
            <h2>Reports by District (Geographic)</h2>
            <div id="district-map" class="district-map-container">
                <div id="district-map-key" class="district-map-key" style="display:none;">
                    <div class="district-map-key-title">Districts</div>
                    <div id="district-map-key-rows"></div>
                </div>
                <div id="map-legend" class="map-legend" style="display:none;">
                    <div class="map-legend-title">{{ strtoupper($province->province_name ?? '') }} HEATMAP LEGEND</div>
                    <div class="map-legend-row"><span class="map-legend-swatch low" aria-hidden="true"></span><span>LOW</span></div>
                    <div class="map-legend-row"><span class="map-legend-swatch medium" aria-hidden="true"></span><span>MEDIUM</span></div>
                    <div class="map-legend-row"><span class="map-legend-swatch high" aria-hidden="true"></span><span>HIGH</span></div>
                </div>
                <div id="district-map-tooltip" class="district-map-tooltip" style="display:none;">
                    <div class="tt-title" id="district-map-tooltip-title"></div>
                    <div class="tt-sub" id="district-map-tooltip-sub"></div>
                </div>
            </div>
        </section>
    </div>
</div>

<script>
(function() {
  const reportsUrl = "{{ url('/provincial-admin/reports') }}";
  const viewBtns = document.querySelectorAll('.heatmap-view-btn');
  const scaleCount = document.getElementById('heatmapScaleCount');
  const scalePct = document.getElementById('heatmapScalePct');

  if (viewBtns.length) {
    viewBtns.forEach(btn => {
      btn.addEventListener('click', function() {
        const view = this.dataset.view;
        viewBtns.forEach(b => { b.classList.remove('active'); b.setAttribute('aria-pressed', 'false'); });
        this.classList.add('active');
        this.setAttribute('aria-pressed', 'true');
        document.querySelectorAll('.heatmap-cell[data-count]').forEach(cell => {
          const countEl = cell.querySelector('.heatmap-cell-count');
          const pctEl = cell.querySelector('.heatmap-cell-pct');
          if (countEl && pctEl) {
            if (view === 'percent') { countEl.style.display = 'none'; pctEl.style.display = ''; }
            else { countEl.style.display = ''; pctEl.style.display = 'none'; }
          }
        });
        if (scaleCount && scalePct) {
          scaleCount.style.display = view === 'count' ? 'flex' : 'none';
          scalePct.style.display = view === 'percent' ? 'flex' : 'none';
        }
      });
    });
  }

  document.querySelectorAll('.heatmap-cell[data-district-id]').forEach(cell => {
    cell.addEventListener('click', function() {
      const did = this.dataset.districtId;
      const aid = this.dataset.abuseTypeId;
      const count = parseInt(this.dataset.count, 10);
      if (count === 0) return;
      const url = new URL(reportsUrl, window.location.origin);
      const params = new URLSearchParams(window.location.search);
      ['district','school','abuse_type','from_date','to_date','age_range'].forEach(k => {
        if (params.has(k)) url.searchParams.set(k, params.get(k));
      });
      if (did) url.searchParams.set('district', did);
      if (aid) url.searchParams.set('abuse_type', aid);
      window.location.href = url.toString();
    });
    cell.addEventListener('keydown', function(e) {
      if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); this.click(); }
    });
  });
})();
</script>

@include('components.provincial-admin-sidebar-script')

<script>
(function() {
  const container = document.getElementById('district-map');
  if (!container) return;

  const provinceSlug = @json($mapProvinceSlug ?? '');
  const districtCounts = @json($heatmapRowTotals ?? []);
  const tableDistrictNames = @json(array_keys($heatmapMatrix ?? []));
  const legendEl = document.getElementById('map-legend');
  if (legendEl) legendEl.style.display = 'block';
  const tooltipEl = document.getElementById('district-map-tooltip');
  const tooltipTitleEl = document.getElementById('district-map-tooltip-title');
  const tooltipSubEl = document.getElementById('district-map-tooltip-sub');
  const keyEl = document.getElementById('district-map-key');
  const keyRowsEl = document.getElementById('district-map-key-rows');

  function normalizeName(name) {
    return String(name || '').toLowerCase().replace(/&/g, 'and').replace(/[^a-z0-9\s]/g, ' ').replace(/\s+/g, ' ').trim();
  }
  function stripPrefixes(name) {
    return normalizeName(name).replace(/^city of\s+/, '').replace(/\s+district municipality$/, '').replace(/\s+metropolitan municipality$/, '');
  }

  const countsByKey = {};
  Object.entries(districtCounts || {}).forEach(([name, count]) => { countsByKey[stripPrefixes(name)] = Number(count) || 0; });

  const max = Math.max(1, ...Object.values(countsByKey));
  const thresholds = { low: max * 0.33, medium: max * 0.66 };
  function getFill(count) {
    if (count <= thresholds.low) return '#22c55e';
    if (count <= thresholds.medium) return '#38b6ff';
    return '#ef4444';
  }

  function formatTooltipTitle(name) {
    return String(name || '').trim().replace(/\s+District Municipality$/i, '').replace(/\s+Metropolitan Municipality$/i, '').trim();
  }

  function showTooltip(clientX, clientY, title, count) {
    if (!tooltipEl) return;
    tooltipTitleEl.textContent = String(title || '');
    tooltipSubEl.textContent = `${Number(count || 0).toLocaleString()} report(s)`;
    tooltipEl.style.display = 'block';
    const rect = container.getBoundingClientRect();
    const pad = 12;
    const x = Math.min(rect.width - pad, Math.max(pad, clientX - rect.left + 12));
    const y = Math.min(rect.height - pad, Math.max(pad, clientY - rect.top + 12));
    tooltipEl.style.transform = `translate(${Math.round(x)}px, ${Math.round(y)}px)`;
  }
  function hideTooltip() {
    if (!tooltipEl) return;
    tooltipEl.style.display = 'none';
    tooltipEl.style.transform = 'translate(-9999px, -9999px)';
  }

  const url = `https://raw.githubusercontent.com/datawizzards/zadmaps/master/geojson/${provinceSlug}.json`;
  fetch(url)
    .then(r => r.json())
    .then(items => {
      const svgNS = 'http://www.w3.org/2000/svg';
      const svg = document.createElementNS(svgNS, 'svg');
      svg.setAttribute('class', 'district-map-svg');
      svg.setAttribute('preserveAspectRatio', 'xMidYMid meet');
      const g = document.createElementNS(svgNS, 'g');
      svg.appendChild(g);

      const shapeByKey = {};
      (items || []).forEach((it) => {
        const name = it?.name ?? '';
        const key = stripPrefixes(name);
        const count = countsByKey[key] ?? 0;
        const path = document.createElementNS(svgNS, 'path');
        path.setAttribute('d', it?.path ?? '');
        path.setAttribute('class', 'district-map-shape');
        path.setAttribute('fill', getFill(count));
        path.setAttribute('tabindex', '0');
        path.setAttribute('role', 'img');
        path.setAttribute('aria-label', `${formatTooltipTitle(name)}: ${Number(count).toLocaleString()} report(s)`);
        path.addEventListener('mouseenter', (e) => showTooltip(e.clientX, e.clientY, formatTooltipTitle(name), count));
        path.addEventListener('mousemove', (e) => showTooltip(e.clientX, e.clientY, formatTooltipTitle(name), count));
        path.addEventListener('mouseleave', hideTooltip);
        g.appendChild(path);
        shapeByKey[key] = { name, pathEl: path, count };
      });

      const oldSvg = container.querySelector('svg.district-map-svg');
      if (oldSvg) oldSvg.remove();
      container.insertBefore(svg, container.firstChild);

      requestAnimationFrame(() => {
        try { const bb = g.getBBox(); svg.setAttribute('viewBox', `${bb.x - 10} ${bb.y - 10} ${bb.width + 20} ${bb.height + 20}`); } catch (e) {}

        const desired = (Array.isArray(tableDistrictNames) ? tableDistrictNames : []).map((n) => ({ original: n, key: stripPrefixes(n) }));
        const dedup = new Map();
        desired.forEach((d) => { if (d.key) dedup.set(d.key, d); });
        const data = Array.from(dedup.values()).map((d) => {
          const match = shapeByKey[d.key];
          return { key: d.key, label: formatTooltipTitle(match?.name ?? d.original), count: Number(match?.count ?? countsByKey[d.key] ?? 0), pathEl: match?.pathEl ?? null };
        });
        data.sort((a, b) => b.count - a.count || a.label.localeCompare(b.label));

        if (keyEl && keyRowsEl) {
          keyRowsEl.innerHTML = '';
          keyEl.style.display = 'block';
          data.forEach((d, idx) => {
            const row = document.createElement('div');
            row.className = 'district-map-key-row';
            const swatch = document.createElement('span');
            swatch.className = 'district-map-key-swatch';
            swatch.style.background = getFill(d.count);
            const num = document.createElement('span'); num.className = 'district-map-key-num'; num.textContent = String(idx + 1);
            const name = document.createElement('span'); name.className = 'district-map-key-name'; name.textContent = d.label;
            const count = document.createElement('span'); count.className = 'district-map-key-count'; count.textContent = Number(d.count).toLocaleString();
            row.appendChild(swatch); row.appendChild(num); row.appendChild(name); row.appendChild(count);
            keyRowsEl.appendChild(row);
          });
        }

        const markerLayer = document.createElementNS('http://www.w3.org/2000/svg', 'g');
        markerLayer.setAttribute('class', 'district-map-markers');
        g.appendChild(markerLayer);

        const placed = [];
        data.forEach((d, idx) => {
          if (!d.pathEl) return;
          let bb; try { bb = d.pathEl.getBBox(); } catch (e) { return; }
          let x = bb.x + bb.width / 2;
          let y = bb.y + bb.height / 2;
          for (let attempt = 0; attempt < 20; attempt++) {
            const collide = placed.some((p) => { const dx = p.x - x; const dy = p.y - y; return Math.sqrt(dx*dx+dy*dy) < 18; });
            if (!collide) break;
            const angle = (attempt + idx) * 0.9;
            const radius = 6 + attempt * 2.5;
            x = (bb.x + bb.width / 2) + Math.cos(angle) * radius;
            y = (bb.y + bb.height / 2) + Math.sin(angle) * radius;
          }
          placed.push({ x, y });
          const svgNS = 'http://www.w3.org/2000/svg';
          const mg = document.createElementNS(svgNS, 'g');
          mg.setAttribute('class', 'district-map-marker');
          mg.setAttribute('transform', `translate(${x}, ${y})`);
          const circle = document.createElementNS(svgNS, 'circle');
          const countText = String(Number(d.count || 0));
          const r = Math.max(10, Math.min(22, 8 + countText.length * 2.2));
          circle.setAttribute('r', String(r));
          mg.appendChild(circle);
          const text = document.createElementNS(svgNS, 'text');
          const fontSize = countText.length <= 2 ? 11 : countText.length === 3 ? 10 : countText.length === 4 ? 9 : 8;
          text.setAttribute('font-size', String(fontSize));
          text.textContent = countText;
          mg.appendChild(text);
          markerLayer.appendChild(mg);
        });
      });
    })
    .catch(() => {});
})();
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
function exportPDF() {
    const element = document.getElementById('main-content');
    if (!element) { alert("Main content not found!"); return; }
    html2pdf().from(element).set({
        margin: 10, filename: 'provincial-admin-dashboard.pdf',
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'mm', format: 'a3', orientation: 'landscape' }
    }).save();
}
</script>

</body>
</html>