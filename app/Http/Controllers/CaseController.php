<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incident;
use Illuminate\Support\Str;

class CaseController extends Controller
{
    // Map abuse type names to prefixes
    protected $abusePrefixes = [
        'Bullying' => 'BU',
        'Suspected Sexual Harassment' => 'SH',
'Substance Abuse' => 'SA',
        'Violence' => 'VL',
        'Teenage Pregnancy' => 'TP',
        'Weapons' => 'WP',
    ];

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'reporter_email' => 'required|email|max:255',
            'phone_number' => 'nullable|string|max:20',
            'image_path' => 'nullable|string',
            'abuse_type' => 'required|string',
        ]);

        // Determine prefix based on abuse type
        $prefix = $this->abusePrefixes[$request->input('abuse_type')] ?? 'XX';

        // ✅ Count only reports for this specific school
        $count = Report::where('school_name', $request->school_name)->count() + 1;
        
        // ✅ Format as 4 digits
        $formattedCount = str_pad($count, 4, '0', STR_PAD_LEFT);
        
        // ✅ Build the final Case Number
        $datePart = now()->format('dm');
        $caseNumber = 'CASE-' . $prefix . $formattedCount . $datePart;

        // Save the case
        $case = Report::create([
            'case_number' => $caseNumber,
            'school_name' => $request->school_name,
            'full_name' => $request->input('full_name'),
            'description' => $request->input('description'),
            'reporter_email' => $request->input('reporter_email'),
            'phone_number' => $request->input('phone_number'),
            'image_path' => $request->input('image_path'),
            'abuse_type' => $request->input('abuse_type'),
        ]);

        return response()->json([
            'message' => 'Case created successfully',
            'case_number' => $caseNumber,
            'case' => $case,
        ]);
    }
}
