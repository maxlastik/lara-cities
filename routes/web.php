<?php

use App\Http\Controllers\MainController;
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

Route::get('/reset', [MainController::class, 'reset']);
Route::get('/load-cities', [MainController::class, 'loadCities']);

Route::prefix('{city?}')->group(function() {
    Route::get('/', [MainController::class, 'index']);
    Route::get('about', [MainController::class, 'about']);
    Route::get('news', [MainController::class, 'news']);
});







