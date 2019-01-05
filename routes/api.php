<?php

use Illuminate\Http\Request;

Route::post('login', 'UserController@login');

// Todas as rotas devem estar aqui
Route::group(['middleware' => 'auth:api'], function(){
    Route::post('register', 'UserController@register');

    Route::resource('coupons', 'CouponController');
});