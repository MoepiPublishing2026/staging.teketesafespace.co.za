<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Reports | Tekete SafeSpace – {{ $province->province_name ?? 'Provincial Admin' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
    <style>
:root {
    --theme-gradient: linear-gradient(to right, #38b6ff, #38b6ff);
    --black: #000000;
    --gray-light: #dadada;
    --gray-dark: #2a2e32;
    --offwhite: #fffbf7;
    --lime: #c7da30;
}
* { box-sizing: border-box; margin: 0; padding: 0; }
html, body { font-family: 'Montserrat', sans-serif !important; color: #545454 !important; }
body {
    display: flex;
    min-height: 100vh;
    width: 100%;
    min-width: 0;
    overflow-x: hidden;
    overflow-y: hidden;
}

.sidebar-link, button, select, input, label {
    font-size: 15px !important;
    font-weight: 900 !important;
    color: #545454 !important;
    font-family: 'Montserrat', sans-serif !important;
}
.sidebar {
    width: 235px;
    background-color: white;
    border-right: 1px solid #eaeaea;
    display: flex;
    flex-direction: column;
    padding-top: 120px;
    position: sticky;
    top: 0;
    height: 100vh;
    overflow-y: auto;
    z-index: 100;
}
.sidebar-logo {
    position: fixed;
    top: 40px;
    left: 40px;
    width: 100px;
    height: auto;
    z-index: 1;
}
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
.sidebar-link:hover, .sidebar-link.active { background: var(--theme-gradient); color: #000; }
button:hover, .sidebar-link:hover, .sidebar-link.active {
    color: #fff !important;
    background: linear-gradient(to right, #38b6ff, #38b6ff) !important;
}
button {
    background-color: white !important;
    color: #000 !important;
    border: 3px solid #c7da30 !important;
    font-weight: 900 !important;
    font-family: 'Montserrat', sans-serif !important;
    padding: 0.75rem 1rem !important;
    border-radius: 0.5rem !important;
    cursor: pointer !important;
    transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
    margin: 10px;
    display: block;
    margin-bottom: 0.5rem;
    text-decoration: none;
    padding-right: 110px;
}
button:hover, button:focus {
    background-color: #c7da30 !important;
    color: black !important;
    border-color: #38b6ff !important;
    outline: none;
}
.main-panel { flex: 1 1 0; display: flex; flex-direction: column; height: 100vh; min-width: 0; }

.menu-icon {
    display: none;
    position: fixed;
    top: 12px;
    left: 12px;
    width: 44px;
    height: 44px;
    background: white !important;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    cursor: pointer;
    z-index: 1001;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    margin: 0 !important;
    padding: 0 !important;
    font-size: 22px;
    color: #38b6ff !important;
}

.menu-icon:hover { background: #f3f4f6 !important; border-color: #38b6ff !important; }

.sidebar-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.3);
    z-index: 999;
    opacity: 0;
    transition: opacity 0.2s ease;
}
.sidebar-overlay.active { display: block; opacity: 1; }
@media (min-width: 901px) { .sidebar-overlay { display: none !important; } }

.sidebar.open { width: 240px; min-width: 240px; }
main { flex: 1; padding: 2.5rem; background: #fff; overflow-y: auto; min-width: 0; }

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
    width: 42px; height: 42px; border-radius: 50%;
    background: #ececec; overflow: hidden;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 1px 6px rgba(51, 51, 63, 0.08);
}
.profile-avatar img { width: 100%; height: 100%; object-fit: cover; }
.profile .meta { text-align: right; }
.profile .meta > span:first-child { color: #38b6ff; font-size: 18px; font-weight: 700; }
.profile .meta span { display: block; line-height: 1.3; font-weight: 700; color: #232323; }
.profile .meta .role { font-weight: 400; color: #4a4a4a; font-size: 0.9rem; }
h1 {
    margin: 0 0 1.5rem;
    font-weight: 900 !important;
    font-size: 32px !important;
    font-family: 'Montserrat', sans-serif !important;
    letter-spacing: 0.03em;
    text-transform: uppercase !important;
    color: #545454 !important;
    text-align: center;
}
table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.9rem;
    color: var(--black);
    font-family: 'Montserrat', sans-serif;
    table-layout: fixed;
}

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
thead { background: #bbc93dff; color: black; text-transform: uppercase; letter-spacing: 0.05em; font-size: 0.75rem; }
th, td { padding: 0.9rem 1rem; border-bottom: 1px solid var(--lime); text-align: left; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
tbody tr:hover { background: rgba(199,218,48,0.15); cursor: pointer; transition: background-color 0.3s ease; }
tbody tr:last-child td { border-bottom: none; }

.pagination { display: flex; justify-content: center; margin-top: 1rem; }
.page-item.active .page-link { background: #cddc39; border-color: #cddc39; color: black; }
.page-link {
    border: 1px solid #cddc39; color: black; border-radius: 50%;
    width: 35px; height: 35px; text-align: center; line-height: 32px;
    margin: 0 4px; transition: all 0.3s ease; display: inline-block;
    text-decoration: none;
}
.page-link:hover { background: #cddc39; color: white; }

.modal-backdrop {
    position: fixed; inset: 0;
    background: rgba(0,12,12,0.42);
    display: none; align-items: center; justify-content: center;
    z-index: 50; border: 3px solid #38b6ff !important;
}
.modal-card {
    background: #fff; border: 2.5px solid #d7e47a; border-radius: 16px;
    width: 900px; max-width: 95vw;
    box-shadow: 0 6px 40px rgba(46,56,64,0.18), 0 1.5px 3px rgba(140,160,145,0.05);
    padding: 0; position: relative;
    font-family: 'Montserrat', sans-serif; color: #333;
}
.modal-close {
     display: flex !important;
     justify-content: center !important;
     align-items: center !important;
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
.modal-close:hover, .modal-close:focus {
    background: linear-gradient(to right, #74b9ff, #74b9ff) !important;
    color: white !important; border-color: #74b9ff !important;
}
.modal-content { padding: 2.2rem 2.2rem 1.7rem 2.2rem; border-radius: 12px; border: none; }
.modal-content h3, #modalTitle {
    font-size: 1.4rem; font-weight: 700; margin-top: 0.4rem; margin-bottom: 2rem;
    color: #232b0b; text-align: left; letter-spacing: 0.018em;
    border-bottom: 2px solid #e6eea1; padding-bottom: 0.8rem;
}
.modal-content p { margin-bottom: 0.55rem; font-size: 1.01rem; display: flex; align-items: baseline; }
.modal-content strong { width: 138px; display: inline-block; color: #222 !important; font-weight: 600; }
#modalReason { color: #865c0b; font-size: 0.98rem; font-style: italic; }
#modalDescription {
    background: #fff; min-height: 1.85em; border-radius: 6px;
    padding: 0.55rem 0.75rem; color: #636c0b; font-size: 1.06rem;
    margin-bottom: 1rem; border: 3px solid #cddc39;
}
#modalAttachments img, #modalAttachments video {
    border: 2px solid #c7da30; border-radius: 7px;
    width: 80px !important; height: 80px !important;
    object-fit: cover; margin-right: 8px;
}
::-webkit-scrollbar { width: 8px; }
::-webkit-scrollbar-thumb { background: var(--lime); border-radius: 10px; }
::-webkit-scrollbar-track { background: #f2f2f2; }

@media (max-width: 900px) {
    .menu-icon { display: flex !important; }
    .sidebar {
        position: fixed;
        top: 0; left: 0;
        width: 0; min-width: 0;
        height: 100vh;
        overflow-x: hidden;
        transition: width 0.3s ease, min-width 0.3s ease;
        z-index: 1000;
        box-shadow: 2px 0 12px rgba(0,0,0,0.15);
        padding-top: 0;
    }
    .sidebar-link { margin-bottom: 17px; padding: 11px 18px; font-size: 15px !important; }
    .sidebar-logo { display: none; position: sticky; top: 0; left: 0; width: 100%; padding: 12px 12px 0; background: white; justify-content: flex-end; }
    .sidebar.open .sidebar-logo { display: flex; }
    .sidebar-logo img { width: 95px; height: auto; display: block; }
    .main-panel { margin-left: 0 !important; transition: margin-left 0.3s ease; height: 100vh; }
    .main-panel.shifted { margin-left: 240px; }
    main { padding: 1.25rem; }
    .filter-grid { grid-template-columns: 1fr 1fr !important; }
    th, td { padding: 0.65rem 0.75rem; }
    h1 { font-size: 26px !important; }
}
@media (max-width: 540px) {
    .filter-grid { grid-template-columns: 1fr !important; }
    main { padding: 1rem; }
}
@media (max-width: 600px) {
    .menu-icon { top: 10px; left: 10px; width: 40px; height: 40px; font-size: 20px; }
    .sidebar.open { width: 100%; max-width: 280px; min-width: 0; }
    .main-panel.shifted { margin-left: 0; }
    .sidebar-logo img { width: 85px; height: auto; }
}

/* ── Filter Panel ──────────────────────────────────────────────── */
.filter-panel {
    background: #f9fafb;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 18px 20px;
    margin-bottom: 24px;
}
.filter-label {
    font-family: 'Montserrat', sans-serif;
    font-size: 11px !important;
    font-weight: 700 !important;
    color: #6b7280 !important;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    margin-bottom: 5px;
    display: block;
}
.filter-input {
    width: 100%;
    border: 2px solid #e5e7eb !important;
    border-radius: 8px;
    padding: 7px 10px !important;
    font-size: 13px !important;
    font-family: 'Montserrat', sans-serif !important;
    color: #111 !important;
    background: white !important;
    transition: border-color 0.2s;
    outline: none;
    box-sizing: border-box;
    font-weight: 400 !important;
    margin: 0 !important;
    display: block;
}
.filter-input:focus { border-color: #c7da30 !important; box-shadow: 0 0 0 3px rgba(199,218,48,0.15); }
.search-wrap { position: relative; margin-bottom: 18px; }
.search-wrap input {
    width: 100%;
    border: 2px solid #c7da30 !important;
    border-radius: 30px;
    padding: 10px 20px 10px 44px !important;
    font-size: 14px !important;
    font-family: 'Montserrat', sans-serif !important;
    color: #111 !important;
    background: white !important;
    outline: none;
    transition: box-shadow 0.2s;
    box-sizing: border-box;
    font-weight: 400 !important;
    margin: 0 !important;
}
.search-wrap input:focus { box-shadow: 0 0 0 3px rgba(199,218,48,0.2); }
.search-icon {
    position: absolute; left: 16px; top: 50%;
    transform: translateY(-50%); color: #aaa;
    pointer-events: none; font-size: 15px;
}
.filter-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
    gap: 12px;
    align-items: end;
}
.filter-btn {
    width: 100%; border-radius: 8px !important;
    padding: 8px 14px !important; font-size: 12px !important;
    font-family: 'Montserrat', sans-serif !important;
    font-weight: 700 !important; cursor: pointer;
    transition: all 0.2s; height: 36px;
    margin: 0 !important; display: block;
}
.filter-btn-apply { background: #38b6ff !important; color: white !important; border: none !important; }
.filter-btn-clear { background: white !important; border: 2px solid #e5e7eb !important; color: #6b7280 !important; }
.filter-btn-apply:hover { background: #1a9fe0 !important; color: white !important; border: none !important; }
.filter-btn-clear:hover { border-color: #c7da30 !important; color: #000 !important; background: #f7fcd4 !important; }

.active-filter-badge {
    display: inline-flex; align-items: center;
    background: #f0f9d4; border: 1px solid #c7da30;
    border-radius: 20px; padding: 2px 10px;
    font-size: 11px; font-family: 'Montserrat', sans-serif;
    font-weight: 600; color: #4a5e00;
    margin-right: 6px; margin-bottom: 6px;
}

/* ── Choices.js overrides ──────────────────────────────────────── */
.choices {
    margin: 0 !important;
}
.choices__inner {
    border: 2px solid #e5e7eb !important;
    border-radius: 8px !important;
    background: white !important;
    font-family: 'Montserrat', sans-serif !important;
    font-size: 13px !important;
    min-height: unset !important;
    padding: 4px 8px !important;
    color: #111 !important;
}
.choices__inner:focus-within {
    border-color: #c7da30 !important;
    box-shadow: 0 0 0 3px rgba(199,218,48,0.15) !important;
}
.choices_list--single .choices_item {
    font-size: 13px !important;
    font-family: 'Montserrat', sans-serif !important;
    color: #111 !important;
    padding: 2px 0 !important;
}
.choices__list--dropdown {
    border: 2px solid #c7da30 !important;
    border-radius: 8px !important;
    font-family: 'Montserrat', sans-serif !important;
    font-size: 13px !important;
    z-index: 9999 !important;
}
.choices_list--dropdown .choices_item {
    font-size: 13px !important;
    font-family: 'Montserrat', sans-serif !important;
    color: #111 !important;
    padding: 8px 12px !important;
}
.choices__list--dropdown .choices__item--selectable.is-highlighted {
    background: #f7fcd4 !important;
    color: #000 !important;
}
.choices__input {
    font-family: 'Montserrat', sans-serif !important;
    font-size: 13px !important;
    color: #111 !important;
    background: white !important;
}
.choices[data-type*="select-one"] .choices__button {
    display: none;
}
.choices__placeholder {
    color: #9ca3af !important;
    opacity: 1 !important;
}
    </style>
</head>
<body>

<aside class="sidebar" id="sidebarPanel">
    <div class="sidebar-logo">
        <img src="{{ asset('images/logo.png') }}" alt="Tekete SafeSpace">
    </div>
    <ul class="sidebar-list">
        <a href="{{ url('/provincial-admin/dashboard') }}" class="sidebar-link {{ request()->is('provincial-admin/dashboard') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ url('/provincial-admin/reports') }}"   class="sidebar-link {{ request()->is('provincial-admin/reports')   ? 'active' : '' }}">Reports</a>
        <a href="{{ url('/provincial-admin/settings') }}"  class="sidebar-link {{ request()->is('provincial-admin/settings')  ? 'active' : '' }}">My Profile</a>
        <a href="#" onclick="event.preventDefault(); exportPDF();" class="sidebar-link">Export PDF</a>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="sidebar-link">Sign Out</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
    </ul>
</aside>

<button class="menu-icon" id="sidebarToggle" aria-label="Toggle menu" type="button">&#9776;</button>
<div class="sidebar-overlay" id="sidebarOverlay" aria-hidden="true"></div>

<div class="main-panel">
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
                @endif
            </div>
        </div>
    </div>
    <main id="main-content">
        <h1>Reports</h1>

        {{-- ════════════════════════════════════════════════════════════ --}}
        {{--  SEARCH BAR + FILTER PANEL                                  --}}
        {{-- ════════════════════════════════════════════════════════════ --}}
        <form id="filterForm" method="GET" action="{{ url('/provincial-admin/reports') }}">
        <div class="filter-panel">

            {{-- Search Bar --}}
            <div class="search-wrap">
                <span class="search-icon"><i class="fas fa-search"></i></span>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search by name, email, case number, description…"
                    autocomplete="off"
                />
            </div>

            {{-- Filter Grid --}}
            <div class="filter-grid">
                <div>
                    <label class="filter-label">Anonymous</label>
                    <select name="is_anonymous" class="filter-input">
                        <option value="">All</option>
                        <option value="1" {{ request('is_anonymous') === '1' ? 'selected' : '' }}>Anonymous</option>
                        <option value="0" {{ request('is_anonymous') === '0' ? 'selected' : '' }}>Non Anonymous</option>
                    </select>
                </div>

               <div>
                    <label class="filter-label">School</label>
                    <input
                        type="text"
                        name="school_name"
                        id="schoolSearch"
                        class="filter-input"
                        list="schoolDatalist"
                        autocomplete="off"
                        placeholder="Type to search school…"
                        value="{{ $schoolName }}"
                    />
                    <datalist id="schoolDatalist">
                        @foreach($schoolOptions as $school)
                            <option value="{{ $school->school_name }}">
                        @endforeach
                    </datalist>
                </div>

                <div>
                    <label class="filter-label">Name / Surname</label>
                    <input type="text" name="full_name" class="filter-input"
                           value="{{ request('full_name') }}"
                           placeholder="e.g. John Smith" />
                </div>

                <div>
                    <label class="filter-label">Grade</label>
                    <select name="grade" class="filter-input">
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
                           value="{{ request('date_from') }}" />
                </div>

                <div>
                    <label class="filter-label">Date To</label>
                    <input type="date" name="date_to" class="filter-input"
                           value="{{ request('date_to') }}" />
                </div>

                <div>
                    <label class="filter-label">Report Type</label>
                    <select name="type_id" class="filter-input">
                        <option value="">All Types</option>
                        @foreach($typeOptions as $type)
                            <option value="{{ $type->id }}" {{ request('type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->type_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="filter-label">Subtype</label>
                    <select name="subtype_id" id="subtypeSelect" class="filter-input">
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
                    <select name="status" class="filter-input">
                        <option value="">All Statuses</option>
                        <option value="awaiting-resolution" {{ request('status') == 'awaiting-resolution' ? 'selected' : '' }}>Awaiting Resolution</option>
                        <option value="under-review"        {{ request('status') == 'under-review'        ? 'selected' : '' }}>Under Review</option>
                        <option value="forwarded"           {{ request('status') == 'forwarded'           ? 'selected' : '' }}>Forwarded</option>
                        <option value="closed"              {{ request('status') == 'closed'              ? 'selected' : '' }}>Closed</option>
                        <option value="unresolved"          {{ request('status') == 'unresolved'          ? 'selected' : '' }}>Unresolved</option>
                        <option value="false-report"        {{ request('status') == 'false-report'        ? 'selected' : '' }}>False Report</option>
                    </select>
                </div>

                {{-- Apply + Clear --}}
                <div style="display:flex; gap:6px; align-items:flex-end;">
                    <button type="submit" class="filter-btn filter-btn-apply" style="flex:1;">
                        <i class="fas fa-filter" style="margin-right:4px;"></i> Apply
                    </button>
                    <button 
                        type="button" 
                        class="filter-btn filter-btn-clear" 
                        style="flex:1;" 
                        onclick="event.preventDefault(); event.stopPropagation(); clearFilters();">
                        <i class="fas fa-times" style="margin-right:4px;"></i> Clear
                    </button>
                </div>

            </div>{{-- end .filter-grid --}}

            {{-- Active filter badges --}}
            @php
               $activeFilters = array_filter([
                    'Search'    => request('search'),
                    'School'    => request('school_id')
                                    ? ($schoolOptions->firstWhere('id', request('school_id'))?->school_name ?? request('school_id'))
                                    : null,
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
                        <td>{{ $report->school->school_name ?? 'N/A' }}</td>
                        <td>{{ $report->grade ?? 'N/A' }}</td>
                        <td>{{ $report->reportType->type_name ?? 'N/A' }}</td>
                        <td>{{ ucfirst(str_replace('-', ' ', $report->status)) }}</td>
                        <td>{{ $report->is_anonymous ? 'Yes' : 'No' }}</td>
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
                    <span class="page-link" style="background:#cddc39; font-weight:bold;">{{ $page }}</span>
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
</div>{{-- end .main-panel --}}

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
            <button type="button" class="modal-close" aria-label="Close" onclick="closeReportModal()">Close</button>
        </div>
    </div>
</div>

<script src="{{ asset('js/mobile-select-modal.js') }}"></script>
<script src="https://kit.fontawesome.com/2c36e9b7b9.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/dist/choices.min.js"></script>
<script>
// ── PDF Export ───────────────────────────────────────────────────
function exportPDF() {
    const element = document.getElementById('main-content');
    if (!element) { alert("Main content not found!"); return; }
    html2pdf().from(element).set({
        margin: 10,
        filename: 'provincial-admin-reports.pdf',
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'mm', format: 'a3', orientation: 'landscape' }
    }).save();
}

// ── Clear all filters ────────────────────────────────────────────
function clearFilters() {
    document.getElementById('filterForm').reset();
    window.location.href = '{{ url('/provincial-admin/reports') }}';
}

// ── Report detail modal ──────────────────────────────────────────
function openReportModal(reportId) {
    fetch(`/provincial-admin/reports/${reportId}`, {
        headers: { 'Accept': 'application/json' }
    })
    .then(r => { if (!r.ok) throw new Error('Network error'); return r.json(); })
    .then(report => {
        document.getElementById('modalCaseNumber').textContent  = report.case_number || 'N/A';
        document.getElementById('modalFullName').textContent    = report.full_name || 'Anonymous';
        document.getElementById('modalEmail').textContent       = report.reporter_email || 'Anonymous';
        document.getElementById('modalPhone').textContent       = report.phone_number || 'N/A';
        document.getElementById('modalType').textContent        = report.abuseType || 'N/A';
        document.getElementById('modalSubtype').textContent     = report.subtype || 'N/A';
        document.getElementById('modalSchool').textContent      = report.school || 'N/A';
        document.getElementById('modalGrade').textContent       = report.grade || 'N/A';
        document.getElementById('modalStatus').textContent      = report.status ? report.status.replace(/-/g, ' ') : 'N/A';
        document.getElementById('modalReason').textContent      = report.latest_status_reason || 'No status history recorded.';
        document.getElementById('modalDescription').textContent = report.description || '';

        const attachmentSpan = document.getElementById('modalAttachments');
        attachmentSpan.innerHTML = '';

        if (report.attachments && report.attachments.length > 0) {
            report.attachments.forEach(filePath => {
                const ext       = filePath.split('.').pop().toLowerCase();
                const publicUrl = `/storage/${filePath.replace(/^\/+/, '')}`;
                let elem;

                if (['jpg','jpeg','png','gif','bmp','webp','svg'].includes(ext)) {
                    elem = document.createElement('img');
                    elem.src = publicUrl;
                    elem.alt = 'Attachment';
                    Object.assign(elem.style, {
                        width: '80px', height: '80px', marginRight: '10px',
                        border: '2px solid #c7da30', borderRadius: '8px', objectFit: 'cover'
                    });
                } else if (['mp4','mov','avi','wmv'].includes(ext)) {
                    elem = document.createElement('video');
                    elem.controls = true;
                    Object.assign(elem.style, { width: '120px', height: '80px', marginRight: '10px' });
                    const src = document.createElement('source');
                    src.src  = publicUrl;
                    src.type = 'video/' + ext;
                    elem.appendChild(src);
                } else {
                    elem = document.createElement('a');
                    elem.href        = publicUrl;
                    elem.target      = '_blank';
                    elem.textContent = filePath.split('/').pop();
                    Object.assign(elem.style, {
                        color: '#4c8eda', textDecoration: 'underline',
                        marginRight: '10px', display: 'inline-block'
                    });
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

document.addEventListener('keydown', e => { if (e.key === 'Escape') closeReportModal(); });

// ── DOMContentLoaded ─────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {

    // Sidebar toggle
    var toggle    = document.getElementById('sidebarToggle');
    var sidebar   = document.getElementById('sidebarPanel');
    var overlay   = document.getElementById('sidebarOverlay');
    var mainPanel = document.querySelector('.main-panel');

    function toggleSidebar() {
        if (!sidebar || !mainPanel) return;
        sidebar.classList.toggle('open');
        mainPanel.classList.toggle('shifted');
        if (overlay) {
            overlay.classList.toggle('active', sidebar.classList.contains('open'));
            overlay.setAttribute('aria-hidden', !sidebar.classList.contains('open'));
        }
    }

    if (toggle)  toggle.addEventListener('click', toggleSidebar);
    if (overlay) overlay.addEventListener('click', toggleSidebar);

    window.addEventListener('resize', function () {
        if (window.innerWidth > 900 && sidebar && sidebar.classList.contains('open')) {
            sidebar.classList.remove('open');
            if (mainPanel) mainPanel.classList.remove('shifted');
            if (overlay) {
                overlay.classList.remove('active');
                overlay.setAttribute('aria-hidden', 'true');
            }
        }
    });

    // ── Subtype filtered by report type ──────────────────────────
    const typeSelect    = document.querySelector('select[name="type_id"]');
    const subtypeSelect = document.getElementById('subtypeSelect');

function filterSubtypes() {
                const selectedType = typeSelect.value;

                const options = Array.from(subtypeSelect.options).filter(opt => opt.value !== '');
                const placeholder = subtypeSelect.options[0]; // "All Subtypes"

                // Separate "Other" and non-Other options
                const seenOtherTypes = new Set();
                const regular = [];
                const others  = [];

                options.forEach(function(opt) {
                    const isOther = opt.text.trim().toLowerCase() === 'other';
                    const optType = opt.getAttribute('data-type');

                    if (!selectedType) {
                        // No type selected: show all non-Others, show only one Other total
                        if (isOther) {
                            if (!seenOtherTypes.has('global')) {
                                seenOtherTypes.add('global');
                                others.push(opt);
                            }
                        } else {
                            regular.push(opt);
                        }
                    } else {
                        // Type selected: show only matching subtypes
                        if (String(optType) === String(selectedType)) {
                            if (isOther) {
                                others.push(opt);
                            } else {
                                regular.push(opt);
                            }
                        }
                    }
                });

                // Rebuild the select: placeholder → regular options → Others at bottom
                subtypeSelect.innerHTML = '';
                subtypeSelect.appendChild(placeholder);

                regular.forEach(opt => {
                    opt.style.display = '';
                    subtypeSelect.appendChild(opt);
                });

                others.forEach(opt => {
                    opt.style.display = '';
                    subtypeSelect.appendChild(opt);
                });
}

    typeSelect.addEventListener('change', filterSubtypes);
    filterSubtypes();
});

</script>
</body>
</html>