<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified','role:admin'])->group(function () {
        Route::get('/admin/users',[TestController::class,'admin'])->name('admin');
    });

Route::middleware(['auth', 'verified','role:superadmin'])->group(function () {
        Route::get('/admin/users',[TestController::class,'admin'])->name('admin');
        Route::get('/superadmin/system',[TestController::class,'superadmin'])->name('superadmin');

        //Products
        Route::get('/products', [TestController::class, 'index'])->name('products.index');
        Route::get('/products/create', [TestController::class, 'create'])->name('products.create');
        Route::post('/products/store', [TestController::class, 'store'])->name('products.store');
        Route::get('/products/edit/{id}', [TestController::class, 'edit'])->name('products.edit');
        Route::put('/products/update/{id}', [TestController::class, 'update'])->name('products.update');
        Route::delete('/products/delete/{id}', [TestController::class, 'delete'])->name('products.delete');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
