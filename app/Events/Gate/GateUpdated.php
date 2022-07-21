<?php

namespace App\Events\Gate;

use App\Services\GateService;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GateUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function broadcastOn()
    {
        return new Channel('gate-updated');
    }

    public function broadcastAs()
    {
        return 'gate-updated';
    }

    public function broadcastWith()
    {
        $gateService = new GateService();
        return [
            'gates' => $gateService->getGates()
        ];
    }
}
