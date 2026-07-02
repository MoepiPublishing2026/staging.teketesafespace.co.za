<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;
use App\Models\School;
use App\Models\AbuseType;
use App\Models\Subtype;
use App\Support\SafeMail;
use App\Support\SafeNotify;
use App\Mail\ReportStatusChangedNotification;
use App\Mail\ReporterBlockedNotification;
use App\Notifications\CaseStatusChanged;

class SchoolAdminReportsController extends AdminController
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'school') {
            abort(403, 'Unauthorized');
        }

        $schoolName = $user->school_name;

        if (!$schoolName) {
            abort(404, 'User does not have a school assigned. Please contact administrator.');
        }

        $school = School::where('school_name', $schoolName)->first();

        if (!$school) {
            abort(404, 'School not found in database. Please contact administrator.');
        }

        // Start query filtered by this admin's school
        $query = Report::with(['province', 'district', 'school', 'abuseType', 'subtype'])
            ->where('school_name', $schoolName);

        // ── EXISTING filters ─────────────────────────────────────────

        // Case number search (kept for backward compatibility)
        if ($request->filled('case_number')) {
            $query->where('case_number', 'LIKE', '%' . $request->input('case_number') . '%');
        }

        // Existing filterable fields
        $filterableFields = [
            'status'     => 'status',
            'abuse_type' => 'abuse_type_id',
        ];

        foreach ($filterableFields as $input => $column) {
            if ($request->filled($input)) {
                $query->where($column, $request->input($input));
            }
        }

        // Age range filter
        if ($request->filled('age_range')) {
            $ageRange = $request->input('age_range');
            if ($ageRange === '30+') {
                $query->where('age', '>=', 30);
            } elseif (strpos($ageRange, '-') !== false) {
                [$minAge, $maxAge] = explode('-', $ageRange);
                if (is_numeric($minAge) && is_numeric($maxAge)) {
                    $query->whereBetween('age', [(int)$minAge, (int)$maxAge]);
                }
            }
        }

        // ── NEW filters ──────────────────────────────────────────────

        // Global search bar: case number, email, full name, description
        if ($s = trim($request->input('search', ''))) {
            $query->where(function ($q) use ($s) {
                $q->where('case_number',      'like', "%{$s}%")
                  ->orWhere('reporter_email', 'like', "%{$s}%")
                  ->orWhere('full_name',      'like', "%{$s}%")
                  ->orWhere('description',    'like', "%{$s}%");
            });
        }

        // Name / surname filter
        if ($n = trim($request->input('full_name', ''))) {
            $query->where(function ($q) use ($n) {
                $q->where('full_name',        'like', "%{$n}%")
                  ->orWhere('reporter_email', 'like', "%{$n}%");
            });
        }

        // Grade filter
        if ($request->filled('grade')) {
            $query->where('grade', $request->input('grade'));
        }

        // Report type filter (dashboard may pass abuse_type_id)
        if ($request->filled('type_id')) {
            $query->where('abuse_type_id', $request->input('type_id'));
        } elseif ($request->filled('abuse_type_id')) {
            $query->where('abuse_type_id', $request->input('abuse_type_id'));
        }

        // Subtype filter
        if ($request->filled('subtype_id')) {
            $query->where('subtype_id', $request->input('subtype_id'));
        }

        // Status dropdown (new panel name — works alongside existing 'status' field)
        if (!$request->filled('status') && $request->filled('filter_status')) {
            $query->where('status', $request->input('filter_status'));
        }

        // Anonymous filter — use has() not filled() because '0' is falsy
        if ($request->has('is_anonymous') && $request->input('is_anonymous') !== '') {
            $query->where('is_anonymous', (int)$request->input('is_anonymous'));
        }

        // Date range (new field names: date_from/date_to — kept alongside old from_date/to_date)
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->input('date_from'));
        } elseif ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->input('from_date'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->input('date_to'));
        } elseif ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->input('to_date'));
        }

        $reports = $query->latest()->paginate(20)->withQueryString();

        // ── Dropdown options for the filter panel ────────────────────
        $typeOptions = AbuseType::orderBy('type_name')->get();

        $subtypeOptions = Subtype::orderBy('sub_type_name')
            ->when(
                $request->filled('type_id'),
                fn ($q) => $q->where('abuse_type_id', $request->input('type_id'))
            )
            ->get();

        $gradeOptions = Report::where('school_name', $schoolName)
            ->whereNotNull('grade')
            ->where('grade', '!=', '')
            ->distinct()
            ->orderBy('grade')
            ->pluck('grade')
            ->toArray();

        return view('school-admin-reports.index', compact(
            'reports',
            'school',
            'typeOptions',
            'subtypeOptions',
            'gradeOptions'
        ));
    }

    public function show($id, Request $request)
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'school') {
            abort(403, 'Unauthorized');
        }

        $schoolName = $user->school_name;

        $report = Report::with(['province', 'district', 'school', 'abuseType', 'subtype', 'user'])
                        ->where('school_name', $schoolName)
                        ->findOrFail($id);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'id'                   => $report->id,
                'case_number'          => $report->case_number,
                'full_name'            => $report->full_name ?? 'Anonymous',
                'province'             => $report->province->province_name ?? 'N/A',
                'district'             => $report->district->district_name ?? 'N/A',
                'school'               => $report->school->school_name ?? $report->school_name ?? 'N/A',
                'abuseType'            => $report->abuseType->type_name ?? 'N/A',
                'subtype'              => $report->subtype->sub_type_name ?? 'N/A',
                'status'               => $report->status,
                'is_anonymous'         => $report->is_anonymous,
                'created_at'           => $report->created_at->format('Y M d'),
                'reporter_email'       => $report->reporter_email ?? 'Anonymous',
                'phone_number'         => $report->phone_number ?? 'N/A',
                'grade'                => $report->grade ?? 'N/A',
                'latest_status_reason' => $report->latest_status_reason ?? 'No status history recorded.',
                'reporter_clarification' => $report->reporter_clarification,
                'blocked_at'           => $report->blocked_at?->format('Y M d'),
                'blocked_by_name'      => $report->blocked_by_name,
                'false_reports_count'  => $this->falseReportsCountFor($report),
                'description'          => $report->description,
                'attachments'          => $report->image_path ? json_decode($report->image_path, true) : [],
            ]);
        }

        abort(404, 'Not Found');
    }

    public function updateStatus(Request $request, $id)
    {
        return $this->safeAdmin(function () use ($request, $id) {
            return $this->performUpdateStatus($request, $id);
        }, $request);
    }

    private function performUpdateStatus(Request $request, $id)
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'school') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'status' => 'required|string|in:awaiting-resolution,under-review,forwarded,closed,unresolved,false-report',
            'reason' => 'required|string|min:10|max:500',
        ], [
            'reason.required' => 'You must provide a reason for this status change.',
            'reason.min'      => 'Please provide a more detailed justification (at least 10 characters).',
        ]);

        $report = Report::with('user')
            ->where('school_name', $user->school_name)
            ->findOrFail($id);

        $newStatus = $request->input('status');
        $reason    = $request->input('reason');

        $report->status               = $newStatus;
        $report->latest_status_reason = $reason;
        $report->save();
        $report->refresh();

        if ($newStatus === 'false-report') {
            $falseCount = Report::where('status', 'false-report')
                ->where(function ($query) use ($report) {
                    if (!empty($report->reporter_email)) {
                        $query->where('reporter_email', $report->reporter_email);
                    } elseif (!empty($report->phone_number)) {
                        $query->where('phone_number', $report->phone_number);
                    } elseif (!empty($report->full_name)) {
                        $query->where('full_name', $report->full_name);
                    } else {
                        $query->whereRaw('1 = 0');
                    }
                })->count();

            if ($falseCount >= 2) {
                Report::where(function ($query) use ($report) {
                    if (!empty($report->reporter_email)) {
                        $query->where('reporter_email', $report->reporter_email);
                    } elseif (!empty($report->phone_number)) {
                        $query->where('phone_number', $report->phone_number);
                    } elseif (!empty($report->full_name)) {
                        $query->where('full_name', $report->full_name);
                    }
                })->update(['suspended_until' => now()->addDays(90)]);

                $report->refresh();
            }
        }

        if ($report->reporter_email && $report->reporter_email !== $user->email) {
            SafeMail::sendAfterResponse($report->reporter_email, new ReportStatusChangedNotification($report, $reason));
        }

        if ($report->user && $report->user->id !== $user->id) {
            SafeNotify::sendAfterResponse($report->user, new CaseStatusChanged($report));
        }

        $message = 'Status updated successfully. Reporter notified.';
        if ($newStatus === 'false-report') {
            if ($report->suspended_until) {
                $isPermanent = $report->suspended_until->year >= Report::PERMANENT_BLOCK_YEAR;
                $message = $isPermanent
                    ? 'Reporter is permanently blocked (linked identifiers found).'
                    : 'Reporter has been suspended for 90 days.';
            } else {
                $message = 'Report marked as false.';
            }
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'status'  => $report->status,
            ]);
        }

        return redirect()->back()->with('success_message', $message);
    }

    public function permanentBlock(Request $request)
    {
        return $this->safeAdmin(function () use ($request) {
            return $this->performPermanentBlock($request);
        }, $request);
    }

    private function performPermanentBlock(Request $request)
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'school') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'report_id' => 'required|integer',
        ]);

        $report = Report::where('school_name', $user->school_name)
            ->findOrFail($request->input('report_id'));

        if (!$report->reporter_email) {
            return response()->json(['success' => false, 'message' => 'No email address found.'], 422);
        }

        $permanentDate = \Carbon\Carbon::create(Report::PERMANENT_BLOCK_YEAR, 12, 31, 23, 59, 59);

        Report::where(function ($query) use ($report) {
            if ($report->reporter_email) {
                $query->where('reporter_email', $report->reporter_email);
            }
            if ($report->phone_number) {
                $query->orWhere('phone_number', $report->phone_number);
            }
            if ($report->full_name) {
                $query->orWhere('full_name', $report->full_name);
            }
        })->update([
            'suspended_until' => $permanentDate,
            'blocked_by_id'   => $user->id,
            'blocked_by_name' => $user->name,
            'blocked_at'      => now(),
        ]);

        $report->refresh();

        SafeMail::sendAfterResponse($report->reporter_email, new ReporterBlockedNotification($report, true));

        return response()->json([
            'success' => true,
            'message' => 'Reporter has been permanently blocked and notified via email.',
        ]);
    }

    private function falseReportsCountFor(Report $report): int
    {
        return Report::where('status', 'false-report')
            ->where(function ($query) use ($report) {
                if (!empty($report->reporter_email)) {
                    $query->where('reporter_email', trim(strtolower($report->reporter_email)));
                } elseif (!empty($report->phone_number)) {
                    $query->where('phone_number', trim($report->phone_number));
                } elseif (!empty($report->full_name)) {
                    $query->where('full_name', trim($report->full_name));
                } else {
                    $query->whereRaw('1 = 0');
                }
            })
            ->count();
    }
}