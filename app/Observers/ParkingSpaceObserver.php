<?php

namespace App\Observers;

use App\Events\ParkingSpace\ParkingSpacesUpdated;
use App\Models\ParkingSpace;

class ParkingSpaceObserver
{

    public function created()
    {
        ParkingSpacesUpdated::dispatch();
    }

    public function updated()
    {
        ParkingSpacesUpdated::dispatch();
    }
}
