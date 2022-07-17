<?php

namespace App\Actions\ParkingSpaceActions;

use App\Utilities\DateUtilities;

class ComputeParkingFee
{
    public function handle(string $parkedOn, string $leftOn, int $vehicleType)
    {
        $dateUtilities = new DateUtilities();
        $hours = ceil($dateUtilities->getTimeDifference($parkedOn, $leftOn));
    }

    private function calculateFee(int $totalHours, int $vehicleType)
    {

    }
}
