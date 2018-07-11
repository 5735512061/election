<?php

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

Route::get('/admin/score', function () {
    return view('admin/admin_score');
});


Auth::routes();
// Route::get('/changePassword','HomeController@showChangePasswordForm');
// Route::post('/changePassword','HomeController@changePassword')->name('changePassword');


// master
Route::group(['middleware' => ['auth']], function () {
  Route::get('/master/home', 'HomeController@index')->name('home');
  // Route::get('/master/home', 'HomeController@show');
  Route::get('master/profile','MasterController@profile');
  Route::post('master/profile', 'MasterController@update_avatar');
  Route::get('master/register', 'MasterController@index');
  Route::post('master/add', 'MasterController@add_header');
  Route::get('/master/edit/{id}', 'MasterController@edit_header');
  Route::post('/master/update','MasterController@update_header');
  Route::get('/master/block/{id}', 'MasterController@block_header');
  Route::get('/master/show/{id}','MasterController@master_showadmin');
  Route::get('/master/showarea/{id}', 'MasterController@master_showarea');
  Route::post('master/home','MasterController@search');
  Route::get('master/changePassword','MasterController@showChangePasswordForm');
  Route::post('master/changePassword','MasterController@changePassword')->name('changePassword');
  Route::get('master/total','MasterController@score_total');
  Route::post('master/block/{id}','MasterController@block');
  Route::post('master/searchadmin','MasterController@search_admin');
});
//admin
Route::group(['prefix' => 'admin'], function(){
  Route::get('/login', 'AuthAdmin\LoginController@ShowLoginForm')->name('admin.login');
  Route::post('/login', 'AuthAdmin\LoginController@login')->name('admin.login.submit');
  Route::get('/', 'AdminController@index')->name('admin.home');
  Route::post('/','AdminController@search');
  Route::get('/profile','AdminController@profile');
  Route::post('/profile', 'AdminController@update_avatar');
  Route::get('/addscore', 'AdminController@index')->name('admin.home');
  Route::post('/addscore','AdminController@addscore');
  Route::post('/action','AdminController@action');
  Route::post('/scoresubmit','AdminController@scoresubmit');
  Route::get('/showscore','AdminController@showscore');
  Route::get('/changePassword','AdminController@showChangePasswordForm');
  Route::post('/changePassword','AdminController@changePassword')->name('changePassword');


});
//header
Route::group(['prefix' => 'header'], function(){
  Route::get('/login', 'AuthHeader\LoginController@ShowLoginForm')->name('header.login');
  Route::post('/login', 'AuthHeader\LoginController@login')->name('header.login.submit');
  Route::get('/', 'HeaderController@index')->name('header.home');
  Route::get('register', 'HeaderController@register');
  Route::post('add','HeaderController@add_admin');
  Route::get('/edit/{id}', 'HeaderController@edit_admin');
  Route::post('update','HeaderController@update_admin');
  Route::get('/block/{id}', 'HeaderController@block_admin');
  Route::get('/add', 'HeaderController@area_admin');
  Route::get('/addarea','HeaderController@addarea');
  Route::get('/show/{admin_id}','HeaderController@showarea');
  Route::get('delete/{id}', 'HeaderController@deletearea');
  Route::get('editarea/{id}','HeaderController@editarea');
  Route::post('editarea/{id}','HeaderController@updatearea');
  Route::get('/selectarea','HeaderController@selectarea');
  Route::get('/profile','HeaderController@profile');
  Route::post('/profile', 'HeaderController@update_avatar');
  Route::post('/','HeaderController@search');
  Route::get('/changePassword','HeaderController@showChangePasswordForm');
  Route::post('/changePassword','HeaderController@changePassword')->name('changePassword');
  Route::get('/total','HeaderController@score_total');
});
