<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subtype; // Import your Subtype model

class AbuseTypeController extends Controller
{
    /**
     * Get unique subtypes based on an abuse type ID.
     *
     * @param int $id The ID of the abuse type.
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSubtypes($id)
    {
        // Use the distinct() method on the query to ensure only unique
        // subtype names are returned. We select the id and sub_type_name
        // to make sure we're getting only the necessary columns.
        $subtypes = Subtype::where('abuse_type_id', $id)
                           ->select('id', 'sub_type_name')
                           ->distinct()
                           ->get();

        return response()->json($subtypes);
    }
}
