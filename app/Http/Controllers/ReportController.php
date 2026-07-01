<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Province;
use App\Models\School;
use App\Models\AbuseType;
use App\Models\Subtype;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Start query with eager loading relationships
        $query = Report::with(['province', 'district', 'school', 'abuseType', 'subtype']);
            
        // ── EXISTING filters ─────────────────────────────────────────

        // Case number search (kept for backward compatibility)
        if ($request->filled('case_number')) {
            $query->where('case_number', 'LIKE', '%' . $request->input('case_number') . '%');
        }

        // Existing filterable fields
        $filterableFields = [
            'status'       => 'status',
            'province'     => 'province_id',
            'district'     => 'district_id',
            'school'       => 'school_id',
            'abuse_type'   => 'abuse_type_id',
            'is_anonymous' => 'is_anonymous',
        ];

        foreach ($filterableFields as $input => $column) {
            if ($request->filled($input)) {
                if ($input === 'is_anonymous') {
                    $value = filter_var($request->input($input), FILTER_VALIDATE_BOOLEAN);
                    $query->where($column, $value);
                } elseif ($input === 'status' && in_array($request->input('status'), Report::canonicalDashboardStatuses(), true)) {
                    $query->whereCanonicalDashboardStatus($request->input('status'));
                } else {
                    $query->where($column, $request->input($input));
                }
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

        // Global search bar: case number, email, full name, description, school name
        if ($s = trim($request->input('search', ''))) {
            $query->where(function ($q) use ($s) {
                $q->where('case_number',      'like', "%{$s}%")
                  ->orWhere('reporter_email', 'like', "%{$s}%")
                  ->orWhere('full_name',      'like', "%{$s}%")
                  ->orWhere('description',    'like', "%{$s}%")
                  ->orWhere('school_name',    'like', "%{$s}%");
            });
        }

        // Name / surname filter
        if ($n = trim($request->input('full_name', ''))) {
            $query->where(function ($q) use ($n) {
                $q->where('full_name',        'like', "%{$n}%")
                  ->orWhere('reporter_email', 'like', "%{$n}%");
            });
        }

        // Province dropdown filter
        if ($request->filled('province_id')) {
            $query->where('province_id', $request->input('province_id'));
        }

        // School — dropdown (school_id) takes priority; fallback to text search
        if ($request->filled('school_id')) {
            $query->where('school_id', $request->input('school_id'));
        } elseif ($sn = trim($request->input('school_name', ''))) {
            $query->where(function ($q) use ($sn) {
                $q->where('school_name', 'like', "%{$sn}%")
                  ->orWhereHas('school', fn ($sq) => $sq->where('school_name', 'like', "%{$sn}%"));
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

        // Status dropdown filter (new panel name — works alongside existing 'status' field)
        if (!$request->filled('status') && $request->filled('filter_status')) {
            $query->where('status', $request->input('filter_status'));
        }
        
        // Anonymous filter — use has() not filled() because '0' is falsy
        //if ($request->has('is_anonymous') && $request->input('is_anonymous') !== '') {
            //$query->where('is_anonymous', (int)$request->input('is_anonymous'));
        //}


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
        $provinceOptions = Province::orderBy('province_name')->get();

        // Narrow school list by selected province if provided
        $schoolOptions = School::orderBy('school_name')
            ->when(
                $request->filled('province_id'),
                fn ($q) => $q->where('province_id', $request->input('province_id'))
            )
            ->get();

        $typeOptions = AbuseType::orderBy('type_name')->get();

       $subtypeOptions = Subtype::orderBy('sub_type_name')
            ->get()
            ->sortBy(function ($sub) {
                return str_contains(strtolower($sub->sub_type_name), 'other') ? 1 : 0;
            })
            ->values();

        $gradeOptions = Report::whereNotNull('grade')
            ->where('grade', '!=', '')
            ->distinct()
            ->pluck('grade') // get the grades
            ->collect()      // turn into a collection
            ->sort(function ($a, $b) {
                $order = [
                    'Creche'  => 0,
                    'Grade R'   => 1,
                    'Grade 1'  => 2,
                    'Grade 2'  => 3,
                    'Grade 3'  => 4,
                    'Grade 4'  => 5,
                    'Grade 5'  => 6,
                    'Grade 6'  => 7,
                    'Grade 7'  => 8,
                    'Grade 8'  => 9,
                    'Grade 9'  => 10,
                    'Grade 10' => 11,
                    'Grade 11' => 12,
                    'Grade 12' => 13,
                ];
        
                $aVal = $order[$a] ?? 99;
                $bVal = $order[$b] ?? 99;
        
                return $aVal <=> $bVal;
            })
            ->values()
            ->toArray();

        $schoolName = $request->filled('school_id')
            ? School::find($request->input('school_id'))?->school_name ?? ''
            : $request->input('school_name', '');

        return view('national-admin-reports.index', compact(
            'reports',
            'provinceOptions',
            'schoolOptions',
            'typeOptions',
            'subtypeOptions',
            'gradeOptions',
            'schoolName'
        ));
    }

    public function show($id, Request $request)
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'national') {
            abort(403, 'Unauthorized');
        }

        $report = Report::with(['province', 'district', 'school', 'abuseType', 'subtype', 'user'])
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
}