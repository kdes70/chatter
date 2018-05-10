<?php

namespace Kdes70\Chatter\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ConversationsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

//    public function with($request)
//    {
//        return [];
//    }


}
