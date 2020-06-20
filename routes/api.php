<?php
use Illuminate\Support\Facades\Route;

Route::post('/register', 'Api\AuthController@register');
Route::post('/login', 'Api\AuthController@login');

Route::apiResource('/notification', 'Api\NotificationController')->middleware('auth:api');
Route::get('/me', 'Api\AuthController@getInfo')->middleware('auth:api');
