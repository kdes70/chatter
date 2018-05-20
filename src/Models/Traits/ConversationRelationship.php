<?php

namespace Kdes70\Chatter\Models\Traits;

use Kdes70\Chatter\Models\Conversation;
use Kdes70\Chatter\Models\Message;

trait ConversationRelationship
{
    /**
     * @return mixed
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'conversation_id');
    }


//    /**
//     * @return \Illuminate\Database\Eloquent\Relations\HasMany
//     */
//    public function conversationOne()
//    {
//        return $this->hasMany(Conversation::class, 'user_one');
//    }
//
//    /**
//     * @return \Illuminate\Database\Eloquent\Relations\HasMany
//     */
//    public function conversationTwo()
//    {
//        return $this->hasMany(Conversation::class, 'user_two');
//    }

    /**
     * @return mixed
     */
    public function userOne()
    {
        return $this->belongsTo(config('chatter.models.user.class'), 'user_one');
    }

    /**
     * @return mixed
     */
    public function userTwo()
    {
        return $this->belongsTo(config('chatter.models.user.class'), 'user_two');
    }


//    /**
//     * Если пользователь есть в разговоре
//     *
//     * @param $id
//     * @return \Illuminate\Database\Eloquent\Builder|static
//     */
//    public function isConversation($id)
//    {
//        return $this->whereHas('conversations', function ($query) use ($id) {
//            $query->where('id', $id);
//        });
//    }

    /**
     * @return \Illuminate\Database\Query\Builder|static
     */
//    public function users()
//    {
//        return $this->userOne()->union($this->userTwo()->toBase());
//    }
}