<?php

namespace Kdes70\Chatter\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed username
 * @property mixed id
 * @property mixed email
 * @property mixed conversation_id
 */
class Conversations extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $messages = $this->messages->first();
        $user = ($this->userTwo->id == auth()->user()->id) ? $this->userTwo : $this->userTwo;

        return [
            'conversation_id'      => $this->id,
            'message' => [
                'id'                => $messages->id,
                'message'           => $messages->message,
                'sender_user_id'    => $messages->sender_user_id,
                'recipient_user_id' => $messages->recipient_user_id,
                'status'            => $messages->status,
                'created_at'        => $messages->created_at,
            ],
            'user'    => [
                'id'              => $user->id,
                'username'        => $user->username,
                'email'           => $user->email,
                'avatar'          => $user->profile->avatar_url,
            ]
        ];
    }
}
