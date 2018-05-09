<?php


# message

Route::group([
   'namespace'=>'Kdes70\Chatter\Http\Controllers',
    'prefix' => 'messages',
    'middleware' => ['web', 'auth'],
    ], function (){

    Route::get('/', 'ChatterController@index')->name('messages');
    Route::get('/chat/{conversation_id}', 'ChatterController@chat')->name('chat');

});