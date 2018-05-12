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

        // TODO почему не ловит юзера?
        if (\Auth::check()) {
            $this->user_id = $user = \Auth::user()->id;
        }
    }
    
    /**
     * @param $user_id
     * @return \Illuminate\Support\Collection
     */
    public function getAllConversations($user_id)
    {
        return $this->conversation->getAllConversations($user_id);
    }

    /**
     * @param $user_id
     * @param $conversation_id
     *
     * @return Collection|null
     */
    public function getConversationMessageById($user_id, $conversation_id): ?Collection
    {
        if ($this->conversation->checkUserExist($user_id, $conversation_id)) {
            $channel = $this->getChannelName($conversation_id, 'chat_room');

            return $this->conversation->getConversationMessageById($conversation_id, $channel);
        }
        abort(404);
    }

    /**
     * @param $user_id
     * @param $conversation_id
     * @param $message
     * @param $receiver_id
     */
    public function sendConversationMessage($user_id, $conversation_id, $message, $receiver_id)
    {
        $this->conversation->sendConversationMessage($conversation_id, [
            'message'    => $message,
            'user_id' => $user_id,
            'receiver_id' => $receiver_id,
            'channel' => $this->getChannelName($conversation_id, 'chat_room'),
        ]);
    }

    /**
     * @param $auth_user_id
     * @param $user_id
     */
    public function startConversationWith($auth_user_id, $user_id)
    {
        $this->conversation->startConversationWith($auth_user_id, $user_id);
    }

    /**
     * @param $conversation_id
     */
    public function acceptMessageRequest($user_id, $conversation_id)
    {
        $this->conversation->acceptMessageRequest($user_id, $conversation_id);
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