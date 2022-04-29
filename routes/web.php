<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Animal\AnimalController;
use App\Http\Controllers\Admin\Animal\AnimalMetaController;
use App\Http\Controllers\Admin\Animal\AnimalGalleryController;
use App\Http\Controllers\Admin\Dashboard\AdminDashboardController;

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

Route::prefix('admin')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.home');
    Route::post('/notification/read-all', [AdminDashboardController::class, 'readAllNotification'])->name('admin.notification.readAll');
    Route::post('/comments/read-all', [AdminDashboardController::class, 'readAllComments'])->name('admin.comments.readAll');

    //animals
    Route::prefix('animal')->group(function () {
        Route::get('/', [AnimalController::class, 'index'])->name('admin.animal.index');
        Route::get('show/{animal}', [AnimalController::class, 'show'])->name('admin.animal.show');
        Route::get('/create', [AnimalController::class, 'create'])->name('admin.animal.create');
        Route::post('/store', [AnimalController::class, 'store'])->name('admin.animal.store');
        Route::get('/edit/{animal}', [AnimalController::class, 'edit'])->name('admin.animal.edit');
        Route::put('/update/{animal}', [AnimalController::class, 'update'])->name('admin.animal.update');
        Route::delete('/destroy/{animal}', [AnimalController::class, 'destroy'])->name('admin.animal.destroy');
        Route::get('/status/{animal}', [AnimalController::class, 'status'])->name('admin.animal.status');
        Route::get('/search', [AnimalController::class, 'search'])->name('admin.animal.search');
        //animal/attribute
        Route::prefix('meta')->group(function () {
            Route::post('update/{meta}', [AnimalMetaController::class, 'update'])->name('admin.animal.meta.update');
            Route::delete('destroy/{meta}', [AnimalMetaController::class, 'destroy'])->name('admin.animal.meta.destroy');
            Route::post('{animal}/store', [AnimalMetaController::class, 'store'])->name('admin.animal.meta.store');
        });
        //animal/image
        Route::prefix('gallery')->group(function () {
            Route::get('/{animal}', [AnimalGalleryController::class, 'index'])->name('admin.animal.gallery.index');
            Route::delete('destroy/{image}', [AnimalGalleryController::class, 'destroy'])->name('admin.animal.image.destroy');
            Route::get('status/{image}', [AnimalGalleryController::class, 'status'])->name('admin.animal.image.status');
            Route::post('{animal}/store', [AnimalGalleryController::class, 'store'])->name('admin.animal.image.store');
        });
    });
});
