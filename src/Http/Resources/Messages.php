<?php

namespace Kdes70\Chatter\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


/**
 * @property mixed id
 * @property mixed conversation_id
 * @property mixed sender_user_id
 * @property mixed recipient_user_id
 * @property mixed status
 * @property mixed message
 * @property mixed created_at
 */
class Messages extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $user = ($this['user_one']['id'] == auth()->user()->id) ? $this['user_two'] : $this['user_one'];

        $messages = collect($this['messages'])->map(function ($item) {
            return collect($item)->only('id', 'message', 'created_at', 'sender_user_id', 'recipient_user_id', 'status');
        });

        return [

            'conversation_id' => $this['id'],
            'channel_name'    => $this['channel_name'],
            'user'            => [
                'id'       => $user['id'],
                'username' => $user['username'],
                'email'    => $user['email'],
                'avatar'   => $user['profile']['avatar_url'],
            ],
            'messages'        => $messages

        ];
    }
}


