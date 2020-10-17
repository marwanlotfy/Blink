<?php

use Illuminate\Support\Facades\Route;

Route::get('/chat','\Blink\Http\Controllers\ChatController@index')->middleware(config('blink.routes.middleware.chat.list',[]));

Route::post('/chat', '\Blink\Http\Controllers\ChatController@store')->middleware(config('blink.routes.middleware.chat.create', []));

Route::get('/chat/{chatId}/message', '\Blink\Http\Controllers\MessageController@index')->middleware(config('blink.routes.middleware.message.list', []));

Route::post('/chat/{chatId}/message','\Blink\Http\Controllers\MessageController@store')->middleware(config('blink.routes.middleware.message.create', []));

Route::get('/chat/{chatId}/message/{messageId}/info','\Blink\Http\Controllers\MessageInfoController@index')->middleware(config('blink.routes.middleware.message.info.list', []));

Route::get('/chat/{chatId}/image/{image}','\Blink\Http\Controllers\ChatController@getImage')->middleware(config('blink.routes.middleware.message.list', []));