<?php

use App\Http\Controllers\FileImportsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware(['auth'])->group(function () {
    $dash = fn() => view('dashboard');
    Route::get('/', $dash);
    Route::get('/dashboard', $dash)->name('dashboard');

    Route::name('file.')->prefix('/file')->group(function () {
        Route::post('/import', [FileImportsController::class, 'import'])
            ->name('import');
        Route::get('/from-to/{hash}', [FileImportsController::class, 'fromTo'])
            ->name('from-to');
    });
});
require __DIR__ . '/auth.php';
