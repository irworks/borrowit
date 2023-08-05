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