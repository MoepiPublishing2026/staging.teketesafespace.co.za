<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;
use App\Models\Province;
use App\Models\AbuseType;
use App\Models\Subtype;
use App\Models\School;

class ProvincialAdminReportsController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'provincial') {
            abort(403, 'Unauthorized');
        }

        $province_id = $user->province_id;

        if (!$province_id) {
            abort(404, 'User does not have a province assigned. Please contact administrator.');
        }

        $province = Province::find($province_id);

        if (!$province) {
            abort(404, 'Province not found in database. Please contact administrator.');
        }

        // Start query with eager loading, strictly locked down to the admin's province
        $query = Report::with(['province', 'district', 'school', 'abuseType', 'subtype'])
            ->where('province_id', $province_id);

        // ── Global search bar: case number, email, full name, description ──
        if ($s = trim($request->input('search', ''))) {
            $query->where(function ($q) use ($s) {
                $q->where('case_number', 'like', "%{$s}%")
                ->orWhere('reporter_email', 'like', "%{$s}%")
                ->orWhere('full_name', 'like', "%{$s}%")
                ->orWhere('description', 'like', "%{$s}%")

                ->orWhereHas('school', function ($school) use ($s) {
                    $school->where('school_name', 'like', "%{$s}%");
                })

                ->orWhereHas('district', function ($district) use ($s) {
                    $district->where('district_name', 'like', "%{$s}%");
                })

                ->orWhereHas('abuseType', function ($type) use ($s) {
                    $type->where('type_name', 'like', "%{$s}%");
                })

                ->orWhereHas('subtype', function ($subtype) use ($s) {
                    $subtype->where('sub_type_name', 'like', "%{$s}%");
                });
            });
        }

       if ($request->filled('full_name')) {
    $n = trim($request->full_name);

    $query->where(function ($q) use ($n) {
        $q->where('full_name', 'like', "%{$n}%")
          ->orWhere('reporter_email', 'like', "%{$n}%");
    });
}
        // ── Case number search (backward compatibility) ──────────────────
        if ($request->filled('case_number')) {
            $query->where('case_number', 'LIKE', '%' . $request->input('case_number') . '%');
        }

        // ── Simple filterable dropdown fields ────────────────────────────
        $filterableFields = [
            'status'     => 'status',
            'district'   => 'district_id',
            'abuse_type' => 'abuse_type_id',
        ];

        foreach ($filterableFields as $input => $column) {
            if ($request->filled($input)) {
                $query->where($column, $request->input($input));
            }
        }

        // ── Age range filter ─────────────────────────────────────────────
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

        // ── Grade filter ─────────────────────────────────────────────────
        if ($request->filled('grade')) {
            $query->where('grade', $request->input('grade'));
        }

        // ── School filter ────────────────────────────────────────────────
        if ($request->filled('school_id')) {
            $query->where('school_id', $request->input('school_id'));
        } elseif ($sc = trim($request->input('school_name', ''))) {
            $query->whereHas('school', fn ($sq) =>
                $sq->where('school_name', 'like', "%{$sc}%")
            );
        }

        // ── Report type filter ───────────────────────────────────────────
        if ($request->filled('type_id')) {
            $query->where('abuse_type_id', $request->input('type_id'));
        }

        // ── Subtype filter ───────────────────────────────────────────────
        if ($request->filled('subtype_id')) {
            $query->where('subtype_id', $request->input('subtype_id'));
        }

        // ── Status filter ────────────────────────────────────────────────
        if ($request->filled('status')) {
            if (in_array($request->input('status'), Report::canonicalDashboardStatuses(), true)) {
                $query->whereCanonicalDashboardStatus($request->input('status'));
            } else {
                $query->where('status', $request->input('status'));
            }
        }

        // ── Anonymous filter ─────────────────────────────────────────────
        if ($request->has('is_anonymous') && $request->input('is_anonymous') !== '') {
            $query->where('is_anonymous', (int) $request->input('is_anonymous'));
        }

        // ── Date range filter ────────────────────────────────────────────
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

        // ── Paginate ─────────────────────────────────────────────────────
        $reports = $query->latest()->paginate(20)->withQueryString();

        // ── Dropdown options ─────────────────────────────────────────────
        $typeOptions = AbuseType::orderBy('type_name')->get();
        $subtypeOptions = Subtype::orderBy('abuse_type_id')->orderBy('sub_type_name')->get();

        $gradeOptions = Report::where('province_id', $province_id)
            ->whereNotNull('grade')
            ->where('grade', '!=', '')
            ->distinct()
            ->pluck('grade')
            ->sort(function ($a, $b) {
                $order = [
                    'Creche'   => 0, 'Grade R'  => 1, 'Grade 1'  => 2,
                    'Grade 2'  => 3, 'Grade 3'  => 4, 'Grade 4'  => 5,
                    'Grade 5'  => 6, 'Grade 6'  => 7, 'Grade 7'  => 8,
                    'Grade 8'  => 9, 'Grade 9'  => 10, 'Grade 10' => 11,
                    'Grade 11' => 12, 'Grade 12' => 13,
                ];
                $posA = $order[$a] ?? 99;
                $posB = $order[$b] ?? 99;
                return $posA <=> $posB;
            })
            ->values()
            ->toArray();

        $schoolName = request('school_id')
            ? School::find(request('school_id'))?->school_name ?? ''
            : request('school_name', '');

        $schoolOptions = School::orderBy('school_name')->get();

        return view('provincial-admin-reports.index', compact(
            'reports', 'province', 'typeOptions', 'subtypeOptions', 
            'gradeOptions', 'schoolOptions', 'schoolName'
        ));
    }

    public function show($id, Request $request)
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'provincial') {
            abort(403, 'Unauthorized');
        }

        $province_id = $user->province_id;

        $report = Report::with(['province', 'district', 'school', 'abuseType', 'subtype', 'user'])
                        ->where('province_id', $province_id)
                        ->findOrFail($id);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'case_number'          => $report->case_number,
                'full_name'            => $report->full_name ?? 'Anonymous',
                'province'             => $report->province->province_name ?? 'N/A',
                'district'             => $report->district->district_name ?? 'N/A',
                'school'               => $report->school->school_name ?? 'N/A',
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