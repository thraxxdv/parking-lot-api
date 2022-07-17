<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ParkingSpaceController extends Controller
{
    //
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_type_id' => ['required', 'exists:vehicle_type'],
        ]);
    }
}
