<?php


# message

Route::group([
   'namespace'=>'Kdes70\Chatter\Http\Controllers',
    'prefix' => 'messages',
    'middleware' => ['web', 'auth'],
    ], function (){

    Route::get('/', 'ChatterController@index')->name('messages');
    Route::get('/conversations', 'ChatterController@conversations')->name('conversation');
    Route::get('/chat/{conversation_id}', 'ChatterController@chat')->name('chat');
    Route::post('/chat/send', 'ChatterController@send')->name('send');
   // Route::get('/chat/conversation/{recipient_id}', 'ChatterController@new_conversation')->name('new_conversation');

});