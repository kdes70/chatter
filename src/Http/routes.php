<?php


# messages


use Kdes70\Chatter\Events\NewConversationMessage;
use Kdes70\Chatter\Http\Resources\MessageResource as MessageResource;

Route::group([
   'namespace'=>'Kdes70\Chatter\Http\Controllers',
    'prefix' => 'messages',
    'middleware' => ['web', 'auth'],
    ], function (){

//    Route::get('/', function (){
//        return view('chatter::chat');
//    })->name('messages');

    Route::get('/{conversation_id}', 'ChatterController@getMessages')->name('get-messages');
    Route::get('/conversations', 'ChatterController@conversations')->name('messages');
    Route::get('/conversations/list', 'ChatterController@getConversationList');
    Route::get('/conversation/recipient/{recipient_id}', 'ChatterController@newConversation')->name('new_conversation');
    Route::get('/conversation/{conversation_id}', 'ChatterController@conversationId')->name('conversation');

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

});