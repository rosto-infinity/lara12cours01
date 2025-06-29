<?php

use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ProductController;


// Route::get('/test-pdf', function() {
//     $product = Product::first();
//     return view('SuperAdmin.Products.PdfProduct', compact('product'));
// });


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
       Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
        Route::get('/download-all', [ProductController::class, 'downloadAll']) ->name('downloadAll');
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/excel', [ProductController::class, 'excel'])->name('excel');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('{product}/pdf', [ProductController::class, 'download'])->name('download');
        Route::get('/{product}', [ProductController::class, 'show'])->name('show');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::patch('/{product}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
     });

});

// Route::get('/products/download-all', [ProductController::class, 'downloadAll'])
//     ->name('products.downloadAll')
//     ->middleware(['auth', 'verified', 'role:superadmin']);

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
