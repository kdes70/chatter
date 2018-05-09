<?php

namespace Kdes70\Chatter\Services;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Collection;
use Kdes70\Chatter\Repositories\Conversation\ConversationRepository;

class ChatterService
{
    protected $config;
    protected $conversation;
    protected $user_id;

    /**
     * Chat constructor.
     *
     * @param Repository                  $config
     * @param ConversationRepository      $conversation
     */
    public function __construct(
        Repository $config,
        ConversationRepository $conversation
    ) {
        $this->config = $config;
        $this->conversation = $conversation;

        dd(\Auth::guard());

       $this->user_id = auth()->check() ? auth()->user()->id : null;

    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getAllConversations()
    {

        return $this->conversation->getAllConversations($this->user_id);
    }

    /**
     * @param $conversationId
     *
     * @return Collection|null
     */
    public function getConversationMessageById($conversationId): ?Collection
    {
        if ($this->conversation->checkUserExist($this->userId, $conversationId)) {
            $channel = $this->getChannelName($conversationId, 'chat_room');
            return $this->conversation->getConversationMessageById($conversationId, $this->userId, $channel);
        }
        abort(404);
    }

    /**
     * @param $conversation_id
     * @param $type
     *
     * @return string
     */
    private function getChannelName($conversation_id, $type): string
    {
        return $this->config->get('chatter.channel.'.$type).'-'.$conversation_id;
    }
}