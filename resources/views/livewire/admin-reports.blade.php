<div>
@include('components.school-admin-styles')

@php
    $formatStatusLabel = static function (?string $status): string {
        if (! $status) {
            return 'N/A';
        }

        return str_replace(' ', '-', ucwords(str_replace('-', ' ', $status)));
    };
@endphp

<style>
.school-reports-shell {
    --reports-lime: #c7da30;
    --reports-lime-soft: #d7e47a;
    --reports-blue: #38b6ff;
    --reports-text: #4a4a4a;
    --reports-muted: #6b7280;
    --reports-border: #e5e5e5;
    display: flex;
    min-height: 100vh;
    margin: 0;
    padding: 0;
    background: #ffffff;
    color: var(--reports-text);
    font-family: 'Montserrat', sans-serif;
}

.school-reports-shell > #sa-sidebar.school-admin-sidebar {
    position: relative !important;
    width: 220px !important;
    min-width: 220px !important;
    height: 100vh;
    padding-top: 140px !important;
    border-right: 1px solid #e5e5e5 !important;
    background: #ffffff !important;
}

.school-reports-shell > #sa-sidebar .sidebar-logo {
    position: absolute !important;
    top: 36px !important;
    left: 28px !important;
    width: 120px !important;
}

.school-reports-shell > #sa-sidebar .sidebar-logo img {
    width: 120px !important;
    height: auto !important;
}

.school-reports-shell > #sa-sidebar .sidebar-list {
    padding: 0 0 0 18px !important;
}

.school-reports-shell > #sa-sidebar nav a.sidebar-link {
    width: calc(100% - 18px) !important;
    margin-bottom: 10px !important;
    padding: 10px 16px !important;
    border-radius: 8px !important;
    color: #545454 !important;
    -webkit-text-fill-color: #545454 !important;
    font-size: 15px !important;
    font-weight: 500 !important;
    line-height: 1.3 !important;
    background: transparent !important;
}

.school-reports-shell > #sa-sidebar nav a.sidebar-link:hover,
.school-reports-shell > #sa-sidebar nav a.sidebar-link.active {
    color: #ffffff !important;
    -webkit-text-fill-color: #ffffff !important;
    background: var(--reports-blue) !important;
}

.school-reports-shell .main-panel {
    flex: 1;
    min-width: 0;
    height: 100vh;
    overflow: hidden;
    background: #ffffff;
}

.school-reports-shell .reports-main {
    box-sizing: border-box;
    height: 100%;
    overflow: auto;
    padding: 28px 36px 28px 28px;
    background: #ffffff;
}

.school-reports-shell .mobile-menu {
    display: none;
}

.school-reports-shell .reports-user {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 12px;
    margin-bottom: 8px;
}

.school-reports-shell .reports-user-copy {
    text-align: right;
    line-height: 1.15;
}

.school-reports-shell .reports-user-name {
    margin: 0;
    color: var(--reports-blue);
    font-size: 16px;
    font-weight: 700;
}

.school-reports-shell .reports-user-role {
    margin: 2px 0 0;
    color: #777777;
    font-size: 13px;
    font-weight: 400;
}

.school-reports-shell .reports-avatar {
    width: 48px;
    height: 48px;
    flex: 0 0 48px;
    border-radius: 50%;
    object-fit: cover;
}

.school-reports-shell .reports-heading {
    margin: 0 0 14px;
    color: #3f3f3f;
    font-size: 28px;
    font-weight: 700;
    line-height: 1.2;
    letter-spacing: 0.02em;
    text-transform: uppercase;
}

.school-reports-shell .filter-panel {
    margin: 0 0 13px;
    padding: 11px 14px 7px;
    border: 2px solid var(--reports-lime) !important;
    border-radius: 10px !important;
    background: #f5f5f5 !important;
    box-shadow: none !important;
}

.school-reports-shell .search-wrap {
    margin-bottom: 4px;
}

.school-reports-shell .search-wrap input {
    box-sizing: border-box;
    width: 100%;
    height: 23px;
    padding: 0 14px;
    border: 2px solid var(--reports-lime);
    border-radius: 999px;
    outline: none;
    background: #ffffff;
    color: #333333;
    font-family: inherit;
    font-size: 9px;
}

.school-reports-shell .search-wrap input::placeholder {
    color: #9ca3af;
}

.school-reports-shell .search-wrap input:focus,
.school-reports-shell .filter-input:focus {
    border-color: #9eb718;
    box-shadow: 0 0 0 3px rgba(199, 218, 48, 0.18);
}

.school-reports-shell .filter-grid {
    display: grid;
    grid-template-columns: 0.85fr 1.2fr 1fr 1.1fr 1.1fr 1fr 1fr 1fr 1.05fr;
    gap: 7px;
    align-items: end;
}

.school-reports-shell .filter-grid > div {
    min-width: 0;
}

.school-reports-shell .filter-label {
    display: block;
    height: 11px;
    margin: 0 0 3px;
    overflow: hidden;
    color: #6b7280;
    font-size: 7px;
    font-weight: 700;
    letter-spacing: 0;
    line-height: 11px;
    text-transform: uppercase;
    white-space: nowrap;
}

.school-reports-shell .filter-input {
    box-sizing: border-box;
    width: 100%;
    height: 23px;
    padding: 0 5px;
    border: 2px solid var(--reports-lime);
    border-radius: 6px;
    outline: none;
    background: #ffffff;
    color: #4b5563;
    font-family: inherit;
    font-size: 8px;
}

.school-reports-shell .filter-input.is-disabled {
    cursor: not-allowed;
    background: #f3f4f6;
    opacity: 0.45;
}

.school-reports-shell .filter-date {
    position: relative;
}

.school-reports-shell .filter-date input {
    padding-right: 12px;
    color-scheme: light;
}

.school-reports-shell .filter-date input::-webkit-calendar-picker-indicator {
    cursor: pointer;
    opacity: 0.55;
}

.school-reports-shell #refreshBtn {
    width: 100%;
    height: 23px;
    border: 0 !important;
    border-radius: 6px;
    background: var(--reports-blue) !important;
    color: #ffffff !important;
    cursor: pointer;
    font-family: inherit;
    font-size: 8px;
    font-weight: 400;
    transition: background-color 0.2s ease;
}

.school-reports-shell #refreshBtn:hover {
    background: #1aa0e8 !important;
    color: #ffffff !important;
}

.school-reports-shell .reports-table-wrap {
    width: 100%;
    overflow-x: auto;
    border-radius: 0;
    -webkit-overflow-scrolling: touch;
}

.school-reports-shell .reports-table {
    display: table;
    width: 100%;
    min-width: 780px;
    border-collapse: collapse;
    table-layout: fixed;
    background: #e5e5e5;
    color: #303030;
    font-size: 8px;
}

.school-reports-shell .reports-table thead tr {
    background: #c4df20;
    color: #ffffff;
}

.school-reports-shell .reports-table th {
    height: 36px;
    padding: 0 6px;
    border-right: 1px solid rgba(255, 255, 255, 0.9);
    font-size: 8px;
    font-weight: 400;
    text-align: center;
    white-space: nowrap;
}

.school-reports-shell .reports-table th:last-child,
.school-reports-shell .reports-table td:last-child {
    border-right: 0;
}

.school-reports-shell .reports-table td {
    height: 32px;
    box-sizing: border-box;
    padding: 0 8px;
    overflow: hidden;
    border-right: 1px solid rgba(255, 255, 255, 0.9);
    border-bottom: 1px solid #ffffff;
    text-align: center;
    text-overflow: ellipsis;
    white-space: nowrap;
    vertical-align: middle;
}

.school-reports-shell .reports-table tbody tr {
    cursor: pointer;
    transition: background-color 0.15s ease;
}

.school-reports-shell .reports-table tbody tr:nth-child(odd) {
    background: #e5e5e5;
}

.school-reports-shell .reports-table tbody tr:nth-child(even) {
    background: #e5e5e5;
}

.school-reports-shell .reports-table tbody tr:hover {
    background: #f4f8d4;
}

.school-reports-shell .case-number {
    color: #2f2f2f;
    font-weight: 700;
}

.school-reports-shell .status-pill {
    display: inline-block;
    max-width: 100%;
    padding: 4px 8px;
    overflow: hidden;
    border-radius: 999px;
    background: #fff3a6;
    color: #9b8749;
    font-size: 8px;
    font-weight: 400;
    line-height: 1.2;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.school-reports-shell .action-select {
    width: calc(100% - 10px);
    max-width: none;
    height: 22px;
    padding: 0 5px;
    border: 0;
    border-radius: 2px;
    background: #f5f5f5;
    color: #555555;
    font-family: inherit;
    font-size: 8px;
    cursor: pointer;
}

.school-reports-shell .reports-pagination {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-top: 22px;
}

.school-reports-shell .pagination-btn {
    display: inline-flex;
    width: 40px;
    height: 40px;
    min-width: 40px;
    align-items: center;
    justify-content: center;
    border: 2px solid var(--reports-lime);
    border-radius: 999px;
    background: #ffffff;
    color: #222222;
    cursor: pointer;
    font-family: inherit;
    font-size: 15px;
    font-weight: 500;
    line-height: 1;
    transition: background-color 0.2s ease, color 0.2s ease;
}

.school-reports-shell .pagination-btn:hover {
    background: #f5f9d7;
    color: #111111;
}

.school-reports-shell .pagination-btn.active {
    border-color: var(--reports-lime);
    background: var(--reports-lime);
    color: #111111;
    font-weight: 700;
}

.school-reports-shell .pagination-btn.is-disabled {
    cursor: not-allowed;
    opacity: 0.4;
}

.school-reports-shell .font-montserrat-bold,
.school-reports-shell .font-montserrat-regular,
.school-reports-shell .font-montserrat {
    font-family: 'Montserrat', sans-serif;
}

@media (min-width: 901px) and (max-width: 1200px) {
    .school-reports-shell > #sa-sidebar.school-admin-sidebar {
        width: 185px !important;
        min-width: 185px !important;
        padding-top: 151px !important;
    }

    .school-reports-shell > #sa-sidebar .sidebar-logo {
        top: 46px !important;
        left: 28px !important;
        width: 140px !important;
    }

    .school-reports-shell > #sa-sidebar .sidebar-logo img {
        width: 140px !important;
    }

    .school-reports-shell > #sa-sidebar .sidebar-list {
        padding-left: 28px !important;
    }

    .school-reports-shell > #sa-sidebar nav a.sidebar-link {
        width: 118px !important;
        min-height: 31px !important;
        margin-bottom: 8px !important;
        padding: 5px 8px !important;
        border-radius: 4px !important;
        font-size: 15px !important;
        font-weight: 400 !important;
        line-height: 21px !important;
    }

    .school-reports-shell .reports-main {
        padding: 24px 39px 18px 24px;
    }

    .school-reports-shell .reports-user {
        min-height: 54px;
        align-items: flex-start;
        margin-bottom: 0;
    }

    .school-reports-shell .reports-avatar {
        width: 52px;
        height: 52px;
        flex-basis: 52px;
    }

    .school-reports-shell .reports-user-name {
        font-size: 16px;
    }

    .school-reports-shell .reports-user-role {
        font-size: 15px;
    }

    .school-reports-shell .reports-heading {
        margin: 3px 0 4px;
        font-size: 17px;
        line-height: 1.25;
    }

    .school-reports-shell .filter-panel {
        margin-bottom: 13px;
        padding: 11px 14px 7px;
        border-radius: 10px !important;
    }

    .school-reports-shell .search-wrap {
        margin-bottom: 4px;
    }

    .school-reports-shell .search-wrap input {
        height: 23px;
        padding: 0 14px;
        font-size: 9px;
    }

    .school-reports-shell .filter-grid {
        grid-template-columns: 80px 87px 62px 101px 99px 62px 67px 67px 69px;
        gap: 5px;
    }

    .school-reports-shell .filter-label {
        height: 11px;
        margin: 0 0 3px;
        overflow: hidden;
        font-size: 7px;
        letter-spacing: 0;
        line-height: 11px;
    }

    .school-reports-shell .filter-input,
    .school-reports-shell #refreshBtn {
        height: 23px;
        padding-right: 5px;
        padding-left: 5px;
        border-radius: 6px;
        font-size: 8px;
    }

    .school-reports-shell .reports-table-wrap {
        overflow-x: hidden;
    }

    .school-reports-shell .reports-table {
        width: 100%;
        min-width: 0;
        font-size: 8px;
    }

    .school-reports-shell .reports-table th {
        height: 36px;
        padding: 0 6px;
        font-size: 8px;
    }

    .school-reports-shell .reports-table td {
        height: 32px;
        padding: 0 8px;
    }

    .school-reports-shell .status-pill {
        padding: 4px 8px;
        font-size: 8px;
    }

    .school-reports-shell .action-select {
        height: 22px;
        padding: 0 5px;
        font-size: 8px;
    }

    .school-reports-shell .reports-pagination {
        flex-wrap: nowrap;
        gap: 5px;
        margin-top: 13px;
    }

    .school-reports-shell .pagination-btn {
        width: 36px;
        height: 36px;
        min-width: 36px;
        font-size: 14px;
    }
}

@media (max-width: 900px) {
    .school-reports-shell > #sa-sidebar.school-admin-sidebar {
        position: fixed !important;
        width: min(300px, 88vw) !important;
        min-width: min(300px, 88vw) !important;
        padding-top: max(0.75rem, env(safe-area-inset-top, 0px)) !important;
    }

    .school-reports-shell .reports-main {
        padding: 64px 16px 24px;
    }

    .school-reports-shell .mobile-menu {
        position: fixed;
        top: 12px;
        left: 12px;
        z-index: 1002;
        display: flex;
        width: 44px;
        height: 44px;
        align-items: center;
        justify-content: center;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        background: #ffffff;
        color: var(--reports-blue);
        cursor: pointer;
        font-size: 22px;
    }

    .school-reports-shell .reports-heading {
        font-size: 22px;
    }

    .school-reports-shell .filter-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .school-reports-shell .reports-pagination {
        justify-content: flex-start;
        overflow-x: auto;
        flex-wrap: nowrap;
    }
}

@media (max-width: 540px) {
    .school-reports-shell .filter-grid {
        grid-template-columns: 1fr;
    }

    .school-reports-shell .reports-user-name {
        max-width: 160px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
}

@media (prefers-reduced-motion: reduce) {
    .school-reports-shell *,
    .school-reports-shell *::before,
    .school-reports-shell *::after {
        transition: none !important;
    }
}
</style>

<div class="school-reports-shell">
    @include('components.school-admin-sidebar')

    <div class="main-panel">
        <button id="sidebarToggle" class="mobile-menu" type="button" aria-label="Open navigation menu" aria-expanded="false">
            <i class="ti ti-menu-2" aria-hidden="true"></i>
        </button>

        <main id="main-content" class="reports-main">
            <div class="reports-user">
                <div class="reports-user-copy">
                    <p class="reports-user-name">{{ auth()->user()->name ?? 'Admin' }}</p>
                    <p class="reports-user-role">Administrator</p>
                </div>
                @php
                    $currentUser = auth()->user();
                    $currentUser = $currentUser ? $currentUser->fresh() : null;
                @endphp
                @if($currentUser && $currentUser->profile_picture)
                    <img src="{{ $currentUser->profile_picture_url }}" alt="{{ $currentUser->name }} profile picture" class="reports-avatar">
                @else
                    <svg class="reports-avatar" viewBox="0 0 52 52" role="img" aria-label="Default administrator profile picture">
                        <circle cx="26" cy="26" r="26" fill="#e3e7ec"/>
                        <ellipse cx="26" cy="20" rx="10" ry="12" fill="#647184"/>
                        <path d="M8 47c2-11 9-17 18-17s16 6 18 17c-5 3-11 5-18 5S13 50 8 47Z" fill="#647184"/>
                    </svg>
                @endif
            </div>

            <h1 class="reports-heading">
                @if ($filter === 'all') All Reports @else {{ $formatStatusLabel($filter) }} Reports @endif
            </h1>

            <section class="filter-panel" aria-label="Report filters">
                <div class="search-wrap">
                    <label class="sr-only" for="report-search">Search reports</label>
                    <input
                        id="report-search"
                        type="text"
                        wire:model.live.debounce.350ms="search"
                        placeholder="Search by name, email, case number, description"
                    />
                </div>

                <div class="filter-grid">
                    <div>
                        <label class="filter-label" for="filter-anonymous">Anonymous</label>
                        <select id="filter-anonymous" class="filter-input" wire:model.live="filterAnonymous">
                            <option value="">All</option>
                            <option value="1">Anonymous</option>
                            <option value="0">Identified</option>
                        </select>
                    </div>

                    <div>
                        <label class="filter-label" for="filter-name">Name / Surname</label>
                        <input
                            id="filter-name"
                            type="text"
                            class="filter-input {{ $filterAnonymous === '1' ? 'is-disabled' : '' }}"
                            wire:model.live.debounce.350ms="filterName"
                            placeholder="e.g Joe Smith"
                            @if($filterAnonymous === '1') disabled @endif
                            title="{{ $filterAnonymous === '1' ? 'Not available for anonymous reports' : '' }}"
                        />
                    </div>

                    <div>
                        <label class="filter-label" for="filter-grade">Grades</label>
                        <select id="filter-grade" class="filter-input" wire:model.live="filterGrade">
                            <option value="">All Grades</option>
                            @foreach($gradeOptions as $grade)
                                <option value="{{ $grade }}">{{ $grade }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-date">
                        <label class="filter-label" for="filter-date-from">Date From</label>
                        <input id="filter-date-from" type="date" class="filter-input" wire:model.live="filterDateFrom" />
                    </div>

                    <div class="filter-date">
                        <label class="filter-label" for="filter-date-to">Date To</label>
                        <input id="filter-date-to" type="date" class="filter-input" wire:model.live="filterDateTo" />
                    </div>

                    <div>
                        <label class="filter-label" for="filter-type">Report Type</label>
                        <select id="filter-type" class="filter-input" wire:model.live="filterType">
                            <option value="">All Types</option>
                            @foreach($typeOptions as $type)
                                <option value="{{ $type->id }}">{{ $type->type_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="filter-label" for="filter-subtype">Subtypes</label>
                        <select id="filter-subtype" class="filter-input" wire:model.live="filterSubtype">
                            <option value="">All Subtypes</option>
                            @foreach($subtypeOptions as $sub)
                                <option value="{{ $sub->id }}">{{ $sub->sub_type_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="filter-label" for="filter-status">Status</label>
                        <select id="filter-status" class="filter-input" wire:model.live="filterStatus">
                            <option value="">All Statuses</option>
                            <option value="awaiting-resolution">Awaiting Resolution</option>
                            <option value="under-review">Under Review</option>
                            <option value="forwarded">Forwarded</option>
                            <option value="closed">Closed</option>
                            <option value="unresolved">Unresolved</option>
                            <option value="false-report">False Report</option>
                        </select>
                    </div>

                    <div>
                        <span class="filter-label" aria-hidden="true">&nbsp;</span>
                        <button type="button" id="refreshBtn" wire:click="clearFilters">Refresh Table</button>
                    </div>
                </div>
            </section>

            <div class="reports-table-wrap">
                <table class="reports-table">
                    <thead>
                        <tr>
                            <th style="width: 12.18%;">Case Number</th>
                            <th style="width: 17.44%;">Full Name</th>
                            <th style="width: 12.56%;">Report Type</th>
                            <th style="width: 13.46%;">Grade</th>
                            <th style="width: 14.87%;">Status</th>
                            <th style="width: 9.36%;">Anonymous</th>
                            <th style="width: 8.72%;">Created At</th>
                            <th style="width: 11.41%;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reports as $report)
                            @php
                                $displayName = $report->is_anonymous
                                    ? 'Anonymous'
                                    : ($report->reporter_email ?: ($report->full_name ?: 'N/A'));
                            @endphp
                            <tr wire:click="showReport({{ $report->id }})">
                                <td class="case-number">{{ $report->case_number }}</td>
                                <td title="{{ $displayName }}">{{ $displayName }}</td>
                                <td>{{ $report->abuseType->type_name ?? 'N/A' }}</td>
                                <td>{{ $report->grade ?? 'N/A' }}</td>
                                <td>
                                    <span class="status-pill">{{ $formatStatusLabel($report->status) }}</span>
                                </td>
                                <td>{{ $report->is_anonymous ? 'YES' : 'NO' }}</td>
                                <td>{{ $report->created_at?->format('Y-m-d') ?? 'N/A' }}</td>
                                <td>
                                    <label class="sr-only" for="status-{{ $report->id }}">Update status for {{ $report->case_number }}</label>
                                    <select
                                        id="status-{{ $report->id }}"
                                        wire:change.stop="promptForStatusUpdate({{ $report->id }}, $event.target.value)"
                                        onclick="event.stopPropagation()"
                                        class="action-select"
                                    >
                                        <option value="">--Update--</option>
                                        <option value="awaiting-resolution">Awaiting Resolution</option>
                                        <option value="under-review">Under Review</option>
                                        <option value="forwarded">Forwarded</option>
                                        <option value="closed">Closed</option>
                                        <option value="unresolved">Unresolved</option>
                                        <option value="false-report">False Report</option>
                                    </select>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="height: 96px; color: #9ca3af;">
                                    No reports match your current filters.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($reports->hasPages())
                <nav class="reports-pagination" aria-label="Reports pagination">
                    @if ($reports->onFirstPage())
                        <span class="pagination-btn is-disabled" aria-disabled="true">←</span>
                    @else
                        <button type="button" wire:click="previousPage" class="pagination-btn" aria-label="Previous page">←</button>
                    @endif

                    @foreach ($reports->getUrlRange(1, $reports->lastPage()) as $page => $url)
                        @if ($page == $reports->currentPage())
                            <span class="pagination-btn active" aria-current="page">{{ $page }}</span>
                        @else
                            <button type="button" wire:click="gotoPage({{ $page }})" class="pagination-btn" aria-label="Go to page {{ $page }}">{{ $page }}</button>
                        @endif
                    @endforeach

                    @if ($reports->hasMorePages())
                        <button type="button" wire:click="nextPage" class="pagination-btn" aria-label="Next page">→</button>
                    @else
                        <span class="pagination-btn is-disabled" aria-disabled="true">→</span>
                    @endif
                </nav>
            @endif

            @if($selectedReport)
                <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 p-4">
                    <div class="bg-white p-6 rounded-lg border-[3px] border-[#c7da30] w-full max-w-4xl max-h-[90vh] overflow-auto shadow-2xl font-montserrat-regular">
                        <h2 class="text-2xl font-montserrat-bold text-black mb-6">Case Details: {{ $selectedReport->case_number }}</h2>

                        @if($selectedReport->blocked_at)
                            <div class="mb-6 bg-black border-l-4 border-red-600 p-4 rounded shadow-md">
                                <div class="flex items-center">
                                    <i class="fas fa-user-slash text-red-600 mr-3 text-xl"></i>
                                    <div>
                                        <h3 class="text-white font-bold uppercase text-xs tracking-widest">Reporter Permanently Blocked</h3>
                                        <p class="text-gray-300 text-xs">
                                            Action taken by Admin: <span class="text-[#c7da30] font-bold">{{ $selectedReport->blocked_by_name }}</span>
                                            on {{ \Carbon\Carbon::parse($selectedReport->blocked_at)->format('Y M d') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($selectedReport->status === 'false-report')
                            <div class="mb-6 bg-red-50 border-l-4 border-red-600 p-4 rounded shadow-sm">
                                <div class="flex items-center">
                                    <i class="fas fa-exclamation-triangle text-red-600 mr-3 text-xl"></i>
                                    <div>
                                        <h3 class="text-red-800 font-bold uppercase text-sm">Attention: This Report is Flagged</h3>
                                        <p class="text-red-700 text-xs font-semibold">Flag Reason: "{{ $selectedReport->latest_status_reason }}"</p>
                                        <p class="text-red-700 text-xs">The reporter has been notified and asked to provide a clarification statement.</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($selectedReport->reporter_clarification)
                            <div class="mb-6 bg-purple-50 border-l-4 border-purple-600 p-4 rounded shadow-sm">
                                <h3 class="text-purple-800 font-bold text-sm mb-2">Reporter's Clarification Statement:</h3>
                                <div class="text-gray-800 text-sm italic leading-relaxed bg-white p-3 rounded border border-purple-200">
                                    "{{ $selectedReport->reporter_clarification }}"
                                </div>
                            </div>
                        @endif

                        <div class="grid grid-cols-2 gap-4 text-sm text-black">
                            <p><strong>Email:</strong> {{ $selectedReport->reporter_email ?? 'Anonymous' }}</p>
                            <p><strong>Phone:</strong> {{ $selectedReport->phone_number ?? 'N/A' }}</p>
                            <p><strong>Type:</strong> {{ $selectedReport->abuseType->type_name ?? 'N/A' }}</p>
                            <p><strong>Subtype:</strong> {{ $selectedReport->subtype->sub_type_name ?? 'N/A' }}</p>
                            <p><strong>School:</strong> {{ $selectedReport->schoolName ?? $selectedReport->school_name ?? 'N/A' }}</p>
                            <p><strong>Grade:</strong> {{ $selectedReport->grade ?? 'N/A' }}</p>
                            <p class="col-span-2"><strong>Current Status:</strong> <span class="font-semibold">{{ $formatStatusLabel($selectedReport->status) }}</span></p>

                            @if($selectedReport->status === 'false-report' || $selectedReport->reporter_clarification)
                                <div class="col-span-2 mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 border-t pt-4">
                                    <div class="bg-gray-50 p-3 rounded-lg border-l-4 border-gray-400">
                                        <h4 class="text-xs font-bold text-gray-600 uppercase mb-1">Reason for Flagging:</h4>
                                        <p class="text-sm leading-relaxed text-gray-800">{{ $selectedReport->latest_status_reason ?? 'No reason provided.' }}</p>
                                    </div>
                                    <div class="bg-purple-50 p-3 rounded-lg border-l-4 border-purple-600">
                                        <h4 class="text-xs font-bold text-purple-800 uppercase mb-1">Reporter's Clarification:</h4>
                                        @if($selectedReport->reporter_clarification)
                                            <p class="text-sm italic leading-relaxed text-gray-800">"{{ $selectedReport->reporter_clarification }}"</p>
                                        @else
                                            <p class="text-sm text-purple-400 italic">The reporter has not responded yet.</p>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <p class="col-span-2 border-t pt-2">
                                    <strong>Latest Reason:</strong> {{ $selectedReport->latest_status_reason ?? 'No notes recorded.' }}
                                </p>
                            @endif
                        </div>

                        <div class="mt-6">
                            <p class="font-semibold mb-2">Description:</p>
                            <div class="p-4 rounded border-[3px] border-[#c7da30] text-sm text-black leading-relaxed">
                                {{ $selectedReport->description }}
                            </div>
                        </div>

                        @php
                            $attachments = $selectedReport->image_path ? json_decode($selectedReport->image_path, true) : [];
                        @endphp

                        @if (!empty($attachments))
                            <div class="mt-6">
                                <p class="font-semibold">Attachments:</p>
                                <div class="flex flex-wrap gap-4">
                                    @foreach ($attachments as $filePath)
                                        @php
                                            $ext       = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                                            $publicUrl = asset('storage/' . ltrim($filePath, '/'));
                                            $isImage   = in_array($ext, ['jpg','jpeg','png','gif','bmp','webp','svg']);
                                            $isVideo   = in_array($ext, ['mp4','mov','avi','wmv']);
                                        @endphp
                                        @if ($isImage)
                                            <img src="{{ $publicUrl }}" alt="Attachment"
                                                 class="w-32 h-auto mt-2 border rounded shadow cursor-pointer"
                                                 wire:click="showImage('{{ $filePath }}')">
                                        @elseif ($isVideo)
                                            <video controls class="w-48 h-auto mt-2 border rounded shadow">
                                                <source src="{{ $publicUrl }}" type="video/{{ $ext }}">
                                            </video>
                                        @else
                                            <a href="{{ $publicUrl }}" target="_blank" class="text-blue-600 underline inline-block mt-2">
                                                View {{ basename($filePath) }}
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <p class="mt-6"><strong>Attachment:</strong> N/A</p>
                        @endif

                        <div class="mt-6">
                            <label class="block text-sm font-medium mb-1">Update Status:</label>
                            <select wire:change.stop="promptForStatusUpdate({{ $selectedReport->id }}, $event.target.value)"
                                    class="w-full sm:w-1/2 border-[3px] border-[#c7da30] p-2 rounded-md shadow-sm text-sm">
                                <option value="awaiting-resolution" {{ $selectedReport->status == 'awaiting-resolution' ? 'selected' : '' }}>Awaiting Resolution</option>
                                <option value="under-review"        {{ $selectedReport->status == 'under-review'        ? 'selected' : '' }}>Under Review</option>
                                <option value="forwarded"           {{ $selectedReport->status == 'forwarded'           ? 'selected' : '' }}>Forwarded</option>
                                <option value="closed"              {{ $selectedReport->status == 'closed'              ? 'selected' : '' }}>Closed</option>
                                <option value="unresolved"          {{ $selectedReport->status == 'unresolved'          ? 'selected' : '' }}>Unresolved</option>
                                <option value="false-report"        {{ $selectedReport->status == 'false-report'        ? 'selected' : '' }}>False Report</option>
                            </select>
                        </div>

                        <div class="mt-6 flex justify-end items-end space-x-3">
                            @if($selectedReport->reporter_email)
                                <div class="flex flex-col items-center">
                                    <span class="text-[11px] font-bold text-red-600 mb-1 uppercase tracking-tighter">
                                        {{ $falseReportsCount }} Total False Reports
                                    </span>
                                    <button wire:click="permanentBlock('{{ $selectedReport->reporter_email }}')"
                                            wire:confirm="Are you sure? This will permanently prevent this email ({{ $selectedReport->reporter_email }}) from making future reports."
                                            class="bg-gradient-to-r from-[#c7da30] to-[#d7e47a] px-5 py-2 rounded-full font-montserrat text-black shadow-md">
                                        <i class="fas fa-user-slash mr-2"></i> Block Reporter
                                    </button>
                                </div>
                            @endif

                            <button wire:click="closeReport"
                                    class="bg-gradient-to-r from-[#c7da30] to-[#d7e47a] px-5 py-2 rounded-full font-montserrat text-black shadow-md">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            @if($modalImage)
                <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-70 z-50">
                    <img src="{{ asset('storage/' . $modalImage) }}" class="max-h-[90vh] max-w-[90vw] rounded-lg shadow-lg">
                    <button wire:click="closeImage"
                            class="absolute bottom-8 bg-gradient-to-r from-[#c7da30] to-[#d7e47a] px-5 py-2 rounded-full font-montserrat text-black">
                        Close
                    </button>
                </div>
            @endif

            @if($showReasonModal)
                <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 p-4">
                    <div class="bg-white p-6 rounded-lg border-[4px] border-[#c7da30] w-full max-w-lg shadow-2xl font-montserrat-regular">
                        @if($newStatus === 'false-report')
                            <h2 class="text-2xl font-montserrat-bold text-black mb-1">FLAGGING REPORT</h2>
                            <p class="mb-4 text-sm text-black">
                                You are changing <strong>{{ $reportToUpdate->case_number }}</strong> status from
                                <span class="font-semibold">{{ $formatStatusLabel($reportToUpdate->status) }}</span>
                                to <span class="font-semibold text-[#c7da30]">{{ $formatStatusLabel($newStatus) }}</span>.
                            </p>
                            <p class="text-xs text-gray-500 mb-4 font-bold uppercase tracking-wider">Note: This action marks the report as fraudulent.</p>
                            <div class="bg-lime-50 p-3 rounded border border-[#c7da30] mb-4 text-sm text-black">
                                <p><strong>Flagged By:</strong> {{ $adminName }}</p>
                                <p><strong>Date/Time:</strong> {{ $timestamp }}</p>
                            </div>
                        @else
                            <p class="mb-4 text-sm text-black">
                                You are changing <strong>{{ $reportToUpdate->case_number }}</strong> status from
                                <span class="font-semibold">{{ $formatStatusLabel($reportToUpdate->status) }}</span>
                                to <span class="font-semibold text-blue-700">{{ $formatStatusLabel($newStatus) }}</span>.
                            </p>
                        @endif

                        <form wire:submit.prevent="finalizeStatusUpdate">
                            <div class="mb-5">
                                <label class="block text-sm font-semibold text-black mb-1">
                                    {{ $newStatus === 'false-report' ? 'Reason for Flagging:' : 'Reason for Update:' }}
                                </label>
                                <textarea wire:model.defer="statusChangeReason"
                                          rows="5"
                                          placeholder="{{ $newStatus === 'false-report' ? 'Provide evidence or reason why this report is false...' : 'Enter reason...' }}"
                                          class="w-full border-[2px] border-[#c7da30] rounded-md p-3 text-sm text-black focus:outline-none focus:ring-2 focus:ring-lime-400 resize-none"></textarea>
                                @error('statusChangeReason')
                                    <p class="mt-1 text-sm text-red-600 font-bold">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex justify-end space-x-3">
                                <button type="button" wire:click="cancelUpdate"
                                        class="bg-gradient-to-r from-[#c7da30] to-[#d7e47a] px-6 py-2 rounded-full font-bold text-black shadow-md">
                                    Cancel
                                </button>
                                <button type="submit"
                                        class="bg-gradient-to-r from-[#c7da30] to-[#d7e47a] text-black px-6 py-2 rounded-full font-bold shadow-md">
                                    {{ $newStatus === 'false-report' ? 'Confirm Flagging' : 'Confirm & Update' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </main>
    </div>
</div>

@include('components.school-admin-sidebar-script')
<script src="https://kit.fontawesome.com/2c36e9b7b9.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    function exportPDF() {
        const element = document.getElementById('main-content');
        if (!element) return console.error("Main content not found!");
        html2pdf().from(element).set({
            margin: 10,
            filename: 'admin-reports.pdf',
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'mm', format: 'a3', orientation: 'landscape' }
        }).save();
    }
</script>
</div>
