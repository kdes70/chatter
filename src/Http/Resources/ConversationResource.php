<?php

namespace Kdes70\Chatter\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed username
 * @property mixed id
 * @property mixed email
 * @property mixed conversation_id
 * @property mixed messages
 */
class ConversationResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $this->resource->load('messages');
        $user = ($this->userTwo->id == auth()->user()->id) ? $this->userOne : $this->userTwo;

        return [
            'conversation_id'   => $this->id,
            'conversation_link' => route('conversation', $this->id),

            'message' => new MessageResource($this->messages()->first()),
            'user'    => [
                'id'       => $user->id,
                'username' => $user->username,
                'email'    => $user->email,
                'avatar'   => $user->profile->avatar_url,
            ]
        ];
    }

    public function with($request)
    {
        return ['status' => 'success'];
    }
}
