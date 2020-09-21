<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
/**
 * 登录注册
 */

Route::get('/login',"LoginController@login");
Route::get('/register',"LoginController@register");
//登录界面验证码
Route::any('/validate','Service\ValidateCodeController@create');
//手机验证码
Route::get('/sendSMS','Service\ValidateCodeController@sendSMS');
//注册
Route::any('/toregister','LoginController@toregister');
//登录
Route::any('/tologin','LoginController@tologin');
Route::group([
    "prefix"=>"/",
    "middleware"=>["verify_login"],
],function(){
    Route::get('a',function (){
       echo '11111111';
    });
});

//Route::get('/');

