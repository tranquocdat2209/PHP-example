<?php

use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\ProductSubCategoryController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\TempImageController;
use \App\Http\Controllers\HomeController as MainController;
use App\Http\Controllers\ProductDetail;
use App\Http\Controllers\ProductListController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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
//FrontEnd

Route::get('/', [MainController::class, 'index'])->name('home');

//category
Route::get('/product-list', [ProductListController::class, 'index'])->name('product-list');
Route::get('/product-list/{category}', [ProductListController::class, 'index'])->name('product-list.filter');
Route::get('/product/{slug}',[ProductDetail::class, 'product'])->name('product-detail');

//Admin
Route::group(['prefix' => 'admin'], function () {
    Route::group(['middleware' => 'admin.guest'], function () {
        Route::get('/login', [AdminLoginController::class, 'index'])->name('admin.login');
        Route::post('/login', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');
    });

    Route::group(['middleware' => 'admin.auth'], function () {
        Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
        Route::get('/logout', [HomeController::class, 'logout'])->name('admin.logout');
        Route::get('/change-password', [HomeController::class, 'changePassword'])->name('admin.change-password');
        Route::post('/update-password', [HomeController::class, 'updatePassword'])->name('admin.update-password');
        Route::get('/my-account', [HomeController::class, 'myAccount'])->name('admin.my-account');

        // Categoris
        Route::get('/category', [CategoryController::class, 'index'])->name('categoris.list');
        Route::get('/category/create', [CategoryController::class, 'create'])->name('categoris.create');
        Route::post('/category', [CategoryController::class, 'store'])->name('categoris.store');
        Route::post('/category/delete/{id}', [CategoryController::class, 'delete'])->name('categoris.delete');
        Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('categoris.edit');
        Route::put('/category/edit/{id}', [CategoryController::class, 'update'])->name('categoris.update');

        //sub category
        Route::get('/sub-category', [SubCategoryController::class, 'index'])->name('sub-categoris.list');
        Route::get('/sub-category/create', [SubCategoryController::class, 'create'])->name('sub-categoris.create');
        Route::post('/sub-category', [SubCategoryController::class, 'store'])->name('sub-categoris.store');
        Route::get('/sub-category/edit/{id}', [SubCategoryController::class, 'edit'])->name('sub-categoris.edit');
        Route::put('/sub-category/edit/{id}', [SubCategoryController::class, 'update'])->name('sub-categoris.update');
        Route::post('/sub-category/delete/{id}', [SubCategoryController::class, 'destroy'])->name('sub-categoris.delete');
        // update image
        Route::post('/upload-image', [TempImageController::class, 'create'])->name('temp-images.create');
        // Get slug
        Route::get('/getSlug', function (Request $request) {
            $slug = '';
            if (!empty($request->title)) {
                $slug = Str::slug($request->title);
            }
            return response()->json([
                'status' => true,
                'slug' => $slug,
            ]);
        })->name('getSlug');

        //Product
        Route::get('/product', [ProductController::class, 'index'])->name('product.list');
        Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/product', [ProductController::class, 'store'])->name('product.store');
        Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
        Route::put('/product/edit/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::post('/product/delete/{id}', [ProductController::class, 'destroy'])->name('product.delete');

        Route::get('/product-subcategories', [ProductSubCategoryController::class, 'index'])->name('product.subcategories');

        //Product update image
        Route::post('/product-images/update', [ProductImageController::class, 'update'])->name('product-images.update');
        Route::delete('/product-images/', [ProductImageController::class, 'destroy'])->name('product-images.destroy');

        //Attribute
        //color
        Route::get('/colors', [ColorController::class, 'index'])->name('colors.list');
        Route::get('/colors/create', [ColorController::class, 'create'])->name('colors.create');
        Route::post('/colors', [ColorController::class, 'store'])->name('colors.store');
        Route::get('/colors/edit/{id}', [ColorController::class, 'edit'])->name('colors.edit');
        Route::put('/colors/edit/{id}', [ColorController::class, 'update'])->name('colors.update');
        Route::post('/colors/delete/{id}', [ColorController::class, 'destroy'])->name('colors.delete');
        //size

        Route::get('/size', [SizeController::class, 'index'])->name('size.list');
        Route::get('/size/create', [SizeController::class, 'create'])->name('size.create');
        Route::post('/size', [SizeController::class, 'store'])->name('size.store');
        Route::get('/size/edit/{id}', [SizeController::class, 'edit'])->name('size.edit');
        Route::put('/size/edit/{id}', [SizeController::class, 'update'])->name('size.update');
        Route::post('/size/delete/{id}', [SizeController::class, 'destroy'])->name('size.delete');
    });
});
