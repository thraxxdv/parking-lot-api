<?php

namespace App\Utilities;

use Illuminate\Support\Collection;

class Utilities
{
    /**
     * Gets the closest number in an array to the given base number
     * e.g. input: 4, array: [1,2,7,8,9] - return value will be 2
     */
    public function getClosestNumber(int $baseNumber, array | Collection $numbers) : int
    {
        $closest = null;
        foreach ($numbers as $curretNumber) {
            if ($closest === null || $baseNumber - $closest > $curretNumber - $baseNumber) {
                $closest = $curretNumber;
            }
        }
        return $closest;
    }
}
