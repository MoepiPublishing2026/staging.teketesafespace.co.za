<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tekete Safe Space Provincial Dashboard</title>
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
    overflow-y: auto;
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

.sidebar-link.active {
    background: linear-gradient(to right, #38b6ff, #38b6ff);
    color: #000;
    font-weight: 400;
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

.chart-abuse-pie {
    height: 380px;
    display: flex;
    flex-direction: column;
}

#abuseTypeChart {
    flex-grow: 1;
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

.menu-icon {
    display: none;
    position: fixed;
    top: 12px;
    left: 12px;
    width: 44px;
    height: 44px;
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
.menu-icon:hover {
    background: #f3f4f6 !important;
    border-color: #38b6ff !important;
}
.sidebar-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.3);
    z-index: 999;
    opacity: 0;
    transition: opacity 0.2s ease;
}
.sidebar-overlay.active {
    display: block;
    opacity: 1;
}
@media (min-width: 901px) {
    .sidebar-overlay {
        display: none !important;
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

canvas {
    width: 100% !important;
    height: 280px !important;
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
    .menu-icon {
        display: flex;
    }
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 0;
        height: 100vh;
        background: white;
        overflow-x: hidden;
        overflow-y: auto;
        transition: width 0.3s ease;
        z-index: 1000;
        box-shadow: 2px 0 12px rgba(0,0,0,0.15);
    }
    .sidebar.open {
        width: 240px;
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
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    canvas {
        height: 250px !important;
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
    .sidebar.open {
        width: 100%;
        max-width: 280px;
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
  background: linear-gradient(135deg, #fafbfc 0%, #fff 100%);
  border-radius: 1rem;
  padding: 1.5rem;
  overflow-x: auto;
  box-shadow: 0 4px 20px rgba(56, 182, 255, 0.08), 0 1px 3px rgba(0,0,0,0.06);
  width: 100%;
  max-width: 100%;
  border: 1px solid rgba(56, 182, 255, 0.15);
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
.heatmap-view-toggle button:hover {
  color: #1f2937;
}
.heatmap-view-toggle button.active {
  background: white;
  color: #0c4a6e;
  box-shadow: 0 1px 2px rgba(0,0,0,0.08);
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
  border: 1px solid #e5e7eb;
  padding: 0.5rem 0.65rem;
  text-align: center;
}
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
.heatmap-cell.heatmap-cell-dark {
  color: #fff;
  text-shadow: 0 1px 2px rgba(0,0,0,0.25);
}
.heatmap-cell:hover {
  transform: scale(1.1);
  box-shadow: 0 4px 12px rgba(0,0,0,0.2);
  z-index: 2;
}
.heatmap-cell::after {
  content: '';
  position: absolute;
  inset: 0;
  border-radius: 2px;
  pointer-events: none;
}
.heatmap-cell.heatmap-hotspot::before {
  content: '◆';
  position: absolute;
  top: 2px;
  right: 4px;
  font-size: 8px;
  color: rgba(255,255,255,0.9);
  opacity: 0.9;
}
.heatmap-cell.heatmap-cell-dark.heatmap-hotspot::before {
  color: rgba(255,255,255,0.95);
}
@media (hover: none) {
  .heatmap-cell:hover {
    transform: none;
  }
  .heatmap-cell:active {
    box-shadow: 0 0 0 3px #38b6ff;
  }
}
@keyframes heatmapCellFadeIn {
  from { opacity: 0; transform: scale(0.95); }
  to { opacity: 1; transform: scale(1); }
}
.heatmap-total-cell {
  background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 100%) !important;
  color: #fff !important;
  font-weight: 700;
}
.heatmap-total-row th,
.heatmap-total-col {
  background: linear-gradient(180deg, #e0f2fe 0%, #bae6fd 100%) !important;
  font-weight: 700;
  color: #0c4a6e;
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
  background: linear-gradient(to right, #e0f2fe 0%, #fef9c3 25%, #eab308 50%, #f97316 75%, #ef4444 100%);
  border: 1px solid #e5e7eb;
  box-shadow: inset 0 1px 2px rgba(0,0,0,0.05);
}
.heatmap-scale-bar.heatmap-scale-pct {
  background: linear-gradient(to right, #f0fdf4 0%, #86efac 25%, #22c55e 50%, #15803d 75%, #14532d 100%);
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
.map-legend-bar {
  height: 10px;
  width: 120px;
  border-radius: 5px;
  background: linear-gradient(to right, #e0f2fe 0%, #fef9c3 25%, #eab308 50%, #f97316 75%, #ef4444 100%);
  margin: 4px 0;
  border: 1px solid #e5e7eb;
}
.map-legend-labels {
  display: flex;
  justify-content: space-between;
  font-size: 11px;
  color: #6b7280;
}
.leaflet-tooltip.map-tooltip {
  background: rgba(30, 64, 175, 0.95);
  color: white;
  border: none;
  padding: 6px 10px;
  font-weight: 600;
  font-size: 13px;
  border-radius: 6px;
}
    </style>
</head>
<body>

<aside class="sidebar">
    <div style="position: fixed; top: 40px; left: 40px; width: 100px; height: auto;">
        <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Safe Space Logo" style="width: 150px; height: auto;">
    </div>
    <ul class="sidebar-list">
        <a href="<?php echo e(url('/provincial-admin/dashboard')); ?>" class="sidebar-link <?php echo e(request()->is('provincial-admin/dashboard') ? 'active' : ''); ?>">Dashboard</a>
        <a href="<?php echo e(url('/provincial-admin/reports')); ?>" class="sidebar-link <?php echo e(request()->is('provincial-admin/reports') ? 'active' : ''); ?>">Reports</a>
        <a href="<?php echo e(url('/provincial-admin/settings')); ?>" class="sidebar-link <?php echo e(request()->is('provincial-admin/settings') ? 'active' : ''); ?>">My Profile</a>
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
                <?php
                    $currentUser = auth()->user()->fresh();
                    $fullName = $currentUser->name ?? 'Administrator';
                    $nameParts = explode(' ', $fullName, 2);
                    $firstName = $nameParts[0] ?? '';
                    $surname = $nameParts[1] ?? '';
                ?>
                <span><?php echo e($firstName); ?> <?php echo e($surname); ?></span>
                <span class="role">Administrator</span>
            </div>
            <div class="profile-avatar">
                <?php if($currentUser && $currentUser->profile_picture): ?>
                    <img src="<?php echo e($currentUser->profile_picture_url); ?>"
                         alt="Profile Picture"
                         onerror="this.style.display='none'; this.parentElement.style.background='#ececec';">
                <?php else: ?>
                    <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24" style="color: #999;">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="dashboard-scroll" id="main-content">
        <h1>
            Tekete Safe Space Provincial Dashboard -
            <span class="province-name"><?php echo e($province->province_name); ?></span>
        </h1>

        <p class="subtitle">Provincial case intelligence and live report monitoring.</p>

        <section class="panel" aria-label="Filters">
            <h2>Filters</h2>
            <hr class="filter-separator"/>
            <form method="GET" action="<?php echo e(url()->current()); ?>" class="filters" id="filtersForm">
                <input type="hidden" name="tab" value="<?php echo e($activeTab); ?>">
                <select name="district" id="districtSelect" onchange="this.form.submit()">
                    <option value="">All Districts</option>
                    <?php $__currentLoopData = $districts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $district): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($district->id); ?>" <?php echo e($districtFilter == $district->id ? 'selected' : ''); ?>>
                            <?php echo e($district->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <select name="school" id="schoolSelect" onchange="this.form.submit()">
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
                <span class="card-subtext"></span>
            </div>
            <div class="metric-card extras-identified" onclick="openExtrasModal('identified')">
                <span class="card-title">Identified</span>
                <div class="card-value"><?php echo e(number_format($anonymousCounts['identified'] ?? 0)); ?></div>
            </div>
            <div class="metric-card extras-abuse" onclick="openExtrasModal('abuse-types')">
                <span class="card-title">Types Of Report Tracked</span>
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
            <div class="grid-two">
                <div>
                    <h2>Monthly Trends</h2>
                    <canvas id="monthlyTrendChart"></canvas>
                </div>
                <div class="chart-card chart-abuse-pie">
                    <h2>Report Types Distribution</h2>
                    <canvas id="abuseTypeChart"></canvas>
                </div>
            </div>
            <div style="margin-top: 1.5rem;">
                <h2 class="chart-title-left">Status Breakdown</h2>
                <canvas id="statusChart"></canvas>
            </div>
            <div class="grid-two" style="margin-top: 1.5rem;">
                <div>
                    <h2>Anonymous vs Identified</h2>
                    <canvas id="anonymousChart"></canvas>
                </div>
                <div>
                    <h2>Top Reporting Schools</h2>
                    <div class="table-responsive">
                        <table style="width:100%; border-collapse:collapse;" class="table">
                            <thead>
                                <tr>
                                    <th style="text-align:left;">School</th>
                                    <th style="text-align:right; white-space:nowrap;">Reports</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $topSchools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schoolName => $schoolCount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td style="padding:0.5rem; border-bottom:1px solid #e5e7eb; word-break:break-word;">
                                            <?php echo e($schoolName); ?>

                                        </td>
                                        <td style="text-align:right; padding:0.5rem; border-bottom:1px solid #e5e7eb; white-space:nowrap;">
                                            <?php echo e(number_format($schoolCount)); ?>

                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <section class="panel heatmap-panel" aria-label="Reports by District and Type">
            <h2>Reports by District &amp; Report Type</h2>
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
                            <th class="heatmap-corner">District</th>
                            <?php $__currentLoopData = $heatmapAbuseTypes ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $atype): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th class="heatmap-col"><?php echo e($atype); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <th class="heatmap-total-col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $heatmapMatrix ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $district => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php $rowIdx = $loop->index; ?>
                            <tr>
                                <th class="heatmap-row"><?php echo e($district); ?></th>
                                <?php $__currentLoopData = $row; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $colIdx => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $intensity = ($heatmapMax ?? 1) > 0 ? min(1, $count / ($heatmapMax ?? 1)) : 0;
                                        $colors = ['#e0f2fe','#fef9c3','#eab308','#f97316','#ef4444'];
                                        $colorIdx = $intensity >= 0.8 ? 4 : ($intensity >= 0.6 ? 3 : ($intensity >= 0.4 ? 2 : ($intensity >= 0.2 ? 1 : 0)));
                                        $bgColor = $colors[$colorIdx];
                                        $isDark = $intensity >= 0.6;
                                        $pct = $heatmapPercentages[$district][$colIdx] ?? 0;
                                        $atype = $heatmapAbuseTypes[$colIdx] ?? '';
                                        $isHotspot = in_array($colIdx, $heatmapHotspots[$district] ?? []);
                                        $districtId = $heatmapDistrictNameToId[$district] ?? null;
                                        $abuseTypeId = $heatmapAbuseTypeNameToId[$atype] ?? null;
                                        $animDelay = ($rowIdx * count($row) + $colIdx) * 0.02;
                                    ?>
                                    <td class="heatmap-cell <?php echo e($isDark ? 'heatmap-cell-dark' : ''); ?> <?php echo e($isHotspot ? 'heatmap-hotspot' : ''); ?>"
                                        style="background-color: <?php echo e($bgColor); ?>; animation-delay: <?php echo e($animDelay); ?>s;"
                                        data-count="<?php echo e($count); ?>"
                                        data-percent="<?php echo e($pct); ?>"
                                        data-district="<?php echo e($district); ?>"
                                        data-abuse-type="<?php echo e($atype); ?>"
                                        data-district-id="<?php echo e($districtId); ?>"
                                        data-abuse-type-id="<?php echo e($abuseTypeId); ?>"
                                        data-view="count"
                                        role="button"
                                        tabindex="0"
                                        title="<?php echo e($district); ?> × <?php echo e($atype); ?>: <?php echo e($count); ?> reports (<?php echo e($pct); ?>% of district) — Click to view reports">
                                        <span class="heatmap-cell-count"><?php echo e($count); ?></span>
                                        <span class="heatmap-cell-pct" style="display:none;"><?php echo e($pct); ?>%</span>
                                    </td>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <td class="heatmap-total-cell"><?php echo e($heatmapRowTotals[$district] ?? 0); ?></td>
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
            <p class="heatmap-legend">◆ = top 3 in district. Districts sorted by total.</p>
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
            <p class="heatmap-legend">Blue = low, yellow = medium, red = high report count. Your province highlighted. Hover for details.</p>
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
    'anonymousReports' => $anonymousReportsPayload ?? [],
    'identifiedReports' => $identifiedReportsPayload ?? [],
]); ?>

</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script>
    Chart.register(ChartDataLabels);

(function() {
  const reportsUrl = "<?php echo e(url('/provincial-admin/reports')); ?>";
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
            if (view === 'percent') {
              countEl.style.display = 'none';
              pctEl.style.display = '';
            } else {
              countEl.style.display = '';
              pctEl.style.display = 'none';
            }
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
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        this.click();
      }
    });
  });
})();

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
            layout: { padding: 10 },
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

    const statusCtx = document.getElementById("statusChart")?.getContext("2d");
    const customColors = ['#99c4d3','#fcb825','#00c382','#9b57cc','#81acef','#38b6ff','#ff66c4'];
    const barColors = [];
    const capColors = [];
    if (statusCtx) {
        customColors.forEach(color => {
            const gradient = statusCtx.createLinearGradient(0, 0, 600, 0);
            gradient.addColorStop(0, color);
            gradient.addColorStop(1, color);
            barColors.push(gradient);
            capColors.push(color);
        });
    }

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
                const chartWidth = fullX - chartArea.left;
                const filledX = chartArea.left + (parseFloat(percentage) / 100) * chartWidth;
                const y = bar.y;
                const h = bar.height;
                const emptyBarColors = ['#c1e6f3ff','#fdf0d4ff','#cbffeeff','#e6c8fcff','#c5d7f5ff','#cfeafaff','#f7bfe1ff'];
                ctx.fillStyle = emptyBarColors[i % emptyBarColors.length];
                ctx.fillRect(chartArea.left, y - h / 2, fullX - chartArea.left, h);
                ctx.fillStyle = barColors[i % barColors.length];
                ctx.fillRect(chartArea.left, y - h / 2, filledX - chartArea.left, h);
                const capWidth = 40;
                const capHeight = 24;
                let left = filledX;
                const right = filledX + capWidth;
                if (right > chartArea.right - 5) {
                    left = Math.max(chartArea.left, chartArea.right - capWidth - 5);
                }
                const top = y - capHeight / 2;
                const bottom = y + capHeight / 2;
                const mid = y;
                ctx.beginPath();
                ctx.moveTo(left, top);
                ctx.lineTo(left + capWidth - 8, top);
                ctx.lineTo(left + capWidth, mid);
                ctx.lineTo(left + capWidth - 8, bottom);
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
            layout: { padding: { right: 50 } },
            scales: {
                x: { display: false, max: 100 },
                y: { ticks: { color: "#333", font: { size: 13, weight: "600" } } }
            },
            plugins: { legend: { display: false }, datalabels: { display: false } }
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
    const url = new URL("<?php echo e(url('/provincial/reports')); ?>", window.location.origin);
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
        const schools = data.topSchools || {};
        const entries = Object.entries(schools);
        if (entries.length === 0) {
            bodyEl.innerHTML = '<p>No schools with reports in the selected period.</p>';
        } else {
            let html = '<table style="width:100%; border-collapse:collapse;"><thead><tr><th style="text-align:left; padding:0.5rem; border-bottom:2px solid #e5e7eb;">School</th><th style="text-align:right; padding:0.5rem; border-bottom:2px solid #e5e7eb;">Reports</th></tr></thead><tbody>';
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
    if (modal) { modal.classList.remove('active'); modal.setAttribute('aria-hidden', 'true'); }
}

function navigateWithFilterByAnonymous(isAnonymous) {
    const url = new URL("<?php echo e(url('/provincial-admin/reports')); ?>", window.location.origin);
    const params = new URLSearchParams(window.location.search);
    params.forEach((value, key) => { if (key !== 'is_anonymous') url.searchParams.append(key, value); });
    url.searchParams.set('is_anonymous', isAnonymous ? 1 : 0);
    window.location.href = url.toString();
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

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
(function() {
  const mapEl = document.getElementById('sa-map');
  if (!mapEl) return;

  const provinceCounts = <?php echo json_encode($mapProvinceCounts ?? [], 15, 512) ?>;
  const userProvinceName = <?php echo json_encode($mapUserProvinceName ?? null, 15, 512) ?>;
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
  const mapColors = ['#e0f2fe', '#fef9c3', '#eab308', '#f97316', '#ef4444'];

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

  fetch(geoJsonUrl)
    .then(r => r.json())
    .then(geojson => {
      let userProvinceLayer = null;
      const geoLayer = L.geoJSON(geojson, {
        style: function(feature) {
          const name = feature.properties?.name || '';
          const count = getCountForProvince(name);
          return { fillColor: getColor(count), weight: 1.5, opacity: 1, color: '#1e40af', fillOpacity: 0.85 };
        },
        onEachFeature: function(feature, layer) {
          const name = feature.properties?.name || 'Unknown';
          const count = getCountForProvince(name);
          if (userProvinceName && normalizeName(name).replace(/-/g, ' ') === normalizeName(userProvinceName).replace(/-/g, ' ')) {
            userProvinceLayer = layer;
          }
          layer.feature = feature;
          layer._defaultStyle = { weight: 1.5, color: '#1e40af' };
          layer.bindTooltip(name + ': ' + count + ' reports', { permanent: false, direction: 'center', className: 'map-tooltip' });
          layer.on({
            mouseover: function(e) { const l = e.target; l.setStyle({ weight: 3, color: '#0c4a6e' }); l.bringToFront(); },
            mouseout: function(e) { const l = e.target; l.setStyle(l._defaultStyle || { weight: 1.5, color: '#1e40af' }); }
          });
        }
      }).addTo(map);

      if (userProvinceLayer && userProvinceLayer.getBounds) {
        try {
          const bounds = userProvinceLayer.getBounds();
          if (bounds.isValid()) map.fitBounds(bounds, { padding: [30, 30], maxZoom: 8 });
        } catch (e) {}
      }
    })
    .catch(err => console.warn('Map GeoJSON load failed:', err));
})();
</script>

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
</html><?php /**PATH /home/teketeq9v8o0/staging.teketesafespace.co.za/resources/views/provincial-admin-dashboard/index.blade.php ENDPATH**/ ?>