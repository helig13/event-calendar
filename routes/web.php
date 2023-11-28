<?php

use App\Livewire\Calendar;
use App\Livewire\EventCreate;
use App\Livewire\EventEdit;
use App\Livewire\EventShow;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Display the main calendar page
Route::get('/', Calendar::class)->name('calendar');

// Other routes can be accessed through modal or separate pages as needed
// Example for creating a new event
Route::get('/event/create', EventCreate::class)->name('event.create');

// For viewing and editing, you might use route parameters
Route::get('/event/{event}/edit', EventEdit::class)->name('event.edit');
Route::get('/event/{event}', EventShow::class)->name('event.show');

