<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingSpace extends Model
{
    use HasFactory;

    protected $table = "parking_spaces";
    public $timestamps = false;

    public function gate()
    {
        return $this->hasOne(Gate::class, 'nearest_space');
    }
}
