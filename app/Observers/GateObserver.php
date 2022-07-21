<?php

namespace App\Observers;

use App\Events\Gate\GateUpdated;
use App\Events\ParkingSpace\ParkingSpacesUpdated;
use App\Models\Gate;

class GateObserver
{

    public function created()
    {
        ParkingSpacesUpdated::dispatch();
        GateUpdated::dispatch();
    }

    public function deleted()
    {
        ParkingSpacesUpdated::dispatch();
        GateUpdated::dispatch();
    }
}
