<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Province;
use App\Models\District;
use App\Models\AbuseType;
use Illuminate\Support\Facades\DB;

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

        $abuseTypeIds = $abuseTypes->pluck('id')->all();

        /* ─────────────────────────────────────────
         * HEATMAP: District × Abuse Type
         * ───────────────────────────────────────── */
        $heatmapAbuseTypes = $abuseTypes->pluck('type_name')->toArray();

        $districtTypeCounts = Report::query()
            ->select('district_id', 'abuse_type_id', DB::raw('COUNT(*) as count'))
            ->whereNotNull('district_id')
            ->whereNotNull('abuse_type_id')
            ->groupBy('district_id', 'abuse_type_id')
            ->get();

        $districtTypeLookup = [];
        foreach ($districtTypeCounts as $row) {
            $districtTypeLookup[(int) $row->district_id][(int) $row->abuse_type_id] = (int) $row->count;
        }

        $heatmapMatrix = [];
        foreach ($districts as $district) {
            $row = [];
            foreach ($abuseTypeIds as $abuseTypeId) {
                $row[] = $districtTypeLookup[(int) $district->id][(int) $abuseTypeId] ?? 0;
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
         * HEATMAP: Province × Abuse Type
         * (moved from the Dashboard into the Heat-map page)
         * ───────────────────────────────────────── */
        $provinceHeatmapAbuseTypes = $heatmapAbuseTypes;
        $provinceHeatmapMatrix = [];

        $provinceTypeCounts = Report::query()
            ->select('province_id', 'abuse_type_id', DB::raw('COUNT(*) as count'))
            ->whereNotNull('province_id')
            ->whereNotNull('abuse_type_id')
            ->groupBy('province_id', 'abuse_type_id')
            ->get();

        $provinceTypeLookup = [];
        foreach ($provinceTypeCounts as $row) {
            $provinceTypeLookup[(int) $row->province_id][(int) $row->abuse_type_id] = (int) $row->count;
        }

        foreach ($provinces as $province) {
            $row = [];
            foreach ($abuseTypeIds as $abuseTypeId) {
                $row[] = $provinceTypeLookup[(int) $province->id][(int) $abuseTypeId] ?? 0;
            }
            $provinceHeatmapMatrix[$province->name] = $row;
        }

        uasort($provinceHeatmapMatrix, fn ($a, $b) => array_sum($b) <=> array_sum($a));

        $provinceHeatmapRowTotals = [];
        $provinceHeatmapColumnTotals = array_fill(0, count($provinceHeatmapAbuseTypes), 0);
        foreach ($provinceHeatmapMatrix as $pName => $row) {
            $provinceHeatmapRowTotals[$pName] = array_sum($row);
            foreach ($row as $i => $count) {
                $provinceHeatmapColumnTotals[$i] += $count;
            }
        }

        $provinceHeatmapGrandTotal = array_sum($provinceHeatmapColumnTotals);
        $provinceHeatmapMax = collect($provinceHeatmapMatrix)->flatten()->max() ?: 1;

        $provinceHeatmapProvinceNameToId = $provinces->pluck('id', 'name')->toArray();
        $provinceHeatmapAbuseTypeNameToId = $abuseTypes->pluck('id', 'type_name')->toArray();

        $provinceHeatmapPercentages = [];
        foreach ($provinceHeatmapMatrix as $pName => $row) {
            $rowTotal = $provinceHeatmapRowTotals[$pName] ?? 0;
            $provinceHeatmapPercentages[$pName] = array_map(
                fn ($c) => $rowTotal > 0 ? round($c / $rowTotal * 100, 1) : 0,
                $row
            );
        }

        $provinceHeatmapHotspots = [];
        foreach ($provinceHeatmapMatrix as $pName => $row) {
            $withIndex = array_map(fn ($c, $i) => ['count' => $c, 'idx' => $i], $row, array_keys($row));
            usort($withIndex, fn ($a, $b) => $b['count'] <=> $a['count']);
            $provinceHeatmapHotspots[$pName] = array_column(array_slice($withIndex, 0, 3), 'idx');
        }

        /* ─────────────────────────────────────────
         * GEOGRAPHIC MAP: per-district counts
         * Expects districts to have latitude/longitude columns.
         * ───────────────────────────────────────── */
        $provinceNameById = $provinces->pluck('name', 'id')->toArray();

        $mapDistrictCounts = [];
        $districtTotals = Report::query()
            ->select('district_id', DB::raw('COUNT(*) as count'))
            ->whereNotNull('district_id')
            ->groupBy('district_id')
            ->get()
            ->keyBy('district_id');

        foreach ($districts as $district) {
            $count = (int) ($districtTotals[$district->id]->count ?? 0);
            $mapDistrictCounts[$district->name] = [
                'count' => $count,
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

            // Heatmap (Province × Abuse Type)
            'provinceHeatmapAbuseTypes'        => $provinceHeatmapAbuseTypes,
            'provinceHeatmapMatrix'            => $provinceHeatmapMatrix,
            'provinceHeatmapMax'               => $provinceHeatmapMax,
            'provinceHeatmapRowTotals'         => $provinceHeatmapRowTotals,
            'provinceHeatmapColumnTotals'      => $provinceHeatmapColumnTotals,
            'provinceHeatmapGrandTotal'        => $provinceHeatmapGrandTotal,
            'provinceHeatmapProvinceNameToId'  => $provinceHeatmapProvinceNameToId,
            'provinceHeatmapAbuseTypeNameToId' => $provinceHeatmapAbuseTypeNameToId,
            'provinceHeatmapPercentages'       => $provinceHeatmapPercentages,
            'provinceHeatmapHotspots'          => $provinceHeatmapHotspots,

            // Map
            'mapDistrictCounts'       => $mapDistrictCounts,
            'mapDistrictMax'          => $mapDistrictMax,
        ]);
    }
}
