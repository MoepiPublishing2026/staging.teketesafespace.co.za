<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;
use App\Models\School;
use App\Models\District;
use App\Models\Province;
use App\Models\AbuseType;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProvincialDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'provincial') {
            abort(403, 'Unauthorized');
        }

        $province_id = $user->province_id;
        $province = Province::find($province_id);

        $districts = District::where('province_id', $province_id)
            ->orderBy('district_name')
            ->pluck('district_name', 'district_id')
            ->toArray();

        $schools = School::where('province_id', $province_id)
            ->orderBy('school_name')
            ->pluck('school_name', 'school_id')
            ->toArray();

        return view('admin.dashboard', [
            'province' => $province->province_name ?? 'Unknown',
            'districts' => $districts,
            'schools' => $schools,
        ]);
    }

    /**
     * AJAX endpoint: fetch dashboard data (used by fetch in JS)
     */
    public function fetchData(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'provincial') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $province_id = $user->province_id;

        $query = Report::with(['abuseType', 'subtype'])
            ->where('province_id', $province_id);

        if ($request->district) {
            $query->where('district_id', $request->district);
        }

        if ($request->school) {
            $query->where('school_id', $request->school);
        }

        if ($request->from) {
            $query->whereDate('created_at', '>=', $request->from);
        }

        if ($request->to) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $reports = $query->get();
        $totalReports = $reports->count();

        // Status counts
        $statuses = ['awaiting-resolution', 'forwarded', 'under-review', 'unresolved', 'closed', 'false-report'];
        $statusCounts = [];
        foreach ($statuses as $status) {
            $statusCounts[$status] = $reports->where('status', $status)->count();
        }

        // Monthly report data
        $monthlyGroups = $reports->groupBy(fn($r) => Carbon::parse($r->created_at)->format('F'));
        $months = [
            'January','February','March','April','May','June',
            'July','August','September','October','November','December'
        ];
        $monthlyCounts = [];
        foreach ($months as $m) {
            $monthlyCounts[$m] = isset($monthlyGroups[$m]) ? $monthlyGroups[$m]->count() : 0;
        }

        // Age groups
        $ranges = [
            '10-15'=>0,'15-20'=>0,'20-25'=>0,'25-30'=>0,'30-35'=>0,
            '35-40'=>0,'40-45'=>0,'45-50'=>0,'50-55'=>0,'55-60'=>0,'60+'=>0
        ];

        foreach ($reports as $r) {
            if (!$r->age) continue;
            $age = (int)$r->age;

            foreach ($ranges as $range => &$count) {
                if ($range === '60+' && $age >= 60) { $count++; break; }
                if (strpos($range, '-') !== false) {
                    [$min, $max] = explode('-', $range);
                    if ($age >= (int)$min && $age < (int)$max) { $count++; break; }
                }
            }
        }

        // Abuse types and subtypes
        $abuseData = [];
        foreach ($reports as $r) {
            $type = $r->abuseType->type_name ?? 'Unknown';
            $sub = $r->subtype->sub_type_name ?? 'No Subtype';
            $abuseData[$type][$sub] = ($abuseData[$type][$sub] ?? 0) + 1;
        }

        // Anonymous counts
        $anonymousCounts = [
            'anonymous' => $reports->where('is_anonymous', 1)->count(),
            'non_anonymous' => $reports->where('is_anonymous', 0)->count(),
        ];

         $latestReport = optional($reports->sortByDesc('created_at')->first())->case_number ?? 'N/A';

    $topSchools = Report::select('school_id', DB::raw('count(*) as total'))
    ->where('province_id', $province_id)
    ->groupBy('school_id')
    ->orderByDesc('total')
    ->take(1)
    ->get()
    ->map(fn($r) => optional($r->school)->school_name ?? 'Unknown');

        return response()->json([
            'total' => $totalReports,
            'statuses' => $statusCounts,
            'monthly' => $monthlyCounts,
            'ageGroups' => $ranges,
            'abuseTypes' => $abuseData,
            'anonymous' => $anonymousCounts,
            'latestReport'=>$latestReport,
             'topSchools' => $topSchools,
        ]);
    }
}
