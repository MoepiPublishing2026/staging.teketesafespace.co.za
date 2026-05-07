<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Province;
use App\Models\District;
use App\Models\AbuseType;

class NationalHeatmapController extends Controller
{
    public function index(Request $request)
    {
        /* ─────────────────────────────────────────
         * FILTER OPTIONS (for future filter bar)
         * ───────────────────────────────────────── */
        $provinces  = Province::orderBy('province_name')
            ->get(['province_id as id', 'province_name as name']);

        $districts  = District::orderBy('district_name')
            ->get(['district_id as id', 'district_name as name', 'province_id']);

        $abuseTypes = AbuseType::orderBy('type_name')->get();

        /* ─────────────────────────────────────────
         * BASE REPORTS QUERY (no filters for now;
         * add filter inputs here when needed)
         * ───────────────────────────────────────── */
        $reports = Report::with(['province', 'district', 'abuseType'])->get();

        /* ─────────────────────────────────────────
         * HEATMAP: District × Abuse Type
         * ───────────────────────────────────────── */
        $heatmapAbuseTypes = $abuseTypes->pluck('type_name')->toArray();

        // Build district → [ abuseType counts ] matrix
        $heatmapMatrix = [];

        // Index districts by id for quick look-up
        $districtById = $districts->keyBy('id');

        foreach ($districts as $district) {
            $row = [];
            foreach ($abuseTypes as $atype) {
                $row[] = $reports
                    ->filter(fn ($r) =>
                        $r->district_id == $district->id &&
                        optional($r->abuseType)->type_name === $atype->type_name
                    )
                    ->count();
            }
            $heatmapMatrix[$district->name] = $row;
        }

        // Sort by row total descending
        uasort($heatmapMatrix, fn ($a, $b) => array_sum($b) <=> array_sum($a));

        // Totals
        $heatmapRowTotals    = [];
        $heatmapColumnTotals = array_fill(0, count($heatmapAbuseTypes), 0);

        foreach ($heatmapMatrix as $dName => $row) {
            $heatmapRowTotals[$dName] = array_sum($row);
            foreach ($row as $i => $count) {
                $heatmapColumnTotals[$i] += $count;
            }
        }

        $heatmapGrandTotal = array_sum($heatmapColumnTotals);
        $heatmapMax        = collect($heatmapMatrix)->flatten()->max() ?: 1;

        // Name → ID maps for click-to-filter navigation
        $heatmapDistrictNameToId  = $districts->pluck('id', 'name')->toArray();
        $heatmapAbuseTypeNameToId = $abuseTypes->pluck('id', 'type_name')->toArray();

        // Row percentages (each cell = % of that district's total)
        $heatmapPercentages = [];
        foreach ($heatmapMatrix as $dName => $row) {
            $rowTotal = $heatmapRowTotals[$dName] ?? 0;
            $heatmapPercentages[$dName] = array_map(
                fn ($c) => $rowTotal > 0 ? round($c / $rowTotal * 100, 1) : 0,
                $row
            );
        }

        /* ─────────────────────────────────────────
         * GEOGRAPHIC MAP: per-district counts
         * Expects districts to have latitude/longitude columns.
         * ───────────────────────────────────────── */
        $provinceNameById = $provinces->pluck('name', 'id')->toArray();

        $mapDistrictCounts = [];
        foreach ($districts as $district) {
            $count = $reports->filter(fn ($r) => $r->district_id == $district->id)->count();
            $mapDistrictCounts[$district->name] = [
                'count'    => $count,
                'province' => $provinceNameById[$district->province_id] ?? '—',
            ];
        }

        // Sort by count descending for the key table
        arsort($mapDistrictCounts);

        $mapDistrictMax = collect($mapDistrictCounts)->max('count') ?: 1;

        /* ─────────────────────────────────────────
         * RETURN VIEW
         * ───────────────────────────────────────── */
        return view('national-admin-dashboard.heatmap', [
            // Heatmap
            'heatmapAbuseTypes'       => $heatmapAbuseTypes,
            'heatmapMatrix'           => $heatmapMatrix,
            'heatmapMax'              => $heatmapMax,
            'heatmapRowTotals'        => $heatmapRowTotals,
            'heatmapColumnTotals'     => $heatmapColumnTotals,
            'heatmapGrandTotal'       => $heatmapGrandTotal,
            'heatmapDistrictNameToId' => $heatmapDistrictNameToId,
            'heatmapAbuseTypeNameToId'=> $heatmapAbuseTypeNameToId,
            'heatmapPercentages'      => $heatmapPercentages,

            // Map
            'mapDistrictCounts'       => $mapDistrictCounts,
            'mapDistrictMax'          => $mapDistrictMax,
        ]);
    }
}