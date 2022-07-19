<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Rules\Gate\IsNearestSpaceFromGateTaken;
use App\Rules\Gate\ValidateGateCount;
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

    public function deleteGate(Request $request)
    {
        $validated = $request->validate([ 'nearest_space' => [ 'exists:gates,nearest_space', new ValidateGateCount ] ]);

        return response()->json($this->gateService->deleteGate($validated['nearest_space']), 204);
    }
}
