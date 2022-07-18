<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Rules\IsNearestSpaceFromGateTaken;
use Illuminate\Http\Request;

class GateController extends Controller
{
    public function createGate(Request $request)
    {
        $validated = $request->validate([ 'nearest_space' => [ 'exists:parking_spaces,id', new IsNearestSpaceFromGateTaken ] ]);
    }

    public function deleteGate()
    {
        # code...
    }
}
