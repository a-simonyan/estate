<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendMailSuggestsPrice
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $suggestsPriceProperty;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($suggestsPriceProperty)
    {
        $this->suggestsPriceProperty = $suggestsPriceProperty;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return [];
    }
}
