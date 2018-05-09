<?php

namespace Kdes70\Chatter\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Kdes70\Chatter\Models\Contracts\MessageInterface;
use Kdes70\Chatter\Models\Traits\MessageRelationship;


class Message extends Model
{
    use MessageRelationship;

    protected $table = 'messages';

    protected $fillable = ['sender_user_id', 'recipient_user_id', 'conversation_id','message'];

    // protected $appends = ['conversation_id'];

    // TODO возможно избыточно!
  //  protected $with = ['conversation'];

//    public function conversation()
//    {
//        return $this->hasMany(config('chatter.models.conversation'), 'id', 'conversation_id');
//    }


    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }



//    public function getConversationAttribute()
//    {
//        return $this->conversation()->id;
//    }

}
