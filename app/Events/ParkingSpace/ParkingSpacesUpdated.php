<?php

namespace App\Events\ParkingSpace;

use App\Services\ParkingSpaceService;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ParkingSpacesUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $parkingSpaces;
    public function __construct()
    {
        $parkingSpaceService = new ParkingSpaceService();
        $this->parkingSpaces = $parkingSpaceService->getParkingSpaces();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('parking-spaces');
    }
}
