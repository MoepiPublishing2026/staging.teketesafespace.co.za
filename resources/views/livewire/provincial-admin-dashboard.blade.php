<div class="flex min-h-screen m-0 p-0">
    <button id="provincialSidebarToggle" type="button" aria-label="Toggle menu" class="min-[901px]:hidden fixed top-4 left-4 z-[60] w-11 h-11 bg-white border-2 border-[#c7da30] rounded-lg shadow flex items-center justify-center">
        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
    </button>
    <div id="provincialSidebarOverlay" class="min-[901px]:hidden fixed inset-0 z-[50] bg-black/40 hidden" aria-hidden="true"></div>
    <!-- Sidebar -->
    <aside id="provincialSidebar" class="w-64 flex flex-col justify-between bg-[#fffbf7] transform -translate-x-full transition-transform duration-300 ease-in-out fixed inset-y-0 left-0 z-[55] min-[901px]:translate-x-0 min-[901px]:sticky min-[901px]:top-0 min-[901px]:h-screen">
        <div class="flex flex-col h-full">
            

            <!-- Navigation Menu -->
            <nav class="flex-1 px-4" style="margin-top: 100px;">
                <ul class="space-y-3">
                    @php
                        $statusColors = [
                            'awaiting-resolution' => 'red',
                            'under-review' => 'blue',
                            'closed' => 'green',
                            'forwarded' => 'yellow',
                            'unresolved' => 'orange',
                            'false-report' => 'gray',
                        ];
                    @endphp

                    <li>
                        <a href="{{ route('provincial.admin.dashboard') }}"
                            class="flex items-center px-4 py-3 rounded-lg transition-all font-semibold hover:bg-gradient-to-r from-[#c7da30] to-[#d7e47a]">
                            Dashboard
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('provincial/reports') }}"
                            class="flex items-center px-4 py-3 rounded-lg transition-all font-semibold hover:bg-gradient-to-r from-[#c7da30] to-[#d7e47a]">
                            Reports
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('provincial/profile') }}"
                            class="flex items-center px-4 py-3 rounded-lg transition-all font-semibold hover:bg-gradient-to-r from-[#c7da30] to-[#d7e47a]">
                            My Profile
                        </a>
                    </li>

                    <!-- Export PDF -->
                    <li class="flex justify-center">
                        <a href="#" onclick="exportPDF()"
                            class="flex items-center font-montserrat-black rounded-lg transition-all font-semibold text-black
                            {{ Request::is('provicial/export') ? 'bg-gradient-to-r from-[#c7da30] to-[#d7e47a]' : 'hover:bg-gradient-to-r from-[#c7da30] to-[#d7e47a]' }}"
                            style="width: 188px; height: 41px; color: black; font-size: 15px;">
                            <i></i>Export PDF
                        </a>
                    </li>

                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left flex items-center px-4 py-3 rounded-lg transition-all font-semibold hover:bg-gradient-to-r from-[#c7da30] to-[#d7e47a]">
                                Sign Out
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>

            <div class="p-4 text-center">
                <p class="text-sm text-gray-600">© {{ date('Y') }} Tekete SafeSpace</p>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main id='main-content' class="flex-1 flex flex-col px-4 sm:px-6 lg:px-8 py-6 overflow-auto">
        <div class="w-full max-w-[1280px] mx-auto">
        <!-- Header -->
        <div class="flex flex-col gap-4 md:flex-row md:justify-between md:items-center mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-lime-800 tracking-wide">
                {{ $province }} Provincial Dashboard
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
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-xl font-bold text-lime-800 mb-4 border-b pb-2">Filters</h3>
            <div class="flex flex-wrap items-end gap-2">
                <div class="flex flex-col">
                    <label class="text-sm font-mediam text-lime-800 mb-1">District:</label>
                    <select id="selectedDistrict" class="border border-gray-300 rounded-md px-3 py-2 w-full max-w-[200px]">
                        <option value="">All Districts</option>
                        @foreach ($districts as $district_id => $district_name)
                            <option value="{{ $district_id }}">{{ $district_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col">
                    <label class="text-sm font-mediam  text-lime-800 mb-1">School:</label>
                    <select id="selectedSchool" class="border border-gray-300 rounded-md px-3 py-2 w-full max-w-[200px]">
                        <option value="">All Schools</option>
                        @foreach ($schools as $school_id => $school_name)
                            <option value="{{ $school_id }}">{{ $school_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col">
                    <label class="text-sm font-mediam  text-lime-800 mb-1">From Date:</label>
                    <input type="date" id="fromDate" class="border border-gray-300 rounded-md px-3 py-2 w-full max-w-[200px]">
                </div>

                <div class="flex flex-col">
                    <label class="text-sm font-mediam  text-lime-800 mb-1">To Date:</label>
                    <input type="date" id="toDate" class="border border-gray-300 rounded-md px-3 py-2 max-w-[200px]">
                </div>

                <div class="flex flex-col">
                    <button id="refreshBtn" class="px-5 py-2 rounded-md text-white font-bold transition-all"
                        style="background: linear-gradient(#7f9b05ff, #d7e47a);">
                        🔄 Refresh ALL
                    </button>
                </div>
            </div>
        </div>

        <!-- KPI Cards -->
        <div class="flex gap-4  mb-8">
    <!-- Total Reports -->
    <a href="{{ route('provincial.reports.index', ['filter' => 'all']) }}" 
       class="rounded-lg shadow p-6 flex flex-col items-center transition-all duration-200 hover:shadow-xl hover:scale-105" 
       style="background: linear-gradient(#c7da30, #d7e47a); width: 140px;">
        <div class="text-white mt-2 font-montserrat-black" style="font-size: 15px">Total Reports</div>
        <div id="totalReports" class="text-3xl font-bold text-white mt-2 font-montserrat-black" style="font-size: 35px">{{ $reports->count() }}</div>
    </a>

    <!-- Awaiting Resolution -->
    <a href="{{ route('provincial.reports.index', ['filter' => 'awaiting-resolution']) }}" 
       class="bg-white rounded-lg shadow p-6 flex flex-col items-center transition-all duration-200 border-2 hover:shadow-xl hover:scale-105 hover:bg-gradient-to-r hover:from-[#c7da30] hover:to-[#d7e47a]"
       style="border-color: #d7e47a; width: 140px;">
        <div class="text-red-500 mt-2 font-montserrat-black" style="font-size: 15px";">Awaiting Resolution</div>    
        <div id="awaitingResolutionCount" class="text-3xl font-bold text-red-500 mt-2 font-montserrat-black" style="font-size: 35px">{{ $reports->where('status', 'awaiting-resolution')->count() }}</div>
    </a>

    <!-- Forwarded -->
    <a href="{{ route('provincial.reports.index', ['filter' => 'forwarded']) }}" 
       class="bg-white rounded-lg shadow p-6 flex flex-col items-center transition-all duration-200 border-2 hover:shadow-xl hover:scale-105 hover:bg-gradient-to-r hover:from-[#c7da30] hover:to-[#d7e47a]"
       style="border-color: #d7e47a; width: 140px;">
        <div class="text-yellow-500 mt-2 font-montserrat-black" style="font-size: 15px";">Forwarded</div>    
        <div id="forwardedCount" class="text-3xl font-bold text-yellow-500 mt-2 font-montserrat-black" style="font-size: 35px">{{ $reports->where('status', 'forwarded')->count() }}</div>
    </a>

    <!-- Under Review -->
    <a href="{{ route('provincial.reports.index', ['filter' => 'under-review']) }}" 
       class="bg-white rounded-lg shadow p-6 flex flex-col items-center transition-all duration-200 border-2 hover:shadow-xl hover:scale-105 hover:bg-gradient-to-r hover:from-[#c7da30] hover:to-[#d7e47a]"
       style="border-color: #d7e47a; width: 140px;">
        <div class="text-blue-500 mt-2 font-montserrat-black" style="font-size: 15px";">Under Review</div>    
        <div id="underReviewCount" class="text-3xl font-bold text-blue-500 mt-2 font-montserrat-black" style="font-size: 35px">{{ $reports->where('status', 'under-review')->count() }}</div>
    </a>

    <!-- Closed -->
    <a href="{{ route('provincial.reports.index', ['filter' => 'closed']) }}" 
       class="bg-white rounded-lg shadow p-6 flex flex-col items-center transition-all duration-200 border-2 hover:shadow-xl hover:scale-105 hover:bg-gradient-to-r hover:from-[#c7da30] hover:to-[#d7e47a]" 
       style="border-color: #d7e47a; width: 140px;">
        <div class="text-green-500 mt-2 font-montserrat-black" style="font-size: 15px";">Closed</div>    
        <div id="closedCount" class="text-3xl font-bold text-green-500 mt-2 font-montserrat-black" style="font-size: 35px">{{ $reports->where('status', 'closed')->count() }}</div>
    </a>

    <!-- Unresolved -->
    <a href="{{ route('provincial.reports.index', ['filter' => 'unresolved']) }}" 
       class="bg-white rounded-lg shadow p-6 flex flex-col items-center transition-all duration-200 border-2 hover:shadow-xl hover:scale-105 hover:bg-gradient-to-r hover:from-[#c7da30] hover:to-[#d7e47a]"
       style="border-color: #d7e47a; width: 140px;">
        <div class="text-orange-500 mt-2 font-montserrat-black" style="font-size: 15px";">Unresolved</div>    
        <div id="unresolvedCount" class="text-3xl font-bold text-orange-500 mt-2 font-montserrat-black" style="font-size: 35px">{{ $reports->where('status', 'unresolved')->count() }}</div>  
    </a>

    <!-- False Report -->
    <a href="{{ route('provincial.reports.index', ['filter' => 'false-report']) }}" 
       class="bg-white rounded-lg shadow p-6 flex flex-col items-center transition-all duration-200 border-2 hover:shadow-xl hover:scale-105 hover:bg-gradient-to-r hover:from-[#c7da30] hover:to-[#d7e47a]"
       style="border-color: #d7e47a; width: 140px;">
        <div class="text-gray-500 mt-2 font-montserrat-black whitespace-nowrap" style="font-size: 15px";">False Report</div>
        <div id="falseReportCount" class="text-3xl font-bold text-gray-500 mt-2 font-montserrat-black" style="font-size: 35px">{{ $reports->where('status', 'false-report')->count() }}</div>
    </a>
</div>


        <!-- Charts -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-bold text-grey-400 mb-4">Monthly Trends</h2>
                <canvas id="reportsTrendsChart" class="w-full h-48"></canvas>
            </div>
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-bold text-grey-400 mb-4">Report Demographics (Age)</h2>
                <canvas id="demographicsChart" class="w-full h-48"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold text-grey-400 mb-4">Reports by Abuse Type</h2>
            <div id="abuseButtons" class="flex flex-wrap gap-2 mb-3"></div>
            <canvas id="abuseChart" class="w-full h-48"></canvas>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            <!-- Notifications & Alerts -->
    <div class="bg-white rounded-2xl shadow-md p-6">
        <h2 class="text-xl font-semibold text-grey-400 mb-4">Notifications & Alerts</h2>

        <ul class="space-y-2 text-gray-600">
    <li>
        <span class="font-medium text-gray-400">New report submitted:</span>
        <span id="latestReport" class="font-semibold text-grey-400">N/A</span>
    </li>

    <li>
        <span class="font-medium text-gray-400">Under-Review alerts:</span>
        <span id="underReviewAlerts" class="font-semibold text-grey-400">0</span>
    </li>

    <li>
        <span class="font-medium text-gray-400">Follow-up reminders:</span>
        <span id="pendingFollowUps" class="font-semibold text-red-600">None</span>
    </li>

     <!-- New: Top School(s) -->
        <li>
            <span class="font-medium text-gray-400">School(s) with most reports:</span>
            <span id="topSchools" class="font-semibold text-purple-700">N/A</span>
        </li>
</ul>

    </div>

            <div class="bg-white rounded-2xl shadow-md p-6 flex flex-col items-center justify-center">
                <h2 class="text-xl font-semibold text-grey-400 mb-4">Anonymous Report Ratio</h2>
                <div class="w-full max-w-xs">
                    <canvas id="anonymousGauge" height="260"></canvas>
                </div>
            </div>
        </div>
        </div>
    </main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var toggle = document.getElementById('provincialSidebarToggle');
    var sidebar = document.getElementById('provincialSidebar');
    var overlay = document.getElementById('provincialSidebarOverlay');

    function openSidebar() {
        if (!sidebar) return;
        sidebar.classList.remove('-translate-x-full');
        sidebar.classList.add('translate-x-0');
        if (overlay) overlay.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        if (!sidebar) return;
        sidebar.classList.add('-translate-x-full');
        sidebar.classList.remove('translate-x-0');
        if (overlay) overlay.classList.add('hidden');
        document.body.style.overflow = '';
    }

    if (toggle && sidebar) {
        toggle.addEventListener('click', function () {
            if (sidebar.classList.contains('-translate-x-full')) {
                openSidebar();
            } else {
                closeSidebar();
            }
        });
    }

    if (overlay) {
        overlay.addEventListener('click', function () {
            closeSidebar();
        });
    }

    window.addEventListener('resize', function () {
        if (window.innerWidth >= 901) {
            closeSidebar();
        }
    });
});
</script>








<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let trendChart=null, ageChart=null, abuseChart=null, anonymousChart=null;
let abuseDataGlobal={};

async function loadDashboardData() {
    const district = document.getElementById('selectedDistrict').value;
    const school = document.getElementById('selectedSchool').value;
    const from = document.getElementById('fromDate').value;
    const to = document.getElementById('toDate').value;

    try {
        const res = await fetch(`/provincial/dashboard/fetch?district=${district}&school=${school}&from=${from}&to=${to}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        const data = await res.json();
        console.log("Fetched Data:", data);

        
        updateDashboard(data);

    } catch (err) {
        console.error("Error loading dashboard data:", err);
    }
}


/* MONTHLY TREND BAR CHART */
function loadMonthlyTrend(monthly){
  const ctx=document.getElementById('reportsTrendsChart').getContext('2d');
  if(trendChart) trendChart.destroy();

  const months=['January','February','March','April','May','June','July','August','September','October','November','December'];
  const values=months.map(m=>monthly[m]||0);
  const gradient=ctx.createLinearGradient(0,0,0,250);
  gradient.addColorStop(0,'#cde614ff');
  gradient.addColorStop(1,'#9cbd0bff');

  trendChart=new Chart(ctx,{
    type:'bar',
    data:{labels:months,datasets:[{data:values,backgroundColor:gradient,borderRadius:2}]},
    options:{plugins:{legend:{display:false}},scales:{y:{beginAtZero:true}}}
  });
}

/* AGE DEMOGRAPHICS LINE CHART */
function loadAgeChart(ageGroups){
  const ctx=document.getElementById('demographicsChart').getContext('2d');
  if(ageChart) ageChart.destroy();

  const labels=Object.keys(ageGroups);
  const values=Object.values(ageGroups);

  // Dim soft green gradient
  const gradient=ctx.createLinearGradient(0,0,0,250);
  gradient.addColorStop(0,'rgba(150, 170, 120, 0.4)');
  gradient.addColorStop(1,'rgba(150, 170, 120, 0.2)');

  ageChart=new Chart(ctx,{
    type:'line',
    data:{
      labels,
      datasets:[
        {
          data:values,
          label:'Age Groups',
          fill:true,
          backgroundColor:gradient,
          borderColor:'rgba(110, 130, 90, 1)',     // softer border
          borderWidth:2,
          tension:0.4,
          pointRadius:3,
          pointBackgroundColor:'rgba(110, 130, 90, 1)' // dim point color
        }
      ]
    },
    options:{plugins:{legend:{display:false}},scales:{y:{beginAtZero:true}}}
  });
}


/* ABUSE TYPE CHART */
function loadAbuseChart(abuseData){
  abuseDataGlobal=abuseData;
  const container=document.getElementById('abuseButtons');
  container.innerHTML='';

  const allBtn=document.createElement('button');
  allBtn.textContent='All Types';
  allBtn.classList.add('active');
  allBtn.onclick=()=>updateAbuseChart('all');
  container.appendChild(allBtn);

  Object.keys(abuseDataGlobal).forEach(type=>{
    const btn=document.createElement('button');
    btn.textContent=type;
    btn.onclick=()=>updateAbuseChart(type);
    container.appendChild(btn);
  });
  updateAbuseChart('all');
}

function updateAbuseChart(type){
  let labels=[],values=[];
  if(type==='all'){
    Object.keys(abuseDataGlobal).forEach(t=>{
      Object.keys(abuseDataGlobal[t]).forEach(sub=>{
        labels.push(`${t}: ${sub}`);
        values.push(abuseDataGlobal[t][sub]);
      });
    });
  }else{
    labels=Object.keys(abuseDataGlobal[type]||{});
    values=Object.values(abuseDataGlobal[type]||{});
  }

  const ctx=document.getElementById('abuseChart').getContext('2d');
  if(abuseChart) abuseChart.destroy();
  const colors=['#8FB41A','#c2f508ff','#55ff07ff','#e5ff22ff','#2cd943ff','#bbd42aff','#D5E36C','#ebcb16ff'];

  abuseChart=new Chart(ctx,{
    type:'bar',
    data:{labels,datasets:[{data:values,backgroundColor:labels.map((_,i)=>colors[i%colors.length]),borderRadius:6}]},
    options:{plugins:{legend:{display:false}},scales:{y:{beginAtZero:true}}}
  });
}

/* ANONYMOUS GAUGE (DOUGHNUT) */
function loadAnonymousGauge(anon,nonAnon){
  const ctx=document.getElementById('anonymousGauge').getContext('2d');
  if(anonymousChart) anonymousChart.destroy();

  const total=anon+nonAnon;
  const pct=total>0?((anon/total)*100).toFixed(1):0;

  const gaugeText={
    id:'gaugeText',
    afterDatasetsDraw(chart,args,opts){
      const{ctx}=chart;
      ctx.save();
      ctx.font='bold 22px Poppins';
      ctx.fillStyle='#111827';
      ctx.textAlign='center';
      ctx.textBaseline='middle';
      ctx.fillText(`${pct}%`,chart.width/2,chart.height/2);
    }
  };

  anonymousChart=new Chart(ctx,{
    type:'doughnut',
    data:{labels:['Anonymous','Non-Anonymous'],datasets:[{data:[anon,nonAnon],backgroundColor:['#22c55e','#e5e7eb'],borderWidth:2,cutout:'70%'}]},
    options:{plugins:{legend:{display:true,position:'bottom'}}},
    plugins:[gaugeText]
  });
}

function resetFilters() {
    const district = document.getElementById('selectedDistrict');
    const school = document.getElementById('selectedSchool');
    const fromDate = document.getElementById('fromDate');
    const toDate = document.getElementById('toDate');

    if (district) district.value = '';
    if (school) school.value = '';
    if (fromDate) fromDate.value = '';
    if (toDate) toDate.value = '';

    // Fetch dashboard data with cleared filters
    loadDashboardData();
}

document.addEventListener('DOMContentLoaded', () => {
    // Initial fetch
    loadDashboardData();

    // Filter change events
    document.getElementById('selectedDistrict')?.addEventListener("change", loadDashboardData);
    document.getElementById('selectedSchool')?.addEventListener("change", loadDashboardData);
    document.getElementById('fromDate')?.addEventListener("change", loadDashboardData);
    document.getElementById('toDate')?.addEventListener("change", loadDashboardData);

    // Refresh button click
    document.getElementById('refreshBtn')?.addEventListener("click", resetFilters);
});


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

    // --- Charts ---
    loadMonthlyTrend(data.monthly ?? {});
    loadAgeChart(data.ageGroups ?? {});
    loadAbuseChart(data.abuseTypes ?? {});
    loadAnonymousGauge(data.anonymous?.anonymous ?? 0, data.anonymous?.non_anonymous ?? 0);

    
    // --- Notifications & Alerts ---
    const latestReport = document.getElementById("latestReport");
    const underReviewAlerts = document.getElementById("underReviewAlerts");
    const pendingFollowUps = document.getElementById("pendingFollowUps");
    const topSchoolsEl = document.getElementById("topSchools");

    if (latestReport) latestReport.textContent = data.latestReport ?? 'N/A';
    if (underReviewAlerts) underReviewAlerts.textContent = data.statuses["under-review"] ?? 0;

    if (pendingFollowUps) {
        const pending = data.statuses["awaiting-resolution"] ?? 0;
        pendingFollowUps.textContent = pending > 0 
            ? pending + ' pending follow-up' + (pending > 1 ? 's' : '') 
            : 'None';
    }

    if (topSchoolsEl) {
        if (data.topSchools && data.topSchools.length > 0) {
            topSchoolsEl.textContent = data.topSchools.join(', ');
        } else {
            topSchoolsEl.textContent = 'N/A';
        }
    }
}


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
                        filename: 'provincial-admin-dashboard.pdf',
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


<style>
/* Abuse buttons style */
#abuseButtons button {
    font-size: 13px;
    border-radius: 6px;
    cursor: pointer;
    padding: 6px 10px;
    font-weight: 600;
    transition: 0.2s all;
}
#abuseButtons button.active {
    background-color: #4c9a2a !important;
    color: white !important;
}
#abuseButtons button:not(.active) {
    background-color: #e5e7eb !important;
    color: #111 !important;
}
#abuseButtons button:hover {
    background-color: #d1d5db !important;
}
</style>

