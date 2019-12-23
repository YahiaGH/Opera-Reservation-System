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

//use App\Http\Controllers\customerController;

use App\Events\ReservedTickets;

Route::get('/', function () {
    return view('pages.opera');
});

Route::get('/dum', function () {
    return view('pages.listen');
});

Route::get('/pusher', function () {
    event(new ReservedTickets('how are you ?'));
});

Route::get('/Admin/showAll', 'AdminController@showAll')->name('Admin.showAll');;
Route::put('/Admin/manage/{Admin}', 'AdminController@manage')->name('Admin.manage');;

//Route::get('/','PagesController@index');
Route::get('logout', 'auth\LoginController@logout');
Route::get('event/{event}/destroy', 'EventController@destroy');
Route::get('event/showVacantSeats', 'EventController@showVacantSeats');
Route::get('event/getAvailableHalls', 'EventController@getAvailableHalls')->name('event.getAvailableHalls');
Route::resource('event', 'EventController');
Route::resource('hall', 'HullController');
Route::resource('ticket', 'TicketController');
Route::resource('user', 'UserController');
Route::resource('Admin', 'AdminController');


Auth::routes(); //** TODO: BLock not needed extra auth Routes */

Route::get('/home', 'HomeController@index')->name('home');
