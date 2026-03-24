

<div class="flex min-h-screen m-0 p-0">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg flex flex-col justify-between sticky top-0 h-screen" style="background-color: white">
        <div>
            <nav style="margin-top: 10px">
                <ul class="space-y-2">
                    <!-- Dashboard -->
                     <div class="flex justify-center" style="margin-bottom: 70px">
                          <img src="{{ asset('images/logo.png') }}" 
                               alt="Safe Space Logo" 
                               style="width: 125px; height: 110px;">
                    </div>

                    <li class="flex justify-center">
                        <a href="/admin/dashboard"
                            class="flex items-center font-montserrat-black rounded-lg transition-all
                            {{ Request::is('admin/dashboard') 
                                ? 'bg-gradient-to-r from-[#38b6ff] to-[#38b6ff]' : 'hover:bg-gradient-to-r from-[#38b6ff] to-[#38b6ff]' }}"
                            style="width: 130px; height: 41px; color: white; font-size: 15px; padding-left: 20px;">
                            <i></i>Dashboard
                        </a>

                    </li>
                    <!-- Reports -->
                    <li class="flex justify-center">
                        <a href="/admin/reports"
                            class="flex items-center font-montserrat-black rounded-lg transition-all
                            {{ Request::is('admin/reports') ? 'bg-gradient-to-r from-[#38b6ff] to-[#38b6ff]' : 'hover:bg-gradient-to-r from-[#38b6ff] to-[#38b6ff]' }}"
                            style="width: 130px; height: 41px; color: #545454; font-size: 15px; padding-left: 20px;">
                            <i></i>Reports
                        </a>
                    </li>
                    <!-- My Profile -->
                    <li class="flex justify-center">
                        <a href="/admin/settings"
                            class="flex items-center font-montserrat-black rounded-lg transition-all
                            {{ Request::is('admin/settings') ? 'bg-gradient-to-r from-[#38b6ff] to-[#38b6ff]' : 'hover:bg-gradient-to-r from-[#38b6ff] to-[#38b6ff]' }}"
                            style="width: 130px; height: 41px; color: #545454; font-size: 15px; padding-left: 20px;">
                            <i></i>My Profile
                        </a>
                    </li>
                    <!-- Export PDF -->
                    <li class="flex justify-center">
                        <a href="#" onclick="exportPDF()"
                            class="flex items-center font-montserrat-black rounded-lg transition-all
                            {{ Request::is('admin/export') ? 'bg-gradient-to-r from-[#38b6ff] to-[#38b6ff]' : 'hover:bg-gradient-to-r from-[#38b6ff] to-[#38b6ff]' }}"
                            style="width: 130px; height: 41px; color: #545454; font-size: 15px; padding-left: 20px;">
                            <i></i>Export PDF
                        </a>
                    </li>
                    <!-- Sign Out -->
                    <li class="flex justify-center">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex items-center font-montserrat-black rounded-lg transition-all
                                hover:bg-gradient-to-r from-[#38b6ff] to-[#38b6ff]"
                                style="width: 130px; height: 41px; color: #545454; font-size: 15px; padding-left: 20px;">
                                Sign Out
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
    <!-- Main Content Wrapper with Topbar -->
    
        <!-- Main Content -->
        <main id="main-content" class="flex-1 p-8 space-y-8 overflow-auto" style="background: white">
            <div class="w-full flex items-center space-x-3 mb-4 justify-end p-4 bg-white  sticky top-0 z-40" style="min-height: 64px;" style="background-color: #fffbf7">
            <div class="flex flex-col text-right">
                <p class="font-montserrat-black font-bold text-[#38b6ff]" style="font-size: 16px;">{{ auth()->user()->name ?? 'Admin' }}</p>
                <p class="text-sm text-gray-500 font-montserrat-black" style="font-size: 15px;">Administrator</p>
            </div>
            @if(auth()->user()->profile_picture)
            <img src="{{ auth()->user()->profile_picture_url }}" alt="Profile Picture" class="w-10 h-10 rounded-full object-cover border-2 border-gray-300 shadow">
            @else
            <div class="w-10 h-10 bg-gradient-to-r from-gray-400 to-gray-600 rounded-full flex items-center justify-center border-2 border-gray-300 shadow">
                <i class="fas fa-user-circle text-white text-5xl"></i>
            </div>
            @endif
        </div>

            <h1 class="font-bold text-[#545454] uppercase text-3xl mb-12  tracking-wide">
                {{ ucfirst($role) }} Admin Dashboard
            </h1>

  <div class="bg-white rounded-[20px] py-6 px-8 mb-6 Height: 50px" style="border: 3px solid #c7da30;">
                <h3 class="text-2xl font-montserrat-black text-gray-700 text-center mb-6 font-bold">Filters</h3>
    
                <div class="flex flex-wrap items-center justify-center gap-6">
                    <!-- Grade Filter -->
                    <div class="flex flex-col">
                        
                        <select wire:model.live="selectedGrade" 
                                class="rounded-[15px] px-4 py-3 focus:outline-none focus:ring-2 font-montserrat text-gray-600 text-center appearance-none"
                                style="width: 180px; border: 3px solid #c7da30; height: 50px;">
                            <option value="">Any Grade</option>
                            <option value="1">Grade 1</option>
                            <option value="2">Grade 2</option>
                            <option value="3">Grade 3</option>
                            <option value="4">Grade 4</option>
                            <option value="5">Grade 5</option>
                            <option value="6">Grade 6</option>
                            <option value="7">Grade 7</option>
                            <option value="8">Grade 8</option>
                            <option value="9">Grade 9</option>
                            <option value="10">Grade 10</option>
                            <option value="11">Grade 11</option>
                            <option value="12">Grade 12</option>
                        </select>
                    </div>

                    <!-- Abuse Type Filter -->
                    <div class="flex flex-col">

                        <select wire:model.live="selectedAbuseType" 
                                class="rounded-[15px] px-4 py-3 focus:outline-none focus:ring-2 font-montserrat text-gray-600 text-center appearance-none"
                                style="width: 180px; border: 3px solid #c7da30; height: 50px;">
                            <option value="">Any Abuse Type</option>
                            <option value="bullying">Bullying</option>
                            <option value="weapons">Weapons</option>
                            <option value="substance_abuse">Substance Abuse</option>
                            <option value="violence">Violence</option>
                            <option value="teenage_pregnancy">Teenage Pregnancy</option>
                        </select>
                    </div>

                    <!-- Age Filter -->
                    <div class="flex flex-col">
                        <select wire:model.live="selectedAge" 
                                class="rounded-[15px] px-4 py-3 focus:outline-none focus:ring-2 font-montserrat text-gray-600 text-center appearance-none"
                                style="width: 180px; border: 3px solid #c7da30; height: 50px;">
                            <option value="">Any Age</option>
                            <option value="0-10">0 - 10</option>
                            <option value="11-15">11 - 15</option>
                            <option value="16-20">16 - 20</option>
                            <option value="21-25">21 - 25</option>
                            <option value="26-30">26 - 30</option>
                            <option value="30+">30+</option>
                        </select>
                    </div>

                    <!-- From Date -->
                    <div class="flex flex-col">
                        
                        <div class="relative">
                            From:
                            <input type="date" 
                                wire:model.live="fromDate"
                                class="rounded-[15px] px-4 py-3 focus:outline-none focus:ring-2 font-montserrat text-gray-600 text-center appearance-none"
                                style="width: 180px; border: 3px solid #c7da30; height: 50px;">
                            <!-- Calendar Icon -->
                            <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- To Date -->
                    <div class="flex flex-col">
                        
                        <div class="relative">
                            To:
                            <input type="date" 
                                wire:model.live="toDate"
                                class="rounded-[15px] px-4 py-3 focus:outline-none focus:ring-2 font-montserrat text-gray-600 text-center appearance-none"
                                style="width: 180px; border: 3px solid #c7da30; height: 50px;">
                            <!-- Calendar Icon -->
                            <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Refresh Button -->
                    <div class="flex flex-col justify-end mb-10">
                        <label class="block font-montserrat-black text-gray-700 text-lg mb-2 text-center opacity-0">Refresh</label>
                        <button wire:click="resetAllFilters"
                                class="font-montserrat-black rounded-full flex items-center justify-center transition-all duration-300 hover:scale-105"
                                style="width: 180px; height: 50px; border: 3px solid #c7da30; color: #38b6ff; background-color: white; font-size: 18px;"
                                onmouseover="this.style.backgroundColor='#f0f8ff'"
                                onmouseout="this.style.backgroundColor='white'">
                            Refresh
                        </button>
                    </div>
                </div>
            </div>



            
            <!-- Modified existing metric cards (updated colors, sizes, and text color) -->
            <div class="flex gap-3 mb-8 flex-wrap">
                <a href="{{ route('admin.reports.index', ['filter' => 'all']) }}"
                    class="rounded-lg shadow p-3 flex flex-col items-center justify-center transition-all duration-200 hover:shadow-xl hover:scale-105"
                    style="background-color: #38b6ff; width: 128px; height: 90px; color: #ffffff;">

                    <div class="text-white font-montserrat-black" style="font-size: 13px;">Total Reports</div>
                    <div id="totalReports" class="font-bold text-white mt-1 font-montserrat-black" style="font-size: 22px">{{ $reports->count() }}</div>
                </a>
                <a href="{{ route('admin.reports.index', ['filter' => 'awaiting-resolution']) }}"
                    class="rounded-lg shadow p-3 flex flex-col items-center justify-center transition-all duration-200 hover:shadow-xl hover:scale-105"
                    style="background-color: #fcb825; width: 128px; height: 90px; color: #ffffff;">
                    <div class="text-white mt-0 font-montserrat-black" style="font-size: 13px;">Awaiting Resolution</div>
                    <div id="awaitingResolutionCount" class="font-bold text-white mt-1 font-montserrat-black" style="font-size: 22px">{{ $reports->where('status', 'awaiting-resolution')->count() }}</div>
                </a>
                <a href="{{ route('admin.reports.index', ['filter' => 'forwarded']) }}"
                    class="rounded-lg shadow p-3 flex flex-col items-center justify-center transition-all duration-200 hover:shadow-xl hover:scale-105"
                    style="background-color: #00c382; width: 128px; height: 90px; color: #ffffff;">
                    <div class="text-white mt-0 font-montserrat-black" style="font-size: 13px;">Forwarded</div>
                    <div id="forwardedCount" class="font-bold text-white mt-1 font-montserrat-black" style="font-size: 22px">{{ $reports->where('status', 'forwarded')->count() }}</div>
                </a>
                <a href="{{ route('admin.reports.index', ['filter' => 'under-review']) }}"
                    class="rounded-lg shadow p-3 flex flex-col items-center justify-center transition-all duration-200 hover:shadow-xl hover:scale-105"
                    style="background-color: #9b57cc; width: 128px; height: 90px; color: #ffffff;">
                    <div class="text-white mt-0 font-montserrat-black" style="font-size: 13px;">Under Review</div>
                    <div id="underReviewCount" class="font-bold text-white mt-1 font-montserrat-black" style="font-size: 22px">{{ $reports->where('status', 'under-review')->count() }}</div>
                </a>
                <a href="{{ route('admin.reports.index', ['filter' => 'closed']) }}"
                    class="rounded-lg shadow p-3 flex flex-col items-center justify-center transition-all duration-200 hover:shadow-xl hover:scale-105"
                    style="background-color: #81acef; width: 128px; height: 90px; color: #ffffff;">
                    <div class="text-white mt-0 font-montserrat-black" style="font-size: 13px;">Closed</div>
                    <div id="closedCount" class="font-bold text-white mt-1 font-montserrat-black" style="font-size: 22px">{{ $reports->where('status', 'closed')->count() }}</div>
                </a>
                <a href="{{ route('admin.reports.index', ['filter' => 'unresolved']) }}"
                    class="rounded-lg shadow p-3 flex flex-col items-center justify-center transition-all duration-200 hover:shadow-xl hover:scale-105"
                    style="background-color: #99c4d3; width: 128px; height: 90px; color: #ffffff;">
                    <div class="text-white mt-0 font-montserrat-black" style="font-size: 13px;">Closed Unresolved</div>
                    <div id="unresolvedCount" class="font-bold text-white mt-1 font-montserrat-black" style="font-size: 22px">{{ $reports->where('status', 'unresolved')->count() }}</div>
                </a>
                <a href="{{ route('admin.reports.index', ['filter' => 'false-report']) }}"
                    class="rounded-lg shadow p-3 flex flex-col items-center justify-center transition-all duration-200 hover:shadow-xl hover:scale-105"
                    style="background-color: #ff66c4; width: 128px; height: 90px; color: #ffffff;">
                    <div class="text-white mt-0 font-montserrat-black whitespace-nowrap" style="font-size: 13px;">False-Report</div>
                    <div id="falseReportCount" class="font-bold text-white mt-1 font-montserrat-black" style="font-size: 22px">{{ $reports->where('status', 'false-report')->count() }}</div>
                </a>
            </div>
            <!-- Data Visualization -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6">

    {{-- 1. Report by Abuse type (Chart - Left Column, Row 1) --}}
    <div class="bg-white rounded-lg shadow p-6 md:col-span-2" wire:ignore>
        <h2 class="text-xl font-bold mb-4" style="color: #38b6ff;">Report by Abuse type</h2>
        <canvas id="abuseTypeChart" class="w-full h-96"></canvas>
    </div>

     <!-- Age Filter-->
   
<!-- School grade filter-->

    {{-- NEW: REPORTER ANONYMITY PIE CHART (Row 2, Col 1 & 2) - MOVED DOWN --}}
   <div class="bg-white rounded-lg shadow p-6 md:col-span-2" wire:ignore>
        <h2 class="text-xl font-bold text-gray-700 mb-4"style="color: #38b6ff;">Anonymous vs Identified</h2>
        {{-- CRITICAL FIX: Add position: relative; --}}
        <div class="flex items-center justify-center h-full max-h-96 w-full" style="height: 350px; position: relative;">
            <canvas id="anonymityPieChart"></canvas>
        </div>
    </div>
    
    {{-- 4. Doughnut Chart for Age Group Distribution (Row 2, Col 3 & 4) --}}
    {{-- The md:col-start-3 class forces this element to the third column on medium screens and larger. --}}
    <div class="bg-white rounded-lg shadow p-6 md:col-start-3 md:col-span-2" wire:ignore>
        <h2 class="text-xl font-bold mb-4" style="color: #38b6ff;">Total Reports by Age Group</h2>
        <div class="flex items-center justify-center h-full max-h-96">
            <canvas id="ageDoughnutChart"></canvas>
        </div>
    </div>
    
    {{-- NEW: Line Graph for Reports Trend by Age (Row 2, Col 3 & 4) --}}
    {{-- This will take the left side of the third row, starting at column 1 and spanning 2 columns --}}
    <div class="bg-white rounded-lg shadow p-6 md:col-span-2" wire:ignore>
       <h2 class="text-xl font-bold mb-4" style="color: #38b6ff;">Total Reports by Age Group</h2>
        
        {{-- CRITICAL: Wrapper with fixed height for chart control --}}
        <div style="max-height: 400px; height: 400px; position: relative;"> 
            <canvas id="ageLineChart"></canvas>
        </div>
        
        {{-- Handle the "No Data" message --}}
        @if (empty($ageTrendData) || count($ageTrendData) === 0)
            <div class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-75 z-10">
                <div class="text-center text-gray-500 font-semibold p-4 rounded">
                    No monthly report trend data found for the current filter.
                </div>
            </div>
        @endif
    </div>

            <!-- Reports by Status Chart -->
<div class="bg-white rounded-lg shadow p-6 md:col-start-3 md:col-span-2" wire:ignore>
    <h2 class="text-xl font-bold mb-4" style="color: #38b6ff;">Total Reports by Status</h2>
   <canvas id="statusChart" style="max-height: 300px; width: 100%;"></canvas>

</div>

</div>


 <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script>
<script>
  // Global variables for chart instances
let abuseTypeChartInstance = null;
let ageDoughnutChartInstance = null;
let ageLineChartInstance = null;
let anonymityPieChartInstance = null; // NEW: Global variable for Pie Chart
let anonymityDoughnutChartInstance = null;


// ========================================================================
// 1. ABUSE TYPE CHART (Bar Chart - Interactive)
// ========================================================================

function renderAbuseTypeChart(labels, chartData) {
    let canvas = document.getElementById('abuseTypeChart');
    if (!canvas) {
        console.error('Abuse Type Chart canvas element not found.');
        return;
    }
    
    const chartContainer = canvas.parentElement;
    let noDataMsg = document.getElementById('noDataMessage');
    
    if (!noDataMsg && chartContainer) {
        noDataMsg = document.createElement('p');
        noDataMsg.id = 'noDataMessage';
        noDataMsg.className = 'text-center text-gray-500 mt-8 font-semibold';
        chartContainer.appendChild(noDataMsg);
    }

    const totalCount = chartData.reduce((sum, current) => sum + current, 0);

    if (abuseTypeChartInstance) {
        abuseTypeChartInstance.destroy();
        abuseTypeChartInstance = null;
    }
    
    if (totalCount === 0) {
        canvas.style.display = 'none';
        if (noDataMsg) {
            noDataMsg.textContent = 'No abuse report data found for the selected filters.';
            noDataMsg.style.display = 'block';
        }
        return;
    }

    canvas.style.display = 'block';
    if (noDataMsg) noDataMsg.style.display = 'none';

    const ctx = canvas.getContext('2d');

    const formattedLabels = labels.map(label => {
        return (label === 'Teenage Pregnancy') ? ['Teenage', 'Pregnancy'] : label;
    });

    // ðŸŽ¨ CUSTOM COLOR SET â€” REPEAT IF MORE BARS EXIST
    const barColors = [
        '#38b6ff',
        '#fcb825',
        '#00c382',
        '#9b57cc',
        '#81acef',
        '#99c4d3',
        '#ff66c4'
    ];

    // Assign color per bar
    const backgroundColors = chartData.map((_, i) => barColors[i % barColors.length]);

    abuseTypeChartInstance = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: formattedLabels,
            datasets: [{
                label: 'Number of Reports',
                data: chartData,
                backgroundColor: backgroundColors,
                borderColor: backgroundColors,
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: { 
                    display: true,
                    text: 'Total Reports By Abuse Type',
                    color: '#38b6ff',
                    font: { size: 18, weight: 'bold' }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: { 
                        display: true, 
                        text: 'Number of Reports',
                        color: '#38b6ff',
                        font: { weight: 'bold' }
                    },
                    ticks: { 
                        color: '#38b6ff',
                        callback: v => Number.isInteger(v) ? v : null
                    }
                },
                x: {
                    ticks: { 
                        color: '#38b6ff',
                        maxRotation: 45,
                        minRotation: 45,
                        autoSkip: false 
                    }
                }
            },
            
            onClick: (event, elements) => {
                if (elements.length > 0) {
                    const clickedIndex = elements[0].index;
                    const clickedAbuseType = labels[clickedIndex];
                    
                    Livewire.dispatch('updateAbuseChartFilters', { 
                        filterType: 'abuse_type', 
                        value: clickedAbuseType 
                    });
                }
            }
        }
    });
}


// ========================================================================
// 2. AGE DOUGHNUT CHART (Interactive)
// ========================================================================

function renderAgeDoughnutChart(labels, chartData) {
    let canvas = document.getElementById('ageDoughnutChart');
    if (!canvas) return;

    const chartContainer = canvas.parentElement;
    let noDataMsg = document.getElementById('noDataMessageAge');
    
    // Ensure No Data Message element exists for the age chart
    if (!noDataMsg && chartContainer) {
        noDataMsg = document.createElement('p');
        noDataMsg.id = 'noDataMessageAge';
        noDataMsg.className = 'text-center text-gray-500 mt-8 font-semibold';
        chartContainer.appendChild(noDataMsg);
    }

    // Destroy existing chart instance
    if (ageDoughnutChartInstance) {
        ageDoughnutChartInstance.destroy();
        ageDoughnutChartInstance = null;
    }

    // Check for no data
    const totalCount = chartData.reduce((sum, current) => sum + current, 0);
    if (totalCount === 0) {
        canvas.style.display = 'none';
        if (noDataMsg) {
            noDataMsg.textContent = 'No age distribution data found for the selected reports.';
            noDataMsg.style.display = 'block';
        }
        return;
    } 
    
    canvas.style.display = 'block';
    if (noDataMsg) noDataMsg.style.display = 'none';

    const ctx = canvas.getContext('2d');

    ageDoughnutChartInstance = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                label: 'Reports by Age Group',
                data: chartData,
                backgroundColor: [
        '#38b6ff',
        '#fcb825',
        '#00c382',
        '#9b57cc',
        '#81acef',
        '#99c4d3',
        '#ff66c4'
                ],
               // hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, 
            plugins: {
  
                legend: {
                    position: 'right', 
                    labels: {
                        font: { family: 'Montserrat, sans-serif' ,size: 13,
    weight: '600'},
                        // 1. DISABLE DEFAULT LEGEND CLICK BEHAVIOR (hiding the slice)
                        onClick: null,
                        
                        // 2. CUSTOM GENERATE LABELS to include count and percentage
                        generateLabels: function(chart) {
                            const data = chart.data;
                            if (data.labels.length && data.datasets.length) {
                                const dataset = data.datasets[0];
                                // Recalculate total inside the function for robustness
                                const total = dataset.data.reduce((sum, current) => sum + current, 0); 
                                
                                return data.labels.map((label, i) => {
                                    const count = dataset.data[i];
                                    const percentage = total > 0 ? ((count / total) * 100).toFixed(2) : '0.00';
                                    
                                    // Format: Label: Count (Percentage%)
                                    const customText = `${label}: ${count} (${percentage}%)`;

                                    return {
                                        text: customText,
                                        fillStyle: dataset.backgroundColor[i], // Color box for the item
                                        strokeStyle: dataset.borderColor ? dataset.borderColor[i] : dataset.backgroundColor[i],
                                        lineWidth: dataset.borderWidth || 1,
                                        hidden: chart.getDatasetMeta(0).data[i].hidden,
                                        index: i
                                    };
                                });
                            }
                            return [];
                        }
                    },
                    // 3. Keep CUSTOM CLICK HANDLER on the legend items for filtering
                    onItemClick: function(event, legendItem, legend) {
                        const clickedIndex = legendItem.index;
                        const clickedAgeGroup = labels[clickedIndex];
                        
                        // Dispatch Livewire event to filter the data
                        Livewire.dispatch('updateAbuseChartFilters', { 
                            filterType: 'age', 
                            value: clickedAgeGroup 
                        });
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const currentValue = context.raw;
                            const currentLabel = context.label || '';
                            let percentage = '0.00';
                            if (totalCount > 0) {
                                // Use toFixed(2) for consistency with the legend format
                                percentage = ((currentValue / totalCount) * 100).toFixed(2); 
                            }
                            return `${currentLabel}: ${currentValue} reports (${percentage}%)`;
                        }
                    }
                },
                title: { display: false }
            },
            
            // CRITICAL: Keep this onClick handler to allow filtering when clicking the SLICE itself.
            onClick: (event, elements) => {
                if (elements.length > 0) {
                    const clickedIndex = elements[0].index;
                    const clickedAgeGroup = labels[clickedIndex];
                    
                    Livewire.dispatch('updateAbuseChartFilters', { 
                        filterType: 'age', 
                        value: clickedAgeGroup 
                    });
                }
            }
        }
    });
}

// 3. AGE LINE CHART (New Function - Filtered by Age Group)
function renderAgeDistributionChart(labels, chartData) {
    let canvas = document.getElementById('ageLineChart');
    if (!canvas) return;

    let noDataMsg = document.getElementById('noDataMessage'); 
    
    if (ageLineChartInstance) {
        ageLineChartInstance.destroy();
        ageLineChartInstance = null;
    }

    const totalCount = chartData.reduce((sum, current) => sum + current, 0);
    if (totalCount === 0) {
        canvas.style.display = 'none';
        if (noDataMsg) {
            noDataMsg.textContent = 'No age group report data found for the current filter.';
            noDataMsg.style.display = 'block';
        }
        return;
    }

    canvas.style.display = 'block';
    if (noDataMsg) noDataMsg.style.display = 'none';

    const ctx = canvas.getContext('2d');

    // compute dynamic Y max, rounded up to nearest 10 (but at least 10)
    const maxValue = Math.max(...chartData, 10);
    const yAxisMax = Math.ceil(maxValue / 10) * 10;

    ageLineChartInstance = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Reports',
                data: chartData,
                fill: false,
                borderColor: '#38b6ff',
                tension: 0.4,
                pointBackgroundColor: '#38b6ff',
                pointBorderColor: '#38b6ff',
                pointRadius: 2,
                pointHoverRadius: 5,
                borderWidth: 2,
                spanGaps: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,

            // optional small layout padding to shift the chart area right so first tick
            // doesn't visually sit on the y-axis. Adjust left value if needed.
            layout: {
                padding: { left: 8, right: 8, top: 4, bottom: 4 }
            },

            plugins: {
                legend: { display: false },
                title: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.label}: ${context.raw} reports`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    min: 0,
                    max: yAxisMax,
                    // keep horizontal grid lines
                    grid: { display: true },
                    title: { display: true, text: 'Number of Reports' },
                    ticks: {
                        stepSize: 10,
                        callback: function(value) { 
                            if (value % 1 === 0) return value;
                        }
                    }
                },
                x: {
                    type: 'category',       // make it explicit that these are category labels
                    title: { display: true, text: 'Age Group' },
                    grid: { display: false }, // no vertical grid lines
                    offset: true,            // <-- IMPORTANT: add offset so first tick isn't flush to the y-axis
                    bounds: 'data',          // helps align the plotted line within chart area
                    alignToPixels: true
                }
            },
            interaction: {
                mode: 'nearest',
                intersect: true
            }
        }
    });
}



// 4. ANONYMITY CHARTS (UPDATED)
// ========================================================================
function renderAnonymityCharts(anonymousCount, nonAnonymousCount) {
   // Chart.register(ChartDataLabels);
    const labels = ['Anonymous', 'Identified']; // Corrected capitalization
    const chartData = [anonymousCount, nonAnonymousCount];
    const totalCount = anonymousCount + nonAnonymousCount;

    const colors = [
       '#99c4d3', // Anonymous 
        '#9b57cc' // identified
    ];
    
    // --- Helper function (Simplified: Ensure it targets the immediate parent) ---
    const updateChartDisplay = (canvasId, instance, chartType) => {
        let canvas = document.getElementById(canvasId);
        if (!canvas) return;

        // Use canvas.parentElement for the container (the flex div with height)
        const container = canvas.parentElement; 
        let noDataMsg = document.getElementById(`noDataMessage-${canvasId}`);
        
        // 1. Ensure No Data Message element exists
        if (!noDataMsg && container) {
            noDataMsg = document.createElement('p');
            noDataMsg.id = `noDataMessage-${canvasId}`;
            noDataMsg.className = 'text-center text-gray-500 mt-8 font-semibold absolute inset-0 flex items-center justify-center p-4';
            container.appendChild(noDataMsg);
        }

        if (totalCount === 0) {
            if (instance) instance.destroy();
            canvas.style.display = 'none';
            if (noDataMsg) {
                noDataMsg.textContent = `No ${chartType} data found for the current filters.`;
                noDataMsg.style.display = 'flex';
            }
        } else {
            canvas.style.display = 'block';
            if (noDataMsg) noDataMsg.style.display = 'none';
            return true; // Ready to render
        }
        return false;
    };
    
    // --- PIE CHART ---
    if (updateChartDisplay('anonymityPieChart', anonymityPieChartInstance, 'anonymity')) {
     //   Chart.register(ChartDataLabels);
        
        let pieCanvas = document.getElementById('anonymityPieChart');
        if (anonymityPieChartInstance) anonymityPieChartInstance.destroy();
        
        anonymityPieChartInstance = new Chart(pieCanvas.getContext('2d'), {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{

                    data: chartData,
                    backgroundColor: colors,
                    hoverOffset: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                // ... inside renderAnonymityCharts function, within anonymityPieChartInstance options ...
                plugins: {
            // ... inside options.plugins.datalabels: { ... }

                    datalabels: {
                // 1. STYLING (Plain text)
                    color: '#000', // ✅ Dark text color ✅

                            font: {
                            weight: 'normal', // Changed to normal weight
                            size: 13, 
                            family: 'montserrat',
                        
                        },
                        padding: 0, // Removed padding
                        borderRadius: 0, // Removed border radius
    
                    // ✅ Set Background/Border to Transparent/None ✅
                    backgroundColor: 'transparent', 
                    borderColor: 'transparent',
                    borderWidth: 0,
    
                    // 2. POSITIONING
                        anchor: 'end', 
                        align: 'end', 
                        offset: 10, 
        
                        // 3. VALUE/FORMATTING (Name \n Percentage)
                            formatter: (value, context) => {
                            const total = context.chart.data.datasets[0].data.reduce((sum, current) => sum + current, 0);
                            const percentage = total > 0 ? (value / total * 100).toFixed(1) : '0.0'; 
                            const name = context.chart.data.labels[context.dataIndex];
                            // Returns the name on one line and the percentage on the next
                        return `${name}\n${percentage}%`; 
                        },
    
                // 5. CONNECTOR LINE
                        callout: {
                        display: false, // ✅ Hide the callout line ✅
                        }
                },
// ...
                    // --- END DATALABELS CONFIGURATION ---

                    // Legend configuration is kept for the side display
                    legend: { 
                        position: 'right',
                        labels: {
                    // ✅ Set usePointStyle to true for circular swatches ✅
                    usePointStyle: false,
                            font: {
                    weight: 'normal',
                    size: 13,
                    family: 'Montserrat', // You might want to specify a font family too
                    },
                        generateLabels: (chart) => {
                        const data = chart.data;
                        const total = data.datasets[0].data.reduce((sum, current) => sum + current, 0); 

                        if (data.labels.length && data.datasets.length) {
                        return data.labels.map((label, i) => {
                        const meta = chart.getDatasetMeta(0);
                        const value = data.datasets[0].data[i];
                        const percentage = total > 0 ? (value / total * 100).toFixed(2) : 0;
    
                    // ✅ Get the color directly from the dataset's backgroundColor array ✅
                    const color = data.datasets[0].backgroundColor[i];
    
                    const formattedLabel = `${label}: ${value} (${percentage}%)`;

                    return {
                        text: formattedLabel,
                        // ✅ Set fillStyle and strokeStyle to match the slice color ✅
                        fillStyle: color,
                        strokeStyle: color,
                        lineWidth: 1, // Keep a small border for clarity if needed
                        hidden: isNaN(data.datasets[0].data[i]) || meta.data[i].hidden,
                        index: i
                        };
                                    });
                                }
                                return [];
                            }
                        }
                    },
                    title: { display: false },
                    tooltip: {
                callbacks: {
                label: function(context) {
                const currentValue = context.raw; 
                const currentLabel = context.label || '';
                
                // Recalculate total for robustness
                    const total = context.dataset.data.reduce((sum, current) => sum + current, 0);

                    let percentage = '0.00';
                        if (total > 0) {
                        percentage = ((currentValue / total) * 100).toFixed(2); 
                        }
    
                        return `${currentLabel}: ${currentValue} reports (${percentage}%)`;
                        }
                    }
                }
    // Closing plugins bracket
// ...
                }
            }
        });
    }
    // Removed the redundant Doughnut Chart section here as per best practices.
}
   

// ========================================================================
// 3. LIVEWIRE LISTENERS (Initialization and Updates)
// ========================================================================

document.addEventListener('livewire:initialized', () => {
    // --- A. Initial Rendering on Page Load ---
    
    // 1. Initial Bar Chart (Abuse Type)
    const initialLabels = @json($abuseTypeLabels);
    const initialData = @json($abuseTypeCounts);
    renderAbuseTypeChart(initialLabels, initialData);
    
    const initialAnonymousCount = @json($anonymousCount ?? 0); 
    const initialNonAnonymousCount = @json($nonAnonymousCount ?? 0); 
    renderAnonymityCharts(initialAnonymousCount, initialNonAnonymousCount);


    // 2. Initial Doughnut Chart (Age Group)
    const initialAgeLabels = @json($availableAgeGroups); 
    // Need to convert associative array to just values for chartData
    const initialAgeData = @json(array_values($ageGroupCounts)); 
    renderAgeDoughnutChart(initialAgeLabels, initialAgeData);
     // 3. Initial Line Chart (Age Distribution) Ã°Å¸Å¡Â¨ MODIFIED Ã°Å¸Å¡Â¨
// Uses the Age Group data (same data as the Doughnut chart)
const initialAgeLabelsForLine = @json($availableAgeGroups ?? []); 
const initialAgeCountsForLine = @json(array_values($ageGroupCounts ?? [])); 
renderAgeDistributionChart(initialAgeLabelsForLine, initialAgeCountsForLine);


    // --- B. Listen for the Livewire event to re-render charts on filter change ---
    
   // --- B. Listen for the Livewire event to re-render charts on filter change ---

Livewire.on('chartDataUpdated', (payload) => {
    // CRITICAL FIX: Livewire 3 often wraps single objects in an array.
    const dataObject = Array.isArray(payload) ? payload[0] : payload;

    if (!dataObject) {
        console.error('Error: Received Livewire payload is empty or invalid.');
        return;
    }

    console.log('Chart Data Updated Event Received! Data:', dataObject);

    // 1. Update Abuse Type Bar Chart
    if (dataObject.labels && dataObject.counts) {
        renderAbuseTypeChart(dataObject.labels, dataObject.counts);
    } else {
        console.warn('Warning: Bar chart data missing from event payload.');
    }

    // 2. Update Age Doughnut Chart & Age Line Chart
    if (dataObject.ageGroupCounts) {
        // Extract labels and values from the associative array
        const ageLabels = Object.keys(dataObject.ageGroupCounts);
        const ageCounts = Object.values(dataObject.ageGroupCounts);
        
        renderAgeDoughnutChart(ageLabels, ageCounts);
        
        // FIX: Use the extracted data for the Line Chart too.
        renderAgeDistributionChart(ageLabels, ageCounts); 
    } else {
        console.warn('Warning: Age Doughnut and Line chart data missing from event payload.');
    }
    
   if (dataObject.ageLabels && dataObject.ageCounts) {
    renderAgeDistributionChart(dataObject.ageLabels, dataObject.ageCounts);
} else {
    console.warn('Warning: Age Distribution Line chart data missing from event payload.');
}
 });
});
</script>
 </div> 
</div>
<script>
const statusCtx = document.getElementById('statusChart').getContext('2d');
const statusLabels = {!! $statusData->pluck('status')->toJson() !!}.map(label => {
    // Capitalize first letter of each word
    return label.split('-').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
});
const statusCounts = {!! $statusData->pluck('total')->toJson() !!};

// Map status colors
const statusColors = statusLabels.map(label => {
    const lowerLabel = label.toLowerCase();
    if (lowerLabel.includes('forwarded')) return '#ff66c4';
    if (lowerLabel.includes('awaiting resolution')) return '#38b6ff';
    if (lowerLabel.includes('unresolved')) return '#00c382';
    if (lowerLabel.includes('under review')) return '#9b57cc';
    if (lowerLabel.includes('false report')) return '#fcb825';
    if (lowerLabel.includes('closed')) return '#81acef';
    return '#99c4d3'; // default fallback
});

new Chart(statusCtx, {
    type: 'bar',
    data: {
        labels: [''], // Empty label for x-axis
        datasets: statusLabels.map((label, index) => ({
            label: label,
            data: [statusCounts[index]],
            backgroundColor: statusColors[index],
            borderWidth: 0,
            borderRadius: 8
        }))
    },
    options: {
        indexAxis: 'x',
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    color: '#666',
                    font: {
                        size: 14,
                        weight: 'bold'
                    }
                },
                ticks: {
                    stepSize: 5,
                    color: '#666',
                    font: {
                        size: 12
                    }
                },
                grid: {
                    color: '#f0f0f0',
                    drawBorder: false
                },
                border: {
                    display: false
                }
            },
            x: {
                ticks: {
                    display: false
                },
                grid: { 
                    display: false 
                },
                border: {
                    display: false
                }
            }
        },
        plugins: {
            legend: { 
                display: true,
                position: 'top',
                align: 'center',
                labels: {
                    usePointStyle: true,
                    pointStyle: 'circle',
                    padding: 20,
                    color: '#666',
                    font: {
                        size: 13
                    }
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                displayColors: false,
                callbacks: {
                    label: function(context) {
                        const count = context.parsed.y;
                        return `${count} ${count === 1 ? 'report' : 'reports'}`;
                    }
                }
            }
        }
    }
});

</script>



            <!-- Font Awesome for icons -->
            <script src="https://kit.fontawesome.com/2c36e9b7b9.js" crossorigin="anonymous"></script>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
            <script>
                function exportPDF() {
                    const element = document.getElementById('main-content'); // ÃƒÂ¢Ã…â€œÃ¢â‚¬Â¦ grabs main content only
                    if (!element) {
                        alert("Main content not found! Add id='main-content' to your <main> tag.");
                        return;
                    }

                    html2pdf().from(element).set({
                        margin: 10,
                        filename: 'admin-dashboard.pdf',
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

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    // --- Select elements ---
                    const yearSelect = document.getElementById("yearSelect");
                    const schoolSelect = document.getElementById("schoolSelect"); // Optional
                    const fromInput = document.getElementById("fromDate");
                    const toInput = document.getElementById("toDate");

                    // Function to fetch and update dashboard data
                    async function fetchDashboardData() {
                        const year = yearSelect ? yearSelect.value : '';
                        const school = schoolSelect ? schoolSelect.value : '';
                        const from = fromInput ? fromInput.value : '';
                        const to = toInput ? toInput.value : '';

                        const url = `/admin/fetch-dashboard-data?year=${year}&school=${school}&from=${from}&to=${to}`;


                        try {
                            const response = await fetch(url, {
                                headers: {
                                    "X-Requested-With": "XMLHttpRequest"
                                }
                            });

                            if (!response.ok) {
                                throw new Error(`HTTP error! Status: ${response.status}`);
                            }

                            const data = await response.json();
                            console.log("Dashboard Data:", data);

                            // Update stats on page
                            updateDashboard(data);
                        } catch (error) {
                            console.error("Error fetching dashboard data:", error);
                        }
                    }

                    // Example function to update dashboard stats
                    function updateDashboard(data) {
                        // --- Total ---
                        const totalElement = document.getElementById("totalReports");
                        if (totalElement) totalElement.textContent = data.total ?? 0;

                        // --- Status Counts ---
                        const awaitingResolutionCount = document.getElementById("awaitingResolutionCount");
                        const forwardedCount = document.getElementById("forwardedCount");
                        const underReviewCount = document.getElementById("underReviewCount");
                        const closedCount = document.getElementById("closedCount");
                        const unresolvedCount = document.getElementById("unresolvedCount");
                        const falseReportCount = document.getElementById("falseReportCount");

                        if (awaitingResolutionCount) awaitingResolutionCount.textContent = data.statuses["awaiting-resolution"] ?? 0;
                        if (forwardedCount) forwardedCount.textContent = data.statuses.forwarded ?? 0;
                        if (underReviewCount) underReviewCount.textContent = data.statuses["under-review"] ?? 0;
                        if (closedCount) closedCount.textContent = data.statuses.closed ?? 0;
                        if (unresolvedCount) unresolvedCount.textContent = data.statuses.unresolved ?? 0;
                        if (falseReportCount) falseReportCount.textContent = data.statuses["false-report"] ?? 0;
                    }

                    // --- Event listeners ---
                    if (yearSelect) yearSelect.addEventListener("change", fetchDashboardData);
                    if (schoolSelect) schoolSelect.addEventListener("change", fetchDashboardData);
                    if (fromInput) fromInput.addEventListener("change", fetchDashboardData);
                    if (toInput) toInput.addEventListener("change", fetchDashboardData);
                    const refreshBtn = document.getElementById("refreshBtn");
                    if (refreshBtn) refreshBtn.addEventListener("click", fetchDashboardData);


                    // Initial fetch on page load
                    fetchDashboardData();
                });
            </script>