<?php
use App\Http\Controllers\ContactsController;
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
    Route::get('/contacts', [ContactsController::class, 'list'])->name('contacts');

    Route::name('file.')->prefix('/file')->group(function () {
        Route::name('import')->prefix('import')->group(function () {
            Route::get('/', fn () => view('file-import-form'));
            Route::post('/', [FileImportsController::class, 'import']);
            Route::put('/', );
        });

        Route::get('/list', [FileImportsController::class, 'files'])->name('list');

        Route::name('from-to')->prefix('/from-to/{hash}')->group(function ($hash) {
            Route::get('/', [FileImportsController::class, 'fromTo', $hash]);
            Route::put('/', [FileImportsController::class, 'storeFromTo', $hash]);
        });
    });
});
require __DIR__ . '/auth.php';
