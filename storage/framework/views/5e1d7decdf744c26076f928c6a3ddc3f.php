<div>
<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');

.font-montserrat-bold { font-family: 'Montserrat', sans-serif; font-weight: 700; }
.font-montserrat-regular { font-family: 'Montserrat', sans-serif; font-weight: 400; }

.bg-custom-gradient { background-image: linear-gradient(to right, #c7da30, #d7e47a); }

.reports-table thead tr {
    background-image: linear-gradient(to right, #c7da30, #d7e47a);
    color: black;
}

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

.main-panel button:hover,
.sidebar-link:hover,
.sidebar-link.active {
    color: #fff !important;
    background: linear-gradient(to right, #38b6ff, #38b6ff) !important;
}

.main-panel { flex: 1; display: flex; flex-direction: column; min-width: 0; height: 100vh; background: white; }

/* ── Filter Panel ─────────────────────────────────────────────────── */
.filter-panel {
    background: #f9fafb;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 18px 20px;
    margin-bottom: 20px;
}
.filter-label {
    font-family: 'Montserrat', sans-serif;
    font-size: 11px;
    font-weight: 700;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    margin-bottom: 5px;
    display: block;
}
.filter-input {
    width: 100%;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    padding: 7px 10px;
    font-size: 13px;
    font-family: 'Montserrat', sans-serif;
    color: #111;
    background: white;
    transition: border-color 0.2s;
    outline: none;
    box-sizing: border-box;
}
.filter-input:focus {
    border-color: #c7da30;
    box-shadow: 0 0 0 3px rgba(199,218,48,0.15);
}
.search-wrap { position: relative; margin-bottom: 18px; }
.search-wrap input {
    width: 100%;
    border: 2px solid #c7da30;
    border-radius: 30px;
    padding: 10px 20px 10px 44px;
    font-size: 14px;
    font-family: 'Montserrat', sans-serif;
    color: #111;
    background: white;
    outline: none;
    transition: box-shadow 0.2s;
    box-sizing: border-box;
}
.search-wrap input:focus { box-shadow: 0 0 0 3px rgba(199,218,48,0.2); }
.search-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: #aaa;
    pointer-events: none;
    font-size: 15px;
}
.filter-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(155px, 1fr));
    gap: 12px;
    align-items: end;
}
.btn-clear-filters {
    background: white;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    padding: 7px 14px;
    font-size: 12px;
    font-family: 'Montserrat', sans-serif;
    font-weight: 700;
    color: #6b7280;
    cursor: pointer;
    transition: all 0.2s;
    width: 100%;
    height: 36px;
}
.btn-clear-filters:hover {
    border-color: #c7da30 !important;
    color: #000 !important;
    background: #f7fcd4 !important;
}
.active-filter-badge {
    display: inline-flex;
    align-items: center;
    background: #f0f9d4;
    border: 1px solid #c7da30;
    border-radius: 20px;
    padding: 2px 10px;
    font-size: 11px;
    font-family: 'Montserrat', sans-serif;
    font-weight: 600;
    color: #4a5e00;
    margin-right: 6px;
    margin-bottom: 6px;
}

@media (max-width: 900px) {
    .sidebar { position: fixed; left: 0; width: 0; overflow-x: hidden; transition: width 0.3s; z-index: 1000; }
    .sidebar.open { width: 220px; }
    .main-panel.shifted { margin-left: 220px; }
    .reports-table { width: 100%; overflow-x: auto; display: block; }
    .reports-table thead, .reports-table tbody, .reports-table th, .reports-table td { white-space: nowrap; }
    .filter-grid { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 540px) {
    .filter-grid { grid-template-columns: 1fr; }
}
</style>
<?php echo $__env->make('components.school-admin-styles', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="flex min-h-screen m-0 p-0" style="min-height: 100vh;">
    <?php echo $__env->make('components.school-admin-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="main-panel">
    <main id="main-content" class="flex-1 p-4 sm:p-6 lg:p-8 space-y-8 overflow-auto" style="background: white">

        <!-- Top right user info -->
        <div class="flex items-center gap-3 mb-4 justify-end flex-wrap">
            <div class="flex flex-col text-right">
                <p class="font-montserrat-black font-bold text-[#38b6ff]" style="font-size: 16px;"><?php echo e(auth()->user()->name ?? 'Admin'); ?></p>
                <p class="text-sm text-gray-500 font-montserrat-black" style="font-size: 15px;">Administrator</p>
            </div>
             <?php
                $currentUser = auth()->user();
                $currentUser = $currentUser ? $currentUser->fresh() : null;
                ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentUser && $currentUser->profile_picture): ?>
                <img src="<?php echo e($currentUser->profile_picture_url); ?>" alt="Profile Picture" class="w-10 h-10 rounded-full object-cover border-2 border-gray-300 shadow">
            <?php else: ?>
                <div class="w-10 h-10 bg-gradient-to-r from-gray-400 to-gray-600 rounded-full flex items-center justify-center border-2 border-gray-300 shadow">
                    <i class="fas fa-user-circle text-white text-5xl"></i>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <h1 class="text-4xl font-bold text-black-800 mb-8 font-montserrat-black">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($filter === 'all'): ?> All Reports <?php else: ?> <?php echo e(ucfirst($filter)); ?> Reports <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </h1>

        <!-- ════════════════════════════════════════════════════════ -->
        <!--  SEARCH BAR + FILTER PANEL                              -->
        <!-- ════════════════════════════════════════════════════════ -->
        <div class="filter-panel">

            <!-- Search Bar -->
            <div class="search-wrap">
                <span class="search-icon"><i class="fas fa-search"></i></span>
                <input
                    type="text"
                    wire:model.live.debounce.350ms="search"
                    placeholder="Search by name, email, case number, description…"
                />
            </div>

            <!-- Filter Grid -->
            <div class="filter-grid">

                <div>
                    <label class="filter-label">Name / Surname</label>
                    <input type="text" class="filter-input"
                           wire:model.live.debounce.350ms="filterName"
                           placeholder="e.g. John Smith" />
                </div>

                <div>
                    <label class="filter-label">Grade</label>
                    <select class="filter-input" wire:model.live="filterGrade">
                        <option value="">All Grades</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $gradeOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($grade); ?>"><?php echo e($grade); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </select>
                </div>

                <div>
                    <label class="filter-label">Date From</label>
                    <input type="date" class="filter-input" wire:model.live="filterDateFrom" />
                </div>

                <div>
                    <label class="filter-label">Date To</label>
                    <input type="date" class="filter-input" wire:model.live="filterDateTo" />
                </div>

                <div>
                    <label class="filter-label">Report Type</label>
                    <select class="filter-input" wire:model.live="filterType">
                        <option value="">All Types</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $typeOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($type->id); ?>"><?php echo e($type->type_name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </select>
                </div>

                <div>
                    <label class="filter-label">Subtype</label>
                    <select class="filter-input" wire:model.live="filterSubtype">
                        <option value="">All Subtypes</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $subtypeOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($sub->id); ?>"><?php echo e($sub->sub_type_name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </select>
                </div>

                <div>
                    <label class="filter-label">Status</label>
                    <select class="filter-input" wire:model.live="filterStatus">
                        <option value="">All Statuses</option>
                        <option value="awaiting-resolution">Awaiting Resolution</option>
                        <option value="under-review">Under Review</option>
                        <option value="forwarded">Forwarded</option>
                        <option value="closed">Closed</option>
                        <option value="unresolved">Unresolved</option>
                        <option value="false-report">False Report</option>
                    </select>
                </div>

                <div>
                    <label class="filter-label">Anonymous</label>
                    <select class="filter-input" wire:model.live="filterAnonymous">
                        <option value="">All Reports</option>
                        <option value="1">Anonymous</option>
                        <option value="0">Identified</option>
                    </select>
                </div>

                <div style="display:flex; align-items:flex-end;">
                    <button type="button" class="btn-clear-filters" wire:click="clearFilters">
                        <i class="fas fa-times mr-1"></i> Clear Filters
                    </button>
                </div>

            </div>

            <!-- Active filter badges -->
            <?php
                $_anon = $filterAnonymous ?? '';
                $activeFilters = array_filter([
                    'Search'    => $search ?? '',
                    'Name'      => $filterName ?? '',
                    'Grade'     => $filterGrade ?? '',
                    'From'      => $filterDateFrom ?? '',
                    'To'        => $filterDateTo ?? '',
                    'Type'      => !empty($filterType)    ? ($typeOptions->firstWhere('id', $filterType)?->type_name          ?? $filterType)    : null,
                    'Subtype'   => !empty($filterSubtype) ? ($subtypeOptions->firstWhere('id', $filterSubtype)?->sub_type_name ?? $filterSubtype) : null,
                    'Status'    => $filterStatus ?? '',
                    'Anonymous' => $_anon === '1' ? 'Yes' : ($_anon === '0' ? 'No' : null),
                ]);
            ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($activeFilters)): ?>
                <div class="mt-3 flex flex-wrap items-center">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $activeFilters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="active-filter-badge">
                            <i class="fas fa-filter mr-1" style="font-size:9px;"></i>
                            <?php echo e($label); ?>: <?php echo e($val); ?>

                        </span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <span class="text-xs text-gray-400 ml-1">— <?php echo e($reports->total()); ?> result(s)</span>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        </div>
        <!-- ═══════════════════════════ END FILTER PANEL ══════════ -->

        <!-- Reports Table -->
        <div class="reports-table-wrap" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
            <table class="bg-[#dadada] w-full table-fixed border border-gray-200 text-sm reports-table" style="min-width: 650px;">
                <thead>
                    <tr class="text-center font-montserrat-regular">
                        <th class="w-[8%]  py-3 px-2 border-b">Case #</th>
                        <th class="w-[15%] py-3 px-2 border-b">Email</th>
                        <th class="w-[10%] py-3 px-2 border-b">Report Type</th>
                        <th class="w-[10%] py-3 px-2 border-b">Subtype</th>
                        <th class="w-[7%]  py-3 px-2 border-b">Grade</th>
                        <th class="w-[9%]  py-3 px-2 border-b">Date</th>
                        <th class="w-[10%] py-3 px-2 border-b">Status</th>
                        <th class="w-[7%]  py-3 px-2 border-b">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-blue-50 transition cursor-pointer align-top"
                            wire:click="showReport(<?php echo e($report->id); ?>)">
                            <td class="py-3 px-2 border-b text-center font-mono truncate">
                                <?php echo e($report->case_number); ?>

                            </td>
                            <td class="py-3 px-2 border-b text-center truncate">
                                <?php echo e($report->reporter_email ?? 'Anonymous'); ?>

                            </td>
                            <td class="py-3 px-2 border-b text-center truncate">
                                <?php echo e($report->abuseType->type_name ?? 'N/A'); ?>

                            </td>
                            <td class="py-3 px-2 border-b text-center truncate">
                                <?php echo e($report->subtype->sub_type_name ?? 'N/A'); ?>

                            </td>
                            <td class="py-3 px-2 border-b text-center truncate">
                                <?php echo e($report->grade ?? 'N/A'); ?>

                            </td>
                            <td class="py-3 px-2 border-b text-center truncate">
                                <?php echo e($report->created_at?->format('Y M d') ?? 'N/A'); ?>

                            </td>
                            <td class="py-3 px-2 border-b text-center">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    <?php if($report->status == 'awaiting-resolution'): ?> bg-yellow-100 text-yellow-800
                                    <?php elseif($report->status == 'under-review'): ?>    bg-blue-100   text-blue-800
                                    <?php elseif($report->status == 'forwarded'): ?>       bg-red-100    text-red-800
                                    <?php elseif(in_array($report->status, ['closed','completed'])): ?> bg-green-100 text-green-800
                                    <?php elseif($report->status == 'unresolved'): ?>      bg-gray-100   text-gray-800
                                    <?php elseif($report->status == 'false-report'): ?>    bg-purple-100 text-purple-800
                                    <?php endif; ?>">
                                    <?php echo e(ucfirst($report->status)); ?>

                                </span>
                            </td>
                            <td class="py-3 px-2 border-b text-center">
                                <select
                                    wire:change.stop="promptForStatusUpdate(<?php echo e($report->id); ?>, $event.target.value)"
                                    onclick="event.stopPropagation()"
                                    class="rounded-md shadow-sm border-gray-300 w-full text-xs">
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
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="py-12 text-center text-gray-400 font-montserrat-regular">
                                <i class="fas fa-search mr-2"></i> No reports match your current filters.
                            </td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            <?php echo e($reports->links()); ?>

        </div>

        <!-- ══════════════════════════════════════════════════════════ -->
        <!-- Report Details Modal                                       -->
        <!-- ══════════════════════════════════════════════════════════ -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedReport): ?>
            <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 p-4">
                <div class="bg-white p-6 rounded-lg border-[3px] border-[#c7da30] w-full max-w-4xl max-h-[90vh] overflow-auto shadow-2xl font-montserrat-regular">
                    <h2 class="text-2xl font-montserrat-bold text-black mb-6">Case Details: <?php echo e($selectedReport->case_number); ?></h2>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedReport->blocked_at): ?>
                        <div class="mb-6 bg-black border-l-4 border-red-600 p-4 rounded shadow-md">
                            <div class="flex items-center">
                                <i class="fas fa-user-slash text-red-600 mr-3 text-xl"></i>
                                <div>
                                    <h3 class="text-white font-bold uppercase text-xs tracking-widest">Reporter Permanently Blocked</h3>
                                    <p class="text-gray-300 text-xs">
                                        Action taken by Admin: <span class="text-[#c7da30] font-bold"><?php echo e($selectedReport->blocked_by_name); ?></span>
                                        on <?php echo e(\Carbon\Carbon::parse($selectedReport->blocked_at)->format('Y, M d')); ?>

                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedReport->status === 'false-report'): ?>
                        <div class="mb-6 bg-red-50 border-l-4 border-red-600 p-4 rounded shadow-sm">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle text-red-600 mr-3 text-xl"></i>
                                <div>
                                    <h3 class="text-red-800 font-bold uppercase text-sm">Attention: This Report is Flagged</h3>
                                    <p class="text-red-700 text-xs font-semibold">Flag Reason: "<?php echo e($selectedReport->latest_status_reason); ?>"</p>
                                    <p class="text-red-700 text-xs">The reporter has been notified and asked to provide a clarification statement.</p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedReport->reporter_clarification): ?>
                        <div class="mb-6 bg-purple-50 border-l-4 border-purple-600 p-4 rounded shadow-sm">
                            <h3 class="text-purple-800 font-bold text-sm mb-2">Reporter's Clarification Statement:</h3>
                            <div class="text-gray-800 text-sm italic leading-relaxed bg-white p-3 rounded border border-purple-200">
                                "<?php echo e($selectedReport->reporter_clarification); ?>"
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <div class="grid grid-cols-2 gap-4 text-sm text-black">
                        <p><strong>Email:</strong> <?php echo e($selectedReport->reporter_email ?? 'Anonymous'); ?></p>
                        <p><strong>Phone:</strong> <?php echo e($selectedReport->phone_number ?? 'N/A'); ?></p>
                        <p><strong>Type:</strong> <?php echo e($selectedReport->abuseType->type_name ?? 'N/A'); ?></p>
                        <p><strong>Subtype:</strong> <?php echo e($selectedReport->subtype->sub_type_name ?? 'N/A'); ?></p>
                        <p><strong>School:</strong> <?php echo e($selectedReport->schoolName ?? $selectedReport->school_name ?? 'N/A'); ?></p>
                        <p><strong>Grade:</strong> <?php echo e($selectedReport->grade ?? 'N/A'); ?></p>
                        <p class="col-span-2"><strong>Current Status:</strong> <span class="font-semibold"><?php echo e(ucfirst($selectedReport->status)); ?></span></p>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedReport->status === 'false-report' || $selectedReport->reporter_clarification): ?>
                            <div class="col-span-2 mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 border-t pt-4">
                                <div class="bg-gray-50 p-3 rounded-lg border-l-4 border-gray-400">
                                    <h4 class="text-xs font-bold text-gray-600 uppercase mb-1">Reason for Flagging:</h4>
                                    <p class="text-sm leading-relaxed text-gray-800"><?php echo e($selectedReport->latest_status_reason ?? 'No reason provided.'); ?></p>
                                </div>
                                <div class="bg-purple-50 p-3 rounded-lg border-l-4 border-purple-600">
                                    <h4 class="text-xs font-bold text-purple-800 uppercase mb-1">Reporter's Clarification:</h4>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedReport->reporter_clarification): ?>
                                        <p class="text-sm italic leading-relaxed text-gray-800">"<?php echo e($selectedReport->reporter_clarification); ?>"</p>
                                    <?php else: ?>
                                        <p class="text-sm text-purple-400 italic">The reporter has not responded yet.</p>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <p class="col-span-2 border-t pt-2">
                                <strong>Latest Reason:</strong> <?php echo e($selectedReport->latest_status_reason ?? 'No notes recorded.'); ?>

                            </p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div class="mt-6">
                        <p class="font-semibold mb-2">Description:</p>
                        <div class="p-4 rounded border-[3px] border-[#c7da30] text-sm text-black leading-relaxed">
                            <?php echo e($selectedReport->description); ?>

                        </div>
                    </div>

                    <?php
                        $attachments = $selectedReport->image_path ? json_decode($selectedReport->image_path, true) : [];
                    ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($attachments)): ?>
                        <div class="mt-6">
                            <p class="font-semibold">Attachments:</p>
                            <div class="flex flex-wrap gap-4">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filePath): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $ext       = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                                        $publicUrl = asset('storage/' . ltrim($filePath, '/'));
                                        $isImage   = in_array($ext, ['jpg','jpeg','png','gif','bmp','webp','svg']);
                                        $isVideo   = in_array($ext, ['mp4','mov','avi','wmv']);
                                    ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isImage): ?>
                                        <img src="<?php echo e($publicUrl); ?>" alt="Attachment"
                                             class="w-32 h-auto mt-2 border rounded shadow cursor-pointer"
                                             wire:click="showImage('<?php echo e($filePath); ?>')">
                                    <?php elseif($isVideo): ?>
                                        <video controls class="w-48 h-auto mt-2 border rounded shadow">
                                            <source src="<?php echo e($publicUrl); ?>" type="video/<?php echo e($ext); ?>">
                                        </video>
                                    <?php else: ?>
                                        <a href="<?php echo e($publicUrl); ?>" target="_blank" class="text-blue-600 underline inline-block mt-2">
                                            View <?php echo e(basename($filePath)); ?>

                                        </a>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <p class="mt-6"><strong>Attachment:</strong> N/A</p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <div class="mt-6">
                        <label class="block text-sm font-medium mb-1">Update Status:</label>
                        <select wire:change.stop="promptForStatusUpdate(<?php echo e($selectedReport->id); ?>, $event.target.value)"
                                class="w-full sm:w-1/2 border-[3px] border-[#c7da30] p-2 rounded-md shadow-sm text-sm">
                            <option value="awaiting-resolution" <?php echo e($selectedReport->status == 'awaiting-resolution' ? 'selected' : ''); ?>>Awaiting Resolution</option>
                            <option value="under-review"        <?php echo e($selectedReport->status == 'under-review'        ? 'selected' : ''); ?>>Under Review</option>
                            <option value="forwarded"           <?php echo e($selectedReport->status == 'forwarded'           ? 'selected' : ''); ?>>Forwarded</option>
                            <option value="closed"              <?php echo e($selectedReport->status == 'closed'              ? 'selected' : ''); ?>>Closed</option>
                            <option value="unresolved"          <?php echo e($selectedReport->status == 'unresolved'          ? 'selected' : ''); ?>>Unresolved</option>
                            <option value="false-report"        <?php echo e($selectedReport->status == 'false-report'        ? 'selected' : ''); ?>>False Report</option>
                        </select>
                    </div>

                    <div class="mt-6 flex justify-end items-end space-x-3">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedReport->reporter_email): ?>
                            <div class="flex flex-col items-center">
                                <span class="text-[11px] font-bold text-red-600 mb-1 uppercase tracking-tighter">
                                    <?php echo e($falseReportsCount); ?> Total False Reports
                                </span>
                                <button wire:click="permanentBlock('<?php echo e($selectedReport->reporter_email); ?>')"
                                        wire:confirm="Are you sure? This will permanently prevent this email (<?php echo e($selectedReport->reporter_email); ?>) from making future reports."
                                        class="bg-gradient-to-r from-[#c7da30] to-[#d7e47a] px-5 py-2 rounded-full font-montserrat text-black shadow-md">
                                    <i class="fas fa-user-slash mr-2"></i> Block Reporter
                                </button>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <button wire:click="closeReport"
                                class="bg-gradient-to-r from-[#c7da30] to-[#d7e47a] px-5 py-2 rounded-full font-montserrat text-black shadow-md">
                            Close
                        </button>
                    </div>

                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <!-- Image Modal -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($modalImage): ?>
            <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-70 z-50">
                <img src="<?php echo e(asset('storage/' . $modalImage)); ?>" class="max-h-[90vh] max-w-[90vw] rounded-lg shadow-lg">
                <button wire:click="closeImage"
                        class="absolute bottom-8 bg-gradient-to-r from-[#c7da30] to-[#d7e47a] px-5 py-2 rounded-full font-montserrat text-black">
                    Close
                </button>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <!-- Reason Capture Modal -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showReasonModal): ?>
            <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 p-4">
                <div class="bg-white p-6 rounded-lg border-[4px] border-[#c7da30] w-full max-w-lg shadow-2xl font-montserrat-regular">

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($newStatus === 'false-report'): ?>
                        <h2 class="text-2xl font-montserrat-bold text-black mb-1">FLAGGING REPORT</h2>
                        <p class="mb-4 text-sm text-black">
                            You are changing <strong><?php echo e($reportToUpdate->case_number); ?></strong> status from
                            <span class="font-semibold"><?php echo e(ucfirst($reportToUpdate->status)); ?></span>
                            to <span class="font-semibold text-[#c7da30]"><?php echo e(ucfirst($newStatus)); ?></span>.
                        </p>
                        <p class="text-xs text-gray-500 mb-4 font-bold uppercase tracking-wider">Note: This action marks the report as fraudulent.</p>
                        <div class="bg-lime-50 p-3 rounded border border-[#c7da30] mb-4 text-sm text-black">
                            <p><strong>Flagged By:</strong> <?php echo e($adminName); ?></p>
                            <p><strong>Date/Time:</strong> <?php echo e($timestamp); ?></p>
                        </div>
                    <?php else: ?>
                        <p class="mb-4 text-sm text-black">
                            You are changing <strong><?php echo e($reportToUpdate->case_number); ?></strong> status from
                            <span class="font-semibold"><?php echo e(ucfirst($reportToUpdate->status)); ?></span>
                            to <span class="font-semibold text-blue-700"><?php echo e(ucfirst($newStatus)); ?></span>.
                        </p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <form wire:submit.prevent="finalizeStatusUpdate">
                        <div class="mb-5">
                            <label class="block text-sm font-semibold text-black mb-1">
                                <?php echo e($newStatus === 'false-report' ? 'Reason for Flagging:' : 'Reason for Update:'); ?>

                            </label>
                            <textarea wire:model.defer="statusChangeReason"
                                      rows="5"
                                      placeholder="<?php echo e($newStatus === 'false-report' ? 'Provide evidence or reason why this report is false...' : 'Enter reason...'); ?>"
                                      class="w-full border-[2px] border-[#c7da30] rounded-md p-3 text-sm text-black focus:outline-none focus:ring-2 focus:ring-lime-400 resize-none"></textarea>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['statusChangeReason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600 font-bold"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="flex justify-end space-x-3">
                            <button type="button" wire:click="cancelUpdate"
                                    class="bg-gradient-to-r from-[#c7da30] to-[#d7e47a] px-6 py-2 rounded-full font-bold text-black shadow-md">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="bg-gradient-to-r from-[#c7da30] to-[#d7e47a] text-black px-6 py-2 rounded-full font-bold shadow-md">
                                <?php echo e($newStatus === 'false-report' ? 'Confirm Flagging' : 'Confirm & Update'); ?>

                            </button>
                        </div>
                    </form>

                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    </main>
    </div>
</div>

<?php echo $__env->make('components.school-admin-sidebar-script', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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
</div>
<?php /**PATH C:\xampp\htdocs\staging.teketesafespace.co.za\resources\views/livewire/admin-reports.blade.php ENDPATH**/ ?>