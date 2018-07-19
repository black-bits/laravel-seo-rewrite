<?php
namespace BlackBits\LaravelSeoRewrite\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use phpDocumentor\Reflection\Types\Integer;

class CreateSeoRewriteEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var string
     */
    public $source;

    /**
     * @var string
     */
    public $destination;

    /**
     * @var int|Integer
     */
    public $type;


    /**
     * Create a new event instance.
     *
     * @param String $source
     * @param String $destination
     * @param Integer $type
     */
    public function __construct(string $source, string $destination, int $type = null)
    {

        $this->source = $source;
        $this->destination = $destination;
        $this->type = $type ?? 301;
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
