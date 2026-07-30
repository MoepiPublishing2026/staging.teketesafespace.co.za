<!DOCTYPE html>
<html lang="en" class="pa-app-root">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Tekete SafeSpace Provincial Dashboard</title>
    <x-favicon />
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

html {
    overflow-x: hidden;
}

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

.table-responsive {
    width: 100%;
    overflow-x: auto;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th, .table td {
    padding: 0.5rem;
    text-align: left;
    border-bottom: 2px solid #e5e7eb;
    word-wrap: break-word;
    white-space: normal;
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
    height: auto;
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

.extras-anonymous, .extras-identified, .extras-abuse, .extras-schools {
    background: white;
    color: #1f2933;
    cursor: pointer;
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
    font-family: 'Century Gothic';
    line-height: 1;
}
.chart-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:30px;
    margin-top:20px;
}

.chart-card{
    background:#fff;
    border-radius:12px;
    padding:18px;
}

/* Make Status Breakdown span the full row */
.chart-status{
    grid-column:1 / -1;
}

.chart-card h2{
    font-size:18px;
    font-weight:700;
    color:#4b7cff;
    margin-bottom:15px;
}

.chart-status-host{
    width:100%;
}

.chart-status-host canvas{
    width:100% !important;
    height:100% !important;
}

@media(max-width:900px){
    .chart-grid{
        grid-template-columns:1fr;
    }

    .chart-status{
        grid-column:auto;
    }
}
.card-subtext {
    font-size: 0.8rem;
    color: #080808ff;
    margin-bottom: 0.25rem;
}
.extras-row .metric-card {
    background: white;
    color: #1f2933;
    cursor: pointer;
}

.extras-row .card-title {
    color: #1f2933 !important;
    font-weight: 700;
}

.extras-row .card-value {
    color: #38b6ff !important;
}

.panel {
    background: white;
    border-radius: 1rem;
    padding: 0px;
    max-width: 100%;
}

.panel + .panel {
    margin-top: 1.8rem;
}

.chart-title-left {
    text-align: left !important;
    margin-left: 0 !important;
    padding-left: 0 !important;
}

/* Pie + legend need flexible height so legend rows are not clipped */
.chart-card.chart-abuse-pie {
    height: auto;
    min-height: 370px;
    display: flex;
    flex-direction: column;
}
.chart-abuse-pie .chart-canvas-host {
    position: relative;
    width: 100%;
    flex: 1 1 auto;
    min-height: 280px;
}

#abuseTypeChart {
    display: block;
    width: 100% !important;
    height: 100% !important;
}

/* Status breakdown: flexible height + host (matches school admin) */
.chart-card.chart-status {
    height: auto;
    min-height: 320px;
    display: flex;
    flex-direction: column;
}
.chart-status .chart-status-host {
    position: relative;
    width: 100%;
    flex: 1 1 auto;
    min-height: 280px;
}
#statusChart {
    display: block;
    width: 100% !important;
    height: 100% !important;
}

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
    max-width: 100%;
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

/* Monthly Trends: same title + host + canvas pattern as Status Breakdown */
.chart-monthly-block {
    display: flex;
    flex-direction: column;
    gap: 0.35rem;
    min-width: 0;
    height: auto;
    min-height: 320px;
    background: white;
    padding: 20px;
    border-radius: 12px;
}
.chart-monthly-block .chart-canvas-host {
    position: relative;
    width: 100%;
    flex: 1 1 auto;
    min-height: 280px;
}
.chart-card.chart-anonymous {
    height: auto;
    min-height: 320px;
    display: flex;
    flex-direction: column;
    min-width: 0;
    background: white;
    padding: 20px;
    border-radius: 12px;
}
.chart-card.chart-anonymous .chart-canvas-host {
    position: relative;
    width: 100%;
    flex: 1 1 auto;
    min-height: 280px;
}
section[aria-label="Analytics"] .chart-canvas-host canvas,
section[aria-label="Analytics"] .chart-status-host canvas {
    display: block;
    width: 100% !important;
    height: 100% !important;
    min-height: 0 !important;
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
    padding: 2rem;
    position: relative;
    font-family: 'Montserrat', sans-serif;
    color: #333;
}

.modal-card h3 {
    margin: 0 0 1.5rem;
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

@media (max-width: 1200px) {
    .metrics-row > .metric-card {
        flex: 1 1 calc(25% - 1rem);
        min-width: 90px;
        max-width: none;
    }
    .extras-row > .metric-card {
        flex: 1 1 calc(50% - 0.5rem);
        min-width: 0;
    }
}

@media (max-width: 900px) {
    body {
        overflow-x: hidden;
    }
    .main-panel {
        margin-left: 0 !important;
        width: 100%;
    }
    .main-panel.shifted {
        margin-left: 0 !important;
    }
    .dashboard-scroll {
        padding: 1rem;
    }
    .metrics-row, .extras-row {
        gap: 0.75rem;
    }
    .metrics-row > .metric-card {
        flex: 1 1 calc(50% - 0.5rem);
        min-width: 0;
        max-width: none;
        min-height: 90px;
        padding: 10px 12px;
    }
    .metrics-row > .metric-card .card-value {
        font-size: 24px !important;
    }
    .extras-row > .metric-card {
        flex: 1 1 calc(50% - 0.5rem);
        min-width: 0;
    }
    .grid-two {
        grid-template-columns: 1fr !important;
        gap: 1.25rem !important;
        width: 100%;
        min-width: 0;
    }
    section[aria-label="Analytics"] .grid-two > * {
        min-width: 0;
        width: 100%;
    }
    .chart-monthly-block .chart-canvas-host,
    .chart-card.chart-anonymous .chart-canvas-host {
        min-height: 220px;
    }
    .chart-canvas-host canvas,
    .chart-status-host canvas {
        height: 100% !important;
        min-height: 200px !important;
    }
    .chart-card.chart-abuse-pie,
    .chart-card.chart-status {
        width: 100% !important;
        max-width: 100%;
    }
    .heatmap-panel {
        padding: 1rem;
    }
    .heatmap-toolbar {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    .heatmap-wrap {
        -webkit-overflow-scrolling: touch;
        overflow-x: auto;
        overflow-y: visible;
    }
    .heatmap-table {
        font-size: 11px;
    }
    .heatmap-table th,
    .heatmap-table td {
        padding: 0.35rem 0.45rem;
    }
    .heatmap-corner {
        min-width: 90px;
        font-size: 11px;
    }
    .heatmap-col {
        min-width: 65px;
        font-size: 10px;
    }
    .heatmap-row {
        min-width: 90px;
        font-size: 11px;
    }
    .heatmap-cell {
        min-width: 40px;
    }
    .heatmap-scale {
        flex-wrap: wrap;
        gap: 0.35rem;
    }
    .heatmap-scale-bar {
        width: 100px;
    }
    .map-panel {
        padding: 1rem;
    }
    .sa-map-container {
        height: 320px;
        min-height: 280px;
    }
    .map-legend {
        bottom: 10px;
        right: 10px;
        padding: 8px 10px;
        font-size: 11px;
    }
    .map-legend-bar {
        width: 80px;
        height: 8px;
    }
    form.filters {
        flex-direction: column;
        gap: 0.75rem;
        align-items: stretch;
    }
    form.filters select,
    form.filters input[type="date"],
    form.filters button {
        min-width: 100%;
        width: 100%;
    }
    form.filters label {
        width: 100%;
    }
    form.filters label input {
        width: 100%;
    }
    .topbar {
        padding: 0.75rem 1rem;
        min-height: 56px;
    }
    .profile .meta > span:first-child {
        font-size: 14px;
    }
    .profile .meta .role {
        font-size: 12px;
    }
    h1 {
        font-size: 22px !important;
        padding: 0 0.5rem;
    }
    .subtitle {
        font-size: 13px;
        padding: 0 0.5rem;
    }
    .modal-card {
        width: min(96vw, 480px);
        padding: 1.25rem;
    }
    section[aria-label="Filters"] {
        padding: 0.75rem 1rem;
    }
    .panel {
        padding: 0;
    }
}

@media (max-width: 600px) {
    .menu-icon {
        top: 10px;
        left: 10px;
        width: 40px;
        height: 40px;
        font-size: 20px;
    }
    .chart-title-left {
        text-align: left !important;
        margin-top: 1.25rem !important;
        padding-left: 0 !important;
    }


    .main-panel.shifted {
        margin-left: 0;
    }
    .dashboard-scroll {
        padding: 0.75rem;
    }
    .metrics-row > .metric-card {
        flex: 1 1 100%;
    }
    .extras-row > .metric-card {
        flex: 1 1 100%;
    }
    .metrics-row > .metric-card .card-value {
        font-size: 22px !important;
    }
    .card-title {
        font-size: 12px !important;
    }
    .heatmap-corner {
        min-width: 75px;
    }
    .heatmap-col {
        min-width: 55px;
        font-size: 9px;
    }
    .heatmap-cell {
        min-width: 36px;
    }
    .heatmap-table th,
    .heatmap-table td {
        padding: 0.3rem 0.35rem;
    }
    .sa-map-container {
        height: 280px;
        min-height: 240px;
    }
    .map-legend {
        bottom: 8px;
        right: 8px;
        padding: 6px 8px;
        font-size: 10px;
    }
    .map-legend-bar {
        width: 60px;
    }
    h1 {
        font-size: 18px !important;
    }
    .subtitle {
        font-size: 12px;
    }
    section[aria-label="Filters"] {
        padding: 0.5rem 0.75rem;
    }
}

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
.heatmap-panel h2 {
  margin-bottom: 0.5rem;
}
.heatmap-toolbar {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 1rem;
  margin-bottom: 1rem;
}
.heatmap-view-toggle {
  display: flex;
  gap: 0.5rem;
}
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
.heatmap-view-toggle button:hover {
  background: #c7da30 !important;
  color: #fff !important;
}
.heatmap-view-toggle button.active {
  background: #c7da30 !important;
  color: #fff !important;
}
.heatmap-wrap {
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
}
.heatmap-table {
  border-collapse: collapse;
  font-size: 13px;
  min-width: 100%;
}
.heatmap-table th,
.heatmap-table td {
  border: 1px solid #111827;
  padding: 0.5rem 0.65rem;
  text-align: center;
}
.heatmap-corner {
  background: #d1d5db;
  font-weight: 700;
  text-align: left !important;
  min-width: 120px;
  position: static !important;
  left: auto !important;
  z-index: auto !important;
}
.heatmap-col {
  background: #d1d5db;
  font-weight: 700;
  white-space: nowrap;
  min-width: 90px;
}
.heatmap-row {
  background: #d1d5db;
  font-weight: 600;
  text-align: left !important;
  padding-left: 0.75rem;
  position: static !important;
  left: auto !important;
  z-index: auto !important;
}
.heatmap-cell {
  font-weight: 600;
  cursor: pointer;
  transition: none;
  min-width: 50px;
  position: relative;
  animation: none;
}
.heatmap-cell.heatmap-cell-dark {
  color: #fff;
  text-shadow: 0 1px 2px rgba(0,0,0,0.25);
}
.heatmap-cell:hover {
  transform: none;
  box-shadow: none;
  z-index: 2;
}
.heatmap-cell::after {
  content: '';
  position: absolute;
  inset: 0;
  border-radius: 2px;
  pointer-events: none;
}
.heatmap-cell.heatmap-hotspot::before { display: none; }
@media (hover: none) {
  .heatmap-cell:hover {
    transform: none;
  }
  .heatmap-cell:active {
    box-shadow: 0 0 0 3px #38b6ff;
  }
}
.heatmap-total-cell,
.heatmap-total-row,
.heatmap-total-col {
  display: none;
}
.heatmap-scale-wrap {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 1rem;
  margin-top: 1rem;
}
.heatmap-scale {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 12px;
  color: #6b7280;
}
.heatmap-scale-bar {
  height: 14px;
  width: 180px;
  border-radius: 7px;
  background: linear-gradient(to right, #d1cb23 0%, #fbbf0f 50%, #ed1c24 100%);
  border: 1px solid #111827;
  box-shadow: inset 0 1px 2px rgba(0,0,0,0.05);
}
.heatmap-scale-bar.heatmap-scale-pct {
  background: linear-gradient(to right, #d1cb23 0%, #fbbf0f 50%, #ed1c24 100%);
}
.heatmap-legend {
  margin-top: 0.5rem;
  font-size: 12px;
  color: #6b7280;
}

/* Geographic map */
.map-panel {
  background: white;
  border-radius: 1rem;
  padding: 1.5rem;
  box-shadow: 0 1px 3px rgba(0,0,0,0.08);
}
.sa-map-container {
  height: 450px;
  width: 100%;
  max-width: 100%;
  min-height: 350px;
  border-radius: 0.5rem;
  overflow: hidden;
  border: 1px solid #e5e7eb;
  position: relative;
}
.map-legend {
  position: absolute;
  bottom: 20px;
  right: 20px;
  z-index: 1000;
  background: rgba(255,255,255,0.95);
  padding: 10px 14px;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.15);
  font-size: 12px;
  font-family: 'Montserrat', sans-serif;
}
.map-legend-title {
  font-weight: 700;
  margin-bottom: 6px;
  color: #1f2937;
}
.map-legend-row { display: flex; align-items: center; gap: 8px; font-size: 11px; color: #111827; margin-top: 4px; }
.map-legend-swatch { width: 14px; height: 10px; border: 1px solid #111827; }
.map-legend-swatch.low { background: #d1cb23; }
.map-legend-swatch.medium { background: #fbbf0f; }
.map-legend-swatch.high { background: #ed1c24; }
.district-map-container {
  height: 450px;
  width: 100%;
  max-width: 100%;
  min-height: 350px;
  border-radius: 0.5rem;
  overflow: hidden;
  position: relative;
}
.district-map-svg { width: 100%; height: 100%; display: block; }
.district-map-shape { stroke: #111827; stroke-width: 1.1; transition: opacity 0.15s ease, stroke 0.15s ease, stroke-width 0.15s ease; }
.district-map-shape:hover { stroke: #38b6ff; stroke-width: 1.8; }
.district-map-label {
  pointer-events: none;
  fill: #111827;
  font-weight: 900;
  font-size: 9px;
  text-transform: uppercase;
  letter-spacing: 0.03em;
  text-anchor: middle;
  paint-order: stroke;
  stroke: rgba(255,255,255,0.9);
  stroke-width: 3px;
  opacity: 0.9;
}
.district-map-marker circle {
  fill: rgba(255,255,255,0.92);
  stroke: #111827;
  stroke-width: 1.4;
}
.district-map-marker text {
  fill: #111827;
  font-weight: 900;
  font-size: 10px;
  dominant-baseline: middle;
  text-anchor: middle;
}
.district-map-key {
  position: absolute;
  top: 12px;
  left: 12px;
  z-index: 15;
  background: rgba(255,255,255,0.96);
  border: 1px solid rgba(17,24,39,0.2);
  border-radius: 10px;
  padding: 10px 10px 8px;
  box-shadow: 0 8px 24px rgba(0,0,0,0.12);
  max-height: calc(100% - 24px);
  overflow: auto;
  min-width: 180px;
}
.district-map-key-title {
  font-weight: 900;
  font-size: 11px;
  color: #111827;
  margin-bottom: 6px;
  letter-spacing: 0.03em;
  text-transform: uppercase;
}
.district-map-key-row {
  display: grid;
  grid-template-columns: 14px 26px 1fr auto;
  gap: 8px;
  align-items: center;
  font-size: 11px;
  color: #111827;
  padding: 4px 0;
  border-top: 1px solid rgba(17,24,39,0.08);
}
.district-map-key-row:first-of-type { border-top: none; }
.district-map-key-swatch { width: 14px; height: 10px; border: 1px solid #111827; border-radius: 3px; }
.district-map-key-num { font-weight: 900; color: #111827; }
.district-map-key-name { font-weight: 700; color: #111827; }
.district-map-key-count { font-weight: 900; color: #4b5563; white-space: nowrap; }
.district-map-tooltip {
  position: absolute;
  left: 0;
  top: 0;
  transform: translate(-9999px, -9999px);
  background: rgba(255,255,255,0.98);
  border: 1px solid rgba(17,24,39,0.2);
  border-radius: 10px;
  padding: 8px 10px;
  box-shadow: 0 8px 24px rgba(0,0,0,0.12);
  font-size: 12px;
  color: #111827;
  pointer-events: none;
  z-index: 20;
  max-width: 220px;
  line-height: 1.2;
}
.district-map-tooltip .tt-title { font-weight: 900; font-size: 12px; }
.district-map-tooltip .tt-sub { font-weight: 700; font-size: 11px; color: #4b5563; margin-top: 2px; }
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
                    <img src="{{ $currentUser->profile_picture_url }}"
                         alt="Profile Picture"
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

        <section class="panel" aria-label="Filters">
            <h2>Filters</h2>
            <hr class="filter-separator"/>
            <form method="GET" action="{{ url()->current() }}" class="filters" id="filtersForm">
                <input type="hidden" name="tab" value="{{ $activeTab }}">
                <select name="district" id="districtSelect" onchange="this.form.submit()">
                    <option value="">All Districts</option>
                    @foreach ($districts as $district)
                        <option value="{{ $district->id }}" {{ $districtFilter == $district->id ? 'selected' : '' }}>
                            {{ $district->name }}
                        </option>
                    @endforeach
                </select>
                <select name="school" id="schoolSelect" onchange="this.form.submit()">
                    <option value="">All Schools</option>
                    @foreach ($schools as $school)
                        <option value="{{ $school->school_id }}" {{ $schoolFilter == $school->school_id ? 'selected' : '' }}>
                            {{ $school->school_name }}
                        </option>
                    @endforeach
                </select>
                <select name="abuse_type" onchange="this.form.submit()">
                    <option value="">Any Report Type</option>
                    @foreach ($abuseTypes as $type)
                        <option value="{{ $type->id }}" {{ $abuseTypeFilter == $type->id ? 'selected' : '' }}>
                            {{ $type->type_name }}
                        </option>
                    @endforeach
                </select>
                <select name="age_range" onchange="this.form.submit()">
                    <option value="">Any Age</option>
                    @foreach (['0-10','11-15','16-20','21-22'] as $range)
                        <option value="{{ $range }}" {{ $ageRange == $range ? 'selected' : '' }}>
                            {{ $range }}
                        </option>
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
                <button type="button" id="refreshBtn">Refresh Table</button>
            </form>
            @if(!empty($activeFilters))
                <div class="filter-chips" aria-label="Active filters">
                    @foreach ($activeFilters as $chip)
                        <span>{{ $chip }}</span>
                    @endforeach
                </div>
            @endif
        </section>

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
                <span class="card-subtext"></span>
            </div>
            <div class="metric-card extras-identified" onclick="openExtrasModal('identified')">
                <span class="card-title">Identified</span>
                <div class="card-value">{{ number_format($anonymousCounts['identified'] ?? 0) }}</div>
            </div>
            <div class="metric-card extras-abuse" onclick="openExtrasModal('abuse-types')">
                <span class="card-title">Types Of Report Tracked</span>
                <div class="card-value">{{ count($abuseTypeLabels) }}</div>
                <span class="card-subtext"></span>
            </div>
            <div class="metric-card extras-schools" onclick="openExtrasModal('schools')" title="Open full list of schools with reports">
                <span class="card-title">Active Schools</span>
                <div class="card-value">{{ number_format($activeSchoolsWithReports ?? 0) }}</div>
                <span class="card-subtext">Tap for every school</span>
            </div>
        </section>

     <section class="panel" aria-label="Analytics">
            @php
                $monthlyPointCount = max(count($months ?? []), 1);
                $monthlyTrendHostH = (int) max(260, min(440, 170 + $monthlyPointCount * 12));
                $anonymousHostH = (int) max(280, min(400, 300));
                $abuseTypeCount = max(count($abuseTypeLabels ?? []), 1);
                $abusePieHostHeight = max(360, min(520, 220 + $abuseTypeCount * 18));
            @endphp
            <section class="chart-grid" aria-label="Dashboard charts overview">

                <div class="chart-card chart-monthly">
                    <h2>Monthly Trends</h2>
                    <div class="chart-canvas-host" style="height: {{ $monthlyTrendHostH }}px;">
                        <canvas id="monthlyTrendChart"></canvas>
                    </div>
                </div>

                <div class="chart-card chart-abuse-pie">
                    <h2>Report Types Distribution</h2>
                    <div class="chart-canvas-host" style="height: {{ $abusePieHostHeight }}px;">
                        <canvas id="abuseTypeChart"></canvas>
                    </div>
                </div>

                <div class="chart-card chart-anonymous">
                    <h2>Anonymous vs Identified</h2>
                    <div class="chart-canvas-host" style="height: {{ $anonymousHostH }}px;">
                        <canvas id="anonymousChart"></canvas>
                    </div>
                </div>

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
                                @forelse($topSchools ?? [] as $schoolName => $schoolCount)
                                    <tr>
                                        <td>{{ $schoolName }}</td>
                                        <td>{{ number_format($schoolCount) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" style="text-align:center; color:#6b7280; padding:1rem;">
                                            No schools with a linked record in this filter.
                                            @if(($reportsWithoutLinkedSchool ?? 0) > 0)
                                                <br><span style="font-size:12px;">{{ number_format($reportsWithoutLinkedSchool) }} report(s) have no linked school.</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                                @if(count($topSchools ?? []) > 0)
                                @php $sumTopSchools = array_sum($topSchools); @endphp
                                <tr>
                                    <td colspan="2" style="font-size:12px; color:#6b7280; padding:0.65rem 0.5rem 0; line-height:1.45;">
                                        Top {{ count($topSchools) }} by volume: <strong>{{ number_format($sumTopSchools) }}</strong> reports.
                                        @if(($reportsWithoutLinkedSchool ?? 0) > 0)
                                            <strong>{{ number_format($reportsWithoutLinkedSchool) }}</strong> report(s) have no linked school.
                                        @endif
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                @php
                    $statusBreakdownN = max(count($statusCounts ?? []), 1);
                    $statusChartHostH = max(300, min(680, 110 + $statusBreakdownN * 54));
                @endphp
                <div class="chart-card chart-status">
                    <h2>Status Breakdown</h2>
                    <div class="chart-status-host" style="height: {{ $statusChartHostH }}px;">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>

            </section>

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
    'topSchools' => $topSchools ?? [],
    'activeSchoolsWithReports' => $activeSchoolsWithReports ?? 0,
    'activeSchoolsByReports' => $activeSchoolsByReports ?? [],
    'reportsWithoutLinkedSchool' => $reportsWithoutLinkedSchool ?? 0,
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
    form.querySelectorAll('select').forEach(select => {
        select.selectedIndex = 0;
        select.disabled = false;
    });
    form.querySelectorAll('input[type="date"]').forEach(input => {
        input.value = '';
    });
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

    let titleText = 'Reports';
    if (status === 'total') {
        titleText = 'All Reports (' + reports.length + ')';
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
            layout: { padding: { top: 4, bottom: 22, left: 2, right: 6 } },
            plugins: { legend: { display: true, position: 'top' } },
            scales: {
                x: { ticks: { color: '#4b5664', padding: 4 }, grid: { drawBorder: false } },
                y: { beginAtZero: true, ticks: { precision: 0 }, grid: { drawBorder: false } }
            }
        }
    });

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
                        padding: abuseLegendPosition === 'right' ? 10 : 14,
                        boxWidth: 14,
                        boxHeight: 14,
                        usePointStyle: true,
                        maxWidth: abuseLegendPosition === 'bottom' ? 520 : 220,
                        font: { size: abuseLabels.length > 10 ? 10 : 11, family: 'Montserrat' },
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

    const statusBarPlugin = {
        id: 'provincialStatusBarPlugin',
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
                    color: 'white',
                    anchor: 'center',
                    align: 'center',
                    font: { weight: 'bold', size: 14, family: 'Montserrat' },
                    display: function(ctx) { return ctx.dataset.data[ctx.dataIndex] > 0; },
                    formatter: (value, ctx) => {
                        const pcts = percentagesTo100(ctx.chart.data.datasets[0].data);
                        return `${pcts[ctx.dataIndex]}%`;
                    }
                }
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    const dataElement = document.getElementById('dashboard-data');
    const dataset = dataElement ? JSON.parse(dataElement.textContent || '{}') : {};
    statusReportsMap = dataset.statusReports || {};
    allReportsList = dataset.allReports || [];

    if (dataset.anonymousReports) statusReportsMap['anonymous'] = dataset.anonymousReports;
    if (dataset.identifiedReports) statusReportsMap['identified'] = dataset.identifiedReports;

    renderOverviewCharts(dataset);

    const firstCard = document.querySelector('.metric-card.status-total');
    if (firstCard) firstCard.classList.add('active');
});

function navigateWithFilter(status) {
    const url = new URL("{{ url('/provincial/reports') }}", window.location.origin);
    const params = new URLSearchParams(window.location.search);
    params.forEach((value, key) => { if (key !== 'status') url.searchParams.append(key, value); });
    if (status && status !== 'total') { url.searchParams.set('status', status); } else { url.searchParams.delete('status'); }
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
    } else if (type === 'schools') {
        titleEl.textContent = 'Active Schools';
        const schools = data.activeSchoolsByReports || {};
        const entries = Object.entries(schools);
        const activeN = Number(data.activeSchoolsWithReports || 0);
        const noSchool = Number(data.reportsWithoutLinkedSchool || 0);
        const sumListed = entries.reduce((s, [, c]) => s + Number(c || 0), 0);
        if (entries.length === 0) {
            bodyEl.innerHTML = '<p>No schools with a linked record for the current filters.</p>';
        } else {
            let html = '<p style="margin:0 0 0.75rem; font-size:13px; color:#4b5563;">All <strong>' + activeN.toLocaleString() + '</strong> school(s) with at least one report (linked school record), sorted by report count.</p>';
            html += '<div style="max-height:min(52vh,480px); overflow-y:auto; border:1px solid #e5e7eb; border-radius:8px;">';
            html += '<table style="width:100%; border-collapse:collapse;"><thead style="position:sticky; top:0; background:#fff; z-index:1;"><tr><th style="text-align:left; padding:0.5rem; border-bottom:2px solid #e5e7eb;">School</th><th style="text-align:right; padding:0.5rem; border-bottom:2px solid #e5e7eb;">Reports</th></tr></thead><tbody>';
            entries.forEach(([name, count]) => {
                html += '<tr><td style="padding:0.5rem; border-bottom:1px solid #e5e7eb; word-break:break-word;">' + (name || 'N/A') + '</td><td style="text-align:right; padding:0.5rem; border-bottom:1px solid #e5e7eb; white-space:nowrap;">' + Number(count).toLocaleString() + '</td></tr>';
            });
            html += '</tbody></table></div>';
            html += '<p style="margin:0.75rem 0 0; font-size:12px; color:#6b7280; line-height:1.45;">Rows total <strong>' + sumListed.toLocaleString() + '</strong> reports with a linked school.';
            if (noSchool > 0) html += ' <strong>' + noSchool.toLocaleString() + '</strong> report(s) have no linked school (not listed above).';
            html += '</p>';
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

function navigateWithFilterByAnonymous(isAnonymous) {
    const url = new URL("{{ url('/provincial-admin/reports') }}", window.location.origin);
    const params = new URLSearchParams(window.location.search);
    params.forEach((value, key) => { if (key !== 'is_anonymous') url.searchParams.append(key, value); });
    url.searchParams.set('is_anonymous', isAnonymous ? 1 : 0);
    window.location.href = url.toString();
}

</script>
<x-provincial-admin-sidebar-script />

<script src="{{ asset('js/mobile-select-modal.js') }}"></script>
<script src="https://kit.fontawesome.com/2c36e9b7b9.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    function exportPDF() {
        const element = document.getElementById('main-content');
        if (!element) {
            alert("Main content not found!");
            return;
        }
        html2pdf().from(element).set({
            margin: 10,
            filename: 'provincial-admin-dashboard.pdf',
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'mm', format: 'a3', orientation: 'landscape' }
        }).save();
    }
</script>

</body>
</html>
