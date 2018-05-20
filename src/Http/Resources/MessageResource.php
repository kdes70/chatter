<?php

namespace Kdes70\Chatter\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


/**
 * @property mixed id
 * @property mixed sender_user_id
 * @property mixed recipient_user_id
 * @property mixed status
 * @property mixed message
 * @property mixed created_at
 */
class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'message'           => $this->message,
            'created_at'        => $this->created_at,
            'sender_user_id'    => $this->sender_user_id,
            'recipient_user_id' => $this->recipient_user_id,
            'status'            => $this->status,
        ];
    }
}


