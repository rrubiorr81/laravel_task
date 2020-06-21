<?php
use Illuminate\Support\Facades\Route;

Route::post('/register', 'Api\AuthController@register');
Route::post('/login', 'Api\AuthController@login');

Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResource('/notification', 'Api\NotificationController');
    Route::get('/me', 'Api\AuthController@getInfo');
    Route::get('/getBusinessInfo/{location}/{term}', 'Api\BusinessController@getInfoBasedOnLocation');
});
