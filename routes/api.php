<?php

use Illuminate\Http\Request;

Route::post('login', 'UserController@login');

Route::get('products/search', 'ProductController@search');

// Todas as rotas devem estar aqui
Route::group(['middleware' => 'auth:api'], function(){
    Route::post('register', 'UserController@register');

    Route::resource('products', 'ProductController');
});