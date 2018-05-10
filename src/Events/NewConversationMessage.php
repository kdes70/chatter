<?php

namespace Kdes70\Chatter\Events;

use Carbon\Carbon;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewConversationMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var
     */
    public $message;
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
     * @param $message
     * @param $channel
     * @param $sender
     */
    public function __construct($message, $channel, $sender)
    {
        $this->message = $message;
        $this->channel = $channel;
        $this->sender = $sender;

        dd($this->channel);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel($this->channel);
    }

    public function broadcastWith()
    {
        return [
            'message'       => $this->message,
            'sender'     => $this->sender,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ];
    }
}