<?php


return [
    /*
    |--------------------------------------------------------------------------
    | Models
    |--------------------------------------------------------------------------
    */
    'models'  => [
        'user'         => [
            'class' => \App\Domain\User\User::class,
            'table' => 'users', // Existing user table name
        ],
        'message'      => [
            'class' => \Kdes70\Chatter\Models\Message::class,
            'table' => 'messages',
        ],
        'conversation' => [
            'class' => \Kdes70\Chatter\Models\Conversation::class,
            'table' => 'messages_conversation',
        ]
    ],
    'relation' => [
        'conversations'       => \Kdes70\Chatter\Models\Conversation::class,
    ],
    'channel' => [
        'new_conversation_created' => 'new-conversation-created',
        'chat_room'                => 'chat-room',
    ],
];