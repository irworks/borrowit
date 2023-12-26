<?php

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

Route::get('/', function () {
    return redirect(\route('categories.index'));
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('/categories', App\Http\Controllers\CategoryController::class);
Route::resource('/organisations', App\Http\Controllers\Manager\OrganisationController::class);
Route::resource('/users', App\Http\Controllers\Admin\UserController::class);

Route::resource('/itemStacks', App\Http\Controllers\Admin\ItemStackController::class);
Route::resource('/itemStacks/{itemStack}/items', App\Http\Controllers\Admin\ItemStackController::class);

// user routes
Route::get('/profile', [\App\Http\Controllers\User\UserProfileController::class, 'edit']);
Route::post('/profile', [\App\Http\Controllers\User\UserProfileController::class, 'update'])->name('profile.update');

Route::get('/categories/{category}/itemStacks/{itemStack}', [\App\Http\Controllers\ItemStackController::class, 'show'])->name('itemStack.show');

Route::get('/reservation', [\App\Http\Controllers\ReservationController::class, 'edit'])->name('reservation.edit');
Route::get('/reservation/done', [\App\Http\Controllers\ReservationController::class, 'done'])->name('reservation.done');
Route::get('/reservation/itemStacks/availability', [\App\Http\Controllers\ReservationController::class, 'availability'])->name('reservation.availability');

Route::post('/reservation', [\App\Http\Controllers\ReservationController::class, 'submit'])->name('reservation.submit');
Route::patch('/reservation/interval', [\App\Http\Controllers\ReservationController::class, 'update'])->name('reservation.update');
Route::post('/reservation/add', [\App\Http\Controllers\ReservationController::class, 'add'])->name('reservation.add-itemstack');
Route::patch('/reservation/itemStacks/{itemStack}', [\App\Http\Controllers\ReservationController::class, 'updateItem'])->name('reservation.itemStacks');
Route::delete('/reservation/{reservation}', [\App\Http\Controllers\ReservationController::class, 'cancel'])->name('reservation.cancel');

// manager routes
Route::get('/reservations', [\App\Http\Controllers\Manager\ManagerReservationController::class, 'index'])->name('reservations.index');
Route::get('/reservations/{reservation}/collect', [\App\Http\Controllers\Manager\ManagerReservationController::class, 'collect'])->name('reservations.collect');
Route::get('/reservations/{reservation}/collect/details', [\App\Http\Controllers\Manager\ManagerReservationController::class, 'details'])->name('reservations.details');
Route::post('/reservations/{reservation}/collect', [\App\Http\Controllers\Manager\ManagerReservationController::class, 'book'])->name('reservations.book');
Route::patch('/reservations/{reservation}/cancel', [\App\Http\Controllers\Manager\ManagerReservationController::class, 'cancel'])->name('reservations.cancel');

Route::get('/items/{item}', [\App\Http\Controllers\ItemController::class, 'show']);
Route::get('/items/{item}/scan', [\App\Http\Controllers\ItemController::class, 'showReservationByItemId']);

Route::get('/bookings', [\App\Http\Controllers\Manager\ManagerBookingController::class, 'index'])->name('booking.index');
Route::get('/bookings/{booking}/return', [\App\Http\Controllers\Manager\ManagerBookingController::class, 'return'])->name('booking.return');
Route::get('/bookings/{booking}/return/details', [\App\Http\Controllers\Manager\ManagerBookingController::class, 'details'])->name('booking.details');
Route::post('/bookings/{booking}/return', [\App\Http\Controllers\Manager\ManagerBookingController::class, 'complete'])->name('booking.complete');

Route::get('/profile/bookings', [\App\Http\Controllers\User\UserBookingController::class, 'index'])->name('user.booking.index');
