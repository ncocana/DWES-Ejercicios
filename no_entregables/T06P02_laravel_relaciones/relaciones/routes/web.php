<?php

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Profile2Controller;
use App\Http\Controllers\Profile3Controller;
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

// Route::get('/adminlte/form', function () {
//     return view('form.index');
// })->middleware(['auth', 'verified'])->name('form');

Route::middleware('auth')->group(function () {
    Route::get('/adminlte/form', [Profile3Controller::class, 'edit'])->name('form.index');
    Route::patch('/adminlte/form', [Profile3Controller::class, 'update'])->name('form.update');
});

Route::get('/adminlte', function () {
    return view('adminlte.index');
});

// CHANGES IT ONLY ON THE ROUTE CREATED
// use Illuminate\Support\Facades\App;
// Route::get('/greeting/{locale}', function ($locale) {
//     if (! in_array($locale, ['en', 'es'])) {
//         abort(400);
//     }
//     App::setLocale($locale);
//     echo env('APP_LOCALE');
//     return view('dashboard');
// });

Route::post('/language-switch', [LanguageController::class, 'languageSwitch'])->name('language.switch');
