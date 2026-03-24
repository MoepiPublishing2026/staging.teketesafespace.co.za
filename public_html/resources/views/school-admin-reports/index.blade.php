<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Reports - School Admin - {{ $school->school_name ?? '' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
     <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400&display=swap" rel="stylesheet">
   <style>
:root {
   --theme-gradient:  linear-gradient(to right, #38b6ff, #38b6ff); --black: #000000; --gray-light: #dadada; --gray-dark: #2a2e32;
    --offwhite: #fffbf7;
}

/* ========== GLOBAL RESET ========== */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

html, body {
  font-family: 'Montserrat', sans-serif !important;
  color: #545454 !important;
}

/* ========== LAYOUT ========== */
body {
    display: flex;
}

/* ===== SIDEBAR ===== */
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
  background-color: #c7da30 !important; /* Green background on hover for contrast */
  color: white !important; /* White text on hover */
  border-color: #38b6ff !important; /* Blue border on hover */
  outline: none;
}


/* ===== MAIN PANEL ===== */
.main-panel {
    flex: 1;
    display: flex;
    flex-direction: column;
    height: 100vh;
}

/* ===== TOPBAR ===== */
   
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
   
}

/* ===== PROFILE SECTION ===== */
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
    color: #38b6ff; /* Theme blue */
    font-size: 18px; /* Increase font size */
    font-weight: 700; /* Bold for emphasis */
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

/* ===== MAIN CONTENT ===== */
main {
    flex: 1;
    padding: 2.5rem;
    background: #fff;
    overflow-y: auto;
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

/* ===== TABLE ===== */
table { width: 100%; border-collapse: collapse; font-size: 0.9rem; background: var(--gray-light); color: var(--black); font-family: 'Montserrat', sans-serif; table-layout: fixed; border: 3px solid #c7da30; border-radius: 0.375rem; overflow: hidden; }

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

/* ===== PAGINATION ===== */
.pagination {
    display: flex;
    justify-content: center;
    margin-top: 1rem;
}

.page-item.active .page-link {
    background: #cddc39; /* lime green */
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


/* ===== MODAL ===== */
/* Modal Overlay */
.modal-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(0, 12, 12, 0.42); /* Subtle dark overlay */
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 50;
     border: 3px solid #38b6ff !important;
}

/* Modal Card Container */
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

.modal-close:hover,
.modal-close:focus {
    background: linear-gradient(to right, #74b9ff, #74b9ff) !important;
    color: white !important;
    border-color: #74b9ff !important;
}


/* Modal Content Wrapping */
.modal-content {
    padding: 2.2rem 2.2rem 1.7rem 2.2rem;
    border-radius: 12px;
    border: none;
}

/* Modal Title */
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

/* Labels and Values */
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

/* Subtle values and Reason */
#modalReason {
    color: #865c0b;
    font-size: 0.98rem;
    font-style: italic;
}

/* Description block */
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

/* Attachments Handling */
#modalAttachments img,
#modalAttachments video {
    border: 2px solid #c7da30;
    border-radius: 7px;
    width: 80px !important;
    height: 80px !important;
    object-fit: cover;
    margin-right: 8px;
}

/* Button, Form fields if needed (hidden in screenshot, but for completeness) */
.modal-content select,
.modal-content textarea,
.modal-content input {
    display: none !important;
}

/* ===== SCROLLBAR ===== */
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

/* ===== RESPONSIVE ===== */
@media (max-width: 900px) {
    body {
        flex-direction: column;
    }
    .sidebar {
        flex-direction: row;
        width: 100%;
        height: auto;
        border-right: none;
        border-bottom: 3px solid var(--lime);
        justify-content: space-around;
        padding: 0.5rem 0;
    }
    .sidebar-link {
        margin-bottom: 0;
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
    }
    .main-panel {
        height: auto;
    }
    main {
        padding: 1.5rem;
    }
}
</style>

</head>
<body>
<aside class="sidebar">
     <div style="position: fixed; top: 40px; left: 40px; width: 100px; height: auto;">
        <img src="{{ asset('images/logo.png') }}" alt="Safe Space Logo" style="width: 150px; height: auto;"></div>
    <ul class="sidebar-list">
        <a href="{{ url('/admin/dashboard') }}" class="sidebar-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ url('/admin/reports') }}" class="sidebar-link {{ request()->is('admin/reports') ? 'active' : '' }}">Reports</a>
        <a href="{{ url('/admin/settings') }}" class="sidebar-link {{ request()->is('admin/settings') ? 'active' : '' }}">My Profile</a>
        <a href="#" onclick="event.preventDefault(); exportPDF();" class="sidebar-link">Export PDF</a>

        <!-- Sign Out as a styled form -->
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="sidebar-link">
    Sign Out
</a>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

    </ul>
</aside>

    <!-- Main dashboard (topbar + scrollable dashboard) -->
    <div class="main-panel">
        <!-- Top bar with profile only (sticky) -->
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
                    @else
                        <!-- Default gray circle, nothing inside -->
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
        style="padding: 0.5rem 0.75rem; border: 2px solid #c7da30; border-radius: 0.375rem; font-family: 'Montserrat', sans-serif; font-size: 1rem; width: 440px;" 
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
                <td>{{ $report->created_at->format('Y-m-d') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center; padding: 1rem;">No reports found for this filter.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination Links -->
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


<script>
function openReportModal(reportId) {
    fetch(`/admin/reports/${reportId}`, {
        headers: { 'Accept': 'application/json' }
    })
    .then(response => {
        if (!response.ok) throw new Error('Network response was not OK');
        return response.json();
    })
    .then(report => {
        // Fill all fields
        document.getElementById('modalCaseNumber').textContent = report.case_number || 'N/A';
        document.getElementById('modalEmail').textContent = report.reporter_email || 'Anonymous';
        document.getElementById('modalPhone').textContent = report.phone_number || 'N/A';
        document.getElementById('modalType').textContent = report.abuseType || 'N/A';
        document.getElementById('modalSubtype').textContent = report.subtype || 'N/A';
        document.getElementById('modalSchool').textContent = report.school || 'N/A';
        document.getElementById('modalGrade').textContent = report.grade || 'N/A';
        document.getElementById('modalStatus').textContent = report.status ? report.status.replace(/-/g, ' ').replace(/\b\w/g, c => c.toUpperCase()) : 'N/A';
        document.getElementById('modalReason').textContent = report.latest_status_reason || 'No status history recorded.';
        document.getElementById('modalDescription').textContent = report.description || '';

        // Attachments as part of fields
        const attachmentSpan = document.getElementById('modalAttachments');
        attachmentSpan.innerHTML = ''; // clear previous content

        if (report.attachments && report.attachments.length > 0) {
            report.attachments.forEach(filePath => {
                const ext = filePath.split('.').pop().toLowerCase();
                const publicUrl = `/storage/${filePath.replace(/^\/+/, '')}`;
                let elem;

                if (['jpg','jpeg','png','gif','bmp','webp','svg'].includes(ext)) {
                    elem = document.createElement('img');
                    elem.src = publicUrl;
                    elem.alt = 'Attachment';
                    elem.style.width = '80px';
                    elem.style.height = '80px';
                    elem.style.marginRight = '10px';
                    elem.style.border = '2px solid #c7da30';
                    elem.style.borderRadius = '8px';
                    elem.style.objectFit = 'cover';
                } else if (['mp4','mov','avi','wmv'].includes(ext)) {
                    elem = document.createElement('video');
                    elem.controls = true;
                    elem.style.width = '120px';
                    elem.style.height = '80px';
                    elem.style.marginRight = '10px';
                    const source = document.createElement('source');
                    source.src = publicUrl;
                    source.type = 'video/' + ext;
                    elem.appendChild(source);
                } else {
                    elem = document.createElement('a');
                    elem.href = publicUrl;
                    elem.target = '_blank';
                    elem.textContent = filePath.split('/').pop();
                    elem.style.color = '#4c8eda';
                    elem.style.textDecoration = 'underline';
                    elem.style.marginRight = '10px';
                    elem.style.display = 'inline-block';
                }

                attachmentSpan.appendChild(elem);
            });
        } else {
            attachmentSpan.textContent = 'N/A';
        }

        // Show modal
        const modal = document.getElementById('reportModal');
        modal.style.display = 'flex';
        modal.setAttribute('aria-hidden', 'false');
    })
    .catch(err => alert('Failed to load report details.'));
}

// Close modal
function closeReportModal() {
    const modal = document.getElementById('reportModal');
    modal.style.display = 'none';
    modal.setAttribute('aria-hidden', 'true');
}

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeReportModal();
    }
});

   document.getElementById('refreshBtn').addEventListener('click', function() {
    const form = document.getElementById('searchForm');
    form.case_number.value = '';
    form.submit();
});

</script>

<script src="https://kit.fontawesome.com/2c36e9b7b9.js" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    function exportPDF() {
        const element = document.getElementById('main-content');
        if (!element) {
            alert("Main content not found! Add id='main-content' to your <main> tag.");
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
</body>
</html>

