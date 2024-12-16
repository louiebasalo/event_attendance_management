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
Route::get('/','HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@home')->name('home');
Route::get('/homehome','HomeController@homehome')->name('homehome');
Route::get('/sheet','HomeController@getSheet')->name('sheet');

Route::get('/attendance','HomeController@attendance')->name('attendance');
Route::get('/select_event','HomeController@select_event')->name('select_event');
Route::get('/events','HomeController@getEvents')->name('getevents.action');
Route::get('/lilo','HomeController@setSession')->name('setSession.action');
Route::get('/records','HomeController@allAttendance')->name('allAttendance');
Route::get('/transmit/{id}','HomeController@transmit')->name('transmit');
Route::get('/totrans','AttendanceController@getall')->name('getAll');
Route::get('/transmitna','TransmitController@totransmit')->name('transmitna');

Route::get('/insert','AttendanceController@insertAttendance')->name('insertAttendance.action');

Route::get('/collect','HomeController@collect')->name('collect');


Route::get('/setup','SetUpController@setUp')->name('setup');
Route::get('endsession','HomeController@endSession')->name('endsession');