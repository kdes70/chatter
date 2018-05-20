<?php

namespace Kdes70\Chatter\Repositories\Conversation;

use Illuminate\Support\Collection;
use Kdes70\Chatter\Events\NewConversationMessage;
use Kdes70\Chatter\Models\Conversation;
use Kdes70\Chatter\Repositories\BaseRepository;


class ConversationRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Conversation::class;

    /**
     * ConversationRepository constructor.
     *
     */
    public function __construct()
    {

    }

    public function getConversationsIs()
    {
        $conversations = $this->query()->with(['conversations'])->get();
        dd($conversations);
    }


    /**
     * @param int $user_id
     * @return Collection
     */
    public function getAllConversations($user_id): Collection
    {
        $conversations = $this->query()->with([
            'messages' => function ($query) {
                return $query->latest();
            },
            'userOne',
            'userTwo'
        ])->where('user_one', $user_id)->orWhere('user_two', $user_id)->get();

        return $conversations;
    }


    /**
     * Проверим есть ли уже разгоаор
     *
     * @param $user_id
     * @param $recipient_id
     * @return Collection|null
     */
    public function checkUserRecipient($user_id, $recipient_id): ?Conversation
    {
        $conversations = $this->query()->with([
            'userOne',
            'userTwo'
        ])->where(['user_one' => $user_id, 'user_two' => $recipient_id])
            ->orWhere(['user_two' => $user_id, 'user_one' => $recipient_id])->first();

        if ($conversations) {
            return $conversations;
        }
        return null;
    }


    /**
     * TODO
     * Список всех разговоров
     *
     * @param $user_id
     * @return \Illuminate\Support\Collection
     */
    public function getConversations(int $user_id): Collection
    {
        $one = $this->query(['users.*', 'convOne.id as conversations_id'])
            ->whereHas('conversationOne', function ($query) use ($user_id) {
                $query->where('user_two', $user_id);
            })->join(config('chatter.models.conversation.table') . ' AS convOne', 'convOne.user_one', '=',
                'users.id');

        $two = $this->query(['users.*', 'convTwo.id as conversations_id'])
            ->whereHas('conversationTwo', function ($query) use ($user_id) {
                $query->where('user_one', $user_id);
            })->join(config('chatter.models.conversation.table') . ' AS convTwo', 'convTwo.user_two', '=',
                'users.id');

        return $one->union($two->toBase());
    }


    /**
     * @param $conversation_id
     * @return Conversation|null
     */
    public function getConversationMessageById($conversation_id)
    {
        $conversation = $this->query()
            ->with(['messages', 'messages.users', 'userOne', 'userTwo'])
            ->find($conversation_id);

        return $conversation;
    }

    /**
     * @param $conversation_id
     * @param array $data
     *
     * @return bool
     */
    public function sendConversationMessage($conversation_id, array $data)
    {
        return $this->sendMessage($conversation_id, $data);
    }


    /**
     *  Starts a new conversation.
     *
     * @param $userOne
     * @param $userTwo
     * @return Conversation
     */
    public function startConversationWith($userOne, $userTwo): Conversation
    {
        return $this->query()->create([
            'user_one' => $userOne,
            'user_two' => $userTwo,
        ]);
    }

    /**
     * @param $user_id
     * @param $conversation_id
     * @return bool
     */
    public function acceptMessageRequest($user_id, $conversation_id)
    {
        if ($this->checkUserExist($user_id, $conversation_id)) {
            $conversation = $this->find($conversation_id);
            $conversation->status = true;
            $conversation->save();
            return true;
        }
        return false;
    }


    /**
     * @param $user_id
     * @param $conversation_id
     * @return bool
     */
    public function checkUserExist($user_id, $conversation_id): bool
    {
        $thread = $this->find($conversation_id);
        if ($thread) {
            if (($thread->user_one == $user_id) || ($thread->user_two == $user_id)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $conversation_id
     * @param array $data
     *
     * @return bool
     */
    private function sendMessage($conversation_id, array $data)
    {
        $conversation = $this->find($conversation_id);

        return $conversation->messages()
            ->create([
                'message'           => $data['message'],
                'recipient_user_id' => $data['receiver_id'],
                'sender_user_id'    => $data['user_id'],
                'status'            => 1,
                'conversation_type' => 'conversation'
            ]);
    }

    /**
     * @param $user
     * @param $conversation
     *
     * @return bool
     */
    public function canJoinConversation($user, $conversation)
    {
        $thread = $this->find($conversation);
        if ($thread) {
            if (($thread->user_one == $user->id) || ($thread->user_two == $user->id)) {
                return true;
            }
        }
        return false;
    }


}