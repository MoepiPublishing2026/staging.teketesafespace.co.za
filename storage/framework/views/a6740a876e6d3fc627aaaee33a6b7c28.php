<div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 flex flex-col justify-between sticky top-0 h-screen" style="background-color: #fffbf7;">
        <div class="flex flex-col h-full">
            

            <nav class="flex-1 px-4 mt-24 space-y-3">
                <a href="<?php echo e(route('provincial.admin.dashboard')); ?>"
                   class="flex items-center px-4 py-3 rounded-lg transition-all font-semibold text-black hover:bg-gradient-to-r from-[#c7da30] to-[#d7e47a]">
                   Dashboard
                </a>
                <a href="<?php echo e(url('provincial/reports')); ?>"
                   class="flex items-center px-4 py-3 rounded-lg transition-all font-semibold text-black hover:bg-gradient-to-r from-[#c7da30] to-[#d7e47a]">
                   Reports
                </a>
                <a href="<?php echo e(url('provincial/profile')); ?>"
                   class="flex items-center px-4 py-3 rounded-lg transition-all font-semibold text-black hover:bg-gradient-to-r from-[#c7da30] to-[#d7e47a]">
                   My Profile
                </a>
               <!-- Export PDF -->
                    <li class="flex justify-center">
                        <a href="#" onclick="exportPDF()"
                            class="flex items-center font-montserrat-black rounded-lg transition-all font-semibold text-black
                            <?php echo e(Request::is('provicial/export') ? 'bg-gradient-to-r from-[#c7da30] to-[#d7e47a]' : 'hover:bg-gradient-to-r from-[#c7da30] to-[#d7e47a]'); ?>"
                            style="width: 188px; height: 41px; color: black; font-size: 15px;">
                            <i></i>Export PDF
                        </a>
                    </li>
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit"
                        class="w-full text-left flex items-center px-4 py-3 rounded-lg transition-all font-semibold hover:bg-gradient-to-r from-[#c7da30] to-[#d7e47a]">
                        Sign Out
                    </button>
                </form>
            </nav>

            <div class="p-4 text-center">
                <p class="text-sm text-gray-600">© 2025 SafeSpace</p>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main id='main-content' class="flex-1 flex flex-col p-8 bg-gray-100 overflow-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-lime-800 tracking-wide">
                <?php echo e($province); ?> Provincial Report
            </h1>
            <div class="flex items-center gap-4">
                <div class="text-right">
                    <p class="font-bold text-gray-800"><?php echo e(auth()->user()->name ?? 'Admin'); ?></p>
                    <p class="text-sm text-gray-500">Provincial Admin</p>
                </div>
                <!--[if BLOCK]><![endif]--><?php if(auth()->user()->profile_picture): ?>
                    <img src="<?php echo e(auth()->user()->profile_picture_url); ?>" 
                         class="w-12 h-12 rounded-full object-cover border-2 border-gray-300 shadow">
                <?php else: ?>
                    <div class="w-12 h-12 bg-gray-400 rounded-full flex items-center justify-center border-2 border-gray-300 shadow">
                        <i class="fas fa-user-circle text-white text-3xl"></i>
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>

        <!-- Filters -->
    
<div class="bg-white rounded-lg shadow-md p-4 mb-6 flex flex-wrap gap-4 items-end">

    <!-- From Date -->
    <div>
        <label class="block text-sm font-semibold text-gray-600 mb-1">From</label>
        <input type="date" wire:model.live="fromDate"
               class="border rounded-lg px-3 py-2 focus:ring-lime-500 focus:border-lime-500">
    </div>

    <!-- To Date -->
    <div>
        <label class="block text-sm font-semibold text-gray-600 mb-1">To</label>
        <input type="date" wire:model.live="toDate"
               class="border rounded-lg px-3 py-2 focus:ring-lime-500 focus:border-lime-500">
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

<div>
        <!-- Reports Table -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Reports Summary</h2>
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
                    <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="text-center hover:bg-lime-50 transition">
                            <td class="p-2 border"><?php echo e($report->case_number); ?></td>
                            <td class="p-2 border"><?php echo e($report->reporter_email ?? 'Anonymous'); ?></td>
                            <td class="p-2 border"><?php echo e($report->abuseType->type_name ?? 'N/A'); ?></td>
                            <td class="p-2 border"><?php echo e($report->school->school_name ?? 'N/A'); ?></td>
                            <td class="p-2 border">
                                <span class="px-2 py-1 rounded text-xs font-semibold
                                    <?php if($report->status == 'awaiting-resolution'): ?> bg-yellow-100 text-yellow-800
                                    <?php elseif($report->status == 'under-review'): ?> bg-blue-100 text-blue-800
                                    <?php elseif($report->status == 'forwarded'): ?> bg-red-100 text-red-800
                                    <?php elseif(in_array($report->status, ['closed','completed'])): ?> bg-green-100 text-green-800
                                    <?php elseif($report->status == 'unresolved'): ?> bg-gray-100 text-gray-800
                                    <?php elseif($report->status == 'false-report'): ?> bg-purple-100 text-purple-800
                                    <?php endif; ?>">
                                    <?php echo e(ucfirst($report->status)); ?>

                                </span>
                            </td>
                            <td class="p-2 border"><?php echo e($report->created_at->format('Y-m-d')); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-gray-500">No reports found for this province.</td>
                        </tr>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </tbody>
            </table>
        </div>
    </main>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<script>
document.addEventListener('livewire:updated', () => {
    const search = window.Livewire.find('<?php echo e($_instance->getId()); ?>').searchCase;
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

<?php /**PATH /home/teketeq9v8o0/staging.teketesafespace.co.za/resources/views/livewire/provincial-report.blade.php ENDPATH**/ ?>