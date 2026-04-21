
<div class="flex min-h-screen m-0 p-0">
    <!-- Sidebar -->
  <aside class="w-64 flex flex-col justify-between sticky top-0 h-screen" style="background-color: #fffbf7;">
    <div class="flex flex-col h-full">
        <!-- Navigation Menu -->
        <nav class="flex-1 px-4" style="margin-top: 100px;">
            <ul class="space-y-3">
                <!-- Dashboard -->
                <li>
                    <a href="#" wire:click.prevent="setActiveTab('dashboard')"
       class="flex items-center px-4 py-3 rounded-lg transition-all font-semibold text-black
       {{ $activeTab === 'dashboard' ? 'bg-gradient-to-r from-[#c7da30] to-[#d7e47a]' : 'hover:bg-gradient-to-r from-[#c7da30] to-[#d7e47a]' }}">
       Dashboard
    </a>
                </li>
                <!-- Reports -->
                <li>
                    <a href="#" wire:click.prevent="setActiveTab('reports')"
       class="flex items-center px-4 py-3 rounded-lg transition-all font-semibold text-black
       {{ $activeTab === 'reports' ? 'bg-gradient-to-r from-[#c7da30] to-[#d7e47a]' : 'hover:bg-gradient-to-r from-[#c7da30] to-[#d7e47a]' }}">
       Reports
    </a>
                </li>
                <!-- My Profile -->
                <li>
            <a href="{{ route('district.profile') }}"
   class="flex items-center px-4 py-3 rounded-lg transition-all font-semibold text-black
   {{ Request::is('district/profile') ? 'bg-gradient-to-r from-[#c7da30] to-[#d7e47a]' : 'hover:bg-gradient-to-r from-[#c7da30] to-[#d7e47a]' }}">
   My Profile
</a>
</li>
                <!-- Export PDF -->
                    <li class="flex justify-center">
                        <a href="#" onclick="exportPDF()"
                            class="flex items-center font-montserrat-black rounded-lg transition-all font-semibold text-black
                            {{ Request::is('district/export') ? 'bg-gradient-to-r from-[#c7da30] to-[#d7e47a]' : 'hover:bg-gradient-to-r from-[#c7da30] to-[#d7e47a]' }}"
                            style="width: 188px; height: 41px; color: black; font-size: 15px;">
                            <i></i>Export PDF
                        </a>
                    </li>
                <!-- Sign Out -->
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left flex items-center px-4 py-3 rounded-lg transition-all font-semibold text-black
                            hover:bg-gradient-to-r from-[#c7da30] to-[#d7e47a']">
                            Sign Out
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
            
            <!-- Footer -->
            <div class="p-4 text-center">
                <p class="text-sm text-gray-600">&copy; {{ date('Y') }} Tekete SafeSpace</p>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-h-screen">
        <!-- Top Header -->
        <header class="bg-white shadow-sm border-b border-gray-200 px-6 py-4">
            <div class="flex items-center justify-end">
                
                  <div class="flex items-center space-x-4 relative" style="font-family: 'Century Gothic', sans-serif;">
            <div class="text-right">
                <p class="font-bold text-black" style="font-size: 16px;">{{ auth()->user()->name ?? 'District Admin' }}</p>
                <p class="text-gray-500 text-sm">{{ $districtName }}</p>
            </div>
            @if(auth()->user()->profile_picture)
                <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="Profile Picture" class="w-10 h-10 rounded-full object-cover border-2 border-gray-300 shadow">
            @else
                <div class="w-10 h-10 bg-gradient-to-r from-gray-400 to-gray-600 rounded-full flex items-center justify-center border-2 border-gray-300 shadow">
                    <i class="fas fa-user-circle text-white text-5xl"></i>
                </div>
            @endif
                </div>
            </div>
        </header>

        <!-- Main Content -->
         <main id="main-content" class="flex flex-col flex-1 p-8 bg-white" style="font-family: 'Century Gothic', sans-serif;">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <h2 class="text-3xl font-poppins font-extrabold uppercase tracking-wide" style="font-family: 'Poppins', sans-serif;">Tekete SafeSpace - District Administrator Dashboard</h2>
                <p class="text-gray-600 mt-2">
                    Showing insights for <span class="font-semibold text-lime-700">{{ $districtName }}</span>
                    @if($provinceName)
                    in {{ $provinceName }} Province
                    @endif
                </p>
            </div>

            <div class="bg-gray-100 rounded-lg px-4 py-3 shadow-sm">
                <p class="text-xs uppercase text-gray-500">Active Filters</p>
                <p class="text-sm font-semibold text-gray-800">{{ $this->filtersApplied ? 'Custom selection applied' : 'No filters' }}</p>
            </div>
        </div>

        @if($activeTab === 'dashboard')
            <!-- Status Cards -->
            <section class="flex flex-wrap gap-6 mb-8">
                <button wire:click="showStatusReports(null)" class="rounded-lg shadow p-6 flex flex-col items-center cursor-pointer bg-gradient-to-br from-[#c7da30] to-[#d7e47a] w-44 font-bold">
                    <div class="text-white mt-2 text-sm">Total Reports</div>
                    <div class="text-3xl font-extrabold text-white mt-2">{{ $totalReports }}</div>
                </button>

                @php
                    $order = ['awaiting-resolution', 'forwarded', 'under-review', 'closed', 'unresolved', 'false-report'];
                    $colors = [
                        'awaiting-resolution' => 'text-red-500',
                        'forwarded' => 'text-yellow-400',
                        'under-review' => 'text-blue-500',
                        'closed' => 'text-green-600',
                        'unresolved' => 'text-orange-400',
                        'false-report' => 'text-gray-500',
                    ];
                @endphp

                @foreach ($order as $status)
                    <button wire:click="showStatusReports('{{ $status }}')" class="bg-white rounded-lg shadow border-2 border-[#d7e47a] p-6 flex flex-col items-center cursor-pointer w-44 font-bold">
                        <div class="{{ $colors[$status] ?? 'text-gray-500' }} mt-2 text-sm">{{ ucwords(str_replace('-', ' ', $status)) }}</div>
                        <div class="text-3xl font-extrabold {{ $colors[$status] ?? 'text-gray-500' }} mt-2" style="font-size: 2rem;">
                            {{ $statusCounts[$status] ?? 0 }}
                        </div>
                    </button>
                @endforeach
            </section>
        @endif

        <!-- Quick Insights -->
        <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-6 gap-4 mb-10">
            <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
                <p class="text-xs uppercase tracking-wide text-gray-500">Unique Schools Reporting</p>
                <p class="text-3xl font-extrabold text-lime-700 mt-2">{{ $summaryStats['uniqueSchools'] ?? 0 }}</p>
                <p class="text-sm text-gray-400 mt-1">Schools with at least one case</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
                <p class="text-xs uppercase tracking-wide text-gray-500">Anonymous Case Ratio</p>
                <p class="text-3xl font-extrabold text-lime-700 mt-2">{{ $summaryStats['anonymousPercentage'] ?? 0 }}%</p>
                <p class="text-sm text-gray-400 mt-1">Portion of reports submitted anonymously</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
                <p class="text-xs uppercase tracking-wide text-gray-500">Latest Report</p>
                <p class="text-3xl font-extrabold text-lime-700 mt-2">{{ $summaryStats['latestReportDate'] ?? 'N/A' }}</p>
                <p class="text-sm text-gray-400 mt-1">Most recent case captured</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
                <p class="text-xs uppercase tracking-wide text-gray-500">Reports per School</p>
                <p class="text-3xl font-extrabold text-lime-700 mt-2">{{ $summaryStats['reportsPerSchool'] ?? 0 }}</p>
                <p class="text-sm text-gray-400 mt-1">Average cases per active school</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
                <p class="text-xs uppercase tracking-wide text-gray-500">Average Age</p>
                <p class="text-3xl font-extrabold text-lime-700 mt-2">{{ $ageStatistics['averageAge'] ?? 'N/A' }}</p>
                <p class="text-sm text-gray-400 mt-1">Median: {{ $ageStatistics['medianAge'] ?? 'N/A' }} | Under 18: {{ $ageStatistics['minorsPercentage'] ?? 'N/A' }}%</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
                <p class="text-xs uppercase tracking-wide text-gray-500">Under 10 Cases</p>
                <p class="text-3xl font-extrabold text-lime-700 mt-2">{{ $ageStatistics['underTenCount'] ?? 0 }}</p>
                <p class="text-sm text-gray-400 mt-1">Across {{ $ageStatistics['sampleSize'] ?? 0 }} cases with age data</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
                <p class="text-xs uppercase tracking-wide text-gray-500">Last Refreshed</p>
                <p class="text-3xl font-extrabold text-lime-700 mt-2">{{ $dataRefreshedAt ?: 'Just now' }}</p>
                <p class="text-sm text-gray-400 mt-1">Updated automatically when filters change</p>
            </div>
        </section>

        <!-- Filters -->
        <section x-data="{ open: true }" class="mb-8 border-2 border-lime-600 rounded-lg p-4">
            <button @click="open = !open" class="font-poppins font-bold text-lime-700 mb-4 flex items-center space-x-2 focus:outline-none" style="font-family: 'Poppins', sans-serif;">
                <span>Filters</span>
                <svg :class="{'rotate-180': !open}" class="w-5 h-5 transform transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <div x-show="open" x-transition>
                <div class="mb-4">
                    <h4 class="font-semibold text-gray-700 mb-2 font-poppins" style="font-family: 'Poppins', sans-serif;">School</h4>
                    @if (count($schools))
                        <div class="flex flex-wrap gap-2">
                            @foreach($schools as $id => $name)
                                <button wire:click="$set('selectedSchool', {{ $id }})" class="px-3 py-1 rounded-lg font-semibold shadow-sm border font-century {{ $selectedSchool == $id ? 'bg-[#b8d42f] text-white' : 'bg-gray-100 text-gray-800 hover:bg-[#e6eeae]' }}">
                                    {{ $name }}
                                </button>
                            @endforeach
                            @if ($selectedSchool)
                                <button wire:click="$set('selectedSchool', '')" class="px-4 ml-4 py-1 rounded-lg font-semibold bg-red-600 text-white whitespace-nowrap">Clear School</button>
                            @endif
                        </div>
                    @else
                        <p class="text-gray-500 italic">No schools assigned to this district yet.</p>
                    @endif
                </div>

                <div class="mb-4">
                    <h4 class="font-semibold text-gray-700 mb-2 font-poppins" style="font-family: 'Poppins', sans-serif;">Abuse Type</h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($abuseTypes as $id => $name)
                            <button wire:click="$set('selectedAbuseType', {{ $id }})" class="px-4 py-1 rounded-lg font-semibold shadow border border-gray-200 font-century {{ $selectedAbuseType == $id ? 'bg-[#b8d42f] text-white' : 'bg-gray-100 text-gray-800 hover:bg-[#e6eeae]' }}">
                                {{ $name }}
                            </button>
                        @endforeach
                        @if ($selectedAbuseType)
                            <button wire:click="$set('selectedAbuseType', '')" class="px-4 py-1 ml-4 rounded-lg font-semibold bg-red-600 text-white whitespace-nowrap">Clear Type</button>
                        @endif
                    </div>
                </div>

                <div class="mb-4">
                    <h4 class="font-semibold text-gray-700 mb-2 font-poppins" style="font-family: 'Poppins', sans-serif;">Age Range</h4>
                    <div class="flex flex-wrap gap-2">
                        <button wire:click="$set('selectedAgeRange', '')"
                            class="px-4 py-1 rounded-lg font-semibold shadow-sm border font-century {{ $selectedAgeRange === '' ? 'bg-[#b8d42f] text-white' : 'bg-gray-100 text-gray-800 hover:bg-[#e6eeae]' }}">
                            All Ages
                        </button>
                        @foreach($ageRanges as $range)
                            <button wire:click="$set('selectedAgeRange', '{{ $range }}')"
                                class="px-3 py-1 rounded-lg font-semibold shadow-sm border font-century {{ $selectedAgeRange === $range ? 'bg-[#b8d42f] text-white' : 'bg-gray-100 text-gray-800 hover:bg-[#e6eeae]' }}">
                                {{ $range }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="mb-4">
                    <h4 class="font-semibold text-gray-700 mb-2 font-poppins" style="font-family: 'Poppins', sans-serif;">Grade</h4>
                    <div class="flex flex-wrap gap-2">
                        <button wire:click="$set('selectedGrade', '')"
                            class="px-4 py-1 rounded-lg font-semibold shadow-sm border font-century {{ $selectedGrade === '' ? 'bg-[#b8d42f] text-white' : 'bg-gray-100 text-gray-800 hover:bg-[#e6eeae]' }}">
                            All Grades
                        </button>
                        @forelse($gradeOptions as $grade)
                            <button wire:click="$set('selectedGrade', '{{ $grade }}')"
                                class="px-3 py-1 rounded-lg font-semibold shadow-sm border font-century {{ $selectedGrade === (string) $grade ? 'bg-[#b8d42f] text-white' : 'bg-gray-100 text-gray-800 hover:bg-[#e6eeae]' }}">
                                {{ $grade }}
                            </button>
                        @empty
                            <p class="text-gray-500 italic">No grade data available.</p>
                        @endforelse
                    </div>
                </div>

                <div class="mb-4">
                    <h4 class="font-semibold text-gray-700 mb-2 font-poppins" style="font-family: 'Poppins', sans-serif;">Date Range</h4>
                    <div class="flex flex-wrap gap-4 items-end">
                        <div>
                            <label for="fromDate" class="block text-sm font-medium text-gray-700">From:</label>
                            <input id="fromDate" type="date" wire:model="fromDate" class="border rounded px-3 py-2">
                        </div>
                        <div>
                            <label for="toDate" class="block text-sm font-medium text-gray-700">To:</label>
                            <input id="toDate" type="date" wire:model="toDate" class="border rounded px-3 py-2">
                        </div>
                        <button wire:click.prevent="resetFilters" class="bg-gradient-to-r from-[#7f9b05] to-[#d7e47a] text-white font-bold py-2 px-4 rounded whitespace-nowrap">?9?4 Reset Filters</button>
                    </div>
                </div>
            </div>
        </section>

        @if($this->filtersApplied)
            @php
                $filterPills = [];
                if ($selectedSchool) {
                    $filterPills[] = 'School: ' . ($schools[$selectedSchool] ?? $selectedSchool);
                }
                if ($selectedAbuseType) {
                    $filterPills[] = 'Abuse: ' . ($abuseTypes[$selectedAbuseType] ?? $selectedAbuseType);
                }
                if ($selectedAgeRange) {
                    $filterPills[] = 'Age: ' . $selectedAgeRange;
                }
                if ($selectedGrade !== '') {
                    $filterPills[] = 'Grade: ' . $selectedGrade;
                }
                if ($fromDate) {
                    $filterPills[] = 'From: ' . $fromDate;
                }
                if ($toDate) {
                    $filterPills[] = 'To: ' . $toDate;
                }
            @endphp
            <section class="bg-white rounded-lg shadow p-5 mb-10 border border-gray-100">
                <div class="flex items-center justify-between flex-wrap gap-3">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">Current Filters</h3>
                        <p class="text-sm text-gray-500">Applied to all charts and tables</p>
                    </div>
                    <div class="flex flex-wrap gap-2 text-xs font-semibold text-gray-600">
                        @forelse($filterPills as $pill)
                            <span class="px-3 py-1 rounded-full bg-lime-100 text-lime-700">{{ $pill }}</span>
                        @empty
                            <span class="text-gray-400">No additional filters selected</span>
                        @endforelse
                    </div>
                </div>
            </section>
        @endif

        @if(!empty($periodComparison))
            <section class="bg-white rounded-lg shadow p-5 mb-10 border border-gray-100">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">Period Comparison</h3>
                        <p class="text-sm text-gray-500">Comparing {{ $periodComparison['currentRange'][0] }} to {{ $periodComparison['currentRange'][1] }} with the previous {{ count(array_filter($periodComparison['currentRange'])) ? 'period' : 'month' }}.</p>
                    </div>
                    <div class="flex flex-wrap gap-3 text-sm font-semibold">
                        <span class="px-3 py-1 rounded-full bg-lime-100 text-lime-700">Current: {{ $periodComparison['currentCount'] }}</span>
                        <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-600">Previous: {{ $periodComparison['previousCount'] }}</span>
                        <span class="px-3 py-1 rounded-full {{ $periodComparison['difference'] >= 0 ? 'bg-red-100 text-red-600' : 'bg-lime-100 text-lime-700' }}">
                            {{ $periodComparison['difference'] >= 0 ? '+' : '' }}{{ $periodComparison['difference'] }} cases
                            @if($periodComparison['percentChange'] !== null)
                                ({{ $periodComparison['percentChange'] >= 0 ? '+' : '' }}{{ $periodComparison['percentChange'] }}%)
                            @endif
                        </span>
                    </div>
                </div>
            </section>
        @endif

        @if(!empty($dataQuality))
            <section class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10">
                <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
                    <p class="text-xs uppercase tracking-wide text-gray-500">Reports Missing Age</p>
                    <p class="text-2xl font-extrabold text-lime-700 mt-2">{{ $dataQuality['missingAge'] }}</p>
                    <p class="text-sm text-gray-400 mt-1">Out of {{ $dataQuality['total'] }} total records</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
                    <p class="text-xs uppercase tracking-wide text-gray-500">Reports Missing Grade</p>
                    <p class="text-2xl font-extrabold text-lime-700 mt-2">{{ $dataQuality['missingGrade'] }}</p>
                    <p class="text-sm text-gray-400 mt-1">Encourage schools to capture grade details</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
                    <p class="text-xs uppercase tracking-wide text-gray-500">Reports Missing Details</p>
                    <p class="text-2xl font-extrabold text-lime-700 mt-2">{{ $dataQuality['missingDetails'] }}</p>
                    <p class="text-sm text-gray-400 mt-1">Consider prompting for follow-up information</p>
                </div>
            </section>
        @endif

        @if($activeTab === 'dashboard')
            <!-- Charts -->
            <section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-10">
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-poppins font-bold mb-4 text-gray-700" style="font-family: 'Poppins', sans-serif;">Monthly Trends</h2>
                    <canvas id="reportsTrendsChart" class="w-full h-56"></canvas>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-poppins font-bold mb-4 text-gray-700" style="font-family: 'Poppins', sans-serif;">Age Demographics</h2>
                    <canvas id="demographicsChart" class="w-full h-56"></canvas>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-poppins font-bold mb-4 text-gray-700" style="font-family: 'Poppins', sans-serif;">Status Distribution</h2>
                    <canvas id="statusChart" class="w-full h-56"></canvas>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-poppins font-bold mb-4 text-gray-700" style="font-family: 'Poppins', sans-serif;">Grade Distribution</h2>
                    <canvas id="gradeDistributionChart" class="w-full h-56"></canvas>
                </div>
            </section>

            <section class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-poppins font-bold mb-4 text-lime-700" style="font-family: 'Poppins', sans-serif;">Reports by Abuse Type</h2>
                    <canvas id="abuseChart" class="w-full h-56"></canvas>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-poppins font-bold mb-4 text-lime-700" style="font-family: 'Poppins', sans-serif;">Anonymous vs Identified</h2>
                    <canvas id="anonymousChart" class="w-full h-56"></canvas>
                </div>
            </section>

            <section class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-12">
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-poppins font-bold mb-4 text-gray-700" style="font-family: 'Poppins', sans-serif;">Top Schools by Case Volume</h2>
                    @if(count($topSchools))
                        <canvas id="topSchoolsChart" class="w-full h-64"></canvas>
                        <ul class="mt-4 space-y-3">
                            @foreach($topSchools as $schoolName => $count)
                                <li class="flex items-center justify-between text-sm">
                                    <span class="font-semibold text-gray-700">{{ $loop->iteration }}. {{ $schoolName }}</span>
                                    <span class="text-lime-700 font-bold">{{ $count }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500">No school insights available yet.</p>
                    @endif
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-poppins font-bold text-gray-700" style="font-family: 'Poppins', sans-serif;">Recent Reports</h2>
                        <span class="text-xs bg-lime-100 text-lime-700 px-2 py-1 rounded">Read-only</span>
                    </div>
                    @if($recentReports->count())
                        <ul class="space-y-3">
                            @foreach($recentReports as $report)
                                <li class="p-3 rounded-lg border border-gray-100 hover:border-lime-200 hover:bg-lime-50 transition">
                                    <div class="flex justify-between items-center">
                                        <p class="font-semibold text-gray-800">{{ $report->case_number }}</p>
                                        <span class="text-xs font-bold px-2 py-1 rounded-full bg-gray-100 text-gray-700">{{ $report->status ? ucwords(str_replace('-', ' ', $report->status)) : 'Unknown' }}</span>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-1">
                                        {{ $report->school->school_name ?? 'No school recorded' }} ?? {{ optional($report->created_at)->format('Y-m-d') }}
                                    </p>
                                    <p class="text-sm text-gray-600 mt-1">
                                        {{ \Illuminate\Support\Str::limit($report->details ?? 'No description available.', 120) }}
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500">No recent reports match the current filters.</p>
                    @endif
                </div>
            </section>

            @php
                $topGradeLabel = $gradeDistribution ? array_key_first($gradeDistribution) : null;
                $topGradeCount = $topGradeLabel ? $gradeDistribution[$topGradeLabel] : 0;
            @endphp

            <section class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-12">
                <div class="bg-white rounded-lg shadow p-6 border border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-700 mb-3">Age Insights</h2>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li><strong class="text-gray-700">Average Age:</strong> {{ $ageStatistics['averageAge'] ?? 'N/A' }}</li>
                        <li><strong class="text-gray-700">Median Age:</strong> {{ $ageStatistics['medianAge'] ?? 'N/A' }}</li>
                        <li><strong class="text-gray-700">Minors:</strong> {{ $ageStatistics['minorsPercentage'] !== null ? $ageStatistics['minorsPercentage'].'%' : 'N/A' }} of age-reported cases</li>
                        <li><strong class="text-gray-700">Under 10:</strong> {{ $ageStatistics['underTenCount'] ?? 0 }} cases</li>
                        <li><strong class="text-gray-700">Sample Size:</strong> {{ $ageStatistics['sampleSize'] ?? 0 }}</li>
                    </ul>
                </div>
                <div class="bg-white rounded-lg shadow p-6 border border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-700 mb-3">Grade Highlights</h2>
                    @if($topGradeLabel)
                        <p class="text-sm text-gray-600">Most reported grade:</p>
                        <p class="text-2xl font-extrabold text-lime-700 mt-1">{{ $topGradeLabel }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ $topGradeCount }} cases in current view</p>
                    @else
                        <p class="text-sm text-gray-500">No grade data available for the selected filters.</p>
                    @endif
                    @if(count($gradeDistribution) > 1)
                        <div class="mt-4">
                            <h3 class="text-xs uppercase text-gray-500 mb-2">Top Grades</h3>
                            <ul class="space-y-1 text-sm text-gray-600">
                                @foreach(array_slice($gradeDistribution, 0, 4, true) as $grade => $count)
                                    <li class="flex justify-between"><span>{{ $grade }}</span><span class="font-semibold text-lime-700">{{ $count }}</span></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="bg-white rounded-lg shadow p-6 border border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-700 mb-3">Attention Required</h2>
                    <p class="text-xs uppercase text-gray-500 mb-2">Open or pending statuses</p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        @forelse($attentionStatuses as $item)
                            <li class="border border-gray-100 rounded-lg px-3 py-2">
                                <div class="flex items-center justify-between">
                                    <span class="font-semibold text-gray-700">{{ ucwords(str_replace('-', ' ', $item['status'])) }}</span>
                                    <span class="text-lime-700 font-bold">{{ $item['count'] }}</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Oldest case: {{ $item['oldestDays'] !== null ? $item['oldestDays'].' days' : 'N/A' }}</p>
                                <p class="text-xs text-gray-400">Last update: {{ $item['lastUpdate'] ?? 'N/A' }}</p>
                            </li>
                        @empty
                            <li class="text-gray-500">All statuses are clear across current filters.</li>
                        @endforelse
                    </ul>
                </div>
            </section>
        @else
            <!-- Reports Tab Content -->
            <section class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10">
                <div class="bg-white rounded-lg shadow p-5">
                    <p class="text-xs uppercase text-gray-500">Total Reports</p>
                    <p class="text-3xl font-extrabold text-lime-700 mt-2">{{ $totalReports }}</p>
                    <p class="text-sm text-gray-400 mt-1">Across current filters</p>
                </div>
                <div class="bg-white rounded-lg shadow p-5">
                    <p class="text-xs uppercase text-gray-500">Anonymous Reports</p>
                    <p class="text-3xl font-extrabold text-lime-700 mt-2">{{ $anonymousCounts['anonymous'] ?? 0 }}</p>
                    <p class="text-sm text-gray-400 mt-1">{{ $anonymousCounts['non_anonymous'] ?? 0 }} identified</p>
                </div>
                <div class="bg-white rounded-lg shadow p-5">
                    <p class="text-xs uppercase text-gray-500">Active Statuses</p>
                    <p class="text-3xl font-extrabold text-lime-700 mt-2">{{ collect($statusCounts)->filter()->count() }}</p>
                    <p class="text-sm text-gray-400 mt-1">Statuses with activity</p>
                </div>
            </section>

            <section class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-bold text-gray-700 mb-4">Status Breakdown</h2>
                    <table class="min-w-full text-sm border border-gray-200 rounded">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                            <tr>
                                <th class="px-3 py-2 border">Status</th>
                                <th class="px-3 py-2 border text-right">Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($statusCounts as $status => $count)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-3 py-2 border">{{ ucwords(str_replace('-', ' ', $status)) }}</td>
                                    <td class="px-3 py-2 border text-right font-semibold">{{ $count }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-bold text-gray-700 mb-4">Abuse Types</h2>
                    <table class="min-w-full text-sm border border-gray-200 rounded">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                            <tr>
                                <th class="px-3 py-2 border">Type</th>
                                <th class="px-3 py-2 border text-right">Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($abuseTypesData as $type => $count)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-3 py-2 border">{{ $type }}</td>
                                    <td class="px-3 py-2 border text-right font-semibold">{{ $count }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-3 py-4 text-center text-gray-500">No abuse type data available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="bg-white rounded-lg shadow p-6 mb-10">
                <h2 class="text-lg font-bold text-gray-700 mb-4">Grade Distribution</h2>
                @if(count($gradeDistribution))
                    <table class="min-w-full text-sm border border-gray-200 rounded">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                            <tr>
                                <th class="px-3 py-2 border">Grade</th>
                                <th class="px-3 py-2 border text-right">Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($gradeDistribution as $grade => $count)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-3 py-2 border">{{ $grade }}</td>
                                    <td class="px-3 py-2 border text-right font-semibold">{{ $count }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-sm text-gray-500">No grade data available for the selected filters.</p>
                @endif
            </section>

            <section class="bg-white rounded-lg shadow p-6 mb-12">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
                    <div>
                        <h2 class="text-xl font-poppins font-bold text-gray-700" style="font-family: 'Poppins', sans-serif;">Reports Detail View</h2>
                        <p class="text-sm text-gray-500">Every report matching current filters with key attributes.</p>
                    </div>
                    <div class="flex flex-wrap gap-3 text-xs uppercase text-gray-500">
                        <span class="px-3 py-1 rounded-full bg-lime-100 text-lime-700 font-semibold">Total: {{ $totalReports }}</span>
                        <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-600">Anonymous: {{ $anonymousCounts['anonymous'] ?? 0 }}</span>
                        <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-600">Identified: {{ $anonymousCounts['non_anonymous'] ?? 0 }}</span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 rounded-lg text-sm">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                            <tr>
                                <th class="px-3 py-2 border">Case #</th>
                                <th class="px-3 py-2 border">School</th>
                                <th class="px-3 py-2 border">Abuse Type</th>
                                <th class="px-3 py-2 border">Status</th>
                                <th class="px-3 py-2 border">Created</th>
                                <th class="px-3 py-2 border">Anonymous</th>
                                <th class="px-3 py-2 border">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports as $report)
                                <tr class="hover:bg-lime-50">
                                    <td class="px-3 py-2 border font-semibold text-gray-700">{{ $report->case_number }}</td>
                                    <td class="px-3 py-2 border text-gray-600">{{ $report->school->school_name ?? 'No school recorded' }}</td>
                                    <td class="px-3 py-2 border text-gray-600">{{ $report->abuseType->type_name ?? 'N/A' }}</td>
                                    <td class="px-3 py-2 border text-gray-600">{{ $report->status ? ucwords(str_replace('-', ' ', $report->status)) : 'Unknown' }}</td>
                                    <td class="px-3 py-2 border text-gray-600">{{ optional($report->created_at)->format('Y-m-d') }}</td>
                                    <td class="px-3 py-2 border text-gray-600">{{ $report->is_anonymous ? 'Yes' : 'No' }}</td>
                                    <td class="px-3 py-2 border text-gray-600">{{ \Illuminate\Support\Str::limit($report->details ?? 'No description available.', 80) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-3 py-4 text-center text-gray-500">No reports available with the current filters.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        @endif

        <!-- Status Modal -->
        @if($showModal)
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white rounded-lg shadow-lg p-6 max-w-3xl w-full max-h-[85vh] overflow-y-auto">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold">{{ $modalStatus ? ucwords(str_replace('-', ' ', $modalStatus)) : 'All' }} Reports</h3>
                        <button wire:click="closeModal" class="text-red-600 font-bold text-2xl">&times;</button>
                    </div>

                    @if($statusReports->count())
                        <table class="w-full border border-gray-300 rounded table-auto">
                            <thead class="bg-gray-100 font-semibold">
                                <tr>
                                    <th class="border p-2 text-left">Case Number</th>
                                    <th class="border p-2 text-left">Abuse Type</th>
                                    <th class="border p-2 text-left">Status</th>
                                    <th class="border p-2 text-left">Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($statusReports as $report)
                                    <tr class="cursor-pointer hover:bg-gray-100" wire:click="showReportDetails({{ $report->id }})">
                                        <td class="border p-2">{{ $report->case_number }}</td>
                                        <td class="border p-2">{{ $report->abuseType->type_name ?? 'N/A' }}</td>
                                        <td class="border p-2">{{ ucwords(str_replace('-', ' ', $report->status)) }}</td>
                                        <td class="border p-2">{{ $report->created_at->format('Y-m-d') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No reports found for this status.</p>
                    @endif

                    <?php if (!empty($selectedReportDetails)): ?>
                        <div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50">
                            <div class="bg-white rounded-lg shadow-lg p-6 max-w-lg w-full max-h-[80vh] overflow-y-auto relative">
                                <h4 class="text-lg font-bold mb-4">Report Details</h4>
                                <button wire:click="closeReportDetails" class="absolute top-4 right-4 text-red-600 font-bold text-2xl">&times;</button>

                                <?php $details = $selectedReportDetails; ?>
                                <p><strong>Case Number:</strong> <?= e(data_get($details, 'case_number', 'N/A')) ?></p>
                                <p><strong>Abuse Type:</strong> <?= e(data_get($details, 'abuse_type', 'N/A')) ?></p>
                                <p><strong>Status:</strong> <?= e(data_get($details, 'status', 'N/A')) ?></p>
                                <p><strong>Created:</strong> <?= e(data_get($details, 'created_at', 'N/A')) ?></p>
                                <p><strong>Province:</strong> <?= e(data_get($details, 'province', 'N/A')) ?></p>
                                <p><strong>District:</strong> <?= e(data_get($details, 'district', 'N/A')) ?></p>
                                <p><strong>School:</strong> <?= e(data_get($details, 'school', 'N/A')) ?></p>
                                <p><strong>Age:</strong> <?= e(data_get($details, 'age', 'N/A')) ?></p>
                                <p><strong>Anonymous:</strong> <?= e(data_get($details, 'anonymous', 'N/A')) ?></p>
                                <p><strong>Details:</strong></p>
                                <p class="whitespace-pre-wrap border rounded p-3 bg-gray-50"><?= e(data_get($details, 'details', 'No additional details.')) ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        @endif

    </main>

</div>

@php
    $initialPayload = [
        'months' => $months,
        'monthlyCounts' => $monthlyCounts,
        'ageGroups' => $ageGroups,
        'abuseTypes' => $abuseTypesData,
        'statusDistribution' => $statusDistribution,
        'anonymousCounts' => $anonymousCounts,
        'topSchools' => $topSchools,
        'gradeDistribution' => $gradeDistribution,
    ];
@endphp

<script id="district-initial-data" type="application/json">{!! json_encode($initialPayload) !!}</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    let trendChart, ageChart, abuseChartInstance, statusChart, anonymousChart, topSchoolsChart, gradeChart;
    const initialDataElement = document.getElementById('district-initial-data');
    const initialData = initialDataElement ? JSON.parse(initialDataElement.textContent || '{}') : {};

    function renderTrendChart(months, values) {
        const canvas = document.getElementById("reportsTrendsChart");
        if (!canvas) return;
        const ctx = canvas.getContext("2d");
        if (trendChart) trendChart.destroy();
        trendChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    data: values,
                    backgroundColor: '#D5E36C'
                }]
            },
            options: {responsive: true, scales: {y: {beginAtZero: true}}}
        });
    }

    function renderAgeChart(labels, values) {
        const canvas = document.getElementById("demographicsChart");
        if (!canvas) return;
        const ctx = canvas.getContext("2d");
        if (ageChart) ageChart.destroy();
        ageChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels,
                datasets: [{
                    label: "Age Groups",
                    data: values,
                    borderWidth: 2,
                    borderColor: "#A7C21A",
                    backgroundColor: "rgba(74, 255, 128, 0.35)",
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {responsive: true, scales: {y: {beginAtZero: true}}}
        });
    }

    function renderAbuseChart(abuseData) {
        const canvas = document.getElementById("abuseChart");
        if (!canvas) return;
        const ctx = canvas.getContext("2d");
        if (abuseChartInstance) abuseChartInstance.destroy();
        const labels = Object.keys(abuseData);
        const values = Object.values(abuseData);
        abuseChartInstance = new Chart(ctx, {
            type: "bar",
            data: {
                labels: labels.length ? labels : ['No data'],
                datasets: [{
                    data: values.length ? values : [0],
                    backgroundColor: ['#b8d42f','#c7e03a','#f5cf4d','#e38645','#5ea241','#3fa796']
                }]
            },
            options: {plugins: {legend: {display: false}}, scales: {y: {beginAtZero: true}}}
        });
    }

    function renderGradeChart(distribution) {
        const canvas = document.getElementById("gradeDistributionChart");
        if (!canvas) return;
        const ctx = canvas.getContext("2d");
        if (gradeChart) gradeChart.destroy();

        const labels = Object.keys(distribution || {});
        const values = Object.values(distribution || {});

        gradeChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels.length ? labels : ['No data'],
                datasets: [{
                    data: values.length ? values : [0],
                    backgroundColor: '#34d399',
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });
    }

    function renderStatusChart(statusData) {
        const canvas = document.getElementById("statusChart");
        if (!canvas) return;
        const ctx = canvas.getContext("2d");
        if (statusChart) statusChart.destroy();
        const labelsRaw = Object.keys(statusData);
        const labels = labelsRaw.length ? labelsRaw.map(label => label.replace(/-/g, ' ')) : ['No data'];
        const values = Object.values(statusData);
        statusChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels,
                datasets: [{
                    data: values.length ? values : [1],
                    backgroundColor: ['#ff7675','#fdcb6e','#74b9ff','#55efc4','#ffeaa7','#636e72'],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {legend: {position: 'bottom'}},
                cutout: '55%'
            }
        });
    }

    function renderAnonymousChart(counts) {
        const canvas = document.getElementById("anonymousChart");
        if (!canvas) return;
        const ctx = canvas.getContext("2d");
        if (anonymousChart) anonymousChart.destroy();
        const anonymous = counts && typeof counts.anonymous !== 'undefined' ? counts.anonymous : 0;
        const nonAnonymous = counts && typeof counts.non_anonymous !== 'undefined' ? counts.non_anonymous : 0;
        const hasData = anonymous || nonAnonymous;
        anonymousChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Anonymous', 'Non-Anonymous'],
                datasets: [{
                    data: hasData ? [anonymous, nonAnonymous] : [1, 0],
                    backgroundColor: ['#22c55e', '#94a3b8'],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {legend: {position: 'bottom'}},
                cutout: '65%'
            }
        });
    }

    function renderTopSchoolsChart(topSchools) {
        const canvas = document.getElementById("topSchoolsChart");
        if (!canvas) return;
        const labels = Object.keys(topSchools);
        const values = Object.values(topSchools);

        if (topSchoolsChart) topSchoolsChart.destroy();

        if (!labels.length) {
            canvas.style.display = 'none';
            return;
        }

        canvas.style.display = 'block';

        topSchoolsChart = new Chart(canvas.getContext("2d"), {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    data: values,
                    backgroundColor: '#4ade80'
                }]
            },
            options: {
                indexAxis: 'y',
                plugins: {legend: {display: false}},
                scales: {
                    x: {beginAtZero: true}
                }
            }
        });
    }

    document.addEventListener("DOMContentLoaded", () => {
        renderTrendChart(initialData.months, initialData.monthlyCounts);
        renderAgeChart(Object.keys(initialData.ageGroups), Object.values(initialData.ageGroups));
        renderAbuseChart(initialData.abuseTypes);
        renderStatusChart(initialData.statusDistribution);
        renderAnonymousChart(initialData.anonymousCounts);
        renderTopSchoolsChart(initialData.topSchools);
        renderGradeChart(initialData.gradeDistribution);
    });

    Livewire.on("updateCharts", d => {
        renderTrendChart(d.months, d.monthlyCounts);
        renderAgeChart(Object.keys(d.ageGroups), Object.values(d.ageGroups));
        renderAbuseChart(d.abuseTypes);
        renderStatusChart(d.statusDistribution);
        renderAnonymousChart(d.anonymousCounts);
        renderTopSchoolsChart(d.topSchools);
        renderGradeChart(d.gradeDistribution);
    });

    Livewire.on('exportDistrictDashboard', () => {
        const element = document.getElementById('district-dashboard-root');
        if (!element) {
            alert('Dashboard area not found for export.');
            return;
        }

        html2pdf().from(element).set({
            margin: 10,
            filename: 'district-admin-dashboard.pdf',
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
        }).save();
    });
</script>
<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
                function exportPDF() {
                    const element = document.getElementById('main-content'); // ?0?9?0?4?? grabs main content only
                    if (!element) {
                        alert("Main content not found! Add id='main-content' to your <main> tag.");
                        return;
                    }

                    html2pdf().from(element).set({
                        margin: 10,
                        filename: 'district-admin-dashboard.pdf',
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
