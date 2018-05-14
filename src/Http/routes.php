<?php


# messages


use Kdes70\Chatter\Events\NewConversationMessage;
use Kdes70\Chatter\Http\Resources\Message as MessageResource;

Route::group([
   'namespace'=>'Kdes70\Chatter\Http\Controllers',
    'prefix' => 'messages',
    'middleware' => ['web', 'auth'],
    ], function (){

    Route::get('/', function (){
        return view('chatter::chat');
    })->name('messages');

    Route::get('/conversations', 'ChatterController@conversations')->name('conversation');
    Route::get('/chat/{conversation_id}', 'ChatterController@chat')->name('chat');
    Route::post('/chat/send', function (){

        $user_id = auth()->check() ? auth()->user()->id : null;

        $result = Chatter::sendConversationMessage(
            $user_id,
            request('conversation_id'),
            request('message'),
            request('receiver_id')
        );

        broadcast(new NewConversationMessage($result['created'], $result['channel'], $user_id));

       // return new MessageResource($result['created']);

    })->name('send');
   // Route::get('/chat/conversation/{recipient_id}', 'ChatterController@new_conversation')->name('new_conversation');

});