<?php

use Illuminate\Http\Request;

Route::post('login', 'UserController@login');

// Sem necessidade de estar logado
Route::get('products/search', 'ProductController@search');
Route::get('promotions/search', 'PromotionController@search');

// Todas as rotas devem estar aqui
// Route::group(['middleware' => 'auth:api'], function(){
Route::post('register', 'UserController@register');
Route::resource('products', 'ProductController');
Route::resource('promotions', 'PromotionController');
Route::resource('coupons', 'CouponController');
Route::post('promotions/{id}/like', 'PromotionController@upLike');
Route::post('promotions/{id}/report', 'PromotionController@report');
// });

