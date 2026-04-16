<div class="flex min-h-screen m-0 p-0">
    <!-- Sidebar -->
    <aside class="w-64 flex flex-col justify-between sticky top-0 h-screen" style="background: linear-gradient(180deg, #b8d42f 0%, #c7e03a 100%);">
        <div class="flex flex-col h-full">
            <!-- Logo/Title Section -->
            <div class="p-6 text-center">
                <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">Tekete SafeSpace</p>
                <h1 class="text-2xl font-bold text-gray-700 uppercase tracking-wide">NATIONAL<br>ADMIN</h1>
            </div>
            <!-- Navigation Menu -->
            <nav class="flex-1 px-4" style="margin-top: 100px;">
                <ul class="space-y-3">
                    <li><a href="#"
                           class="flex items-center px-4 py-3 rounded-lg transition-all font-semibold text-gray-700
                           {{ Request::is('national/dashboard') ? 'bg-white bg-opacity-30' : 'hover:bg-white hover:bg-opacity-20' }}"
                           style="background-color: rgba(255, 255, 255, 0.3);">Dashboard</a></li>
                    <li><a href="#"
                           class="flex items-center px-4 py-3 rounded-lg transition-all font-semibold text-gray-700
                           {{ Request::is('national/reports') ? 'bg-white bg-opacity-30' : 'hover:bg-white hover:bg-opacity-20' }}">Reports</a></li>
                    <li><a href="#"
                           class="flex items-center px-4 py-3 rounded-lg transition-all font-semibold text-gray-700
                           {{ Request::is('national/profile') ? 'bg-white bg-opacity-30' : 'hover:bg-white hover:bg-opacity-20' }}">My Profile</a></li>
                    <li><a href="#" onclick="exportPDF()"
                           class="flex items-center px-4 py-3 rounded-lg transition-all font-semibold text-gray-700
                           hover:bg-white hover:bg-opacity-20">Export PDF</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">@csrf
                            <button type="submit"
                                    class="w-full text-left flex items-center px-4 py-3 rounded-lg transition-all font-semibold text-gray-700
                                    hover:bg-white hover:bg-opacity-20">Sign Out</button>
                        </form>
                    </li>
                </ul>
            </nav>
            <!-- Footer -->
            <div class="p-4 text-center">
                <p class="text-sm text-gray-600">© {{ date('Y') }} Tekete SafeSpace</p>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-h-screen">
        <!-- Top Header -->
        <header class="bg-white shadow-sm border-b border-gray-200 px-6 py-4">
            <div class="flex items-center justify-end">
                <div class="flex items-center space-x-3">
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Welcome back,</p>
                        <p class="font-semibold text-gray-800">{{ auth()->user()->name ?? 'Elvis Noko' }}</p>
                    </div>
                    @if(auth()->user() && auth()->user()->profile_picture)
                        <img src="{{ auth()->user()->profile_picture_url }}" alt="Profile"
                             class="w-10 h-10 rounded-full object-cover border-2 border-gray-300">
                    @else
                        <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white font-semibold">
                            {{ substr(auth()->user()->name ?? 'E', 0, 1) }}
                        </div>
                    @endif
                </div>
            </div>
        </header>

        <!-- MAIN CONTENT (export target) -->
        <div id="main-content" class="p-6">
            <style>
                .dashboard-summary, .filters {
                    display: flex; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem;
                }
                .card {
                    flex: 1 1 150px; background: white; border-radius: 12px;
                    border: 2px solid #a5d817; padding: 1rem; cursor: pointer;
                    transition: background-color 0.3s, transform 0.12s; text-align: center; min-width: 150px;
                }
                .card.active, .card:hover {
                    background: #a5d817; color: white; transform: translateY(-3px);
                }
                .card h4 { margin-bottom: .25rem; font-weight: 600; font-size: .9rem; color: inherit; }
                .card h2 { font-size: 1.6rem; font-weight: 700; margin: 0; color: inherit; }
                tr, th, td { border-bottom: 1px solid #ddd; }
                th { background: #f6f6f6; font-weight: bold; }
            </style>

            <h1 style="color:#a5d817; font-weight:bold; font-size:1.875rem; margin-bottom:2rem; text-align:center;">
                SAFESPACE NATIONAL DASHBOARD
            </h1>

            <div class="dashboard-summary">
                <div wire:click="showStatusReports(null)" class="card">
                    <h4>Total Reports</h4>
                    <h2>{{ $summaryCounts['total'] ?? 0 }}</h2>
                </div>
                @foreach (['awaiting-resolution', 'under-review', 'forwarded', 'closed', 'unresolved', 'false-report'] as $status)
                    <div wire:click="showStatusReports('{{ $status }}')" class="card">
                        <h4>{{ ucwords(str_replace('-', ' ', $status)) }} Reports</h4>
                        <h2>{{ $summaryCounts[$status] ?? 0 }}</h2>
                    </div>
                @endforeach
            </div>

            <!-- TAB SWITCH -->
            <div class="flex gap-4 mt-8 mb-6">
                <button wire:click="switchTab('overview')" class="px-4 py-2 rounded-lg font-semibold {{ $activeTab === 'overview' ? 'bg-[#a5d817] text-white' : 'bg-gray-200 text-gray-700' }}">
                    Overview
                </button>
                <button wire:click="switchTab('analysis')" class="px-4 py-2 rounded-lg font-semibold {{ $activeTab === 'analysis' ? 'bg-[#a5d817] text-white' : 'bg-gray-200 text-gray-700' }}">
                    Abuse Analysis
                </button>
            </div>

            @if($activeTab === 'overview')
                <div class="flex gap-6 mb-8" style="height: 580px;">
                    <!-- Left Card Container with border, padding, bg white and heading -->
                    <div class="flex-1 flex flex-col space-y-4 border-2 border-dashed border-[#a5d817] rounded-lg p-6 bg-white overflow-auto" style="height: 100%;">
                        <h4 class="font-bold text-gray-700 mb-2 text-center">Abuse Type Reports</h4>
                        <div wire:ignore style="flex:1; min-width: 300px;">
                            <canvas id="abuseTypeChart" style="width:100%; height:100%;"></canvas>
                        </div>
                    </div>

                    <!-- Filters Container: Half width, full height -->
                    <div class="flex-1 flex flex-col space-y-6 border-2 border-dashed border-[#a5d817] rounded-lg p-6 bg-white overflow-auto" style="height: 100%;">
                        <div>
                            <h4 class="font-bold text-gray-700 mb-3">Filter by Province</h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($provinces as $province)
                                <button wire:click="$set('provinceFilter', {{ $province['id'] }})" type="button"
                                    class="rounded px-3 py-1 text-sm font-semibold border border-[#a5d817] cursor-pointer {{ $provinceFilter === $province['id'] ? 'bg-[#a5d817] text-white' : 'bg-white text-gray-800' }}">
                                    {{ $province['name'] }}
                                </button>
                                @endforeach
                                <button wire:click="$set('provinceFilter', null)" type="button"
                                    class="ml-auto border-2 border-red-600 hover:bg-red-600 hover:text-white rounded px-3 py-1 font-semibold text-red-600">
                                    Clear
                                </button>
                            </div>
                        </div>

                        @if($provinceFilter)
                        <div>
                            <h4 class="font-bold text-gray-700 mb-3">Filter by District</h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($districts as $district)
                                <button wire:click="$set('districtFilter', {{ $district['id'] }})" type="button"
                                    class="rounded px-3 py-1 text-sm font-semibold border border-[#a5d817] cursor-pointer {{ $districtFilter === $district['id'] ? 'bg-[#a5d817] text-white' : 'bg-white text-gray-800' }}">
                                    {{ $district['name'] }}
                                </button>
                                @endforeach
                                <button wire:click="$set('districtFilter', null)" type="button"
                                    class="ml-auto border-2 border-red-600 hover:bg-red-600 hover:text-white rounded px-3 py-1 font-semibold text-red-600">
                                    Clear
                                </button>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            @endif

            @if($activeTab === 'analysis')
                <div class="flex gap-6 mb-8" style="height: 580px;">
                    <!-- Charts Container Left with heading -->
                    <div class="flex-1 flex flex-col space-y-4 border-2 border-dashed border-[#a5d817] rounded-lg p-6 bg-white overflow-auto" style="height: 100%;">
                        <h4 class="font-bold text-gray-700 mb-2 text-center">Reports per School</h4>
                        <div wire:ignore style="flex:1; min-width: 300px;">
                            <canvas id="schoolChart" style="width:100%; height:100%;"></canvas>
                        </div>
                    </div>

                    <!-- Filters Container Right -->
                    <div class="flex-1 flex flex-col space-y-6 border-2 border-dashed border-[#a5d817] rounded-lg p-6 bg-white overflow-auto" style="height: 100%;">
                        <div>
                            <h4 class="font-bold text-gray-700 mb-3">Filter by Abuse Type</h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($abuseTypes as $type)
                                <button wire:click="$set('abuseTypeFilter', {{ $type->id }})" type="button"
                                    class="rounded px-3 py-1 text-sm font-semibold border border-[#a5d817] cursor-pointer {{ $abuseTypeFilter === $type->id ? 'bg-[#a5d817] text-white' : 'bg-white text-gray-800' }}">
                                    {{ $type->type_name }}
                                </button>
                                @endforeach
                                <button wire:click="$set('abuseTypeFilter', null)" type="button"
                                    class="ml-auto border-2 border-red-600 hover:bg-red-600 hover:text-white rounded px-3 py-1 font-semibold text-red-600">
                                    Clear
                                </button>
                            </div>
                        </div>

                        <div>
                            <h4 class="font-bold text-gray-700 mb-3">Filter by Town/City</h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($townCities as $city)
                                <button wire:click="$set('townCityFilter', '{{ $city }}')" type="button"
                                    class="rounded px-3 py-1 text-sm font-semibold border border-[#a5d817] cursor-pointer {{ $townCityFilter === $city ? 'bg-[#a5d817] text-white' : 'bg-white text-gray-800' }}">
                                    {{ $city }}
                                </button>
                                @endforeach
                                <button wire:click="$set('townCityFilter', null)" type="button"
                                    class="ml-auto border-2 border-red-600 hover:bg-red-600 hover:text-white rounded px-3 py-1 font-semibold text-red-600">
                                    Clear
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Reports List Popup -->
            @if($showModal)
                <div class="fixed inset-0 flex justify-center items-center bg-black bg-opacity-60"
                     style="z-index: 60; border: 4px solid #a5d817;"
                     wire:click.self="closeModal">
                    <div class="bg-white rounded-lg shadow-lg p-8 max-w-6xl w-full max-h-[90vh] overflow-auto">
                        <h2 class="font-bold text-lg mb-4">
                            Reports{{ $modalStatus ? ': '.ucwords(str_replace('-', ' ', $modalStatus)) : '' }}
                        </h2>

                        @if($statusReports->isEmpty())
                            <p>No reports found for this status.</p>
                        @else
                            <table class="table-auto w-full text-left mb-2 cursor-pointer">
                                <thead>
                                    <tr class="bg-green-100">
                                        <th class="p-2 border-b">School Name</th>
                                        <th class="p-2 border-b">District</th>
                                        <th class="p-2 border-b">Abuse Type</th>
                                        <th class="p-2 border-b">Status</th>
                                        <th class="p-2 border-b">Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($statusReports as $report)
                                        <tr wire:click="showReportDetails({{ $report->id }})" class="hover:bg-green-50" style="cursor: pointer;">
                                            <td class="p-2 border-b">{{ $report->school_name ?? 'Unknown' }}</td>
                                            <td class="p-2 border-b">{{ optional($report->district)->district_name ?? 'Unknown' }}</td>
                                            <td class="p-2 border-b">{{ optional($report->abuseType)->type_name ?? 'Unknown' }}</td>
                                            <td class="p-2 border-b">{{ $report->status }}</td>
                                            <td class="p-2 border-b">{{ $report->created_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif

                        <button class="btn mt-4 bg-green-600 text-white px-4 py-2 rounded" wire:click="closeModal">Close</button>
                    </div>
                </div>
            @endif

            <!-- Detail Popup -->
            @if($selectedReport)
                <div class="fixed inset-0 flex justify-center items-center bg-black bg-opacity-70"
                     style="z-index: 70; border: 4px solid #a5d817;"
                     wire:click.self="closeReportDetails">
                    <div class="bg-white rounded-lg shadow-lg p-8 max-w-4xl w-full max-h-[90vh] overflow-auto">
                        <h2 class="font-bold text-lg mb-4">Report Details - Case #{{ $selectedReport->case_number ?? 'N/A' }}</h2>

                        <table class="table-auto w-full text-left mb-2">
                            <tbody>
                                <tr><th class="pr-4 py-1">School Name:</th><td>{{ $selectedReport->school_name ?? 'Unknown' }}</td></tr>
                                <tr><th class="pr-4 py-1">District:</th><td>{{ optional($selectedReport->district)->district_name ?? 'Unknown' }}</td></tr>
                                <tr><th class="pr-4 py-1">Province:</th><td>{{ optional($selectedReport->province)->province_name ?? 'Unknown' }}</td></tr>
                                <tr><th class="pr-4 py-1">Abuse Type:</th><td>{{ optional($selectedReport->abuseType)->type_name ?? 'Unknown' }}</td></tr>
                                <tr><th class="pr-4 py-1">Status:</th><td>{{ $selectedReport->status }}</td></tr>
                                <tr><th class="pr-4 py-1">Created At:</th><td>{{ $selectedReport->created_at }}</td></tr>
                                <tr><th class="pr-4 py-1">Description:</th><td>{{ $selectedReport->description }}</td></tr>
                                <tr><th class="pr-4 py-1">Reporter Name:</th><td>{{ $selectedReport->full_name ?? 'Anonymous' }}</td></tr>
                                <tr><th class="pr-4 py-1">Phone Number:</th><td>{{ $selectedReport->phone_number ?? 'N/A' }}</td></tr>
                                <tr><th class="pr-4 py-1">Reporter Email:</th><td>{{ $selectedReport->reporter_email ?? 'N/A' }}</td></tr>
                                <tr><th class="pr-4 py-1">Age:</th><td>{{ $selectedReport->age ?? 'N/A' }}</td></tr>
                                <tr><th class="pr-4 py-1">Location:</th><td>{{ $selectedReport->location ?? 'N/A' }}</td></tr>
                                <tr><th class="pr-4 py-1">Grade:</th><td>{{ $selectedReport->grade ?? 'N/A' }}</td></tr>
                                <tr><th class="pr-4 py-1">Is Anonymous:</th><td>{{ $selectedReport->is_anonymous ? 'Yes' : 'No' }}</td></tr>
                                <tr><th class="pr-4 py-1">Latest Status Reason:</th><td>{{ $selectedReport->latest_status_reason ?? 'N/A' }}</td></tr>
                                @if($selectedReport->image_path)
                                    <tr><th class="pr-4 py-1">Attached Image:</th>
                                        <td><img src="{{ asset('storage/' . $selectedReport->image_path) }}" alt="Report Image" class="max-w-xs rounded"></td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <button class="btn mt-4 bg-green-600 text-white px-4 py-2 rounded" wire:click="closeReportDetails">Close Details</button>
                    </div>
                </div>
            @endif

            <!-- Filtered reports table -->
            @if($anyFilterActive)
                <div style="background:#fff; padding:1rem; border-radius:8px; box-shadow:0 2px 8px #ddd;">
                    <h3 style="color:#4a4a4a; margin-bottom:1rem;">Filtered Reports</h3>

                    <table class="min-w-full border border-gray-300">
                        <thead class="bg-gray-100 font-semibold text-gray-700">
                            <tr>
                                <th class="border border-gray-300 px-3 py-2">School Name</th>
                                @if($provinceFilter)
                                    <th class="border border-gray-300 px-3 py-2">District</th>
                                    <th class="border border-gray-300 px-3 py-2">Province</th>
                                @endif
                                @if($townCityFilter)
                                    <th class="border border-gray-300 px-3 py-2">Location</th>
                                @endif
                                <th class="border border-gray-300 px-3 py-2">Abuse Type</th>
                                <th class="border border-gray-300 px-3 py-2">Status</th>
                                <th class="border border-gray-300 px-3 py-2">Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($filteredReports as $report)
                                <tr>
                                    <td class="border border-gray-300 px-3 py-2">{{ $report->school_name ?? 'Unknown' }}</td>
                                    @if($provinceFilter)
                                        <td class="border border-gray-300 px-3 py-2">{{ optional($report->district)->district_name ?? 'Unknown' }}</td>
                                        <td class="border border-gray-300 px-3 py-2">{{ optional($report->province)->province_name ?? 'Unknown' }}</td>
                                    @endif
                                    @if($townCityFilter)
                                        <td class="border border-gray-300 px-3 py-2">{{ $report->location ?? 'Unknown' }}</td>
                                    @endif
                                    <td class="border border-gray-300 px-3 py-2">{{ optional($report->abuseType)->type_name ?? 'Unknown' }}</td>
                                    <td class="border border-gray-300 px-3 py-2">{{ $report->status }}</td>
                                    <td class="border border-gray-300 px-3 py-2">{{ $report->description }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="border border-gray-300 px-3 py-4 text-center" colspan="{{ 5 + ($provinceFilter ? 1 : 0) + ($townCityFilter ? 1 : 0) }}">
                                        No records found matching the filters.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $filteredReports->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('livewire:load', function() {
    let abuseTypeChart = null, schoolChart = null;

    function renderAbuseChart(data) {
        const el = document.getElementById('abuseTypeChart');
        if (!el) return;
        if (abuseTypeChart) abuseTypeChart.destroy();

        abuseTypeChart = new Chart(el, {
            type: 'bar',
            data: {
                labels: Object.keys(data),
                datasets: [{
                    label: 'Abuse Type Reports',
                    data: Object.values(data),
                    backgroundColor: [
                        '#b8d42f','#c7e03a','#f5cf4d','#e38645','#5ea241','#3fa796'
                    ]
                }]
            },
            options: { responsive: true, plugins: { legend: { display: true } } }
        });
    }

    function renderSchoolChart(data) {
        const el = document.getElementById('schoolChart');
        if (!el) return;
        if (schoolChart) schoolChart.destroy();

        schoolChart = new Chart(el, {
            type: 'bar',
            data: {
                labels: Object.keys(data),
                datasets: [{
                    label: 'Reports per School',
                    data: Object.values(data),
                    backgroundColor: '#5ea241'
                }]
            },
            options: { responsive: true, plugins: { legend: { display: false } } }
        });
    }

    renderAbuseChart(@json($abuseTypeChartData ?? []));
    renderSchoolChart(@json($schoolChartData ?? []));

    Livewire.on('refreshCharts', function(abuseData, schoolData) {
        renderAbuseChart(abuseData ?? {});
        renderSchoolChart(schoolData ?? {});
    });
});
</script>
