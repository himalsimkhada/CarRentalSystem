<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CarReserved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $company;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user, $company, $id)
    {
        $this->user = $user;

        $this->company = $company;

        return $id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
