<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Rules\IsNearestSpaceFromGateTaken;
use App\Services\GateService;
use Illuminate\Http\Request;

class GateController extends Controller
{

    private $gateService;

    public function __construct() {
        $this->gateService = new GateService();
    }


    public function createGate(Request $request)
    {
        $validated = $request->validate([ 'nearest_space' => [ 'exists:parking_spaces,id', new IsNearestSpaceFromGateTaken ] ]);

        return response()->json($this->gateService->createGate($validated['nearest_space']), 201);
    }

    public function deleteGate()
    {
        # code...
    }
}
