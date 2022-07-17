<?php

namespace App\Utilities;

use DateTime;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class DateUtilities
{
    /**
     * Gets the closest number in an array to the given base number
     * e.g. input: 4, array: [1,2,7,8,9] - return value will be 2
     */
    public function getTimeDifference(string $time1, string $time2) : float
    {
        $oldTime =  new DateTime($time1);
        $newTime =  new DateTime($time2);
        return abs($oldTime->getTimestamp() - $newTime->getTimestamp()) / 60;
    }
}
