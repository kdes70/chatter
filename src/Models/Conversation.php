<?php

namespace Kdes70\Chatter\Models;

use Illuminate\Database\Eloquent\Model;
use Kdes70\Chatter\Models\Traits\ConversationRelationship;

class Conversation extends Model
{
    use ConversationRelationship;

    protected $table;

    protected $fillable = ['user_one', 'user_two'];

    public $timestamps = false;

    protected $appends = ['channel_name'];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('chatter.models.conversation.table');
    }

    public function getChannelNameAttribute()
    {
        return  $this->attributes['channel_name'] = config('chatter.channel.chat_room') . '-' . $this->id;
    }

//    public function users()
//    {
//        return $this
//            // ->select(['*', 'conversation.id as conversation_id'])
//            ->whereHas('conversationFrom', function ($q) {
//                return $q->where('user_one', '=', $this->id);
//            })
//            ->orWhereHas('conversationTo', function ($q) {
//                return $q->where('user_two', '=', $this->id);
//            });
//    }


    /**
     * @param $sender_id
     * @param $receiver_id
     * @return int
     */
    public function newConversation($sender_id, $receiver_id): int
    {
        return $this->insertGetId([
            'user_one' => $sender_id,
            'user_two' => $receiver_id,
        ]);
    }


//    public function conversationSenderAndReceiverId($sender_id, $receiver_id)
//    {
//        return $this->where(function ($query) use ($sender_id, $receiver_id) {
//            $query->where(function ($q) use ($sender_id, $receiver_id) {
//                $q->where('user_one', $sender_id)
//                    ->where('user_two', $receiver_id);
//            })->orWhere(function ($q) use ($sender_id, $receiver_id) {
//                $q->where('user_two', $sender_id)
//                    ->where('user_one', $receiver_id);
//            });
//        });
//    }

//    /**
//     * @param $id
//     * @return void
//     */
//    public function conversations($id)
//    {
//       return $this
//           ->where('user_one', '=', $id)
//           ->orWhere('user_two', '=', $id);
//    }

}
