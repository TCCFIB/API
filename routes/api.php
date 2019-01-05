<?php

use Illuminate\Http\Request;

Route::post('login', 'UserController@login');

// Sem necessidade de estar logado
Route::get('promotions/search', 'PromotionController@search');

// Todas as rotas devem estar aqui
Route::group(['middleware' => 'auth:api'], function(){
    Route::post('register', 'UserController@register');

    Route::resource('promotions', 'PromotionController');
    Route::post('promotions/{id}/like', 'PromotionController@upLike');
});