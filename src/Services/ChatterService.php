<?php

namespace Kdes70\Chatter\Services;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Collection;
use Kdes70\Chatter\Events\NewConversationMessage;
use Kdes70\Chatter\Models\Message;
use Kdes70\Chatter\Repositories\Conversation\ConversationRepository;

class ChatterService
{
    protected $config;
    protected $conversation;
    protected $user_id;

    /**
     * Chat constructor.
     *
     * @param Repository $config
     * @param ConversationRepository $conversation
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
     * @return \Kdes70\Chatter\Models\Conversation|null
     */
    public function getConversationMessageById($user_id, $conversation_id)
    {
        if ($this->conversation->checkUserExist($user_id, $conversation_id)) {
            return $this->conversation->getConversationMessageById($conversation_id);
        }
        abort(404);
    }


    /**
     * @param $user_id
     * @param $recipient_id
     * @return Collection|\Kdes70\Chatter\Models\Conversation|null
     */
    public function startOrGetConversationByRecipient($user_id, $recipient_id)
    {
        $conversation = $this->conversation->checkUserRecipient($user_id, $recipient_id);

        if (!$conversation) {
            $conversation = $this->conversation->startConversationWith($user_id, $recipient_id);
        }

        return $conversation;
    }


    /**
     * @param $user_id
     * @param $conversation_id
     * @param $message
     * @param $receiver_id
     * @return void
     */
    public function sendConversationMessage($user_id, $conversation_id, $message, $receiver_id)
    {
        $channel = $this->getChannelName($conversation_id, 'chat_room');

        $created = $this->conversation->sendConversationMessage($conversation_id, [
            'message'     => $message,
            'user_id'     => $user_id,
            'receiver_id' => $receiver_id,
            'channel'     => $channel,
        ]);

        if ($created) {

            return compact(['created', 'channel']);
        }
    }

//    /**
//     * Начало нового диалога
//     *
//     * @param $auth_user_id
//     * @param $user_id
//     * @return void
//     */
//    public function startConversationWith($auth_user_id, $user_id)
//    {
//        $this->conversation->startConversationWith($auth_user_id, $user_id);
//    }

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
        return $this->config->get('chatter.channel.' . $type) . '-' . $conversation_id;
    }
}