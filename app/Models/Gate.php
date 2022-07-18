<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gate extends Model
{
    use HasFactory;

    public function parkingSpace()
    {
        return $this->belongsTo(ParkingSpace::class);
    }
}
