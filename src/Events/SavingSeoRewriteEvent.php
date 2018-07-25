<?php

namespace BlackBits\LaravelSeoRewrite\Events;

use BlackBits\LaravelSeoRewrite\Models\SeoRewrite;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SavingSeoRewriteEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var SeoRewrite
     */
    public $seoRewrite;

    /**
     * Create a new event instance.
     *
     * @param SeoRewrite $seoRewrite
     */
    public function __construct(SeoRewrite $seoRewrite)
    {
        $this->seoRewrite = $seoRewrite;
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
