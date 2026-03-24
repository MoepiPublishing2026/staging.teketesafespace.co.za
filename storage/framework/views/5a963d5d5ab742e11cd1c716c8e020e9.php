<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Tekete Safe Space National Dashboard</title>
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

* {
    box-sizing: border-box;
}

html, body {
  font-family: 'Montserrat', sans-serif !important;
  color: #545454 !important;
}

.sidebar {
    width: 240px;
    background-color: white;
    border-right: 1px solid #eaeaea;
    display: flex;
    flex-direction: column;
    padding-top: 140px;
}

.sidebar-link, button, select, input, label {
  font-size: 15px !important;
  font-weight: 900 !important;
  color: #545454 !important;
  font-family: 'Montserrat', sans-serif !important;
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
  background-color: #c7da30 !important;
  color: white !important;
  border-color: #38b6ff !important;
  outline: none;
}

button:hover, .sidebar-link:hover, .sidebar-link.active {
  color: #fff !important;
  background: linear-gradient(to right, #38b6ff, #38b6ff) !important;
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

h2 {
  color: #38b6ff !important;
  font-family: 'Montserrat', sans-serif;
  font-weight: 900;
}

body {
    display: flex;
    min-height: 100vh;
    width: 100%;
    min-width: 0;
    overflow-x: hidden;
    overflow-y: auto;
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

.main-panel {
    flex: 1 1 0;
    display: flex;
    flex-direction: column;
    min-width: 0;
    min-height: 100vh;
    background: white;
    overflow-x: hidden;
}

.metrics-row > .metric-card {
    flex: 0 0 100px;
    max-width: 115px;
    min-width: 115px;
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
    font-weight: 900 !important;
    font-size: 32px !important;
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
    color: #fff !important;
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

.metrics-row > .metric-card.status-total    { background-color: #38b6ff; color: white; }
.metrics-row > .metric-card.status-awaiting { background-color: #fcb825; color: white; }
.metrics-row > .metric-card.status-forwarded{ background-color: #64d58f; color: white; }
.metrics-row > .metric-card.status-review   { background-color: #9b57cc; color: white; }
.metrics-row > .metric-card.status-closed   { background-color: #81acef; color: white; }
.metrics-row > .metric-card.status-unresolved{ background-color: #99c4d3; color: white; }
.metrics-row > .metric-card.status-false    { background-color: #ff66c4; color: white; }

.extras-anonymous, .extras-identified, .extras-abuse, .extras-schools {
    background: white;
    color: #1f2933;
    cursor: pointer;
    font-family: 'Century Gothic';
    box-shadow: 0 4px 8px rgba(199, 218, 48, 0.2);
    border: 1px solid #c7da30;
}

.extras-anonymous .card-title,
.extras-identified .card-title,
.extras-abuse .card-title,
.extras-schools .card-title {
    color: #1f2933 !important;
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
    color: #38b6ff !important;
}

.card-subtext {
    font-size: 0.8rem;
    color: #080808ff;
    margin-bottom: 0.25rem;
}

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

.chart-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1.5rem;
  max-width: 1280px;
  width: 100%;
  margin: 0 auto;
}

.chart-card {
  width: 100%;
  background: white;
  padding: 20px;
  border-radius: 12px;
}

.chart-monthly   { grid-column: 1 / 2; grid-row: 1; height: 400px; }
.chart-abuse-pie { grid-column: 2 / 3; grid-row: 1; height: 400px; display: flex; flex-direction: column; }
.chart-anonymous { grid-column: 1 / 2; grid-row: 2; height: 400px; display: flex; flex-direction: column; }
.chart-schools   { grid-column: 2 / 3; grid-row: 2; display: flex; flex-direction: column; }
.chart-status    { grid-column: 1 / 3; grid-row: 3; width: 70%; justify-self: center; }

#abuseTypeChart {
    flex-grow: 1;
    width: 100% !important;
    height: 100% !important;
}

#anonymousChart {
    flex-grow: 1;
    width: 100% !important;
    height: 100% !important;
}

/* Top Reporting Schools table styles */
.schools-table-wrap {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
    margin-top: 0.5rem;
}

.schools-table {
    width: 100%;
    border-collapse: collapse;
    font-family: 'Montserrat', sans-serif;
    font-size: 13px;
}

.schools-table th {
    text-align: left;
    padding: 0.5rem 0.75rem;
    border-bottom: 2px solid #e5e7eb;
    font-weight: 700;
    color: #545454;
    white-space: nowrap;
}

.schools-table th:last-child {
    text-align: right;
}

.schools-table td {
    padding: 0.5rem 0.75rem;
    border-bottom: 1px solid #f0f0f0;
    word-break: break-word;
    white-space: normal;
    color: #545454;
}

.schools-table td:last-child {
    text-align: right;
    white-space: nowrap;
    font-weight: 700;
    color: #38b6ff;
}

.schools-table tr:hover td {
    background: #f9fafb;
}

/* Heatmap */
.heatmap-panel {
  background: linear-gradient(135deg, #fafbfc 0%, #fff 100%);
  border-radius: 1rem;
  padding: 1.5rem;
  overflow-x: auto;
  box-shadow: 0 4px 20px rgba(56, 182, 255, 0.08), 0 1px 3px rgba(0,0,0,0.06);
  width: 100%;
  max-width: 100%;
  border: 1px solid rgba(56, 182, 255, 0.15);
}
.heatmap-panel h2 { margin-bottom: 0.5rem; }
.heatmap-toolbar {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 1rem;
  margin-bottom: 1rem;
}
.heatmap-view-toggle {
  display: flex;
  background: #f3f4f6;
  border-radius: 8px;
  padding: 3px;
  gap: 2px;
}
.heatmap-view-toggle button {
  padding: 0.4rem 0.9rem;
  border: none;
  border-radius: 6px;
  font-size: 12px;
  font-weight: 700;
  cursor: pointer;
  background: transparent;
  color: #6b7280;
  transition: all 0.2s ease;
}
.heatmap-view-toggle button:hover { color: #1f2937; }
.heatmap-view-toggle button.active {
  background: white;
  color: #0c4a6e;
  box-shadow: 0 1px 2px rgba(0,0,0,0.08);
}
.heatmap-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
.heatmap-table { border-collapse: collapse; font-size: 13px; min-width: 100%; }
.heatmap-table th, .heatmap-table td { border: 1px solid #e5e7eb; padding: 0.5rem 0.65rem; text-align: center; }
.heatmap-corner {
  background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
  font-weight: 700;
  text-align: left !important;
  min-width: 120px;
  position: sticky;
  left: 0;
  z-index: 1;
}
.heatmap-col {
  background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
  font-weight: 700;
  white-space: nowrap;
  min-width: 90px;
}
.heatmap-row {
  background: #fafbfc;
  font-weight: 600;
  text-align: left !important;
  padding-left: 0.75rem;
  position: sticky;
  left: 0;
  z-index: 1;
}
.heatmap-cell {
  font-weight: 600;
  cursor: pointer;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
  min-width: 50px;
  position: relative;
  animation: heatmapCellFadeIn 0.4s ease backwards;
}
.heatmap-cell.heatmap-cell-dark { color: #fff; text-shadow: 0 1px 2px rgba(0,0,0,0.25); }
.heatmap-cell:hover { transform: scale(1.1); box-shadow: 0 4px 12px rgba(0,0,0,0.2); z-index: 2; }
.heatmap-cell::after { content: ''; position: absolute; inset: 0; border-radius: 2px; pointer-events: none; }
.heatmap-cell.heatmap-hotspot::before {
  content: '◆';
  position: absolute;
  top: 2px; right: 4px;
  font-size: 8px;
  color: rgba(255,255,255,0.9);
  opacity: 0.9;
}
.heatmap-cell.heatmap-cell-dark.heatmap-hotspot::before { color: rgba(255,255,255,0.95); }
@media (hover: none) {
  .heatmap-cell:hover { transform: none; }
  .heatmap-cell:active { box-shadow: 0 0 0 3px #38b6ff; }
}
@keyframes heatmapCellFadeIn {
  from { opacity: 0; transform: scale(0.95); }
  to   { opacity: 1; transform: scale(1); }
}
.heatmap-total-cell {
  background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 100%) !important;
  color: #fff !important;
  font-weight: 700;
}
.heatmap-total-row th, .heatmap-total-col {
  background: linear-gradient(180deg, #e0f2fe 0%, #bae6fd 100%) !important;
  font-weight: 700;
  color: #0c4a6e;
}
.heatmap-scale-wrap { display: flex; flex-wrap: wrap; align-items: center; gap: 1rem; margin-top: 1rem; }
.heatmap-scale { display: flex; align-items: center; gap: 0.5rem; font-size: 12px; color: #6b7280; }
.heatmap-scale-bar {
  height: 14px; width: 180px; border-radius: 7px;
  background: linear-gradient(to right, #e0f2fe 0%, #fef9c3 25%, #eab308 50%, #f97316 75%, #ef4444 100%);
  border: 1px solid #e5e7eb;
  box-shadow: inset 0 1px 2px rgba(0,0,0,0.05);
}
.heatmap-scale-bar.heatmap-scale-pct {
  background: linear-gradient(to right, #f0fdf4 0%, #86efac 25%, #22c55e 50%, #15803d 75%, #14532d 100%);
}
.heatmap-legend { margin-top: 0.5rem; font-size: 12px; color: #6b7280; }

/* Geographic map */
.map-panel { background: white; border-radius: 1rem; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.08); }
.sa-map-container {
  height: 450px; width: 100%; max-width: 100%; min-height: 350px;
  border-radius: 0.5rem; overflow: hidden; border: 1px solid #e5e7eb; position: relative;
}
.map-legend {
  position: absolute; bottom: 20px; right: 20px; z-index: 1000;
  background: rgba(255,255,255,0.95); padding: 10px 14px; border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.15); font-size: 12px; font-family: 'Montserrat', sans-serif;
}
.map-legend-title { font-weight: 700; margin-bottom: 6px; color: #1f2937; }
.map-legend-bar {
  height: 10px; width: 120px; border-radius: 5px;
  background: linear-gradient(to right, #e0f2fe 0%, #fef9c3 25%, #eab308 50%, #f97316 75%, #ef4444 100%);
  margin: 4px 0; border: 1px solid #e5e7eb;
}
.map-legend-labels { display: flex; justify-content: space-between; font-size: 11px; color: #6b7280; }
.leaflet-tooltip.map-tooltip {
  background: rgba(30, 64, 175, 0.95); color: white; border: none;
  padding: 6px 10px; font-weight: 600; font-size: 13px; border-radius: 6px;
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

.filter-chips { display: flex; flex-wrap: wrap; gap: 0.75rem; margin-top: 1.25rem; }
.filter-chips span {
    background: rgba(47, 123, 52, 0.08);
    color: var(--green);
    border-radius: 999px;
    padding: 0.4rem 0.85rem;
    font-size: 0.78rem;
    font-weight: 600;
}

.grid-two { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 0.5rem; }
.grid-three { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.5rem; }

canvas { width: 100% !important; height: 280px !important; }

.modal-backdrop {
    position: fixed; inset: 0;
    background: rgba(17, 24, 39, 0.58);
    display: none; align-items: center; justify-content: center; z-index: 50;
}
.modal-backdrop.active { display: flex; }
.modal-card {
    width: min(960px, 92vw);
    max-height: 85vh;
    overflow-y: auto;
    background: white;
    border-radius: 1.25rem;
    padding: 2rem;
    box-shadow: 0 32px 64px rgba(15, 23, 42, 0.35);
}
.modal-card h3 { margin: 0 0 1rem; font-size: 1.5rem; font-weight: 700; color: var(--green-dark); }
.modal-close { background: none; border: none; font-size: 1.5rem; color: #ef4444; cursor: pointer; }
.extras-modal-btn {
    padding: 0.5rem 1rem; background: #38b6ff; color: white;
    border: none; border-radius: 6px; cursor: pointer; font-weight: 600; font-family: 'Montserrat', sans-serif;
}
.extras-modal-btn:hover { background: #0c8cb3; }

.filter-separator { border: none; border-bottom: 2px solid silver; margin: 0 0 1rem 0; }

.filters button#refreshBtn {
    color: white; border: none; padding: 0.65rem 0.85rem;
    border-radius: 0.75rem; font-weight: 600; cursor: pointer;
    margin-left: 0.5rem; transition: background-color 0.2s;
}
.filters button#refreshBtn:hover { background: linear-gradient(to right, #38b6ff, #38b6ff); }

.menu-icon {
    display: none; position: fixed; top: 12px; left: 12px;
    width: 44px; height: 44px; padding: 0;
    border: 2px solid #e5e7eb; background: white !important;
    border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    cursor: pointer; z-index: 1001; align-items: center; justify-content: center;
    font-size: 22px; color: #38b6ff !important;
}
.menu-icon:hover { background: #f3f4f6 !important; border-color: #38b6ff !important; }
.sidebar-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(0,0,0,0.3); z-index: 999; opacity: 0; transition: opacity 0.2s ease;
}
.sidebar-overlay.active { display: block; opacity: 1; }
@media (min-width: 901px) { .sidebar-overlay { display: none !important; } }

@media (max-width: 1200px) {
    .metrics-row > .metric-card { flex: 1 1 calc(25% - 1rem); min-width: 90px; max-width: none; }
    .chart-grid { gap: 1rem; }
}

@media (max-width: 900px) {
    .menu-icon { display: flex; }
    .sidebar {
        position: fixed; top: 0; left: 0; width: 0; height: 100vh;
        background: white; overflow-x: hidden; overflow-y: auto;
        transition: width 0.3s ease; z-index: 1000;
        box-shadow: 2px 0 12px rgba(0,0,0,0.15);
    }
    .sidebar.open { width: 240px; }
    .main-panel { margin-left: 0 !important; transition: margin-left 0.3s ease; }
    .main-panel.shifted { margin-left: 240px; }
    .dashboard-scroll { padding: 1rem; }
    .metrics-row, .extras-row { gap: 0.75rem; }
    .metrics-row > .metric-card { flex: 1 1 calc(50% - 0.5rem); min-width: 0; max-width: none; min-height: 90px; padding: 10px 12px; }
    .metrics-row > .metric-card .card-value { font-size: 24px !important; }
    .extras-row > .metric-card { flex: 1 1 calc(50% - 0.5rem); min-width: 0; }
    .chart-grid { grid-template-columns: 1fr; gap: 1rem; }
    .chart-grid > .chart-card:last-child { grid-column: 1; }
    .chart-monthly, .chart-abuse-pie, .chart-anonymous, .chart-schools, .chart-status {
        grid-column: 1; width: 100%;
    }
    .chart-card { min-height: 250px; }
    canvas { height: 250px !important; }
    .heatmap-panel { padding: 1rem; }
    .heatmap-toolbar { flex-direction: column; align-items: flex-start; gap: 0.5rem; }
    .heatmap-wrap { -webkit-overflow-scrolling: touch; overflow-x: auto; overflow-y: visible; }
    .heatmap-table { font-size: 11px; }
    .heatmap-table th, .heatmap-table td { padding: 0.35rem 0.45rem; }
    .heatmap-corner { min-width: 90px; font-size: 11px; }
    .heatmap-col { min-width: 65px; font-size: 10px; }
    .heatmap-row { min-width: 90px; font-size: 11px; }
    .heatmap-cell { min-width: 40px; }
    .heatmap-scale { flex-wrap: wrap; gap: 0.35rem; }
    .heatmap-scale-bar { width: 100px; }
    .map-panel { padding: 1rem; }
    .sa-map-container { height: 320px; min-height: 280px; }
    .map-legend { bottom: 10px; right: 10px; padding: 8px 10px; font-size: 11px; }
    .map-legend-bar { width: 80px; height: 8px; }
    form.filters { flex-direction: column; gap: 0.75rem; align-items: stretch; }
    form.filters select, form.filters input[type="date"], form.filters button { min-width: 100%; width: 100%; }
    form.filters label { width: 100%; }
    form.filters label input { width: 100%; }
    .topbar { padding: 0.75rem 1rem; min-height: 56px; }
    .profile .meta > span:first-child { font-size: 14px; }
    .profile .meta .role { font-size: 12px; }
    h1 { font-size: 22px !important; padding: 0 0.5rem; }
    .subtitle { font-size: 13px; padding: 0 0.5rem; }
    .modal-card { width: min(96vw, 480px); padding: 1.25rem; }
    section[aria-label="Filters"] { padding: 0.75rem 1rem; }
    .panel { padding: 0; }
}

@media (max-width: 600px) {
    .menu-icon { top: 10px; left: 10px; width: 40px; height: 40px; font-size: 20px; }
    .sidebar.open { width: 100%; max-width: 280px; }
    .main-panel.shifted { margin-left: 0; }
    .dashboard-scroll { padding: 0.75rem; }
    .metrics-row > .metric-card { flex: 1 1 100%; }
    .extras-row > .metric-card { flex: 1 1 100%; }
    .metrics-row > .metric-card .card-value { font-size: 22px !important; }
    .card-title { font-size: 12px !important; }
    .heatmap-corner { min-width: 75px; }
    .heatmap-col { min-width: 55px; font-size: 9px; }
    .heatmap-cell { min-width: 36px; }
    .heatmap-table th, .heatmap-table td { padding: 0.3rem 0.35rem; }
    .sa-map-container { height: 280px; min-height: 240px; }
    .map-legend { bottom: 8px; right: 8px; padding: 6px 8px; font-size: 10px; }
    .map-legend-bar { width: 60px; }
    h1 { font-size: 18px !important; }
    .subtitle { font-size: 12px; }
    section[aria-label="Filters"] { padding: 0.5rem 0.75rem; }
}
    </style>
</head>
<body>

<aside class="sidebar">
    <div style="position: fixed; top: 40px; left: 40px; width: 100px; height: auto;">
        <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Safe Space Logo" style="width: 150px; height: auto;">
    </div>
    <ul class="sidebar-list">
        <a href="<?php echo e(url('/national-admin/dashboard')); ?>" class="sidebar-link <?php echo e(request()->is('national-admin/dashboard') ? 'active' : ''); ?>">Dashboard</a>
        <a href="<?php echo e(url('/national-admin/reports')); ?>" class="sidebar-link <?php echo e(request()->is('national-admin/reports') ? 'active' : ''); ?>">Reports</a>
        <a href="<?php echo e(url('/national-admin/settings')); ?>" class="sidebar-link <?php echo e(request()->is('national-admin/settings') ? 'active' : ''); ?>">My Profile</a>
        <a href="#" onclick="event.preventDefault(); exportPDF();" class="sidebar-link">Export PDF</a>
        <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="sidebar-link">Sign Out</a>
        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
            <?php echo csrf_field(); ?>
        </form>
    </ul>
</aside>

<div class="sidebar-overlay" id="sidebarOverlay" aria-hidden="true"></div>

<div class="main-panel">
    <button class="menu-icon" aria-label="Toggle menu" type="button">&#9776;</button>

    <div class="topbar">
        <div class="profile">
            <div class="meta">
                <span><?php echo e(auth()->user()->name ?? 'Administrator'); ?></span>
                <span class="role">Administrator</span>
            </div>
            <div class="profile-avatar">
                <?php $currentUser = auth()->user()->fresh(); ?>
                <?php if($currentUser && $currentUser->profile_picture): ?>
                    <img src="<?php echo e($currentUser->profile_picture_url); ?>" alt="Profile Picture" class="profile-pic">
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="dashboard-scroll" id="main-content">
        <h1>Tekete Safe Space National Dashboard</h1>
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
                    <option value="">Any Report Type</option>
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
            <div class="metric-card extras-anonymous" onclick="openExtrasModal('anonymous')">
                <span class="card-title">Anonymous</span>
                <div class="card-value"><?php echo e(number_format($anonymousCounts['anonymous'] ?? 0)); ?></div>
                <span class="card-subtext"></span>
            </div>
            <div class="metric-card extras-identified" onclick="openExtrasModal('identified')">
                <span class="card-title">Identified</span>
                <div class="card-value"><?php echo e(number_format($anonymousCounts['identified'] ?? 0)); ?></div>
            </div>
            <div class="metric-card extras-abuse" onclick="openExtrasModal('abuse-types')">
                <span class="card-title">Active Report Types</span>
                <div class="card-value"><?php echo e(count($abuseTypeLabels)); ?></div>
                <span class="card-subtext"></span>
            </div>
            <div class="metric-card extras-schools" onclick="openExtrasModal('schools')">
                <span class="card-title">Active Schools</span>
                <div class="card-value"><?php echo e(count($topSchools)); ?></div>
                <span class="card-subtext"></span>
            </div>
        </section>

        <section class="panel" aria-label="Analytics">
            <section class="chart-grid" aria-label="Dashboard charts overview">

                <div class="chart-card chart-monthly">
                    <h2>Monthly Trends</h2>
                    <canvas id="monthlyTrendChart"></canvas>
                </div>

                <div class="chart-card chart-abuse-pie">
                    <h2>Report Types Distribution</h2>
                    <canvas id="abuseTypeChart"></canvas>
                </div>

                <div class="chart-card chart-anonymous">
                    <h2>Anonymous vs Identified</h2>
                    <canvas id="anonymousChart"></canvas>
                </div>

                <!-- Top Reporting Schools — HTML table instead of canvas -->
                <div class="chart-card chart-schools">
                    <h2>Top Reporting Schools</h2>
                    <div class="schools-table-wrap">
                        <table class="schools-table">
                            <thead>
                                <tr>
                                    <th>School</th>
                                    <th>Reports</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $topSchools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schoolName => $schoolCount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($schoolName); ?></td>
                                        <td><?php echo e(number_format($schoolCount)); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="2" style="text-align:center; color:#6b7280; padding:1rem;">No schools with reports.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="chart-card chart-status">
                    <h2>Status Breakdown</h2>
                    <canvas id="statusChart"></canvas>
                </div>

            </section>

            <section class="panel heatmap-panel" aria-label="Reports by Province and Type">
                <h2>Reports by Province &amp; Report Type</h2>
                <div class="heatmap-toolbar">
                    <div class="heatmap-view-toggle" role="group" aria-label="View mode">
                        <button type="button" class="heatmap-view-btn active" data-view="count" aria-pressed="true">Counts</button>
                        <button type="button" class="heatmap-view-btn" data-view="percent" aria-pressed="false">Row %</button>
                    </div>
                    <span class="heatmap-legend" style="margin:0;">Click a cell to view filtered reports</span>
                </div>
                <div class="heatmap-wrap">
                    <table class="heatmap-table" role="table">
                        <thead>
                            <tr>
                                <th class="heatmap-corner">Province</th>
                                <?php $__currentLoopData = $heatmapAbuseTypes ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $atype): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th class="heatmap-col"><?php echo e($atype); ?></th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <th class="heatmap-total-col">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $heatmapMatrix ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $province => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php $rowIdx = $loop->index; ?>
                                <tr>
                                    <th class="heatmap-row"><?php echo e($province); ?></th>
                                    <?php $__currentLoopData = $row; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $colIdx => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $intensity = ($heatmapMax ?? 1) > 0 ? min(1, $count / ($heatmapMax ?? 1)) : 0;
                                            $colors = ['#e0f2fe','#fef9c3','#eab308','#f97316','#ef4444'];
                                            $colorIdx = $intensity >= 0.8 ? 4 : ($intensity >= 0.6 ? 3 : ($intensity >= 0.4 ? 2 : ($intensity >= 0.2 ? 1 : 0)));
                                            $bgColor = $colors[$colorIdx];
                                            $isDark = $intensity >= 0.6;
                                            $pct = $heatmapPercentages[$province][$colIdx] ?? 0;
                                            $atype = $heatmapAbuseTypes[$colIdx] ?? '';
                                            $isHotspot = in_array($colIdx, $heatmapHotspots[$province] ?? []);
                                            $provinceId = $heatmapProvinceNameToId[$province] ?? null;
                                            $abuseTypeId = $heatmapAbuseTypeNameToId[$atype] ?? null;
                                            $animDelay = ($rowIdx * count($row) + $colIdx) * 0.02;
                                        ?>
                                        <td class="heatmap-cell <?php echo e($isDark ? 'heatmap-cell-dark' : ''); ?> <?php echo e($isHotspot ? 'heatmap-hotspot' : ''); ?>"
                                            style="background-color: <?php echo e($bgColor); ?>; animation-delay: <?php echo e($animDelay); ?>s;"
                                            data-count="<?php echo e($count); ?>"
                                            data-percent="<?php echo e($pct); ?>"
                                            data-province="<?php echo e($province); ?>"
                                            data-abuse-type="<?php echo e($atype); ?>"
                                            data-province-id="<?php echo e($provinceId); ?>"
                                            data-abuse-type-id="<?php echo e($abuseTypeId); ?>"
                                            data-view="count"
                                            role="button"
                                            tabindex="0"
                                            title="<?php echo e($province); ?> × <?php echo e($atype); ?>: <?php echo e($count); ?> reports (<?php echo e($pct); ?>% of province) — Click to view reports">
                                            <span class="heatmap-cell-count"><?php echo e($count); ?></span>
                                            <span class="heatmap-cell-pct" style="display:none;"><?php echo e($pct); ?>%</span>
                                        </td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <td class="heatmap-total-cell"><?php echo e($heatmapRowTotals[$province] ?? 0); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="<?php echo e(count($heatmapAbuseTypes ?? []) + 2); ?>" style="text-align:center; padding:2rem; color:#6b7280;">No report data for the selected filters.</td>
                                </tr>
                            <?php endif; ?>
                            <?php if(!empty($heatmapMatrix)): ?>
                                <tr class="heatmap-total-row">
                                    <th class="heatmap-corner">Total</th>
                                    <?php $__currentLoopData = $heatmapColumnTotals ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $colTotal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <td class="heatmap-total-col"><?php echo e($colTotal); ?></td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <td class="heatmap-total-cell"><?php echo e($heatmapGrandTotal ?? 0); ?></td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="heatmap-scale-wrap">
                    <div class="heatmap-scale heatmap-scale-count" id="heatmapScaleCount">
                        <span>Low</span>
                        <div class="heatmap-scale-bar" aria-hidden="true"></div>
                        <span>High</span>
                    </div>
                    <div class="heatmap-scale heatmap-scale-pct" id="heatmapScalePct" style="display:none;">
                        <span>0%</span>
                        <div class="heatmap-scale-bar heatmap-scale-pct" aria-hidden="true"></div>
                        <span>100%</span>
                    </div>
                </div>
                <p class="heatmap-legend">◆ = top 3 in province. Provinces sorted by total.</p>
            </section>

            <section class="panel map-panel" aria-label="Reports by Province Map">
                <h2>Reports by Province (Geographic)</h2>
                <div id="sa-map" class="sa-map-container">
                    <div id="map-legend" class="map-legend" style="display:none;">
                        <div class="map-legend-title">Report count</div>
                        <div class="map-legend-bar"></div>
                        <div class="map-legend-labels">
                            <span id="map-legend-min">0</span>
                            <span id="map-legend-max">0</span>
                        </div>
                    </div>
                </div>
                <p class="heatmap-legend">Blue = low, yellow = medium, red = high report count. Hover for details.</p>
            </section>

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
                        <th>Report Type</th>
                        <th>Status</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody id="statusModalBody"></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal for extras cards -->
<div class="modal-backdrop" id="extrasModal" aria-hidden="true" onclick="if(event.target === this) closeExtrasModal();">
    <div class="modal-card">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h3 id="extrasModalTitle">Details</h3>
            <button class="modal-close" onclick="closeExtrasModal()" aria-label="Close">&times;</button>
        </div>
        <div id="extrasModalBody" style="max-height: 60vh; overflow-y: auto;"></div>
    </div>
</div>

<script id="dashboard-data" type="application/json">
<?php echo json_encode([
    'months' => $months,
    'monthlyCounts' => $monthlyCounts,
    'abuseLabels' => $abuseTypeLabels,
    'abuseCounts' => $abuseTypeCounts,
    'abuseTypePercentages' => $abuseTypePercentages ?? [],
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

(function() {
  const reportsUrl = "<?php echo e(url('/national-admin/reports')); ?>";
  const viewBtns = document.querySelectorAll('.heatmap-view-btn');
  const scaleCount = document.getElementById('heatmapScaleCount');
  const scalePct = document.getElementById('heatmapScalePct');

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

  document.querySelectorAll('.heatmap-cell[data-province-id]').forEach(cell => {
    cell.addEventListener('click', function() {
      const pid = this.dataset.provinceId;
      const aid = this.dataset.abuseTypeId;
      const count = parseInt(this.dataset.count, 10);
      if (count === 0) return;
      const url = new URL(reportsUrl, window.location.origin);
      const params = new URLSearchParams(window.location.search);
      ['province','district','school','abuse_type','from_date','to_date','age_range'].forEach(k => {
        if (params.has(k)) url.searchParams.set(k, params.get(k));
      });
      if (pid) url.searchParams.set('province', pid);
      if (aid) url.searchParams.set('abuse_type', aid);
      window.location.href = url.toString();
    });
    cell.addEventListener('keydown', function(e) {
      if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); this.click(); }
    });
    cell.addEventListener('mouseenter', function() {
      this.dispatchEvent(new CustomEvent('heatmapProvinceHover', { bubbles: true, detail: { province: this.dataset.province } }));
    });
    cell.addEventListener('mouseleave', function() {
      document.dispatchEvent(new CustomEvent('heatmapProvinceHover', { detail: { province: null } }));
    });
  });
})();

document.getElementById('refreshBtn').addEventListener('click', function () {
  const form = document.getElementById('filtersForm');
  form.querySelectorAll('select').forEach(select => { select.selectedIndex = 0; select.disabled = false; });
  form.querySelectorAll('input[type="date"]').forEach(input => { input.value = ''; });
  form.submit();
});

const chartRegistry = {};
let statusReportsMap = {};
let allReportsList = [];

function openStatusModal(status) {
  let reports;
  if (status === 'total') { reports = allReportsList; }
  else if (statusReportsMap[status]) { reports = statusReportsMap[status]; }
  else { reports = []; }

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
      row.innerHTML = `<td>${report.case_number ?? 'N/A'}</td><td>${report.abuse_type ?? 'N/A'}</td><td>${report.status ?? 'N/A'}</td><td>${report.created_at ?? 'N/A'}</td>`;
      tbody.appendChild(row);
    });
  }

  title.textContent = status === 'total' ? 'All Reports' : status === 'false-report' ? 'False Reports' : status.replace(/-/g, ' ').replace(/\b\w/g, c => c.toUpperCase()) + ' Reports';

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
  return source && Object.prototype.hasOwnProperty.call(source, key) && source[key] != null ? source[key] : fallback;
}

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
  const ctx = document.getElementById("statusChart")?.getContext("2d");
  const customColors = ['#99c4d3','#fcb825','#00c382','#9b57cc','#81acef','#38b6ff','#ff66c4'];
  const barColors = [];
  const capColors = [];
  if (ctx) {
    customColors.forEach(color => {
      const gradient = ctx.createLinearGradient(0, 0, 600, 0);
      gradient.addColorStop(0, color);
      gradient.addColorStop(1, color);
      barColors.push(gradient);
      capColors.push(color);
    });
  }

  createChart('monthlyTrendChart', {
    type: 'line',
    data: {
      labels: dataset.months || [],
      datasets: [{
        label: 'Reports',
        data: dataset.monthlyCounts || [],
        borderColor: '#ff66c4',
        backgroundColor: 'rgba(236, 144, 224, 0.2)',
        fill: true, tension: 0.3, borderWidth: 2, pointRadius: 4, pointHoverRadius: 6
      }]
    },
    options: {
      responsive: true, maintainAspectRatio: false,
      plugins: { legend: { display: true, position: 'top' } },
      scales: {
        x: { ticks: { color: '#4b5664' } },
        y: { beginAtZero: true, ticks: { precision: 0 }, grid: { drawBorder: false } }
      }
    }
  });

  const abuseLabels = dataset.abuseLabels || [];
  const abuseCountsRaw = dataset.abuseCounts || [];
  const abuseCounts = abuseLabels.map((_, i) => abuseCountsRaw[i] ?? 0);
  const abuseColors = ['#004c99','#fcb825','#00c382','#9b57cc','#81acef','#38b6ff','#ff66c4','#C0C0C0','#FF0000','#FFFF00'];

  createChart('abuseTypeChart', {
    type: 'pie',
    data: {
      labels: abuseLabels,
      datasets: [{ data: abuseCounts, backgroundColor: abuseColors.slice(0, Math.max(abuseLabels.length, 1)) }]
    },
    options: {
      responsive: true, maintainAspectRatio: false, layout: { padding: 10 },
      plugins: {
        legend: {
          position: 'bottom',
          labels: {
            padding: 12, font: { size: 12, family: 'Montserrat' },
            generateLabels: function(chart) {
              const data = chart.data; const ds = data.datasets[0];
              const pcts = percentagesTo100(ds.data);
              return data.labels.map((label, i) => ({
                text: label + ' (' + pcts[i] + '%)',
                fillStyle: ds.backgroundColor[i],
                strokeStyle: ds.borderColor ? ds.borderColor[i] : ds.backgroundColor[i],
                lineWidth: 1, hidden: false, index: i
              }));
            }
          }
        },
        tooltip: { callbacks: { label: ctx => { const pcts = percentagesTo100(ctx.dataset.data); return `${ctx.label}: ${ctx.parsed} (${pcts[ctx.dataIndex]}%)`; } } },
        datalabels: { display: false }
      }
    }
  });

  if (!ctx) return;

  const barPlugin = {
    id: "barPlugin",
    afterDatasetDraw(chart) {
      const { ctx, chartArea } = chart;
      const datasetMeta = chart.getDatasetMeta(0);
      const total = chart.data.datasets[0].data.reduce((sum, val) => sum + val, 0);
      datasetMeta.data.forEach((bar, i) => {
        const value = chart.data.datasets[0].data[i];
        const percentage = total ? ((value / total) * 100).toFixed(1) : '0';
        const fullX = chart.scales.x.getPixelForValue(100);
        const filledX = chartArea.left + (parseFloat(percentage) / 100) * (fullX - chartArea.left);
        const y = bar.y; const h = bar.height;
        const emptyBarColors = ['#c1e6f3ff','#fdf0d4ff','#cbffeeff','#e6c8fcff','#c5d7f5ff','#cfeafaff','#f7bfe1ff'];
        ctx.fillStyle = emptyBarColors[i % emptyBarColors.length];
        ctx.fillRect(chartArea.left, y - h / 2, fullX - chartArea.left, h);
        ctx.fillStyle = barColors[i % barColors.length];
        ctx.fillRect(chartArea.left, y - h / 2, filledX - chartArea.left, h);
        const capWidth = 40; const capHeight = 24;
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
        ctx.fillStyle = capColors[i % capColors.length];
        ctx.fill();
        ctx.fillStyle = "#fff"; ctx.font = "12px Montserrat"; ctx.textAlign = "center"; ctx.textBaseline = "middle";
        ctx.fillText(percentage + "%", left + capWidth / 2 - 4, mid);
      });
    }
  };

  const statuses = Object.entries(dataset.statusCounts || {}).sort((a, b) => b[1] - a[1]);
  const labels = statuses.map(s => s[0]);
  const values = statuses.map(s => s[1]);

  createChart("statusChart", {
    type: "bar", plugins: [barPlugin],
    data: {
      labels,
      datasets: [{
        data: values, backgroundColor: barColors,
        borderRadius: { topLeft: 20, bottomLeft: 20, topRight: 0, bottomRight: 0 },
        borderWidth: 0, barPercentage: 0.55, categoryPercentage: 0.55
      }]
    },
    options: {
      indexAxis: "y", responsive: true, maintainAspectRatio: false,
      layout: { padding: { right: 50 } },
      scales: { x: { display: false, max: 100 }, y: { ticks: { color: "#333", font: { size: 13, weight: "600" } } } },
      plugins: { legend: { display: false }, datalabels: { display: false } }
    }
  });

  createChart('anonymousChart', {
    type: 'doughnut',
    data: {
      labels: ['Anonymous', 'Identified'],
      datasets: [{
        data: [getValue(dataset.anonymousCounts, 'anonymous', 0), getValue(dataset.anonymousCounts, 'identified', 0)],
        backgroundColor: ['#9b57cc', '#99c4d3']
      }]
    },
    options: {
      responsive: true, maintainAspectRatio: false,
      plugins: {
        legend: { position: 'bottom' },
        tooltip: { callbacks: { label: ctx => `${ctx.label}: ${ctx.parsed}` } },
        datalabels: {
          color: 'white', anchor: 'center', align: 'center',
          font: { weight: 'bold', size: 14, family: 'Montserrat' },
          display: function(ctx) { return ctx.dataset.data[ctx.dataIndex] > 0; },
          formatter: (value, ctx) => { const pcts = percentagesTo100(ctx.chart.data.datasets[0].data); return `${pcts[ctx.dataIndex]}%`; }
        }
      }
    }
  });
}

document.addEventListener('DOMContentLoaded', function () {
  const dataElem = document.getElementById('dashboard-data');
  const parsedDataset = dataElem ? JSON.parse(dataElem.textContent || '{}') : {};
  statusReportsMap = parsedDataset.statusReports || {};
  allReportsList = parsedDataset.allReports || [];
  renderOverviewCharts(parsedDataset);
  const firstCard = document.querySelector('.metric-card.status-total');
  if (firstCard) firstCard.classList.add('active');
});

function navigateWithFilter(status) {
  const url = new URL("<?php echo e(url('/national-admin/reports')); ?>", window.location.origin);
  const params = new URLSearchParams(window.location.search);
  params.forEach((value, key) => { if (key !== 'status') url.searchParams.append(key, value); });
  if (status && status !== 'total') { url.searchParams.set('status', status); } else { url.searchParams.delete('status'); }
  window.location.href = url.toString();
}

function navigateWithFilterByAnonymous(isAnonymous) {
  const url = new URL("<?php echo e(url('/national-admin/reports')); ?>", window.location.origin);
  const params = new URLSearchParams(window.location.search);
  params.forEach((value, key) => { if (key !== 'is_anonymous') url.searchParams.append(key, value); });
  url.searchParams.set('is_anonymous', isAnonymous ? 1 : 0);
  window.location.href = url.toString();
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
    titleEl.textContent = 'Active Report Types';
    const labels = data.abuseLabels || []; const counts = data.abuseCounts || []; const pcts = data.abuseTypePercentages || [];
    let html = '<table style="width:100%; border-collapse:collapse;"><thead><tr><th style="text-align:left; padding:0.5rem; border-bottom:2px solid #e5e7eb;">Report Type</th><th style="text-align:right; padding:0.5rem; border-bottom:2px solid #e5e7eb;">Count</th><th style="text-align:right; padding:0.5rem; border-bottom:2px solid #e5e7eb;">%</th></tr></thead><tbody>';
    labels.forEach((label, i) => {
      html += '<tr><td style="padding:0.5rem; border-bottom:1px solid #e5e7eb;">' + (label || 'N/A') + '</td><td style="text-align:right; padding:0.5rem; border-bottom:1px solid #e5e7eb;">' + (counts[i] || 0).toLocaleString() + '</td><td style="text-align:right; padding:0.5rem; border-bottom:1px solid #e5e7eb;">' + (pcts[i] ?? 0) + '%</td></tr>';
    });
    html += '</tbody></table>';
    bodyEl.innerHTML = html;
  } else if (type === 'schools') {
    titleEl.textContent = 'Active Schools';
    const schools = data.topSchools || {};
    const entries = Object.entries(schools);
    if (entries.length === 0) {
      bodyEl.innerHTML = '<p>No schools with reports in the selected period.</p>';
    } else {
      let html = '<table style="width:100%; border-collapse:collapse;"><thead><tr><th style="text-align:left; padding:0.5rem; border-bottom:2px solid #e5e7eb;">School</th><th style="text-align:right; padding:0.5rem; border-bottom:2px solid #e5e7eb;">Reports</th></tr></thead><tbody>';
      entries.forEach(([name, count]) => {
        html += '<tr><td style="padding:0.5rem; border-bottom:1px solid #e5e7eb; word-break:break-word;">' + (name || 'N/A') + '</td><td style="text-align:right; padding:0.5rem; border-bottom:1px solid #e5e7eb; white-space:nowrap;">' + Number(count).toLocaleString() + '</td></tr>';
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
  if (modal) { modal.classList.remove('active'); modal.setAttribute('aria-hidden', 'true'); }
}

const menuIcon = document.querySelector('.menu-icon');
const sidebar = document.querySelector('.sidebar');
const mainPanel = document.querySelector('.main-panel');
const sidebarOverlay = document.getElementById('sidebarOverlay');

function toggleSidebar() {
  if (!sidebar || !mainPanel) return;
  sidebar.classList.toggle('open');
  mainPanel.classList.toggle('shifted');
  if (sidebarOverlay) {
    sidebarOverlay.classList.toggle('active', sidebar.classList.contains('open'));
    sidebarOverlay.setAttribute('aria-hidden', !sidebar.classList.contains('open'));
  }
}
if (menuIcon) menuIcon.addEventListener('click', toggleSidebar);
if (sidebarOverlay) sidebarOverlay.addEventListener('click', toggleSidebar);
</script>

<script>
window.agePyramidData = {
    ageGroups: <?php echo json_encode($ageGroups, 15, 512) ?>,
    ageCounts: <?php echo json_encode($ageCounts, 15, 512) ?>
};
</script>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
(function() {
  const mapEl = document.getElementById('sa-map');
  if (!mapEl) return;

  const provinceCounts = <?php echo json_encode($mapProvinceCounts ?? [], 15, 512) ?>;
  const geoJsonUrl = 'https://gist.githubusercontent.com/MeganBeckett/9101ba77bd0af06fd003ea5c99d051ab/raw/sa-provinces.json';

  function normalizeName(name) {
    if (!name) return '';
    return String(name).trim().toLowerCase().replace(/\s+/g, ' ');
  }

  function getCountForProvince(geoName) {
    const g = normalizeName(geoName).replace(/-/g, ' ');
    for (const [dbName, count] of Object.entries(provinceCounts)) {
      const d = normalizeName(dbName).replace(/-/g, ' ');
      if (g === d) return count;
      if (g.replace(/\s/g, '') === d.replace(/\s/g, '')) return count;
    }
    return 0;
  }

  const map = L.map('sa-map', { zoomControl: true }).setView([-29, 24], 5);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
  }).addTo(map);

  const maxCount = Math.max(1, ...Object.values(provinceCounts));
  const mapColors = ['#e0f2fe','#fef9c3','#eab308','#f97316','#ef4444'];

  function getColor(count) {
    if (count === 0) return mapColors[0];
    const intensity = Math.min(1, count / maxCount);
    const idx = intensity >= 0.8 ? 4 : intensity >= 0.6 ? 3 : intensity >= 0.4 ? 2 : intensity >= 0.2 ? 1 : 0;
    return mapColors[idx];
  }

  const legendEl = document.getElementById('map-legend');
  if (legendEl) {
    legendEl.style.display = 'block';
    const minEl = document.getElementById('map-legend-min');
    const maxEl = document.getElementById('map-legend-max');
    if (minEl) minEl.textContent = '0';
    if (maxEl) maxEl.textContent = String(maxCount);
  }

  const provinceLayers = {};

  function matchProvinceName(heatmapName, geoName) {
    const h = normalizeName(heatmapName || '').replace(/-/g, ' ');
    const g = normalizeName(geoName || '').replace(/-/g, ' ');
    return h === g || h.replace(/\s/g, '') === g.replace(/\s/g, '');
  }

  fetch(geoJsonUrl)
    .then(r => r.json())
    .then(geojson => {
      L.geoJSON(geojson, {
        style: function(feature) {
          const name = feature.properties?.name || '';
          return { fillColor: getColor(getCountForProvince(name)), weight: 1.5, opacity: 1, color: '#1e40af', fillOpacity: 0.85 };
        },
        onEachFeature: function(feature, layer) {
          const name = feature.properties?.name || 'Unknown';
          const count = getCountForProvince(name);
          provinceLayers[normalizeName(name).replace(/-/g, ' ')] = { layer, name, count };
          layer.feature = feature;
          layer._defaultStyle = { weight: 1.5, color: '#1e40af' };
          layer.bindTooltip(name + ': ' + count + ' reports', { permanent: false, direction: 'center', className: 'map-tooltip' });
          layer.on({
            mouseover: function(e) { const l = e.target; l.setStyle({ weight: 3, color: '#0c4a6e' }); l.bringToFront(); },
            mouseout: function(e) { const l = e.target; l.setStyle(l._defaultStyle || { weight: 1.5, color: '#1e40af' }); }
          });
        }
      }).addTo(map);

      window.addEventListener('heatmapProvinceHover', function(e) {
        const province = e.detail?.province;
        Object.values(provinceLayers).forEach(({ layer }) => {
          const geoName = layer.feature?.properties?.name || '';
          if (province && matchProvinceName(province, geoName)) {
            layer.setStyle({ weight: 4, color: '#0369a1' }); layer.bringToFront();
          } else {
            layer.setStyle(layer._defaultStyle || { weight: 1.5, color: '#1e40af' });
          }
        });
      });
    })
    .catch(err => console.warn('Map GeoJSON load failed:', err));
})();
</script>

<script src="https://kit.fontawesome.com/2c36e9b7b9.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
function exportPDF() {
  const element = document.getElementById('main-content');
  if (!element) { alert("Main content not found!"); return; }
  html2pdf().from(element).set({
    margin: 10,
    filename: 'National-admin-dashboard.pdf',
    html2canvas: { scale: 2 },
    jsPDF: { unit: 'mm', format: 'a3', orientation: 'landscape' }
  }).save();
}
</script>

</body>
</html><?php /**PATH C:\xampp\htdocs\staging.teketesafespace.co.za\resources\views/national-admin-dashboard/index.blade.php ENDPATH**/ ?>