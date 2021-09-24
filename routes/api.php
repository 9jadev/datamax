<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('/external-books', [BookController::class, 'externalbook'])->name('external');
// $url = route('external', ['name' => 'ak']);

Route::get('/external-books', [BookController::class, 'externalbook']);

Route::group(['prefix' => 'v1'], function () {
    Route::post('/books', [BookController::class, 'createbook']);
    Route::get('/books', [BookController::class, 'getbooks']);
    Route::get('/books/{id}', [BookController::class, 'singlebook']);
    Route::patch('/books/{id}', [BookController::class, 'editbook']);
    Route::delete('/books/{id}', [BookController::class, 'deletebook']);
    // Route:post('/create', [CustomerController::class, 'register']);
});