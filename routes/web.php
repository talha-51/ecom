<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
// use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\SubCategoryController;




Route::get('/', [HomeController::class, 'index'])->name('home.index');

// for individual page
// Route::get('/category/{name}', [HomeController::class, 'filteredByCategoryProducts'])->name('home.filteredByCategoryProducts');
// Route::get('/sub-category/{name}', [HomeController::class, 'filteredBySubCategoryProducts'])->name('home.filteredBySubCategoryProducts');
// Route::get('/brand/{name}', [HomeController::class, 'filteredByBrandProducts'])->name('home.filteredByBrandProducts');


// for single dynamic page
Route::get('/{type}/{name}', [HomeController::class, 'filteredProducts'])
    ->where('type', 'category|sub-category|brand')
    ->name('home.filteredProducts');





Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/user-list', [AdminController::class, 'userList'])->name('admin.userList');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.addToCart');
    Route::post('/cart/update/{id}', [CartController::class, 'updateCart'])->name('cart.updateCart');
    Route::delete('/cart/delete/{id}', [CartController::class, 'deleteItem'])->name('cart.deleteItem');

    Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/checkout/onepagecheckout/{id}', [CartController::class, 'onepagecheckout'])->name('cart.onepagecheckout');
    Route::post('/confirm-order', [CartController::class, 'confirmOrder'])->name('cart.confirmOrder');

    // Resource Controllers
    Route::resource('slider', SliderController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('sub-category', SubCategoryController::class);
    Route::resource('product', ProductController::class);
    Route::resource('brand', BrandController::class);
    Route::resource('settings', SettingsController::class);

    Route::resource('order', OrderController::class);

    Route::resource('order-item', OrderItemController::class);



    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
