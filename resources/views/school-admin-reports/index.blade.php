<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <title>Reports | Tekete SafeSpace – {{ $school->school_name ?? 'School Admin' }}</title>
    <x-favicon />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400&display=swap" rel="stylesheet">
    <style>
:root {
   --theme-gradient:  linear-gradient(to right, #38b6ff, #38b6ff); --black: #000000; --gray-light: #dadada; --gray-dark: #2a2e32;
    --offwhite: #fffbf7;
}

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
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
}

.sidebar-logo { position: fixed; top: 40px; left: 40px; width: 100px; height: auto; }
.sidebar-logo img { width: 90px; height: auto; max-width: 100%; display: block; }

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

button:hover, .sidebar-link:hover, .sidebar-link.active {
  color: #fff !important;
  background: linear-gradient(to right, #38b6ff, #38b6ff) !important;
}

button {
  background-color: white !important;
  color: #38b6ff !important;
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
  color: white !important;
  border-color: #38b6ff !important;
  outline: none;
}

.main-panel {
    flex: 1 1 0;
    display: flex;
    flex-direction: column;
    height: 100vh;
    min-width: 0;
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
    color: #4a4a4a;
    font-size: 0.9rem;
}

main {
    flex: 1;
    padding: 2.5rem;
    background: #fff;
    overflow-y: auto;
    min-width: 0;
}

h1 {
    margin: 0 0 0.5rem;
   font-weight: 900 !important;
  font-size: 32px  !important;
   font-family: 'Montserrat', sans-serif !important;
    letter-spacing: 0.03em;
    text-transform: uppercase !important;
  color: #545454 !important;
    text-align: center;
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
table { width: 100%; border-collapse: collapse; font-size: 0.9rem; color: var(--black); font-family: 'Montserrat', sans-serif; table-layout: fixed; }

thead {
     background: #bbc93dff;
    color: black;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    font-size: 0.75rem;
}

th, td {
    padding: 0.9rem 1rem;
    border-bottom: 1px solid var(--lime);
    text-align: left;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

tbody tr:hover {
    background: rgba(199, 218, 48, 0.15);
    cursor: pointer;
    transition: background-color 0.3s ease;
}

tbody tr:last-child td {
    border-bottom: none;
}

.pagination {
    display: flex;
    justify-content: center;
    margin-top: 1rem;
}

.page-item.active .page-link {
    background: #cddc39;
    border-color: #cddc39;
    color: black;
}

.page-link {
    border: 1px solid #cddc39;
    color: black;
    border-radius: 50%;
    width: 35px;
    height: 35px;
    text-align: center;
    line-height: 32px;
    margin: 0 4px;
    transition: all 0.3s ease;
}

.page-link:hover {
    background: #cddc39;
    color: white;
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

.modal-card {
    background: #fff;
    border: 2.5px solid #d7e47a;
    border-radius: 16px;
    width: 900px;
    max-width: 95vw;
    box-shadow: 0 6px 40px rgba(46,56,64,0.18),
                0 1.5px 3px rgba(140,160,145,0.05);
    padding: 0;
    position: relative;
    font-family: 'Montserrat', sans-serif;
    color: #333;
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

.modal-close:hover,
.modal-close:focus {
    background: linear-gradient(to right, #74b9ff, #74b9ff) !important;
    color: white !important;
    border-color: #74b9ff !important;
}

.modal-content {
    padding: 2.2rem 2.2rem 1.7rem 2.2rem;
    border-radius: 12px;
    border: none;
}

.modal-content h3, #modalTitle {
    font-size: 1.4rem;
    font-weight: 700;
    margin-top: 0.4rem;
    margin-bottom: 2rem;
    color: #232b0b;
    text-align: left;
    letter-spacing: 0.018em;
    border-bottom: 2px solid #e6eea1;
    padding-bottom: 0.8rem;
}

.modal-content p {
    margin-bottom: 0.55rem;
    font-size: 1.01rem;
    display: flex;
    align-items: baseline;
}

.modal-content strong {
    width: 138px;
    display: inline-block;
    color: #222 !important;
    font-weight: 600;
}

#modalReason {
    color: #865c0b;
    font-size: 0.98rem;
    font-style: italic;
}

#modalDescription {
    background: #fff;
    min-height: 1.85em;
    border-radius: 6px;
    padding: 0.55rem 0.75rem;
    color: #636c0b;
    font-size: 1.06rem;
    margin-bottom: 1rem;
    border: 3px solid #cddc39
}

#modalAttachments img,
#modalAttachments video {
    border: 2px solid #c7da30;
    border-radius: 7px;
    width: 80px !important;
    height: 80px !important;
    object-fit: cover;
    margin-right: 8px;
}

.modal-content select,
.modal-content textarea,
.modal-content input {
    display: none !important;
}

::-webkit-scrollbar {
    width: 8px;
}
::-webkit-scrollbar-thumb {
    background: var(--lime);
    border-radius: 10px;
}
::-webkit-scrollbar-track {
    background: #f2f2f2;
}

@keyframes toastSlideUp {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
}

@media (max-width: 900px) {
    main { padding: 1.5rem; }
    #searchForm { flex-direction: column; align-items: stretch !important; }
    #searchForm input { width: 100% !important; max-width: 100% !important; }
    #searchForm button { width: 100% !important; }
}
    </style>
    @include('components.school-admin-styles')
    <link rel="stylesheet" href="{{ asset('css/school-admin-mobile.css') }}">
</head>
<body class="sa-app">
@include('components.school-admin-sidebar')

    <div class="main-panel">
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
                    <span>
                        {{ $firstName }} {{ $surname }}
                    </span>
                    <span class="role">
                        Administrator
                    </span>
                </div>
                <div class="profile-avatar">
                    @php
                        $currentUser = auth()->user()->fresh();
                    @endphp
                    @if($currentUser && $currentUser->profile_picture)
                      <img src="{{ $currentUser->profile_picture_url }}" alt="Profile Picture" class="profile-pic">
                    @endif
                </div>
            </div>
        </div>

        <main id="main-content">
            <h1>Reports</h1>
            <form id="searchForm" method="GET" action="{{ url('/admin/reports') }}" style="margin-bottom: 1rem; display: flex; gap: 8px; justify-content: center; align-items: center;">
                <input
                    type="text"
                    name="case_number"
                    placeholder="Search by Case Number"
                    value="{{ request('case_number') }}"
                    style="padding: 0.5rem 0.75rem; border: 2px solid #c7da30; border-radius: 0.375rem; font-family: 'Montserrat', sans-serif; font-size: 1rem; width: min(440px, 100%); max-width: 100%; box-sizing: border-box;"
                    aria-label="Search by Case Number"
                >
                <button
                    type="submit"
                    style="background: #38b6ff; color: white; border: none; border-radius: 0.375rem; padding: 0.5rem 1rem; font-weight: 600; cursor: pointer;"
                    aria-label="Search"
                >
                    Search
                </button>
                <button
                    type="button"
                    id="refreshBtn"
                    style="background: #38b6ff; color: white; border: none; border-radius: 0.375rem; padding: 0.5rem 1rem; font-weight: 600; cursor: pointer;"
                    aria-label="Refresh"
                >
                    Refresh
                </button>
            </form>

            <div class="table-wrap">
                <table aria-label="List of filtered reports">
                    <thead>
                        <tr>
                            <th>Case Number</th>
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
                            <td>{{ $report->abuseType->type_name ?? 'N/A' }}</td>
                            <td>{{ ucfirst(str_replace('-', ' ', $report->status)) }}</td>
                            <td>{{ $report->is_anonymous ? 'Yes' : 'No' }}</td>
                            <td>{{ $report->created_at->format('Y M d') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align:center; padding: 1rem;">No reports found for this filter.</td>
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
                        <span class="page-link" style="background: #cddc39; font-weight: bold;">{{ $page }}</span>
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

    <div class="modal-backdrop" id="reportModal" aria-hidden="true" style="display:none;">
        <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="modalTitle" aria-describedby="modalDescription">
            <button type="button" class="modal-close" aria-label="Close" onclick="closeReportModal()">&times;</button>
            <div class="modal-content">
                <h3 id="modalTitle" style="margin-bottom:1rem;">Report Details: <span id="modalCaseNumber"></span></h3>
                <p><strong>Email:</strong> <span id="modalEmail"></span></p>
                <p><strong>Phone:</strong> <span id="modalPhone"></span></p>
                <p><strong>Report Type:</strong> <span id="modalType"></span></p>
                <p><strong>Subtype:</strong> <span id="modalSubtype"></span></p>
                <p><strong>School:</strong> <span id="modalSchool"></span></p>
                <p><strong>Grade:</strong> <span id="modalGrade"></span></p>
                <p><strong>Status:</strong> <span id="modalStatus"></span></p>
                <p><strong>Latest Reason:</strong> <span id="modalReason"></span></p>
                <p><strong>Description:</strong></p>
                <div id="modalDescription" style="margin-bottom:1rem;"></div>
                <p><strong>Attachments:</strong> <span id="modalAttachments"></span></p>
                <button type="button" class="modal-close" aria-label="Close" onclick="closeReportModal()">Close</button>
            </div>
        </div>
    </div>

@include('components.school-admin-sidebar-script')

<script>
function showToast(message, type) {
    type = type || 'success';
    var colors = {
        success: { bg: '#f0fdf4', border: '#4ade80', text: '#166534' },
        danger:  { bg: '#fef2f2', border: '#f87171', text: '#991b1b' },
        warning: { bg: '#fffbeb', border: '#fbbf24', text: '#92400e' },
        info:    { bg: '#eff6ff', border: '#60a5fa', text: '#1e40af' },
    };
    var c = colors[type] || colors.info;

    var toast = document.createElement('div');
    toast.style.cssText = [
        'position:fixed', 'bottom:24px', 'right:24px', 'z-index:9999',
        'display:flex', 'align-items:center', 'gap:12px',
        'background:' + c.bg, 'color:' + c.text,
        'border:1px solid ' + c.border, 'border-radius:12px',
        'padding:14px 18px', 'font-size:14px',
        "font-family:'Montserrat',sans-serif",
        'max-width:360px', 'box-shadow:0 4px 12px rgba(0,0,0,0.08)',
        'animation:toastSlideUp 0.2s ease'
    ].join(';');

    toast.innerHTML =
        '<span style="flex:1">' + message + '</span>' +
        '<button onclick="this.parentElement.remove()" style="all:unset;cursor:pointer;opacity:0.5;font-size:16px;line-height:1;">✕</button>';

    document.body.appendChild(toast);
    setTimeout(function() { if (toast.parentElement) toast.remove(); }, 4500);
}

function openReportModal(reportId) {
    fetch('/admin/reports/' + reportId, {
        headers: { 'Accept': 'application/json' }
    })
    .then(function(response) {
        if (!response.ok) throw new Error('Network response was not OK');
        return response.json();
    })
    .then(function(report) {
        document.getElementById('modalCaseNumber').textContent = report.case_number || 'N/A';
        document.getElementById('modalEmail').textContent      = report.reporter_email || 'Anonymous';
        document.getElementById('modalPhone').textContent      = report.phone_number || 'N/A';
        document.getElementById('modalType').textContent       = report.abuseType || 'N/A';
        document.getElementById('modalSubtype').textContent    = report.subtype || 'N/A';
        document.getElementById('modalSchool').textContent     = report.school || 'N/A';
        document.getElementById('modalGrade').textContent      = report.grade || 'N/A';
        document.getElementById('modalStatus').textContent     = report.status
            ? report.status.replace(/-/g, ' ').replace(/\b\w/g, function(c) { return c.toUpperCase(); })
            : 'N/A';
        document.getElementById('modalReason').textContent      = report.latest_status_reason || 'No status history recorded.';
        document.getElementById('modalDescription').textContent = report.description || '';

        var attachmentSpan = document.getElementById('modalAttachments');
        attachmentSpan.innerHTML = '';

        if (report.attachments && report.attachments.length > 0) {
            report.attachments.forEach(function(filePath) {
                var ext = filePath.split('.').pop().toLowerCase();
                var publicUrl = '/storage/' + filePath.replace(/^\/+/, '');
                var elem;

                if (['jpg','jpeg','png','gif','bmp','webp','svg'].includes(ext)) {
                    elem = document.createElement('img');
                    elem.src = publicUrl;
                    elem.alt = 'Attachment';
                    elem.style.cssText = 'width:80px;height:80px;margin-right:10px;border:2px solid #c7da30;border-radius:8px;object-fit:cover;';
                } else if (['mp4','mov','avi','wmv'].includes(ext)) {
                    elem = document.createElement('video');
                    elem.controls = true;
                    elem.style.cssText = 'width:120px;height:80px;margin-right:10px;';
                    var source = document.createElement('source');
                    source.src = publicUrl;
                    source.type = 'video/' + ext;
                    elem.appendChild(source);
                } else {
                    elem = document.createElement('a');
                    elem.href = publicUrl;
                    elem.target = '_blank';
                    elem.textContent = filePath.split('/').pop();
                    elem.style.cssText = 'color:#4c8eda;text-decoration:underline;margin-right:10px;display:inline-block;';
                }

                attachmentSpan.appendChild(elem);
            });
        } else {
            attachmentSpan.textContent = 'N/A';
        }

        var modal = document.getElementById('reportModal');
        modal.style.display = 'flex';
        modal.setAttribute('aria-hidden', 'false');
    })
    .catch(function() {
        showToast('Failed to load report details.', 'danger');
    });
}

function closeReportModal() {
    var modal = document.getElementById('reportModal');
    modal.style.display = 'none';
    modal.setAttribute('aria-hidden', 'true');
}

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') closeReportModal();
});

document.getElementById('refreshBtn').addEventListener('click', function() {
    var form = document.getElementById('searchForm');
    form.case_number.value = '';
    form.submit();
});
</script>

<script src="https://kit.fontawesome.com/2c36e9b7b9.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
function exportPDF() {
    var element = document.getElementById('main-content');
    if (!element) {
        showToast('Main content not found.', 'danger');
        return;
    }
    html2pdf().from(element).set({
        margin: 10,
        filename: 'school-admin-reports.pdf',
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'mm', format: 'a3', orientation: 'landscape' }
    }).save();
}
</script>

@if(session('success_message') || session('error_message') || session('warning_message'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if(session('success_message'))
            showToast(@js(session('success_message')), 'success');
        @endif
        @if(session('error_message'))
            showToast(@js(session('error_message')), 'danger');
        @endif
        @if(session('warning_message'))
            showToast(@js(session('warning_message')), 'warning');
        @endif
    });
</script>
@endif

</body>
</html>
