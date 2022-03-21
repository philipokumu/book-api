<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('guest')->group(function () {
    Route::get('books', [App\Http\Controllers\BookController::class, 'index'])->name('books.list');
    Route::get('books/{book}', [App\Http\Controllers\BookController::class, 'show'])->name('books.show');
    Route::get('books/{book}/comments', [App\Http\Controllers\CommentController::class, 'index'])->name('comments.list');
    Route::post('books/{book}/comments', [App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
    Route::delete('books/{book}/comments/{comment}', [App\Http\Controllers\CommentController::class, 'destroy'])->name('comments.destroy');
});
