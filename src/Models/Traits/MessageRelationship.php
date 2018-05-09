<?php

namespace Kdes70\Chatter\Models\Traits;


trait MessageRelationship
{
    /**
     * @return mixed
     */
    public function conversation()
    {
        return $this->morphTo();
    }


    /**
     * @return mixed
     */
    public function users()// sender
    {
        return $this->userFrom()->union($this->userTo()->toBase());
    }

    /**
     * @return mixed
     */
    public function userFrom()
    {
        return $this->belongsTo(config('chatter.models.user.class'), 'sender_user_id');
    }

    /**
     * @return mixed
     */
    public function userTo()
    {
        return $this->belongsTo(config('chatter.models.user.class'), 'recipient_user_id');
    }

//    public function conversation()
//    {
//        return $this->hasMany(config('chatter.models.conversation'), 'id', 'conversation_id');
//    }
}