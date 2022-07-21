<?php

namespace App\Observers;

use App\Events\ParkingSpace\ParkingSpacesUpdated;
use App\Models\Gate;

class GateObserver
{

    public function created(Gate $gate)
    {
        ParkingSpacesUpdated::dispatch();
    }

    public function deleted(Gate $gate)
    {
        ParkingSpacesUpdated::dispatch();
    }
}
