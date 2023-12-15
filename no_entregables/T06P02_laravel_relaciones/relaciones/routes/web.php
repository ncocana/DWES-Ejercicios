<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Profile2Controller;
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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile2', [Profile2Controller::class, 'edit'])->name('profile2.index');
    Route::patch('/profile2', [Profile2Controller::class, 'update'])->name('profile2.update');
});
// Route::get('/profile2', function () {
//     return view('profile2.index');
// })->middleware(['auth', 'verified'])->name('profile2');

require __DIR__.'/auth.php';
