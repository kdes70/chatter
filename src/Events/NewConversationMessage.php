<?php

namespace PhpJunior\LaravelVideoChat\Events;

use Carbon\Carbon;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewConversationMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var
     */
    public $text;
    /**
     * @var
     */
    public $channel;
    /**
     * @var
     */
    private $sender;

    /**
     * Create a new event instance.
     *
     * @param $text
     * @param $channel
     * @param $sender
     */
    public function __construct($text, $channel, $sender)
    {
        $this->text = $text;
        $this->channel = $channel;
        $this->sender = $sender;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel($this->channel);
    }

    public function broadcastWith()
    {
        return [
            'text'       => $this->text,
            'sender'     => $this->sender,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ];
    }
}