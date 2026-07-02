<!DOCTYPE html>
<html lang="en" class="sa-app-root">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reports | Tekete SafeSpace – {{ $school->school_name ?? 'School Admin' }}</title>
    <x-favicon />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
:root {
    --theme-gradient: linear-gradient(to right, #38b6ff, #38b6ff);
    --black: #000000;
    --gray-light: #dadada;
    --gray-dark: #2a2e32;
    --lime: #c7da30;
}
* { box-sizing: border-box; margin: 0; padding: 0; }
html, body { font-family: 'Montserrat', sans-serif !important; color: #545454 !important; background-color: white !important; }
body { display: flex; min-height: 100vh; width: 100%; min-width: 0; overflow-x: hidden; overflow-y: hidden; }
.sidebar-link, button, select, input, label, textarea {
    font-size: 15px !important;
    font-family: 'Montserrat', sans-serif !important;
}
button:not(.menu-icon):not(.modal-close):not(.status-select) {
    background-color: white !important;
    color: #38b6ff !important;
    border: 3px solid #c7da30 !important;
    font-weight: 900 !important;
    padding: 0.75rem 1rem !important;
    border-radius: 0.5rem !important;
    cursor: pointer !important;
}
button:not(.menu-icon):not(.modal-close):hover { background-color: #c7da30 !important; color: white !important; }
.main-panel { flex: 1 1 0; display: flex; flex-direction: column; height: 100vh; min-width: 0; }
.topbar {
    width: 100%; background: white; border-bottom: 1px solid #eaeaea;
    display: flex; align-items: center; justify-content: flex-end;
    padding: 1rem 2.5rem; position: sticky; top: 0; z-index: 10;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08); min-height: 64px;
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
.profile .meta .role { font-weight: 400; color: #4a4a4a; font-size: 0.9rem; }
main { flex: 1; padding: 2.5rem; background: #fff; overflow-y: auto; min-width: 0; }
h1 {
    margin: 0 0 1.5rem; font-weight: 900 !important; font-size: 32px !important;
    letter-spacing: 0.03em; text-transform: uppercase !important; color: #545454 !important; text-align: center;
}
.table-wrap {
    width: 100%; max-width: 100%; overflow-x: auto; overflow-y: hidden;
    -webkit-overflow-scrolling: touch; border: 3px solid #c7da30;
    border-radius: 0.375rem; background: var(--gray-light);
}
.table-wrap table { width: max-content; min-width: 100%; border: 0; background: transparent; }
table { width: 100%; border-collapse: collapse; font-size: 0.9rem; color: var(--black); table-layout: fixed; }
thead { background: #bbc93dff; color: black; text-transform: uppercase; letter-spacing: 0.05em; font-size: 0.75rem; }
th, td { padding: 0.9rem 1rem; border-bottom: 1px solid var(--lime); text-align: left; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
tbody tr:hover { background: rgba(199,218,48,0.15); transition: background-color 0.3s ease; }
tbody tr:last-child td { border-bottom: none; }
.status-badge {
    display: inline-flex; align-items: center; justify-content: center;
    padding: 0.4rem 0.8rem; border-radius: 16px; font-size: 0.8rem; font-weight: 700; white-space: nowrap;
}
.status-awaiting-resolution { background: #fef3c7; color: #92400e; border: 1px solid #fcd34d; }
.status-under-review { background: #dbeafe; color: #1e40af; border: 1px solid #93c5fd; }
.status-forwarded { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
.status-closed { background: #dcfce7; color: #166534; border: 1px solid #86efac; }
.status-unresolved { background: #f3f4f6; color: #374151; border: 1px solid #d1d5db; }
.status-false-report { background: #f3e8ff; color: #6b21a8; border: 1px solid #e9d5ff; }
.status-select {
    width: 100%; max-width: 160px; border: 2px solid #e5e7eb !important;
    border-radius: 8px; padding: 6px 8px !important; font-size: 12px !important;
    font-weight: 600 !important; background: white !important; color: #111 !important;
}
.pagination { display: flex; justify-content: center; margin-top: 1rem; flex-wrap: wrap; gap: 4px; }
.page-link {
    border: 1px solid #cddc39; color: black; border-radius: 50%;
    width: 35px; height: 35px; text-align: center; line-height: 32px;
    transition: all 0.3s ease; display: inline-block; text-decoration: none;
}
.page-link:hover { background: #cddc39; color: white; }
.modal-backdrop {
    position: fixed; inset: 0; background: rgba(0,12,12,0.42);
    display: none; align-items: center; justify-content: center; z-index: 1100;
}
.modal-card {
    background: #fff; border: 2.5px solid #d7e47a; border-radius: 16px;
    width: 900px; max-width: 95vw; max-height: 90vh; overflow-y: auto;
    box-shadow: 0 6px 40px rgba(46,56,64,0.18); position: relative;
    font-family: 'Montserrat', sans-serif; color: #333;
}
.modal-close {
    display: inline-flex !important; justify-content: center !important; align-items: center !important;
    background: white !important; border: 3px solid #cddc39 !important; color: #38b6ff !important;
    font-size: 14px !important; border-radius: 16px !important; cursor: pointer !important;
    padding: 8px 20px !important; margin: 0 !important;
}
.modal-close:hover { background: #38b6ff !important; color: white !important; }
.modal-content { padding: 2rem; }
.modal-content h3 { font-size: 1.4rem; font-weight: 700; margin-bottom: 1.5rem; border-bottom: 2px solid #e6eea1; padding-bottom: 0.8rem; }
.modal-content p { margin-bottom: 0.55rem; font-size: 1rem; }
.modal-content strong { width: 140px; display: inline-block; font-weight: 600; }
#modalDescription { background: #fff; border-radius: 6px; padding: 0.75rem; border: 3px solid #cddc39; margin-bottom: 1rem; white-space: pre-wrap; }
.alert-banner { padding: 0.75rem 1rem; border-radius: 8px; margin-bottom: 1rem; font-size: 0.9rem; }
.alert-banner.danger { background: #fef2f2; border-left: 4px solid #dc2626; color: #991b1b; }
.alert-banner.blocked { background: #111; border-left: 4px solid #dc2626; color: #fff; }
.modal-actions { display: flex; flex-wrap: wrap; gap: 12px; justify-content: flex-end; align-items: center; margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid #e5e7eb; }
.filter-panel { background: #f9fafb; border: 2px solid #e5e7eb; border-radius: 12px; padding: 18px 20px; margin-bottom: 24px; }
.filter-label { font-size: 11px !important; font-weight: 700 !important; color: #6b7280 !important; text-transform: uppercase; letter-spacing: 0.07em; margin-bottom: 5px; display: block; }
.filter-input {
    width: 100%; border: 2px solid #e5e7eb !important; border-radius: 8px;
    padding: 7px 10px !important; font-size: 13px !important; color: #111 !important;
    background: white !important; outline: none; box-sizing: border-box; font-weight: 400 !important; margin: 0 !important;
}
.filter-input:focus { border-color: #c7da30 !important; box-shadow: 0 0 0 3px rgba(199,218,48,0.15); }
.search-wrap { position: relative; margin-bottom: 18px; }
.search-wrap input {
    width: 100%; border: 2px solid #c7da30 !important; border-radius: 30px;
    padding: 10px 20px 10px 44px !important; font-size: 14px !important; outline: none;
}
.search-icon { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #aaa; pointer-events: none; }
.filter-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 12px; align-items: end; }
#refreshBtn {
    width: 100%; background: #38b6ff !important; color: white !important; border: none !important;
    border-radius: 8px !important; padding: 8px 14px !important; font-size: 12px !important;
    font-weight: 700 !important; cursor: pointer; height: 36px; margin: 0 !important;
}
#refreshBtn:hover { background: #1a9fe0 !important; }
.active-filter-badge {
    display: inline-flex; align-items: center; background: #f0f9d4; border: 1px solid #c7da30;
    border-radius: 20px; padding: 2px 10px; font-size: 11px; font-weight: 600; color: #4a5e00;
    margin-right: 6px; margin-bottom: 6px;
}
.reason-modal-card {
    background: #fff; border: 4px solid #c7da30; border-radius: 16px;
    width: 520px; max-width: 95vw; padding: 1.5rem; box-shadow: 0 8px 32px rgba(0,0,0,0.15);
}
.reason-modal-card textarea {
    width: 100%; border: 2px solid #c7da30; border-radius: 8px; padding: 0.75rem;
    font-size: 14px; resize: vertical; min-height: 120px; margin-top: 0.5rem;
}
.reason-error { color: #dc2626; font-size: 0.85rem; margin-top: 0.35rem; display: none; }
@media (max-width: 900px) {
    main { padding: 1.25rem; }
    .filter-grid { grid-template-columns: 1fr 1fr !important; }
    h1 { font-size: 26px !important; }
}
@media (max-width: 540px) { .filter-grid { grid-template-columns: 1fr !important; } }
    </style>
    <x-school-admin-styles />
</head>
<body class="sa-app">

<div class="modal-backdrop" id="reportModal" aria-hidden="true" style="display:none;">
    <div class="modal-card" role="dialog" aria-modal="true">
        <div class="modal-content">
            <h3>Report Details: <span id="modalCaseNumber"></span></h3>
            <div id="modalBlockedBanner" class="alert-banner blocked" style="display:none;"></div>
            <div id="modalFalseBanner" class="alert-banner danger" style="display:none;"></div>
            <p><strong>Full Name:</strong> <span id="modalFullName"></span></p>
            <p><strong>Email:</strong> <span id="modalEmail"></span></p>
            <p><strong>Phone:</strong> <span id="modalPhone"></span></p>
            <p><strong>Report Type:</strong> <span id="modalType"></span></p>
            <p><strong>Subtype:</strong> <span id="modalSubtype"></span></p>
            <p><strong>Grade:</strong> <span id="modalGrade"></span></p>
            <p><strong>Status:</strong> <span id="modalStatus"></span></p>
            <p><strong>Latest Reason:</strong> <span id="modalReason"></span></p>
            <p><strong>Description:</strong></p>
            <div id="modalDescription"></div>
            <p><strong>Attachments:</strong></p>
            <div id="modalAttachments"></div>
            <div style="margin-top:1rem;">
                <label class="filter-label" for="modalStatusSelect">Update Status</label>
                <select id="modalStatusSelect" class="filter-input" style="max-width:280px;">
                    <option value="awaiting-resolution">Awaiting Resolution</option>
                    <option value="under-review">Under Review</option>
                    <option value="forwarded">Forwarded</option>
                    <option value="closed">Closed</option>
                    <option value="unresolved">Unresolved</option>
                    <option value="false-report">False Report</option>
                </select>
            </div>
            <div class="modal-actions">
                <div id="blockReporterWrap" style="display:none;">
                    <span id="falseReportsCountLabel" style="font-size:11px;font-weight:700;color:#dc2626;display:block;margin-bottom:4px;"></span>
                    <button type="button" id="blockReporterBtn" class="modal-close" style="background:#c7da30 !important;color:#000 !important;">Block Reporter</button>
                </div>
                <button type="button" class="modal-close" onclick="closeReportModal()">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal-backdrop" id="reasonModal" aria-hidden="true" style="display:none;">
    <div class="reason-modal-card" role="dialog" aria-modal="true">
        <h3 id="reasonModalTitle" style="margin-bottom:0.75rem;font-weight:900;">Update Status</h3>
        <p id="reasonModalText" style="font-size:0.9rem;margin-bottom:1rem;"></p>
        <label class="filter-label" for="statusChangeReason">Reason</label>
        <textarea id="statusChangeReason" placeholder="Enter reason (at least 10 characters)…"></textarea>
        <p class="reason-error" id="reasonError"></p>
        <div class="modal-actions">
            <button type="button" class="modal-close" onclick="cancelStatusUpdate()">Cancel</button>
            <button type="button" class="modal-close" id="confirmStatusBtn" style="background:#38b6ff !important;color:#fff !important;border-color:#38b6ff !important;">Confirm</button>
        </div>
    </div>
</div>

<x-school-admin-sidebar />

<div class="main-panel">
    <button class="menu-icon" id="sidebarToggle" aria-label="Open navigation menu" aria-expanded="false" aria-controls="sa-sidebar" type="button">&#9776;</button>
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
        <p style="text-align:center;color:#6b7280;margin-bottom:1.5rem;font-size:0.95rem;">{{ $school->school_name }}</p>

        <form id="filterForm" method="GET" action="{{ url('/admin/reports') }}">
            <div class="filter-panel">
                <div class="search-wrap">
                    <span class="search-icon"><i class="fas fa-search"></i></span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, email, case number, description…" autocomplete="off" />
                </div>
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
                        <input type="text" name="full_name" class="filter-input" value="{{ request('full_name') }}" placeholder="e.g. John Smith" id="fullNameInput" />
                    </div>
                    <div>
                        <label class="filter-label">Grade</label>
                        <select name="grade" class="filter-input" onchange="this.form.submit()">
                            <option value="">All Grades</option>
                            @foreach($gradeOptions as $grade)
                                <option value="{{ $grade }}" {{ request('grade') == $grade ? 'selected' : '' }}>{{ $grade }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="filter-label">Date From</label>
                        <input type="date" name="date_from" class="filter-input" value="{{ request('date_from') }}" onchange="this.form.submit()" />
                    </div>
                    <div>
                        <label class="filter-label">Date To</label>
                        <input type="date" name="date_to" class="filter-input" value="{{ request('date_to') }}" onchange="this.form.submit()" />
                    </div>
                    <div>
                        <label class="filter-label">Report Type</label>
                        <select name="type_id" class="filter-input" onchange="document.getElementById('subtypeSelect').value=''; this.form.submit();">
                            <option value="">All Types</option>
                            @foreach($typeOptions as $type)
                                <option value="{{ $type->id }}" {{ request('type_id') == $type->id || request('abuse_type_id') == $type->id ? 'selected' : '' }}>{{ $type->type_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="filter-label">Subtype</label>
                        <select name="subtype_id" id="subtypeSelect" class="filter-input" onchange="this.form.submit()">
                            <option value="">All Subtypes</option>
                            @foreach($subtypeOptions as $sub)
                                <option value="{{ $sub->id }}" data-type="{{ $sub->abuse_type_id }}" {{ request('subtype_id') == $sub->id ? 'selected' : '' }}>{{ $sub->sub_type_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="filter-label">Status</label>
                        <select name="status" class="filter-input" onchange="this.form.submit()">
                            <option value="">All Statuses</option>
                            @foreach(['awaiting-resolution' => 'Awaiting Resolution', 'under-review' => 'Under Review', 'forwarded' => 'Forwarded', 'closed' => 'Closed', 'unresolved' => 'Unresolved', 'false-report' => 'False Report'] as $val => $label)
                                <option value="{{ $val }}" {{ request('status') == $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="display:flex;align-items:flex-end;">
                        <button type="button" id="refreshBtn">Refresh Table</button>
                    </div>
                </div>

                @php
                    $activeFilters = array_filter([
                        'Search'    => request('search'),
                        'Name'      => request('full_name'),
                        'Grade'     => request('grade'),
                        'From'      => request('date_from'),
                        'To'        => request('date_to'),
                        'Type'      => request('type_id') || request('abuse_type_id')
                            ? ($typeOptions->firstWhere('id', request('type_id') ?: request('abuse_type_id'))?->type_name ?? '')
                            : null,
                        'Subtype'   => request('subtype_id')
                            ? ($subtypeOptions->firstWhere('id', request('subtype_id'))?->sub_type_name ?? request('subtype_id'))
                            : null,
                        'Status'    => request('status') ? ucfirst(str_replace('-', ' ', request('status'))) : null,
                        'Anonymous' => request('is_anonymous') !== null && request('is_anonymous') !== ''
                            ? (request('is_anonymous') === '1' ? 'Yes' : 'No') : null,
                    ]);
                @endphp
                @if(count($activeFilters))
                    <div style="margin-top:12px;display:flex;flex-wrap:wrap;align-items:center;">
                        @foreach($activeFilters as $label => $val)
                            <span class="active-filter-badge">{{ $label }}: {{ $val }}</span>
                        @endforeach
                        <span style="font-size:11px;color:#9ca3af;margin-left:4px;">— {{ $reports->total() }} result(s)</span>
                    </div>
                @endif
            </div>
        </form>

        <div class="table-wrap">
            <table aria-label="List of filtered reports">
                <thead>
                    <tr>
                        <th>Case Number</th>
                        <th>Full Name</th>
                        <th>Report Type</th>
                        <th>Grade</th>
                        <th>Status</th>
                        <th>Anonymous</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reports as $report)
                        <tr>
                            <td onclick="openReportModal({{ $report->id }})" style="cursor:pointer;">{{ $report->case_number ?? 'N/A' }}</td>
                            <td onclick="openReportModal({{ $report->id }})" style="cursor:pointer;">{{ $report->full_name ?? 'Anonymous' }}</td>
                            <td onclick="openReportModal({{ $report->id }})" style="cursor:pointer;">{{ $report->abuseType->type_name ?? 'N/A' }}</td>
                            <td onclick="openReportModal({{ $report->id }})" style="cursor:pointer;">{{ $report->grade ?? 'N/A' }}</td>
                            <td onclick="openReportModal({{ $report->id }})" style="cursor:pointer;">
                                <span class="status-badge status-{{ str_replace('_', '-', $report->status) }}">
                                    {{ ucfirst(str_replace('-', ' ', $report->status)) }}
                                </span>
                            </td>
                            <td onclick="openReportModal({{ $report->id }})" style="cursor:pointer;">{{ $report->is_anonymous ? 'Yes' : 'No' }}</td>
                            <td onclick="openReportModal({{ $report->id }})" style="cursor:pointer;">{{ $report->created_at->format('Y M d') }}</td>
                            <td>
                                <select class="status-select" onchange="promptStatusUpdate({{ $report->id }}, this.value, '{{ $report->case_number }}', '{{ $report->status }}'); this.value='';" onclick="event.stopPropagation();">
                                    <option value="">Update</option>
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
                            <td colspan="8" style="text-align:center;padding:1rem;">No reports found for this filter.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination">
            @if ($reports->onFirstPage())
                <span class="page-link" aria-disabled="true">←</span>
            @else
                <a href="{{ $reports->previousPageUrl() }}" class="page-link" rel="prev">←</a>
            @endif
            @foreach ($reports->getUrlRange(1, $reports->lastPage()) as $page => $url)
                @if ($page == $reports->currentPage())
                    <span class="page-link" style="background:#cddc39;font-weight:bold;">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                @endif
            @endforeach
            @if ($reports->hasMorePages())
                <a href="{{ $reports->nextPageUrl() }}" class="page-link" rel="next">→</a>
            @else
                <span class="page-link" aria-disabled="true">→</span>
            @endif
        </div>
    </main>
</div>

<x-school-admin-sidebar-script />
<script src="https://kit.fontawesome.com/2c36e9b7b9.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
let pendingStatusUpdate = { reportId: null, newStatus: null, caseNumber: null, oldStatus: null };
let currentReportId = null;
let currentReportStatus = null;

function showToast(message, type) {
    type = type || 'success';
    const colors = {
        success: { bg: '#f0fdf4', border: '#4ade80', text: '#166534' },
        danger:  { bg: '#fef2f2', border: '#f87171', text: '#991b1b' },
    };
    const c = colors[type] || colors.success;
    const toast = document.createElement('div');
    toast.style.cssText = 'position:fixed;bottom:24px;right:24px;z-index:9999;padding:14px 18px;border-radius:12px;font-size:14px;max-width:360px;box-shadow:0 4px 12px rgba(0,0,0,0.08);background:' + c.bg + ';color:' + c.text + ';border:1px solid ' + c.border;
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 4500);
}

function formatStatus(status) {
    return status ? status.replace(/-/g, ' ').replace(/\b\w/g, c => c.toUpperCase()) : 'N/A';
}

function openReportModal(reportId) {
    currentReportId = reportId;
    fetch('/admin/reports/' + reportId, { headers: { 'Accept': 'application/json' } })
    .then(r => { if (!r.ok) throw new Error(); return r.json(); })
    .then(report => {
        document.getElementById('modalCaseNumber').textContent = report.case_number || 'N/A';
        document.getElementById('modalFullName').textContent = report.full_name || 'Anonymous';
        document.getElementById('modalEmail').textContent = report.reporter_email || 'Anonymous';
        document.getElementById('modalPhone').textContent = report.phone_number || 'N/A';
        document.getElementById('modalType').textContent = report.abuseType || 'N/A';
        document.getElementById('modalSubtype').textContent = report.subtype || 'N/A';
        document.getElementById('modalGrade').textContent = report.grade || 'N/A';
        document.getElementById('modalStatus').textContent = formatStatus(report.status);
        document.getElementById('modalReason').textContent = report.latest_status_reason || 'No status history recorded.';
        document.getElementById('modalDescription').textContent = report.description || '';
        currentReportStatus = report.status || 'awaiting-resolution';
        document.getElementById('modalStatusSelect').value = currentReportStatus;

        const blockedBanner = document.getElementById('modalBlockedBanner');
        const falseBanner = document.getElementById('modalFalseBanner');
        const blockWrap = document.getElementById('blockReporterWrap');
        blockedBanner.style.display = report.blocked_at ? 'block' : 'none';
        if (report.blocked_at) {
            blockedBanner.textContent = 'Reporter permanently blocked by ' + (report.blocked_by_name || 'Admin') + ' on ' + report.blocked_at;
        }
        falseBanner.style.display = report.status === 'false-report' ? 'block' : 'none';
        if (report.status === 'false-report') {
            falseBanner.textContent = 'Flagged: ' + (report.latest_status_reason || 'No reason recorded.');
        }

        if (report.reporter_email && report.reporter_email !== 'Anonymous') {
            blockWrap.style.display = 'block';
            document.getElementById('falseReportsCountLabel').textContent = (report.false_reports_count || 0) + ' total false reports';
        } else {
            blockWrap.style.display = 'none';
        }

        const attachmentSpan = document.getElementById('modalAttachments');
        attachmentSpan.innerHTML = '';
        if (report.attachments && report.attachments.length) {
            report.attachments.forEach(filePath => {
                const ext = filePath.split('.').pop().toLowerCase();
                const publicUrl = '/storage/' + filePath.replace(/^\/+/, '');
                let elem;
                if (['jpg','jpeg','png','gif','bmp','webp','svg'].includes(ext)) {
                    elem = document.createElement('img');
                    elem.src = publicUrl;
                    elem.style.cssText = 'width:80px;height:80px;margin-right:8px;border:2px solid #c7da30;border-radius:8px;object-fit:cover;';
                } else {
                    elem = document.createElement('a');
                    elem.href = publicUrl;
                    elem.target = '_blank';
                    elem.textContent = filePath.split('/').pop();
                    elem.style.cssText = 'color:#4c8eda;margin-right:10px;';
                }
                attachmentSpan.appendChild(elem);
            });
        } else {
            attachmentSpan.textContent = 'N/A';
        }

        document.getElementById('reportModal').style.display = 'flex';
        document.getElementById('reportModal').setAttribute('aria-hidden', 'false');
    })
    .catch(() => showToast('Failed to load report details.', 'danger'));
}

function closeReportModal() {
    document.getElementById('reportModal').style.display = 'none';
    document.getElementById('reportModal').setAttribute('aria-hidden', 'true');
    currentReportId = null;
    currentReportStatus = null;
}

function promptStatusUpdate(reportId, newStatus, caseNumber, oldStatus) {
    if (!newStatus || newStatus === oldStatus) return;
    pendingStatusUpdate = { reportId, newStatus, caseNumber, oldStatus };
    const isFalse = newStatus === 'false-report';
    document.getElementById('reasonModalTitle').textContent = isFalse ? 'Flagging Report' : 'Update Status';
    document.getElementById('reasonModalText').textContent =
        'Changing ' + caseNumber + ' from ' + formatStatus(oldStatus) + ' to ' + formatStatus(newStatus) + '.';
    document.getElementById('statusChangeReason').value = '';
    document.getElementById('reasonError').style.display = 'none';
    document.getElementById('confirmStatusBtn').textContent = isFalse ? 'Confirm Flagging' : 'Confirm & Update';
    document.getElementById('reasonModal').style.display = 'flex';
    document.getElementById('reasonModal').setAttribute('aria-hidden', 'false');
}

function cancelStatusUpdate() {
    pendingStatusUpdate = { reportId: null, newStatus: null, caseNumber: null, oldStatus: null };
    document.getElementById('reasonModal').style.display = 'none';
    document.getElementById('reasonModal').setAttribute('aria-hidden', 'true');
}

function submitStatusUpdate() {
    const reason = document.getElementById('statusChangeReason').value.trim();
    const errorEl = document.getElementById('reasonError');
    if (reason.length < 10) {
        errorEl.textContent = 'Please provide at least 10 characters.';
        errorEl.style.display = 'block';
        return;
    }
    if (!pendingStatusUpdate.reportId) return;

    fetch('/admin/reports/' + pendingStatusUpdate.reportId + '/status', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify({ status: pendingStatusUpdate.newStatus, reason: reason }),
    })
    .then(async r => {
        const data = await r.json();
        if (!r.ok) {
            const msg = (data.errors && data.errors.reason && data.errors.reason[0])
                || data.message || 'Update failed';
            throw new Error(msg);
        }
        return data;
    })
    .then(data => {
        cancelStatusUpdate();
        closeReportModal();
        showToast(data.message || 'Status updated.', 'success');
        setTimeout(() => window.location.reload(), 800);
    })
    .catch(err => {
        errorEl.textContent = err.message || 'Failed to update status.';
        errorEl.style.display = 'block';
    });
}

document.getElementById('confirmStatusBtn').addEventListener('click', submitStatusUpdate);
document.getElementById('modalStatusSelect').addEventListener('change', function () {
    if (!currentReportId || !currentReportStatus) return;
    const newStatus = this.value;
    if (!newStatus || newStatus === currentReportStatus) return;
    const caseNum = document.getElementById('modalCaseNumber').textContent;
    promptStatusUpdate(currentReportId, newStatus, caseNum, currentReportStatus);
    this.value = currentReportStatus;
});

document.getElementById('blockReporterBtn').addEventListener('click', function () {
    if (!currentReportId || !confirm('Permanently block this reporter from future reports?')) return;
    fetch('{{ route('admin.reports.block-reporter') }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
        body: JSON.stringify({ report_id: currentReportId }),
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) { showToast(data.message, 'success'); setTimeout(() => window.location.reload(), 800); }
        else showToast(data.message || 'Block failed.', 'danger');
    })
    .catch(() => showToast('Block request failed.', 'danger'));
});

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') { closeReportModal(); cancelStatusUpdate(); }
});

document.addEventListener('DOMContentLoaded', function () {
    const filterForm = document.getElementById('filterForm');
    let debounce = null;
    if (filterForm) {
        filterForm.querySelectorAll('input[name="search"], input[name="full_name"]').forEach(input => {
            input.addEventListener('input', () => {
                clearTimeout(debounce);
                debounce = setTimeout(() => filterForm.submit(), 500);
            });
        });
        document.getElementById('refreshBtn').addEventListener('click', () => {
            window.location.href = '{{ url('/admin/reports') }}';
        });
    }

    const anonSelect = document.querySelector('select[name="is_anonymous"]');
    const nameInput = document.getElementById('fullNameInput');
    function syncAnonName() {
        if (!anonSelect || !nameInput) return;
        const disabled = anonSelect.value === '1';
        nameInput.disabled = disabled;
        nameInput.style.opacity = disabled ? '0.4' : '1';
    }
    if (anonSelect) { anonSelect.addEventListener('change', syncAnonName); syncAnonName(); }

    function filterSubtypes() {
        const typeId = document.querySelector('select[name="type_id"]')?.value;
        document.querySelectorAll('#subtypeSelect option[data-type]').forEach(opt => {
            opt.hidden = typeId && opt.dataset.type !== typeId;
        });
    }
    filterSubtypes();
});

function exportPDF() {
    const element = document.getElementById('main-content');
    if (!element) { showToast('Main content not found.', 'danger'); return; }
    html2pdf().from(element).set({
        margin: 10, filename: 'school-admin-reports.pdf',
        html2canvas: { scale: 2 }, jsPDF: { unit: 'mm', format: 'a3', orientation: 'landscape' }
    }).save();
}
</script>
@if(session('success_message'))
<script>document.addEventListener('DOMContentLoaded', () => showToast(@js(session('success_message')), 'success'));</script>
@endif
</body>
</html>
