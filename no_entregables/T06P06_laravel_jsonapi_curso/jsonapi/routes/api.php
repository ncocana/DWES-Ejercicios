<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Middleware\ValidateJsonApiDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::withoutMiddleware(ValidateJsonApiDocument::class)
    ->post('login', LoginController::class)
    ->name('api.v1.login');

Route::apiResource('articles', ArticleController::class)->names('api.v1.articles');
// Route::middleware('auth:sanctum')->apiResource('articles', ArticleController::class)->names('api.v1.articles');
