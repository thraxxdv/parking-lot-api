<?php

namespace App\Services;

use App\Models\Gate;

class GateService
{
    public function createGate(int $nearestSpace)
    {
        $gate = new Gate();
        $gate->nearest_space = $nearestSpace;
        $gate->save();

        return $gate;
    }

    public function deleteGate(int $nearestSpace)
    {
        $gate = Gate::where('nearest_space', $nearestSpace)->firstOrfail();
        $gate->delete();
    }
}
