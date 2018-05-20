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

    Route::get('/', 'ChatterController@conversations')->name('messages');
    Route::get('/{conversation_id}', 'ChatterController@getMessages')->name('get-messages');

    Route::get('/conversation/{conversation_id}', 'ChatterController@conversationId')->name('conversation');
\
    Route::get('/conversations/list', 'ChatterController@getConversationList');

    Route::get('/conversation/recipient/{recipient_id}', 'ChatterController@newConversation')->name('new_conversation');


//    Route::post('/chat/send', 'ChatterController@send')->name('send');
    Route::post('/chat/send', function (\Illuminate\Http\Request $request){

        $this->user = auth()->check() ? auth()->user() : null;

        $result = \Chatter::sendConversationMessage(
            $this->user->id,
            $request->input('conversation_id'),
            $request->input('message'),
            $request->input('receiver_id')
        );

        if ($result) {


            Debugbar::addMessage('Broadcasting event.', 'ajax');

            broadcast(new NewConversationMessage($result['created'], $result['channel'], $this->user->id));

            return new MessageResource($result['created']);
        }
    })->name('send');

});