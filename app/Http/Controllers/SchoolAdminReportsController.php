<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;
use App\Models\School;
use App\Models\AbuseType;
use App\Models\Subtype;
use App\Notifications\StatusUpdatedNotification; // add at top with other imports
use App\Models\StatusHistory;                     // add if you have this model

class SchoolAdminReportsController extends Controller
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

        // Report type filter
        if ($request->filled('type_id')) {
            $query->where('abuse_type_id', $request->input('type_id'));
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
                'case_number'          => $report->case_number,
                'full_name'            => $report->full_name ?? 'Anonymous',
                'province'             => $report->province->province_name ?? 'N/A',
                'district'             => $report->district->district_name ?? 'N/A',
                'school'               => $report->school->school_name ?? $report->school_name ?? 'N/A',
                'abuseType'            => $report->abuseType->type_name ?? 'N/A',
                'subtype'              => $report->subtype->sub_type_name ?? 'N/A',
                'status'               => $report->status,
                'is_anonymous'         => $report->is_anonymous,
                'created_at'           => $report->created_at->format('Y-m-d'),
                'reporter_email'       => $report->reporter_email ?? 'Anonymous',
                'phone_number'         => $report->phone_number ?? 'N/A',
                'grade'                => $report->grade ?? 'N/A',
                'latest_status_reason' => $report->latest_status_reason ?? 'No status history recorded.',
                'description'          => $report->description,
                'attachments'          => $report->image_path ? json_decode($report->image_path, true) : [],
            ]);
        }

        abort(404, 'Not Found');
    }
    public function updateStatus(Request $request, Report $report)
    {
        $validated = $request->validate([
            'status' => 'required|string',
            'reason' => 'required|string|max:1000',
        ]);

        $report->update(['status' => $validated['status']]);

        StatusHistory::create([
            'report_id'  => $report->id,
            'status'     => $validated['status'],
            'reason'     => $validated['reason'],
            'changed_by' => auth()->id(),
        ]);

        // Queued — does NOT block the response
        $report->user?->notify(new StatusUpdatedNotification($report));

        return response()->json([
            'ok'           => true,
            'status_label' => ucfirst(str_replace('-', ' ', $validated['status'])),
        ]);
    }   
}