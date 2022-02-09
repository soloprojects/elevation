<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// -------------Admin MODULE-----------
Route::any('/user', [App\Http\Controllers\UsersController::class, 'index'])->name('user')->middleware('auth.superAdmin');
Route::post('/create_user', [App\Http\Controllers\UsersController::class, 'create'])->name('create_user');
Route::post('/edit_user_form', [App\Http\Controllers\UsersController::class, 'editForm'])->name('edit_user_form');
Route::post('/edit_user', [App\Http\Controllers\UsersController::class, 'edit'])->name('edit_user');
Route::post('/delete_user', [App\Http\Controllers\UsersController::class, 'destroy'])->name('delete_user');

// -------------members MODULE-----------
Route::any('/members', [App\Http\Controllers\MembersController::class, 'index'])->name('members')->middleware('auth.admin');
Route::any('/members_detail', [App\Http\Controllers\MembersController::class, 'membersDetail'])->name('members_detail');
Route::any('/create_members', [App\Http\Controllers\MembersController::class, 'create'])->name('members_user')->middleware('auth.admin');
Route::post('/edit_members_form', [App\Http\Controllers\MembersController::class, 'editForm'])->name('edit_members_form');
Route::post('/edit_members', [App\Http\Controllers\MembersController::class, 'edit'])->name('edit_members');
Route::post('/delete_members', [App\Http\Controllers\MembersController::class, 'destroy'])->name('delete_members')->middleware('auth.admin');

// -------------EVENTS MODULE-----------
Route::any('/events', [App\Http\Controllers\EventsController::class, 'index'])->name('events')->middleware('auth');
Route::any('/my_events_calendar', 'EventsController@myCalendar')->name('my_events_calendar')->middleware('auth');
Route::any('/general_events_calendar', 'EventsController@generalCalendar')->name('general_events_calendar')->middleware('auth');
Route::post('/create_events', [App\Http\Controllers\EventsController::class, 'create'])->name('create_events');
Route::post('/edit_events_form', [App\Http\Controllers\EventsController::class, 'editForm'])->name('edit_events_form');
Route::post('/edit_events', [App\Http\Controllers\EventsController::class, 'edit'])->name('edit_events');
Route::post('/delete_events', [App\Http\Controllers\EventsController::class, 'destroy'])->name('delete_events');
Route::any('/attend_events_form', [App\Http\Controllers\EventsController::class, 'attendEventsForm'])->name('attend_events_form')->middleware('auth');
Route::post('/attend_events', [App\Http\Controllers\EventsController::class, 'attendEvents'])->name('attend_events');
Route::any('/all_attendees/{id}', [App\Http\Controllers\EventsController::class, 'allAttendees'])->name('all_attendees');

