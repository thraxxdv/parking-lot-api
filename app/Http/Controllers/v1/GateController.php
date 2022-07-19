<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gate\CreateGateRequest;
use App\Http\Requests\Gate\DeleteGateRequest;
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


    public function createGate(CreateGateRequest $request)
    {
        $validated = $request->validated();

        return response()->json($this->gateService->createGate($validated['nearest_space']), 201);
    }

    public function deleteGate(DeleteGateRequest $request)
    {
        $validated = $request->validated();

        return response()->json($this->gateService->deleteGate($validated['nearest_space']), 204);
    }
}
