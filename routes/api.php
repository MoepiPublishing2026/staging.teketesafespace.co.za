<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\School;

/*
|--------------------------------------------------------------------------
| API Routes....
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/schools', function (Request $request) {
    $query = School::query();

    // Optional search filter
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where('school_name', 'LIKE', $search . '%');
    }

    // Fetch schools ordered by name
    $schools = $query->orderBy('school_name', 'asc')
        ->select(
            'school_id',
            'emis_no',
            'school_name',
            'province',
            'district',
            'towncity',
            'address',
            'telephone',
            'phase_ped'
        )
        ->get();

    // Format for frontend
    return $schools->map(function ($school) {
        return [
            'id' => $school->school_id, // use primary key (school_id)
            'emis_no' => $school->emis_no,
            'name' => $school->school_name,
            'province' => $school->province,
            'district' => $school->district,
            'towncity' => $school->towncity,
            'address' => $school->address,
            'telephone' => $school->telephone,
            'phase_ped' => $school->phase_ped,
        ];
    });
});