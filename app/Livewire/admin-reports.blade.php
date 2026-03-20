<section> <!-- CRITICAL FIX: This is the single root element for Livewire -->
<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');

.font-montserrat-bold {
    font-family: 'Montserrat', sans-serif;
    font-weight: 700;
}

.font-montserrat-regular {
    font-family: 'Montserrat', sans-serif;
    font-weight: 400;
}

/* Custom gradient for buttons/sidebar active */
.bg-custom-gradient {
    background-image: linear-gradient(to right, #c7da30, #d7e47a);
}
.hover\:bg-custom-gradient:hover {
    background-image: linear-gradient(to right, #c7da30, #d7e47a);
    color: black !important;
}

/* Override table header background for the required 'Table Header Green Rectangle' color */
.reports-table thead tr {
    background-image: linear-gradient(to right, #c7da30, #d7e47a);
    color: black;
}
</style>

<div class="flex min-h-screen m-0 p-0">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg flex flex-col justify-between sticky top-0 h-screen" style="background-color: white">
        <div>
            <nav style="margin-top: 10px">
                <ul class="space-y-2">
                    <div class="flex justify-center" style="margin-bottom: 70px">
                          <img src="{{ asset('images/logo.png') }}" 
                               alt="Safe Space Logo" 
                               style="width: 125px; height: 110px;">
                    </div>
                    <!-- Dashboard -->
                    <li class="flex justify-center">
                        <a href="/admin/dashboard"
                            class="block rounded flex items-center font-montserrat-black rounded-lg transition-all
                            {{ Request::is('admin/dashboard') ? 'bg-gradient-to-r from-[#38b6ff] to-[#38b6ff]' : 'hover:bg-gradient-to-r from-[#38b6ff] to-[#38b6ff]' }}"
                            style="width: 130px; height: 41px; color: #545454; font-size: 15px; padding-left: 20px;">
                            <i></i>Dashboard
                        </a>
                    </li>

                    <!-- Reports -->
                    <li class="flex justify-center">
                        <a href="/admin/reports"
                            class="block rounded flex items-center font-montserrat-black rounded-lg transition-all
                            {{ Request::is('admin/reports') ? 'bg-gradient-to-r from-[#38b6ff] to-[#38b6ff]' : 'hover:bg-gradient-to-r from-[#38b6ff] to-[#38b6ff]' }}"
                            style="width: 130px; height: 41px; color: white; font-size: 15px; padding-left: 20px;">
                            <i></i>Reports
                        </a>
                    </li>

                    <!-- My Profile -->
                    <li class="flex justify-center">
                        <a href="/admin/settings"
                            class="block rounded flex items-center font-montserrat-black rounded-lg transition-all
                            {{ Request::is('admin/settings') ? 'bg-gradient-to-r from-[#38b6ff] to-[#38b6ff]' : 'hover:bg-gradient-to-r from-[#38b6ff] to-[#38b6ff]' }}"
                            style="width: 130px; height: 41px; color: #545454; font-size: 15px; padding-left: 20px;">
                            <i></i>My Profile
                        </a>
                    </li>

                    <!-- Export PDF -->
                    <li class="flex justify-center">
                        <a href="#" onclick="exportPDF()"
                            class="block rounded flex items-center font-montserrat-black rounded-lg transition-all
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
                                class="block w-full rounded flex items-center font-montserrat-black rounded-lg transition-all
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

    <!-- Main Content -->
    <main id="main-content" class="flex-1 p-8 space-y-8 overflow-auto" style="background: white">
        <div class="flex items-center space-x-3 mb-4 flex justify-end">
            <div class="flex flex-col text-right">
                <p class="font-montserrat-black font-bold text-[#38b6ff]" style="font-size: 16px;">{{ auth()->user()->name ?? 'Admin' }}</p>
                <p class="text-sm text-gray-500 font-montserrat-black" style="font-size: 15px;">Administrator</p>
            </div>
            @php
                $currentUser = auth()->user()->fresh();
            @endphp
            @if($currentUser && $currentUser->profile_picture)
                <img src="{{ asset('storage/' . $currentUser->profile_picture) }}" alt="Profile Picture" class="w-10 h-10 rounded-full object-cover border-2 border-gray-300 shadow">
            @else
                <div class="w-10 h-10 bg-gradient-to-r from-gray-400 to-gray-600 rounded-full flex items-center justify-center border-2 border-gray-300 shadow" >
                    <i class="fas fa-user-circle text-white text-5xl"></i>
                </div>
            @endif
        </div>

        <h1 class="text-4xl font-bold text-black-800 mb-8 font-montserrat-black">
            @if ($filter === 'all')
                All Reports
            @else
                {{ ucfirst($filter) }} Reports
            @endif
        </h1>

        @if(session()->has('success_message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success_message') }}
            </div>
        @endif
        @if(session()->has('error_message'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                {{ session('error_message') }}
            </div>
        @endif

<!-- Reports Table -->
<div>
    <table class="bg-[#dadada] w-full table-fixed border border-gray-200 text-sm reports-table">
        <thead>
            <tr class="text-center font-montserrat-regular">
                <th class="w-[8%] py-3 px-2 border-b">Case #</th>
                <th class="w-[15%] py-3 px-2 border-b">Email</th>
                <th class="w-[10%] py-3 px-2 border-b">Type</th>
                <th class="w-[10%] py-3 px-2 border-b">Subtype</th>
                <th class="w-[10%] py-3 px-2 border-b">Status</th>
                <th class="w-[7%] py-3 px-2 border-b">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reports as $report)
                <tr class="hover:bg-blue-50 transition cursor-pointer align-top"
                    wire:click="showReport({{ $report->id }})">
                    <td class="py-3 px-2 border-b text-center font-mono truncate">
                        {{ $report->case_number }}
                    </td>
                    <td class="py-3 px-2 border-b text-center truncate">
                        {{ $report->reporter_email ?? 'Anonymous' }}
                    </td>
                    <td class="py-3 px-2 border-b text-center truncate">
                        {{ $report->abuseType->type_name ?? 'N/A' }}
                    </td>
                    <td class="py-3 px-2 border-b text-center truncate">
                        {{ $report->subtype->sub_type_name ?? 'N/A' }}
                    </td>
                    <td class="py-3 px-2 border-b text-center">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold
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
                    <td class="py-3 px-2 border-b text-center">
                        <!-- Prevent row click modal when clicking dropdown -->
                        <select 
                            wire:change.stop="promptForStatusUpdate({{ $report->id }}, $event.target.value)"
                            onclick="event.stopPropagation()"
                            class="rounded-md shadow-sm border-gray-300 w-[100%] text-xs">
                            <option value="">-- Update --</option>
                            <option value="awaiting-resolution">Awaiting Resolution</option>
                            <option value="under-review">Under Review</option>
                            <option value="forwarded">Forwarded</option>
                            <option value="closed">Closed</option>
                            <option value="unresolved">Unresolved</option>
                            <option value="false-report">False Report</option>
                        </select>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>



        <!-- Report Details Modal -->
        @if($selectedReport)
            <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 p-4">
                <div class="bg-white p-6 rounded-lg border-[3px] border-[#c7da30] w-full max-w-4xl max-h-[90vh] overflow-auto shadow-2xl font-montserrat-regular">
                    <h2 class="text-2xl font-montserrat-bold text-black mb-6">Case Details: {{ $selectedReport->case_number }}</h2>
        
                    <div class="grid grid-cols-2 gap-4 text-sm text-black">
                        <p><strong>Email:</strong> {{ $selectedReport->reporter_email ?? 'Anonymous' }}</p>
                        <p><strong>Phone:</strong> {{ $selectedReport->phone_number ?? 'N/A' }}</p>
                        <p><strong>Type:</strong> {{ $selectedReport->abuseType->type_name ?? 'N/A' }}</p>
                        <p><strong>Subtype:</strong> {{ $selectedReport->subtype->sub_type_name ?? 'N/A' }}</p>
                         <p><strong>School:</strong> {{ $selectedReport->schoolName ?? $selectedReport->school_name ?? 'N/A' }}</p> 
                        <p><strong>Grade:</strong> {{ $selectedReport->grade ?? 'N/A' }}</p>
                        <p class="col-span-2"><strong>Current Status:</strong> <span class="font-semibold">{{ ucfirst($selectedReport->status) }}</span></p>
                        <p class="col-span-2 border-t pt-2"><strong>Latest Reason:</strong> {{ $selectedReport->latest_status_reason ?? 'No status history recorded.' }}</p>
                    </div>
        
                    <div class="mt-6">
                        <p class="font-semibold mb-2">Description:</p>
                        <div class="p-4 bg-white-100 rounded border-[3px] border-[#c7da30] text-sm text-black leading-relaxed">
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
                    $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                    $publicUrl = asset('storage/' . ltrim($filePath, '/'));
                    $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg']);
                    $isVideo = in_array($ext, ['mp4', 'mov', 'avi', 'wmv']);
                @endphp

                @if ($isImage)
                    <img src="{{ $publicUrl }}" alt="Attachment" class="w-32 h-auto mt-2 border rounded shadow cursor-pointer"
                        wire:click="showImage('{{ $filePath }}')">
                @elseif ($isVideo)
                    <video controls class="w-48 h-auto mt-2 border rounded shadow cursor-pointer"
                        wire:click="showImage('{{ $filePath }}')">
                        <source src="{{ $publicUrl }}" type="video/{{ $ext }}">
                        Your browser does not support the video tag.
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
                            <option value="under-review">Under Review</option>
                            <option value="forwarded">Forwarded</option>
                            <option value="closed">Closed</option>
                            <option value="unresolved">Unresolved</option>
                            <option value="false-report">False Report</option>
                        </select>
                    </div>
        
                    <div class="mt-6 flex justify-end">
                        <button wire:click="closeReport"
                                class="bg-gradient-to-r from-[#c7da30] to-[#d7e47a] px-5 py-2 rounded-full font-montserrat hover:opacity-90 transition text-black">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        @endif


        <!-- Image Modal -->
        @if($modalImage)
            <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-70 z-50">
                <img src="{{ asset('storage/' . $modalImage) }}" class="max-h-[90vh] max-w-[90vw] rounded-lg shadow-lg">
                <button wire:click="closeImage" class="bg-gradient-to-r from-[#c7da30] to-[#d7e47a] px-5 py-2 rounded-full font-montserrat hover:opacity-90 transition text-black">Close</button>
            </div>
        @endif

        <!-- Reason Capture Modal -->
        @if($showReasonModal)
            <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 p-4">
                <div class="bg-white p-6 rounded-lg border-[3px] border-[#c7da30] w-full max-w-lg shadow-2xl font-montserrat-regular">
                    <h2 class="text-2xl font-montserrat-bold text-black mb-4">JUSTIFY STATUS CHANGE</h2>
        
                    @if($reportToUpdate)
                        <p class="mb-4 text-sm text-black">
                            You are changing <strong>{{ $reportToUpdate->case_number }}</strong> status from 
                            <span class="font-semibold">{{ ucfirst($reportToUpdate->status) }}</span> 
                            to 
                            <span class="font-semibold text-blue-700">{{ ucfirst($newStatus) }}</span>.
                        </p>
                    @endif
        
                    <form wire:submit.prevent="finalizeStatusUpdate">
                        <div class="mb-5">
                            <label for="statusChangeReason" class="block text-sm font-semibold text-black mb-1">Reason for status change:</label>
                            <textarea wire:model.defer="statusChangeReason" id="statusChangeReason" rows="5"
                                      class="w-full border-[3px] border-[#c7da30] rounded-md p-3 text-sm text-black focus:outline-none focus:ring-2 focus:ring-lime-400 resize-none"></textarea>
                            @error('statusChangeReason') 
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                            @enderror
                        </div>
        
                        <div class="flex justify-end space-x-4">
                            <button type="button" wire:click="cancelUpdate"
                                    class="bg-gradient-to-r from-[#c7da30] to-[#d7e47a] px-5 py-2 rounded-full font-montserrat hover:opacity-90 transition text-black">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="bg-gradient-to-r from-[#c7da30] to-[#d7e47a] px-5 py-2 rounded-full font-montserrat hover:opacity-90 transition text-black">
                                Confirm & Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

    </main>
</div>

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
</section>
