<?php

namespace BlackBits\LaravelSeoRewrite\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeleteSeoRewriteEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var string
     */
    public $source;

    /**
     * Create a new event instance.
     *
     * @param string|null $source
     */
    public function __construct(String $source)
    {
        $this->source = $source;
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
