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
Route::resource('/itemStacks/{itemStack}/items', App\Http\Controllers\Admin\ItemController::class);
Route::get('/itemStacks/{itemStack}/items/{item}/qr', [App\Http\Controllers\Admin\ItemStackController::class, 'generateQrCode'])->name('items.qr');

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

Route::get('/items/{item}', [\App\Http\Controllers\Admin\ItemController::class, 'show']);
Route::get('/items/{item}/scan', [\App\Http\Controllers\Admin\ItemController::class, 'showReservationByItemId'])->name('items.scan');

Route::get('/bookings', [\App\Http\Controllers\Manager\ManagerBookingController::class, 'index'])->name('booking.index');
Route::get('/bookings/{booking}/return', [\App\Http\Controllers\Manager\ManagerBookingController::class, 'return'])->name('booking.return');
Route::get('/bookings/{booking}/return/details', [\App\Http\Controllers\Manager\ManagerBookingController::class, 'details'])->name('booking.details');
Route::post('/bookings/{booking}/return', [\App\Http\Controllers\Manager\ManagerBookingController::class, 'complete'])->name('booking.complete');

Route::get('/profile/bookings', [\App\Http\Controllers\User\UserBookingController::class, 'index'])->name('user.booking.index');

Route::get('/settings', [\App\Http\Controllers\Admin\AdminSettingsController::class, 'index'])->name('admin.settings');
Route::post('/settings', [\App\Http\Controllers\Admin\AdminSettingsController::class, 'store'])->name('admin.settings');
Route::patch('/settings/domains/{domain}', [\App\Http\Controllers\Admin\AdminSettingsController::class, 'updateDomain'])->name('admin.settings.domain');
Route::delete('/settings/domains/{domain}', [\App\Http\Controllers\Admin\AdminSettingsController::class, 'deleteDomain'])->name('admin.settings.domain');
Route::post('/settings/domains', [\App\Http\Controllers\Admin\AdminSettingsController::class, 'storeDomain'])->name('admin.settings.domain.store');
