<div>
<style>
.sidebar {
    width: 235px;
    background: white;
    border-right: 1px solid #eaeaea;
    display: flex;
    flex-direction: column;
    padding-top: 120px;
    flex-shrink: 0;
}
.sidebar-list { list-style: none; padding: 0 0 0 22px; }
.sidebar-link {
    display: block;
    width: 92%;
    font-size: 15px !important;
    font-weight: 600 !important;
    color: #545454 !important;
    font-family: 'Montserrat', sans-serif !important;
    padding: 11px 18px;
    margin-bottom: 17px;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.25s ease;
}
.sidebar-link:hover, .sidebar-link.active {
    background: linear-gradient(to right, #38b6ff, #38b6ff);
    color: #fff !important;
}
.main-panel { flex: 1; display: flex; flex-direction: column; min-width: 0; height: 100vh; background: white; }
</style>

@include('components.school-admin-styles')

<div class="flex min-h-screen m-0 p-0" style="min-height: 100vh;">
    <aside class="sidebar school-admin-sidebar" id="schoolAdminSidebar">
        <div class="sidebar-logo">
            <img src="{{ asset('images/logo.png') }}" alt="Tekete SafeSpace">
        </div>
        <ul class="sidebar-list">
            <a href="{{ route('provincial.admin.dashboard') }}" class="sidebar-link {{ request()->is('provincial-admin/dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ url('/provincial/reports') }}" class="sidebar-link {{ request()->is('provincial/reports*') ? 'active' : '' }}">Reports</a>
            <a href="{{ url('/provincial/profile') }}" class="sidebar-link {{ request()->is('provincial/profile') ? 'active' : '' }}">My Profile</a>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="sidebar-link">Sign Out</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
        </ul>
    </aside>
    <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle menu" type="button">
        <svg class="toggle-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
    </button>
    <div class="sidebar-overlay" id="sidebarOverlay" aria-hidden="true"></div>

    <div class="main-panel">
    <main id='main-content' class="flex-1 flex flex-col bg-gray-100 overflow-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="w-full max-w-[1280px] mx-auto">
        <!-- Header -->
        <div class="flex flex-col gap-4 md:flex-row md:justify-between md:items-center mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-lime-800 tracking-wide">
                {{ $province }} Provincial Report
            </h1>
            <div class="flex items-center gap-4">
                <div class="text-right">
                    <p class="font-bold text-gray-800">{{ auth()->user()->name ?? 'Admin' }}</p>
                    <p class="text-sm text-gray-500">Provincial Admin</p>
                </div>
                @if(auth()->user()->profile_picture)
                    <img src="{{ auth()->user()->profile_picture_url }}" 
                         class="w-12 h-12 rounded-full object-cover border-2 border-gray-300 shadow">
                @else
                    <div class="w-12 h-12 bg-gray-400 rounded-full flex items-center justify-center border-2 border-gray-300 shadow">
                        <i class="fas fa-user-circle text-white text-3xl"></i>
                    </div>
                @endif
            </div>
        </div>

        <!-- Filters -->
    
<div class="bg-white rounded-lg shadow-md p-4 mb-6 flex flex-wrap gap-4 items-end">

    <!-- From Date -->
    <div>
        <label class="block text-sm font-semibold text-gray-600 mb-1">From</label>
        <input type="date" wire:model.live="fromDate"
               class="border rounded-lg px-3 py-2 w-full focus:ring-lime-500 focus:border-lime-500">
    </div>

    <!-- To Date -->
    <div>
        <label class="block text-sm font-semibold text-gray-600 mb-1">To</label>
        <input type="date" wire:model.live="toDate"
               class="border rounded-lg px-3 py-2 w-full focus:ring-lime-500 focus:border-lime-500">
    </div>

    <!-- Search & Buttons -->
    <div class="flex-1">
        <label class="block text-sm font-semibold text-gray-600 mb-1">Search Case No.</label>
        <div class="flex gap-2">
            <input type="text" wire:model.defer="searchCase"
                   placeholder="Enter case number..."
                   wire:keydown.enter="searchReport"
                   class="w-full border rounded-lg px-3 py-2 focus:ring-lime-500 focus:border-lime-500">

            <button wire:click="searchReport"
                    class="bg-lime-500 text-white px-4 py-2 rounded-lg hover:bg-lime-600 transition">
                Search
            </button>

            <button wire:click="resetSearch"
                    class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg flex items-center gap-1 hover:bg-gray-300 transition">
                <i class="fas fa-arrow-rotate-right"></i> Refresh
            </button>
        </div>
    </div>

</div>

        <!-- Reports Table -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Reports Summary</h2>
            <div class="overflow-x-auto">
            <table class="min-w-full border-collapse text-sm reports-table">
                <thead>
                    <tr class="text-center font-montserrat-bold">
                        <th class="p-2 border">Case No.</th>
                        <th class="p-2 border">Reporter</th>
                        <th class="p-2 border">Abuse Type</th>
                        <th class="p-2 border">School</th>
                        <th class="p-2 border">Status</th>
                        <th class="p-2 border">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $report)
                        <tr class="text-center hover:bg-lime-50 transition">
                            <td class="p-2 border">{{ $report->case_number }}</td>
                            <td class="p-2 border">{{ $report->reporter_email ?? 'Anonymous' }}</td>
                            <td class="p-2 border">{{ $report->abuseType->type_name ?? 'N/A' }}</td>
                            <td class="p-2 border">{{ $report->school->school_name ?? 'N/A' }}</td>
                            <td class="p-2 border">
                                <span class="px-2 py-1 rounded text-xs font-semibold
                                    @if($report->status == 'awaiting-resolution') bg-yellow-100 text-yellow-800
                                    @elseif($report->status == 'under-review') bg-blue-100 text-blue-800
                                    @elseif($report->status == 'forwarded') bg-red-100 text-red-800
                                    @elseif(in_array($report->status, ['closed','completed'])) bg-green-100 text-green-800
                                    @elseif($report->status == 'unresolved') bg-gray-100 text-gray-800
                                    @elseif($report->status == 'false-report') bg-purple-100 text-purple-800
                                    @endif">
                                    {{ ucfirst($report->status) }}
                                </span>
                            </td>
                            <td class="p-2 border">{{ $report->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-gray-500">No reports found for this province.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>
        </div>
    </main>
    </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<script>
document.addEventListener('livewire:updated', () => {
    const search = @entangle('searchCase');
    if (search) {
        const row = document.getElementById('case-' + search.trim());
        if (row) {
            row.scrollIntoView({ behavior: 'smooth', block: 'center' });
            row.classList.add('bg-yellow-100');
            setTimeout(() => row.classList.remove('bg-yellow-100'), 2000);
        }
    }
});
</script>

<script>
                function exportPDF() {
                    const element = document.getElementById('main-content'); // âœ… grabs main content only
                    if (!element) {
                        alert("Main content not found! Add id='main-content' to your <main> tag.");
                        return;
                    }

                    html2pdf().from(element).set({
                        margin: 10,
                        filename: 'provincial-reports.pdf',
                        html2canvas: {
                            scale: 2
                        },
                        jsPDF: {
                            unit: 'mm',
                            format: 'a3',
                            orientation: 'landscape'
                        }
                    }).save();
                }
            </script>
@include('components.school-admin-sidebar-script')
</div>

