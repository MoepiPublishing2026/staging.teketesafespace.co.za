<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // ✅ Proper alias for PDF
use App\Models\Report;
use App\Models\Province;
use Illuminate\Support\Facades\Auth;

class ProvincialReportController extends Controller
{
    public function exportPDF()
    {
        $user = Auth::user();

        //  Only provincial admins allowed
        if (!$user || $user->role !== 'provincial') {
            abort(403, 'Unauthorized');
        }

        //  Get province name via the relationship
        $province = Province::find($user->province_id);
        $provinceName = $province ? $province->province_name : 'Unknown Province';

        // Fetch reports for this province
        $reports = Report::with(['school', 'abuseType'])
            ->where('province_id', $user->province_id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Generate PDF using your view
        $pdf = Pdf::loadView('livewire.provincial_report_pdf', [
            'reports' => $reports,
            'provinceName' => $provinceName
        ])->setPaper('a4', 'landscape');

        // Download the file
        return $pdf->download('Provincial_Report_' . $provinceName . '.pdf');
    }
}
