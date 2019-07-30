<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



//register
Route::post('register', 'UsersApiController@register');

//verifikasi di email
Route::post('email/verify/{id}', 'VerificationApiController@verify');


//login
Route::post('login', 'UsersApiController@login');

//reset pass
//masukin email
Route::post('forgot', 'UsersApiController@forgot');

//reset pass di email
Route::post('pass/reset/{id}', 'PassController@reset');


