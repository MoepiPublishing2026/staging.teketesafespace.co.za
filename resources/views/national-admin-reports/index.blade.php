<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <title>Reports | Tekete SafeSpace – National Admin</title>
    <x-favicon />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400&display=swap" rel="stylesheet">
    <style>
:root {
    --theme-gradient: linear-gradient(to right, #38b6ff, #38b6ff);
    --black: #000000; --gray-light: #dadada; --gray-dark: #2a2e32;
    --offwhite: #fffbf7; --bg: white;
}
* { box-sizing: border-box; margin: 0; padding: 0; }
html, body { font-family: 'Montserrat', sans-serif !important; color: #545454 !important; background-color: white !important; }
body {
    display: flex;
    min-height: 100vh;
    width: 100%;
    min-width: 0;
    overflow-x: hidden;
    overflow-y: hidden;
}

.sidebar-link, button, select, input, label { font-size: 15px !important; font-weight: 900 !important; color: #545454 !important; font-family: 'Montserrat', sans-serif !important; }
button { background-color: white !important; color: #38b6ff !important; border: 3px solid #c7da30 !important; font-weight: 900 !important; font-family: 'Montserrat', sans-serif !important; padding: 0.75rem 1rem !important; border-radius: 0.5rem !important; cursor: pointer !important; transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease; }
button:hover, button:focus { background-color: #c7da30 !important; color: white !important; border-color: #38b6ff !important; outline: none; }
.main-panel { flex: 1 1 0; display: flex; flex-direction: column; height: 100vh; min-width: 0; }
.topbar { width: 100%; background: white; border-bottom: 1px solid white; display: flex; align-items: center; justify-content: flex-end; padding: 1rem 2.5rem; position: sticky; top: 0; z-index: 10; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
.profile { display: flex; align-items: center; gap: 0.8rem; }
.profile-avatar { width: 42px; height: 42px; border-radius: 50%; background: #ececec; overflow: hidden; display: flex; align-items: center; justify-content: center; box-shadow: 0 1px 6px rgba(51,51,63,0.08); }
.profile-avatar img { width: 100%; height: 100%; object-fit: cover; }
.profile .meta { text-align: right; }
.profile .meta > span:first-child { color: #38b6ff; font-size: 18px; font-weight: 700; }
.profile .meta span { display: block; line-height: 1.3; font-weight: 700; color: #232323; }
.profile .meta .role { font-weight: 400; color: #4a4a4a; font-size: 0.9rem; }
main { flex: 1; padding: 2.5rem; background: #fff; overflow-y: auto; min-width: 0; }
h1 { margin: 0 0 1.5rem; font-weight: 900 !important; font-size: 32px !important; font-family: 'Montserrat', sans-serif !important; letter-spacing: 0.03em; text-transform: uppercase !important; color: #545454 !important; text-align: center; }
.table-wrap {
    width: 100%;
    max-width: 100%;
    overflow-x: auto;
    overflow-y: hidden;
    -webkit-overflow-scrolling: touch;
    touch-action: pan-x;
    border: 3px solid #c7da30;
    border-radius: 0.375rem;
    background: var(--gray-light);
}
.table-wrap table { width: max-content; min-width: 100%; border: 0; background: transparent; }
table { width: 100%; border-collapse: collapse; font-size: 0.9rem; color: var(--black); font-family: 'Montserrat', sans-serif; table-layout: fixed; }
thead { background: #bbc93dff; color: black; text-transform: uppercase; letter-spacing: 0.05em; font-size: 0.75rem; }
th, td { padding: 0.9rem 1rem; border-bottom: 1px solid var(--lime); text-align: left; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
tbody tr:hover { background: rgba(199,218,48,0.15); cursor: pointer; transition: background-color 0.3s ease; }
tbody tr:last-child td { border-bottom: none; }

/* ── Status Badge Styling ── */
.status-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.4rem 0.8rem;
    border-radius: 16px;
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: capitalize;
    white-space: nowrap;
}

.status-awaiting-resolution {
    background-color: #fef3c7;
    color: #92400e;
    border: 1px solid #fcd34d;
}

.status-under-review {
    background-color: #dbeafe;
    color: #1e40af;
    border: 1px solid #93c5fd;
}

.status-forwarded {
    background-color: #fee2e2;
    color: #991b1b;
    border: 1px solid #fca5a5;
}

.status-closed {
    background-color: #dcfce7;
    color: #166534;
    border: 1px solid #86efac;
}

.status-unresolved {
    background-color: #f3f4f6;
    color: #374151;
    border: 1px solid #d1d5db;
}

.status-false-report {
    background-color: #f3e8ff;
    color: #6b21a8;
    border: 1px solid #e9d5ff;
}

.pagination { display: flex; justify-content: center; margin-top: 1rem; }
.page-link { border: 1px solid #cddc39; color: black; border-radius: 50%; width: 35px; height: 35px; text-align: center; line-height: 32px; margin: 0 4px; transition: all 0.3s ease; display: inline-block; text-decoration: none; }
.page-link:hover { background: #cddc39; color: white; }
.modal-backdrop { position: fixed; inset: 0; background: rgba(0,12,12,0.42); display: none; align-items: center; justify-content: center; z-index: 50; }
.modal-card { background: #fff; border: 2.5px solid #d7e47a; border-radius: 16px; width: 900px; max-width: 95vw; box-shadow: 0 6px 40px rgba(46,56,64,0.18), 0 1.5px 3px rgba(140,160,145,0.05); padding: 0; position: relative; font-family: 'Montserrat', sans-serif; color: #333; }
/* Close Button */
.modal-close {
     display: flex !important;
     justify-content: center !important;   /* center text horizontally */
     align-items: center !important;       /* center text vertically */

     position: absolute !important;
     right: 28px !important;
     bottom: 24px !important;

     width: 80px !important;
     height: 38px !important;

     background: white !important;
     border: 3px solid #cddc39 !important;
     color: #38b6ff !important;

     font-size: 14px !important;
     font-weight: 400 !important;

     border-radius: 16px !important;

     transition: background 0.2s, color 0.2s, border 0.2s !important;
     cursor: pointer !important;
     outline: none !important;
     z-index: 2 !important;
}
.modal-close:hover, .modal-close:focus { background: linear-gradient(to right, #74b9ff, #74b9ff) !important; color: white !important; border-color: #74b9ff !important; }
.modal-content { padding: 2.2rem 2.2rem 1.7rem 2.2rem; border-radius: 12px; border: none; }
.modal-content h3, #modalTitle { font-size: 1.4rem; font-weight: 700; margin-top: 0.4rem; margin-bottom: 2rem; color: #232b0b; text-align: left; letter-spacing: 0.018em; border-bottom: 2px solid #e6eea1; padding-bottom: 0.8rem; }
.modal-content p { margin-bottom: 0.55rem; font-size: 1.01rem; display: flex; align-items: baseline; }
.modal-content strong { width: 138px; display: inline-block; color: #222 !important; font-weight: 600; }
#modalReason { color: #865c0b; font-size: 0.98rem; font-style: italic; }
#modalDescription { background: #fff; min-height: 1.85em; border-radius: 6px; padding: 0.55rem 0.75rem; color: #636c0b; font-size: 1.06rem; margin-bottom: 1rem; border: 3px solid #cddc39; }
#modalAttachments img, #modalAttachments video { border: 2px solid #c7da30; border-radius: 7px; width: 80px !important; height: 80px !important; object-fit: cover; margin-right: 8px; }
::-webkit-scrollbar { width: 8px; }
::-webkit-scrollbar-thumb { background: var(--lime); border-radius: 10px; }
::-webkit-scrollbar-track { background: #f2f2f2; }
@media (max-width: 900px) {
    body { overflow-x: hidden; }
    .main-panel { margin-left: 0 !important; transition: margin-left 0.3s ease; height: 100vh; }
    .main-panel.shifted { margin-left: 240px; }
    main { padding: 1.5rem; }
    .filter-grid { grid-template-columns: 1fr 1fr !important; }
}
@media (max-width: 540px) { .filter-grid { grid-template-columns: 1fr !important; } }

/* ── Filter Panel ──────────────────────────────────────────────── */
.filter-panel { background: #f9fafb; border: 2px solid #e5e7eb; border-radius: 12px; padding: 18px 20px; margin-bottom: 24px; }
.filter-label { font-family: 'Montserrat', sans-serif; font-size: 11px !important; font-weight: 700 !important; color: #6b7280 !important; text-transform: uppercase; letter-spacing: 0.07em; margin-bottom: 5px; display: block; }
.filter-input { width: 100%; border: 2px solid #e5e7eb !important; border-radius: 8px; padding: 7px 10px !important; font-size: 13px !important; font-family: 'Montserrat', sans-serif !important; color: #111 !important; background: white !important; transition: border-color 0.2s; outline: none; box-sizing: border-box; font-weight: 400 !important; margin: 0 !important; display: block; }
.filter-input:focus { border-color: #c7da30 !important; box-shadow: 0 0 0 3px rgba(199,218,48,0.15); }
.search-wrap { position: relative; margin-bottom: 18px; }
.search-wrap input { width: 100%; border: 2px solid #c7da30 !important; border-radius: 30px; padding: 10px 20px 10px 44px !important; font-size: 14px !important; font-family: 'Montserrat', sans-serif !important; color: #111 !important; background: white !important; outline: none; transition: box-shadow 0.2s; box-sizing: border-box; font-weight: 400 !important; margin: 0 !important; }
.search-wrap input:focus { box-shadow: 0 0 0 3px rgba(199,218,48,0.2); }
.search-icon { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #aaa; pointer-events: none; font-size: 15px; }
.filter-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 12px; align-items: end; }
.filter-btn { width: 100%; border-radius: 8px !important; padding: 8px 14px !important; font-size: 12px !important; font-family: 'Montserrat', sans-serif !important; font-weight: 700 !important; cursor: pointer; transition: all 0.2s; height: 36px; margin: 0 !important; display: block; }
.filter-btn-apply { background: #38b6ff !important; color: white !important; border: none !important; }
.filter-btn-clear { background: white !important; border: 2px solid #e5e7eb !important; color: #6b7280 !important; }
.filter-btn-apply:hover { background: #1a9fe0 !important; color: white !important; border: none !important; }
.filter-btn-clear:hover { border-color: #c7da30 !important; color: #000 !important; background: #f7fcd4 !important; }
#refreshBtn {
    width: 100%;
    background: #38b6ff !important;
    color: white !important;
    border: none !important;
    border-radius: 8px !important;
    padding: 8px 14px !important;
    font-size: 12px !important;
    font-family: 'Montserrat', sans-serif !important;
    font-weight: 700 !important;
    cursor: pointer;
    height: 36px;
    transition: background-color 0.2s;
}
#refreshBtn:hover { background: #1a9fe0 !important; color: white !important; }
.active-filter-badge { display: inline-flex; align-items: center; background: #f0f9d4; border: 1px solid #c7da30; border-radius: 20px; padding: 2px 10px; font-size: 11px; font-family: 'Montserrat', sans-serif; font-weight: 600; color: #4a5e00; margin-right: 6px; margin-bottom: 6px; }

/* National Reports — match the School Admin reports visual system */
body.na-app {
    --reports-lime: #c7da30;
    --reports-blue: #38b6ff;
    background: #fff !important;
}

body.na-app #na-sidebar.national-admin-sidebar {
    position: relative !important;
    width: 185px !important;
    min-width: 185px !important;
    height: 100vh;
    padding-top: 151px !important;
    border-right: 3px solid #d7d7d7 !important;
    background: #fff !important;
}

body.na-app #na-sidebar .sidebar-logo {
    position: absolute !important;
    top: 46px !important;
    left: 28px !important;
    width: 140px !important;
}

body.na-app #na-sidebar .sidebar-logo img {
    width: 140px !important;
}

body.na-app #na-sidebar .sidebar-list {
    padding-left: 28px !important;
}

body.na-app #na-sidebar nav a.sidebar-link {
    width: 118px !important;
    min-height: 31px !important;
    margin-bottom: 8px !important;
    padding: 5px 8px !important;
    border-radius: 4px !important;
    color: #545454 !important;
    -webkit-text-fill-color: #545454 !important;
    background: transparent !important;
    font-size: 15px !important;
    font-weight: 400 !important;
    line-height: 21px !important;
}

body.na-app #na-sidebar nav a.sidebar-link:hover,
body.na-app #na-sidebar nav a.sidebar-link.active {
    color: #fff !important;
    -webkit-text-fill-color: #fff !important;
    background: var(--reports-blue) !important;
}

body.na-app .main-panel {
    height: 100vh;
    overflow: hidden;
    background: #fff;
}

body.na-app .topbar {
    position: relative;
    height: 78px;
    flex: 0 0 78px;
    align-items: flex-start;
    padding: 24px 39px 0;
    border: 0;
    background: #fff;
    box-shadow: none;
}

body.na-app .profile {
    align-items: flex-start;
    gap: 12px;
}

body.na-app .profile .meta {
    padding-top: 4px;
    line-height: 1.08;
}

body.na-app .profile .meta > span:first-child {
    color: var(--reports-blue) !important;
    font-size: 16px !important;
    font-weight: 700 !important;
}

body.na-app .profile .meta .role {
    margin-top: 2px;
    color: #656565 !important;
    font-size: 15px !important;
    font-weight: 400 !important;
}

body.na-app .profile-avatar {
    width: 52px;
    height: 52px;
    flex: 0 0 52px;
    background: transparent;
    box-shadow: none;
}

body.na-app .profile-avatar svg {
    display: block;
    width: 100%;
    height: 100%;
}

body.na-app main#main-content {
    min-width: 0;
    padding: 3px 39px 18px 24px;
    background: #fff;
}

body.na-app main#main-content > h1 {
    margin: 0 0 4px;
    color: #4a4a4a !important;
    font-size: 17px !important;
    font-weight: 700 !important;
    line-height: 1.25;
    text-align: left;
}

body.na-app .filter-panel {
    margin: 0 0 13px;
    padding: 11px 14px 7px;
    border: 2px solid var(--reports-lime) !important;
    border-radius: 10px;
    background: #f5f5f5;
    box-shadow: none;
}

body.na-app .search-wrap {
    margin-bottom: 7px;
}

body.na-app .search-icon {
    display: none;
}

body.na-app .search-wrap input {
    width: 100%;
    height: 23px;
    margin: 0 !important;
    padding: 0 14px !important;
    border: 2px solid var(--reports-lime) !important;
    border-radius: 999px;
    background: #fff !important;
    color: #333 !important;
    font-size: 9px !important;
    font-weight: 400 !important;
}

body.na-app .filter-grid {
    display: grid;
    grid-template-columns: repeat(8, minmax(0, 1fr));
    gap: 7px;
    align-items: end;
}

body.na-app .filter-grid > div {
    min-width: 0;
}

body.na-app .filter-label {
    display: block;
    height: 11px;
    margin: 0 0 3px;
    overflow: hidden;
    color: #60646a !important;
    font-size: 7px !important;
    font-weight: 700 !important;
    letter-spacing: 0;
    line-height: 11px;
    white-space: nowrap;
}

body.na-app .filter-input,
body.na-app #refreshBtn {
    box-sizing: border-box;
    width: 100%;
    height: 23px;
    margin: 0 !important;
    padding: 0 5px !important;
    border-radius: 6px !important;
    font-family: 'Montserrat', sans-serif !important;
    font-size: 8px !important;
}

body.na-app .filter-input {
    border: 2px solid var(--reports-lime) !important;
    background: #fff !important;
    color: #555 !important;
    font-weight: 400 !important;
}

body.na-app #refreshBtn {
    border: 0 !important;
    background: var(--reports-blue) !important;
    color: #fff !important;
    font-weight: 400 !important;
}

body.na-app .active-filter-badge {
    padding: 1px 6px;
    font-size: 7px;
}

body.na-app .table-wrap {
    width: 100%;
    max-width: 100%;
    overflow-x: auto;
    border: 0;
    border-radius: 0;
    background: #e5e5e5;
}

body.na-app .table-wrap table {
    display: table;
    width: 100% !important;
    min-width: 780px;
    border-collapse: collapse;
    table-layout: fixed;
    background: #e5e5e5;
    color: #303030;
    font-size: 8px;
}

body.na-app .table-wrap thead {
    background: #c4df20;
    color: #fff;
    font-size: 8px;
    letter-spacing: 0;
    text-transform: none;
}

body.na-app .table-wrap th {
    height: 36px;
    padding: 0 5px;
    border-right: 1px solid rgba(255,255,255,.9);
    border-bottom: 0;
    color: #fff;
    font-size: 8px;
    font-weight: 400;
    text-align: center;
}

body.na-app .table-wrap td {
    height: 32px;
    padding: 0 6px;
    overflow: hidden;
    border-right: 1px solid rgba(255,255,255,.9);
    border-bottom: 1px solid #fff;
    color: #303030;
    font-size: 8px;
    font-weight: 400;
    text-align: center;
    text-overflow: ellipsis;
    white-space: nowrap;
}

body.na-app .table-wrap th:nth-child(1) { width: 10%; }
body.na-app .table-wrap th:nth-child(2) { width: 12%; }
body.na-app .table-wrap th:nth-child(3) { width: 9%; }
body.na-app .table-wrap th:nth-child(4) { width: 9%; }
body.na-app .table-wrap th:nth-child(5) { width: 13%; }
body.na-app .table-wrap th:nth-child(6) { width: 8%; }
body.na-app .table-wrap th:nth-child(7) { width: 11%; }
body.na-app .table-wrap th:nth-child(8) { width: 13%; }
body.na-app .table-wrap th:nth-child(9) { width: 8%; }
body.na-app .table-wrap th:nth-child(10) { width: 7%; }

body.na-app .table-wrap td:first-child {
    font-weight: 700;
}

body.na-app .table-wrap tbody tr {
    background: #e5e5e5;
}

body.na-app .table-wrap tbody tr:hover {
    background: #f4f8d4;
}

body.na-app .status-badge {
    padding: 4px 8px;
    border: 0;
    border-radius: 999px;
    background: #fff3a6;
    color: #9b8749;
    font-size: 8px;
    font-weight: 400;
    line-height: 1.2;
    text-transform: none;
}

body.na-app .pagination {
    display: flex;
    flex-wrap: nowrap;
    align-items: center;
    justify-content: center;
    gap: 5px;
    margin-top: 13px;
}

body.na-app .page-link {
    display: inline-flex;
    width: 36px;
    height: 36px;
    margin: 0;
    align-items: center;
    justify-content: center;
    border: 2px solid var(--reports-lime);
    border-radius: 50%;
    background: #fff;
    color: #222;
    font-size: 14px;
    font-weight: 400;
    line-height: 1;
}

body.na-app .page-link:hover,
body.na-app .page-link[aria-current="page"] {
    border-color: var(--reports-lime);
    background: var(--reports-lime);
    color: #111;
}

@media (min-width: 1400px) {
    body.na-app .filter-grid {
        grid-template-columns: repeat(11, minmax(0, 1fr));
    }
}

@media (max-width: 900px) {
    body.na-app .topbar {
        height: 60px;
        flex-basis: 60px;
        padding: 10px 16px 0 60px;
    }

    body.na-app main#main-content {
        padding: 12px 16px 24px;
    }

    body.na-app .filter-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
    }

    body.na-app .table-wrap table {
        min-width: 900px;
    }
}

@media (max-width: 540px) {
    body.na-app .filter-grid {
        grid-template-columns: 1fr !important;
    }
}
    </style>
    <link rel="stylesheet" href="{{ asset('css/national-admin-mobile.css') }}">
    <x-national-admin-styles />
</head>
<body class="na-app">

<x-national-admin-sidebar />

<div class="main-panel">
    <button class="menu-icon" id="sidebarToggle" aria-label="Open navigation menu" aria-expanded="false" aria-controls="na-sidebar" type="button">&#9776;</button>
    <div class="topbar">
        <div class="profile">
            <div class="meta">
                <span>{{ auth()->user()->name ?? 'Administrator' }}</span>
                <span class="role">Administrator</span>
            </div>
            <div class="profile-avatar">
                @php $currentUser = auth()->user()->fresh(); @endphp
                @if($currentUser && $currentUser->profile_picture)
                    <img src="{{ $currentUser->profile_picture_url }}" alt="Profile Picture" class="profile-pic">
                @else
                    <svg viewBox="0 0 52 52" role="img" aria-label="Default administrator profile picture">
                        <circle cx="26" cy="26" r="26" fill="#e3e7ec"/>
                        <ellipse cx="26" cy="20" rx="10" ry="12" fill="#647184"/>
                        <path d="M8 47c2-11 9-17 18-17s16 6 18 17c-5 3-11 5-18 5S13 50 8 47Z" fill="#647184"/>
                    </svg>
                @endif
            </div>
        </div>
    </div>

    <main id="main-content">
        <h1>All Reports</h1>

        {{-- ════════════════════════════════════════════════════════════ --}}
        {{--  SEARCH BAR + FILTER PANEL                                  --}}
        {{-- ════════════════════════════════════════════════════════════ --}}
        <form id="filterForm" method="GET" action="{{ url('/national-admin/reports') }}">
        <div class="filter-panel">

            {{-- Search Bar --}}
            <div class="search-wrap">
                <span class="search-icon"><i class="fas fa-search"></i></span>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search by name, email, case number, school, description…"
                    autocomplete="off"
                />
            </div>

            {{-- Filter Grid --}}
            <div class="filter-grid">

            <div>
                    <label class="filter-label">Anonymous</label>
                    <select name="is_anonymous" class="filter-input" onchange="this.form.submit()">
                        <option value="">All</option>
                        <option value="1" {{ request('is_anonymous') === '1' ? 'selected' : '' }}>Anonymous</option>
                        <option value="0" {{ request('is_anonymous') === '0' ? 'selected' : '' }}>Identified</option>
                    </select>
                </div>

                <div>
                    <label class="filter-label">Name / Surname</label>
                    <input type="text" name="full_name" class="filter-input"
                           value="{{ request('full_name') }}"
                           placeholder="e.g Joe Smith" />
                </div>
                

                
                <div>
                    <label class="filter-label">Grades</label>
                    <select name="grade" class="filter-input" onchange="this.form.submit()">
                        <option value="">All Grades</option>
                        @foreach($gradeOptions as $grade)
                            <option value="{{ $grade }}" {{ request('grade') == $grade ? 'selected' : '' }}>
                                {{ $grade }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="filter-label">Date From</label>
                    <input type="date" name="date_from" class="filter-input"
                           value="{{ request('date_from') }}" onchange="this.form.submit()" />
                </div>

                <div>
                    <label class="filter-label">Date To</label>
                    <input type="date" name="date_to" class="filter-input"
                           value="{{ request('date_to') }}" onchange="this.form.submit()" />
                </div>

                <div>
                    <label class="filter-label">Report Type</label>
                    <select name="type_id" class="filter-input" onchange="document.getElementById('subtypeSelect').value=''; if(typeof filterSubtypes==='function') filterSubtypes(); this.form.submit();">
                        <option value="">All Types</option>
                        @foreach($typeOptions as $type)
                            <option value="{{ $type->id }}" {{ request('type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->type_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="filter-label">Subtypes</label>
                    <select name="subtype_id" id="subtypeSelect" class="filter-input" onchange="this.form.submit()">
                        <option value="">All Subtypes</option>
                        @foreach($subtypeOptions as $sub)
                            <option value="{{ $sub->id }}"
                                    data-type="{{ $sub->abuse_type_id }}"
                                    {{ request('subtype_id') == $sub->id ? 'selected' : '' }}>
                                {{ $sub->sub_type_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="filter-label">Status</label>
                    <select name="status" class="filter-input" onchange="this.form.submit()">
                        <option value="">All Statuses</option>
                        <option value="awaiting-resolution" {{ request('status') == 'awaiting-resolution' ? 'selected' : '' }}>Awaiting Resolution</option>
                        <option value="under-review"        {{ request('status') == 'under-review'        ? 'selected' : '' }}>Under Review</option>
                        <option value="forwarded"           {{ request('status') == 'forwarded'           ? 'selected' : '' }}>Forwarded</option>
                        <option value="closed"              {{ request('status') == 'closed'              ? 'selected' : '' }}>Closed</option>
                        <option value="unresolved"          {{ request('status') == 'unresolved'          ? 'selected' : '' }}>Unresolved</option>
                        <option value="false-report"        {{ request('status') == 'false-report'        ? 'selected' : '' }}>False Report</option>
                    </select>
                </div>

                <div>
                    <label class="filter-label">School</label>
                    <div style="position:relative;">
                        <input
                            type="text"
                            name="school_name"
                            id="schoolSearch"
                            class="filter-input"
                            autocomplete="off"
                            placeholder="Type to search school…"
                            value="{{ $schoolName }}"
                        />
                        <input type="hidden" name="school_id" id="schoolId" value="{{ request('school_id') }}" />
                        <div id="schoolDropdown"
                             style="display:none; position:absolute; left:0; right:0; top:100%; background:#fff; border:1px solid #d1d5db; max-height:200px; overflow-y:auto; z-index:9999; font-size:13px;"></div>
                    </div>
                </div>


                <div>
                    <label class="filter-label">Province</label>
                 <select name="province_id" class="filter-input" onchange="this.form.submit()">
                    <option value="">All Provinces</option>
                    @foreach($provinceOptions as $province)
                        <option value="{{ $province->province_id }}"
                            {{ request('province_id') == $province->province_id ? 'selected' : '' }}>
                            {{ $province->province_name }}
                        </option>
                    @endforeach
                </select>
                </div>

                

                <div style="display:flex; align-items:flex-end;">
                    <button type="button" id="refreshBtn">Refresh Table</button>
                </div>

            </div>{{-- end .filter-grid --}}

            {{-- Active filter badges --}}
           @php
               $activeFilters = array_filter([
                    'Search'    => request('search'),
                    'School'    => request('school_id')
                                    ? ($schoolOptions->firstWhere('school_id', request('school_id'))?->school_name ?? request('school_id'))
                                    : (request('school_name') ?: null),
                    'Name'      => request('full_name'),
                    'Grade'     => request('grade'),
                    'From'      => request('date_from'),
                    'To'        => request('date_to'),
                    'Type'      => request('type_id')    ? ($typeOptions->firstWhere('id', request('type_id'))?->type_name          ?? request('type_id'))    : null,
                    'Subtype'   => request('subtype_id') ? ($subtypeOptions->firstWhere('id', request('subtype_id'))?->sub_type_name ?? request('subtype_id')) : null,
                    'Status'    => request('status'),
                    'Anonymous' => request('is_anonymous') !== null && request('is_anonymous') !== ''
                                    ? (request('is_anonymous') === '1' ? 'Yes' : 'No')
                                    : null,
                ]);
            @endphp
            @if(count($activeFilters))
                <div style="margin-top:12px; display:flex; flex-wrap:wrap; align-items:center;">
                    @foreach($activeFilters as $label => $val)
                        <span class="active-filter-badge">
                            <i class="fas fa-filter" style="font-size:9px; margin-right:4px;"></i>
                            {{ $label }}: {{ $val }}
                        </span>
                    @endforeach
                    <span style="font-size:11px; color:#9ca3af; margin-left:4px;">
                        — {{ $reports->total() }} result(s)
                    </span>
                </div>
            @endif

        </div>{{-- end .filter-panel --}}
        </form>
        {{-- ══════════════════════════ END FILTER PANEL ════════════════ --}}

        <div class="table-wrap">
            <table aria-label="List of filtered reports">
                <thead>
                    <tr>
                        <th>Case Number</th>
                        <th>Full Name</th>
                        <th>Province</th>
                        <th>District</th>
                        <th>School</th>
                        <th>Grade</th>
                        <th>Report Type</th>
                        <th>Status</th>
                        <th>Anonymous</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reports as $report)
                        <tr onclick="openReportModal({{ $report->id }})" style="cursor:pointer;">
                            <td>{{ $report->case_number ?? 'N/A' }}</td>
                            <td>{{ $report->full_name ?? 'Anonymous' }}</td>
                            <td>{{ $report->province->province_name ?? 'N/A' }}</td>
                            <td>{{ $report->district->district_name ?? 'N/A' }}</td>
                            <td>{{ $report->school->school_name ?? $report->school_name ?? 'N/A' }}</td>
                            <td>{{ $report->grade ?? 'N/A' }}</td>
                            <td>{{ $report->abuseType->type_name ?? 'N/A' }}</td>
                            <td style="text-align: center;">
                                <span class="status-badge status-{{ str_replace('_', '-', $report->status) }}">
                                    {{ str_replace(' ', '-', ucwords(str_replace(['-', '_'], ' ', $report->status))) }}
                                </span>
                            </td>
                            <td>{{ $report->is_anonymous ? 'YES' : 'NO' }}</td>
                            <td>{{ $report->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" style="text-align:center; padding:1rem;">
                                No reports found for this filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination — preserve all active filters across pages --}}
        <div class="pagination">
            @if ($reports->onFirstPage())
                <span class="page-link" aria-disabled="true">←</span>
            @else
                <a href="{{ $reports->previousPageUrl() }}&{{ http_build_query(request()->except('page')) }}" class="page-link" rel="prev">←</a>
            @endif

            @foreach ($reports->getUrlRange(1, $reports->lastPage()) as $page => $url)
                @if ($page == $reports->currentPage())
                    <span class="page-link" aria-current="page">{{ $page }}</span>
                @else
                    <a href="{{ $url }}&{{ http_build_query(request()->except('page')) }}" class="page-link">{{ $page }}</a>
                @endif
            @endforeach

            @if ($reports->hasMorePages())
                <a href="{{ $reports->nextPageUrl() }}&{{ http_build_query(request()->except('page')) }}" class="page-link" rel="next">→</a>
            @else
                <span class="page-link" aria-disabled="true">→</span>
            @endif
        </div>

    </main>
</div>

{{-- Report Details Modal --}}
<div class="modal-backdrop" id="reportModal" aria-hidden="true" style="display:none;">
    <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="modalTitle" aria-describedby="modalDescription">
        <button type="button" class="modal-close" aria-label="Close" onclick="closeReportModal()">&times;</button>
        <div class="modal-content">
            <h3 id="modalTitle" style="margin-bottom:1rem;">Report Details: <span id="modalCaseNumber"></span></h3>
            <p><strong>Full Name:</strong> <span id="modalFullName"></span></p>
            <p><strong>Email:</strong>     <span id="modalEmail"></span></p>
            <p><strong>Phone:</strong>     <span id="modalPhone"></span></p>
            <p><strong>Type:</strong>      <span id="modalType"></span></p>
            <p><strong>Subtype:</strong>   <span id="modalSubtype"></span></p>
            <p><strong>School:</strong>    <span id="modalSchool"></span></p>
            <p><strong>Grade:</strong>     <span id="modalGrade"></span></p>
            <p><strong>Status:</strong>    <span id="modalStatus"></span></p>
            <p><strong>Latest Reason:</strong> <span id="modalReason"></span></p>
            <p><strong>Description:</strong></p>
            <div id="modalDescription" style="margin-bottom:1rem;"></div>
            <p><strong>Attachments:</strong> <span id="modalAttachments"></span></p>
            <br>
            <button type="button" class="modal-close" aria-label="Close" onclick="closeReportModal()">Close</button>
        </div>
    </div>
</div>

<script>
function openReportModal(reportId) {
    fetch(`/reports/${reportId}`, { headers: { 'Accept': 'application/json' } })
    .then(r => { if (!r.ok) throw new Error('Network error'); return r.json(); })
    .then(report => {
        document.getElementById('modalCaseNumber').textContent = report.case_number || 'N/A';
        document.getElementById('modalFullName').textContent   = report.full_name || 'Anonymous';
        document.getElementById('modalEmail').textContent      = report.reporter_email || 'Anonymous';
        document.getElementById('modalPhone').textContent      = report.phone_number || 'N/A';
        document.getElementById('modalType').textContent       = report.abuseType || 'N/A';
        document.getElementById('modalSubtype').textContent    = report.subtype || 'N/A';
        document.getElementById('modalSchool').textContent     = report.school || 'N/A';
        document.getElementById('modalGrade').textContent      = report.grade || 'N/A';
        document.getElementById('modalStatus').textContent     = report.status ? report.status.replace(/-/g, ' ') : 'N/A';
        document.getElementById('modalReason').textContent     = report.latest_status_reason || 'No status history recorded.';
        document.getElementById('modalDescription').textContent = report.description || '';

        const attachmentSpan = document.getElementById('modalAttachments');
        attachmentSpan.innerHTML = '';
        if (report.attachments && report.attachments.length > 0) {
            report.attachments.forEach(filePath => {
                const ext = filePath.split('.').pop().toLowerCase();
                const publicUrl = `/storage/${filePath.replace(/^\/+/, '')}`;
                let elem;
               if (['jpg','jpeg','png','gif','bmp','webp','svg'].includes(ext)) {
                    elem = document.createElement('img');
                    elem.src = publicUrl;
                    elem.alt = 'Attachment';
                    Object.assign(elem.style, {
                        width:'80px', height:'80px', marginRight:'10px',
                        border:'2px solid #c7da30', borderRadius:'8px',
                        objectFit:'cover', cursor:'zoom-in'
                    });
                    elem.onclick = function(e) {
                        e.stopPropagation();
                        openLightbox(this.src);
                    };
                } else if (['mp4','mov','avi','wmv'].includes(ext)) {
                    elem = document.createElement('video');
                    elem.controls = true;
                    Object.assign(elem.style, { width:'120px', height:'80px', marginRight:'10px' });
                    const src = document.createElement('source');
                    src.src = publicUrl; src.type = 'video/' + ext;
                    elem.appendChild(src);
                } else {
                    elem = document.createElement('a');
                    elem.href = publicUrl; elem.target = '_blank';
                    elem.textContent = filePath.split('/').pop();
                    Object.assign(elem.style, { color:'#4c8eda', textDecoration:'underline', marginRight:'10px', display:'inline-block' });
                }
                attachmentSpan.appendChild(elem);
            });
        } else {
            attachmentSpan.textContent = 'N/A';
        }
        const modal = document.getElementById('reportModal');
        modal.style.display = 'flex';
        modal.setAttribute('aria-hidden', 'false');
    })
    .catch(() => alert('Failed to load report details.'));
}

function closeReportModal() {
    const modal = document.getElementById('reportModal');
    modal.style.display = 'none';
    modal.setAttribute('aria-hidden', 'true');
}

document.addEventListener('keydown', e => {
    if (e.key !== 'Escape') return;
    
    // Close lightbox first if open
    if (document.getElementById('lightbox') && document.getElementById('lightbox').style.display === 'flex') {
        closeLightbox();
        return;
    }

    const sb = document.querySelector('.sidebar');
    if (sb && sb.classList.contains('open')) {
        if (typeof toggleSidebar === 'function') toggleSidebar();
        return;
    }
    closeReportModal();
});
</script>

<script src="{{ asset('js/mobile-select-modal.js') }}"></script>
<script src="https://kit.fontawesome.com/2c36e9b7b9.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
// ── Shared top-level state (declared ONCE) ──────────────────────
const anonSelect  = document.querySelector('select[name="is_anonymous"]');
const nameInput   = document.querySelector('input[name="full_name"]');
const searchInput = document.querySelector('input[name="search"]');

let allSubtypeOptions = null;
let typeSelect, subtypeSelect;

const PLACEHOLDER_DEFAULT = 'Search by name, email, case number, school, description…';
const PLACEHOLDER_ANON    = 'Search by email, case number, school, description…';

function exportPDF() {
    const element = document.getElementById('main-content');
    if (!element) { alert("Main content not found!"); return; }
    html2pdf().from(element).set({
        margin: 10, filename: 'national-admin-reports.pdf',
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'mm', format: 'a3', orientation: 'landscape' }
    }).save();
}

const subtypesByType = {
    @foreach($typeOptions as $type)
        {{ $type->id }}: [
            @foreach($subtypeOptions->where('abuse_type_id', $type->id) as $sub)
                { id: {{ $sub->id }}, name: "{{ addslashes($sub->sub_type_name) }}" },
            @endforeach
        ],
    @endforeach
};

// ── Subtype filtering ─────────────────────────────────────────────
function filterSubtypes() {
    if (allSubtypeOptions === null) {
        allSubtypeOptions = Array.from(subtypeSelect.options).filter(opt => opt.value !== '');
    }

    const selectedType = typeSelect.value;
    const placeholder = subtypeSelect.options[0];

    const seenOtherTypes = new Set();
    const regular = [];
    const others = [];

    allSubtypeOptions.forEach(function (opt) {
        const isOther = opt.text.trim().toLowerCase() === 'other';
        const optType = opt.getAttribute('data-type');

        if (!selectedType) {
            // No type selected: show all non-Others, only ONE "Other" total
            if (isOther) {
                if (!seenOtherTypes.has('global')) {
                    seenOtherTypes.add('global');
                    others.push(opt.cloneNode(true));
                }
            } else {
                regular.push(opt.cloneNode(true));
            }
        } else if (String(optType) === String(selectedType)) {
            if (isOther) {
                others.push(opt.cloneNode(true));
            } else {
                regular.push(opt.cloneNode(true));
            }
        }
    });

    subtypeSelect.innerHTML = '';
    subtypeSelect.appendChild(placeholder.cloneNode(true));
    regular.forEach(opt => subtypeSelect.appendChild(opt));
    others.forEach(opt => subtypeSelect.appendChild(opt));
}

// ── Anonymous / name-search sync ─────────────────────────────────
function syncAnonNameState() {
    if (!anonSelect || !nameInput) return;
    const isAnon = anonSelect.value === '1';

    nameInput.disabled  = isAnon;
    nameInput.title     = isAnon ? 'Not available for anonymous reports' : '';
    nameInput.style.opacity    = isAnon ? '0.4' : '1';
    nameInput.style.cursor     = isAnon ? 'not-allowed' : '';
    nameInput.style.background = isAnon ? '#f3f4f6' : 'white';
    if (isAnon) nameInput.value = '';

    if (searchInput) {
        searchInput.placeholder = isAnon ? PLACEHOLDER_ANON : PLACEHOLDER_DEFAULT;
    }
}

document.addEventListener('DOMContentLoaded', function () {
    typeSelect    = document.querySelector('select[name="type_id"]');
    subtypeSelect = document.getElementById('subtypeSelect');

    const filterForm = document.getElementById('filterForm');
    let filterDebounce = null;

    if (filterForm) {
        filterForm.querySelectorAll('input[name="search"], input[name="full_name"], input[name="school_name"]').forEach(function (input) {
            input.addEventListener('input', function () {
                clearTimeout(filterDebounce);
                filterDebounce = setTimeout(function () { filterForm.submit(); }, 500);
            });
        });

        const refreshBtn = document.getElementById('refreshBtn');
        if (refreshBtn) {
            refreshBtn.addEventListener('click', function () {
                filterForm.querySelectorAll('select').forEach(function (select) { select.selectedIndex = 0; });
                filterForm.querySelectorAll('input[type="text"], input[type="date"], input[type="hidden"]').forEach(function (input) { input.value = ''; });
                filterSubtypes();
                syncAnonNameState();
                filterForm.submit();
            });
        }
    }

    if (anonSelect) anonSelect.addEventListener('change', syncAnonNameState);
    syncAnonNameState();

    // ── School autocomplete ──────────────────────────────────────
    (function initSchoolAutocomplete() {
        const API_ENDPOINT = '/api/schools';
        const LS_KEY = 'schools_cache_v3';
        const CACHE_TTL = 24 * 60 * 60 * 1000;

        const input = document.getElementById('schoolSearch');
        const dropdown = document.getElementById('schoolDropdown');
        const hiddenId = document.getElementById('schoolId');
        if (!input || !dropdown || !hiddenId) return;

        let schools = [];
        let items = [];
        let focused = -1;
        let timer = null;

        function loadCache() {
            try {
                const raw = localStorage.getItem(LS_KEY);
                if (!raw) return false;
                const parsed = JSON.parse(raw);
                if (!parsed.data || !parsed.timestamp) return false;
                if (Date.now() - parsed.timestamp > CACHE_TTL) return false;
                if (parsed.data.length > 0 && parsed.data[0].name) {
                    schools = parsed.data;
                    return true;
                }
                return false;
            } catch (e) {
                return false;
            }
        }

        function saveCache(data) {
            try {
                localStorage.setItem(LS_KEY, JSON.stringify({ data, timestamp: Date.now() }));
            } catch (e) {}
        }

        async function loadFromDatabase() {
            try {
                const res = await fetch(API_ENDPOINT, { cache: 'no-store' });
                if (!res.ok) throw new Error('HTTP ' + res.status);
                const json = await res.json();
                if (Array.isArray(json)) {
                    schools = json;
                    saveCache(schools);
                }
            } catch (e) {}
        }

        (async function init() {
            if (!loadCache()) {
                await loadFromDatabase();
            }
            fetch(API_ENDPOINT).then(r => r.json()).then(d => {
                if (Array.isArray(d)) {
                    schools = d;
                    saveCache(schools);
                }
            }).catch(() => {});
        })();

        function searchPrefix(q, limit = 20) {
            if (!q) return [];
            const low = q.toLowerCase();
            const out = [];
            for (let i = 0; i < schools.length && out.length < limit; i++) {
                const s = schools[i];
                if (!s || !s.name) continue;
                if (s.name.toLowerCase().startsWith(low)) {
                    out.push(s);
                }
            }
            return out;
        }

        function clearSuggestions() {
            dropdown.innerHTML = '';
            dropdown.style.display = 'none';
            items = [];
            focused = -1;
        }

        function selectItem(index) {
            const it = items[index];
            if (!it) return;
            input.value = it.name;
            hiddenId.value = it.id ?? '';
            clearSuggestions();
            filterForm.submit();
        }

        function render(arr) {
            dropdown.innerHTML = '';
            items = arr || [];
            focused = -1;
            if (!items.length) {
                dropdown.style.display = 'none';
                return;
            }
            for (let i = 0; i < items.length; i++) {
                const it = items[i];
                const el = document.createElement('div');
                el.textContent = it.name + (it.province ? (' (' + it.province + ')') : '');
                el.dataset.index = i;
                el.style.padding = '8px';
                el.style.cursor = 'pointer';
                el.addEventListener('pointerdown', function(e) {
                    e.preventDefault();
                    selectItem(parseInt(this.dataset.index, 10));
                });
                el.addEventListener('mouseenter', function() {
                    focused = parseInt(this.dataset.index, 10);
                    updateFocus();
                });
                dropdown.appendChild(el);
            }
            dropdown.style.display = 'block';
        }

        function updateFocus() {
            const children = dropdown.children;
            for (let i = 0; i < children.length; i++) {
                children[i].style.background = '';
                children[i].style.color = '';
                if (i === focused) {
                    children[i].style.background = '#c6d933';
                    children[i].style.color = '#000';
                }
            }
            if (focused >= 0 && children[focused]) {
                children[focused].scrollIntoView({ block: 'nearest' });
            }
        }

        input.addEventListener('input', function() {
            hiddenId.value = '';
            clearTimeout(timer);
            const q = this.value.trim();
            if (q.length < 1) {
                clearSuggestions();
                return;
            }
            timer = setTimeout(() => {
                render(searchPrefix(q, 20));
            }, 120);
        });

        input.addEventListener('keydown', function(e) {
            if (dropdown.style.display === 'none') return;
            const count = dropdown.children.length;
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                focused = Math.min(count - 1, Math.max(0, focused + 1));
                updateFocus();
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                focused = Math.max(0, focused - 1);
                updateFocus();
            } else if (e.key === 'Enter') {
                if (focused >= 0) {
                    e.preventDefault();
                    selectItem(focused);
                } else {
                    clearSuggestions();
                }
            } else if (e.key === 'Escape') {
                clearSuggestions();
            }
        });

        document.addEventListener('click', function(e) {
            if (!input.contains(e.target) && !dropdown.contains(e.target)) {
                clearSuggestions();
            }
        });
    })();

    typeSelect.addEventListener('change', filterSubtypes);
    filterSubtypes();
});

function openLightbox(src) {
    document.getElementById('lightboxImg').src = src;
    const lb = document.getElementById('lightbox');
    lb.style.display = 'flex';
}

function closeLightbox() {
    const lb = document.getElementById('lightbox');
    lb.style.display = 'none';
    document.getElementById('lightboxImg').src = '';
}
</script>

    <div id="lightbox" onclick="closeLightbox()"
        style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.85);
                z-index:9999; align-items:center; justify-content:center; cursor:zoom-out;">
        <img id="lightboxImg" src="" alt="Full size attachment"
            style="max-height:90vh; max-width:90vw; border-radius:8px; box-shadow:0 8px 40px rgba(0,0,0,0.5);">
    </div>

<x-national-admin-sidebar-script />

</body>
</html>
