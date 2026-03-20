<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth; 

class AdminDashboardController extends Controller
{
    public function fetchData(Request $request)
    {
        $year = $request->query('year');
        $from = $request->query('from');
        $to = $request->query('to');

        $user = Auth::user(); 

        
        $reportsQuery = Report::query();


      
        if ($user && $user->role === 'school') {  
            $reportsQuery->where('school_name', $user->school_name);
        }

       
        if ($year) {
            $reportsQuery->whereYear('created_at', $year);
        }
        if ($from) {
            $reportsQuery->whereDate('created_at', '>=', $from);
        }
        if ($to) {
            $reportsQuery->whereDate('created_at', '<=', $to);
        }

        
        $total = $reportsQuery->count();

      
        $statuses = [
            'awaiting-resolution' => (clone $reportsQuery)->where('status', 'awaiting-resolution')->count(),
            'forwarded' => (clone $reportsQuery)->where('status', 'forwarded')->count(),
            'under-review' => (clone $reportsQuery)->where('status', 'under-review')->count(),
            'closed' => (clone $reportsQuery)->where('status', 'closed')->count(),
            'unresolved' => (clone $reportsQuery)->where('status', 'unresolved')->count(),
            'false-report' => (clone $reportsQuery)->where('status', 'false-report')->count(),
        ];

        
        $monthlyData = (clone $reportsQuery)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupByRaw('MONTH(created_at)')
            ->orderByRaw('MONTH(created_at)')
            ->pluck('count', 'month')
            ->toArray();

        $months = [];
        $monthlyCounts = [];
        for ($m = 1; $m <= 12; $m++) {
            $months[] = Carbon::create()->month($m)->format('F');
            $monthlyCounts[] = $monthlyData[$m] ?? 0;
        }

        
        $ageGroupsQuery = (clone $reportsQuery)
            ->selectRaw('
                CASE 
                    WHEN age < 18 THEN "<18"
                    WHEN age BETWEEN 18 AND 25 THEN "18-25"
                    WHEN age BETWEEN 26 AND 35 THEN "26-35"
                    WHEN age BETWEEN 36 AND 50 THEN "36-50"
                    ELSE "51+"
                END as age_group,
                COUNT(*) as count
            ')
            ->groupBy('age_group')
            ->pluck('count', 'age_group')
            ->toArray();

        $ageGroups = ['<18', '18-25', '26-35', '36-50', '51+'];
        $ageGroupCounts = [];
        foreach ($ageGroups as $group) {
            $ageGroupCounts[] = $ageGroupsQuery[$group] ?? 0;
        }

        return response()->json([
            'total' => $total,
            'statuses' => $statuses,
            'months' => $months,
            'monthlyCounts' => $monthlyCounts,
            'ageGroups' => $ageGroups,
            'ageGroupCounts' => $ageGroupCounts,
        ]);
    }
}