<?php

namespace App\Events\ParkingSpace;

use App\Services\ParkingSpaceService;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ParkingSpacesUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
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

    public function broadcastAs()
    {
        return 'parking-spaces-updated';
    }

    public function broadcastWith()
    {
        $parkingSpaceService = new ParkingSpaceService();
        return [
            'parking_spaces' => $parkingSpaceService->getParkingSpaces()
        ];
    }
}
