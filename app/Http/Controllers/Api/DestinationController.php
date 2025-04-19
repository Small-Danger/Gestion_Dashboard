<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Destination;

class DestinationController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $company_id = $request->input('company_id'); // important pour filtrer par compagnie

        $destinations = Destination::where('company_id', $company_id)
            ->where(function ($q) use ($query) {
                $q->where('city', 'like', "%$query%")
                  ->orWhere('country', 'like', "%$query%");
            })
            ->get();

        return response()->json($destinations);
    }
}

