<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChirpController;
use App\Http\Controllers\InfoController;

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
Route::view('/test', 'welcome2')->name('welcome2');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/welcome2/{name?}', function ($name='') {
    return view('welcome2', ['name'=>$name]);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('chirps', ChirpController::class)
    ->only(['index', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

// Route::resource('/borrar1', \App\Http\Controllers\BorrarController::class);
// Route::apiResource('/borrar1', \App\Http\Controllers\BorrarController::class);
require __DIR__.'/auth.php';

Route::view('/adminlte', 'adminlte.index')->name('layout');

// Route::get('/phpinfo', function () {
//     return phpinfo();
// })->middleware('auth', 'verified');

// Route::get('/phpinfo', function () {
//     return view('phpinfo');
// });

// Route::get('phpinfo', [InfoController::class, 'infoServer']);

Route::view('phpinfo', 'phpinfo')->middleware('auth');
