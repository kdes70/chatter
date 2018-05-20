<?php

namespace Kdes70\Chatter\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


/**
 * @property mixed channel_name
 * @property mixed id
 * @property mixed user
 * @property mixed messages
 */
class MessageListsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $this->user = ($this->userOne->id == auth()->user()->id) ? $this->userTwo : $this->userOne;

        return [
            'conversation_id' => $this->id,
            'channel_name'    => $this->channel_name,
            'user'            => [
                'id'       => $this->user->id,
                'username' => $this->user->username,
                'email'    => $this->user->email,
                'avatar'   => $this->user->profile->avatar_url,
            ],
            'messages'        => (!$this->messages->isEmpty()) ?  MessageResource::collection($this->messages) : null,
        ];
    }
}


