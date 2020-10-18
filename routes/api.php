<?php

use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function ($router)
{
    $router->get('/chat','\Blink\Http\Controllers\ChatController@index')->middleware(config('blink.routes.middleware.chat.list',[]));
    
    $router->post('/chat', '\Blink\Http\Controllers\ChatController@store')->middleware(config('blink.routes.middleware.chat.create', []));
    
    $router->get('/chat/{chatId}/message', '\Blink\Http\Controllers\MessageController@index')->middleware(config('blink.routes.middleware.message.list', []));
    
    $router->post('/chat/{chatId}/message','\Blink\Http\Controllers\MessageController@store')->middleware(config('blink.routes.middleware.message.create', []));
    
    $router->get('/chat/{chatId}/message/{messageId}/info','\Blink\Http\Controllers\MessageInfoController@index')->middleware(config('blink.routes.middleware.message.info.list', []));
    
    $router->get('/chat/{chatId}/{media}','\Blink\Http\Controllers\ChatController@getMedia')->middleware(config('blink.routes.middleware.message.list', []));
});
