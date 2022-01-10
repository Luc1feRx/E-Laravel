<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandProducts;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryProducts;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
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
// frontend
Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('home')->group(function () {
    //category
    Route::get('/categories-product/{category_id}/{slug_category}', [CategoryProducts::class, 'ShowCategoryHome'])->name('category_home');
    //brand
    Route::get('/brands-product/{brand_id}/{slug_brand}', [BrandProducts::class, 'ShowBrandHome'])->name('brand_home');
    //product detail
    Route::get('/product-detail/{product_id}/{slug_product_detail}', [ProductController::class, 'ShowProductDetail'])->name('ProductDetail');
    //cart
    Route::post('/save-cart', [CartController::class, 'Save_Cart'])->name('save-cart');
    Route::get('/show-cart', [CartController::class, 'show_cart'])->name('show-cart');
    Route::get('/delete-cart{IdDelete}', [CartController::class, 'delete_cart'])->name('delete-cart');
    Route::post('/update-cart', [CartController::class, 'Update_Cart'])->name('update-cart-qty');

    //Checkout
    Route::get('/login-checkout', [CheckoutController::class, 'Login_Checkout'])->name('login-checkout');
    Route::post('/add-customer', [CheckoutController::class, 'add_customer'])->name('add-customer');
    Route::get('/checkout', [CheckoutController::class, 'Checkout'])->name('checkout');

    Route::post('/save-checkout-customer', [CheckoutController::class, 'saveCheckoutCustomer'])->name('save-checkout-customer');
    Route::get('/logout-checkout', [CheckoutController::class, 'logoutCheckout'])->name('logout-checkout');

    Route::post('/login-customer', [CheckoutController::class, 'LoginCustomer'])->name('login-customer');
    Route::post('/order-place', [CheckoutController::class, 'OrderPlace'])->name('order-place');
    Route::get('/payment', [CheckoutController::class, 'payment'])->name('payment');
    //seach
    Route::get('/search', [HomeController::class, 'Search'])->name('search-product');
});








//backend
//login dashboard
Route::get('/admin', [AdminController::class, 'index'])->name('admin-login');

Route::prefix('admin')->group(function () {
    Route::get('/dashboard.html', [AdminController::class, 'ShowDashboard'])->name('dashboard');

    //login
    Route::post('/admin-dashboard', [AdminController::class, 'dashboard'])->name('admin-dashboard');
    Route::get('/log-out', [AdminController::class, 'logout'])->name('logout');

    //category product
    Route::get('/add-category', [CategoryProducts::class, 'AddCategory'])->name('addCategory-Products');
    Route::get('/list-categories', [CategoryProducts::class, 'ListCategory'])->name('listCategories-Products');
    Route::get('/delete-category/{category_id}', [CategoryProducts::class, 'deleteCategory'])->name('deleteCategory-Products');
    Route::get('/edit-category/{category_id}', [CategoryProducts::class, 'editCategory'])->name('editCategory-Products');



    //save category product
    Route::post('/save-category-product', [CategoryProducts::class, 'SaveCategory'])->name('SaveCategoryProduct');
    //update category product
    Route::post('/update-category-product/{category_id}', [CategoryProducts::class, 'updateCategory'])->name('updateCategoryProduct');



    //active status category product product
    Route::get('/unactived-status-category/{category_id}', [CategoryProducts::class, 'UnactiveCategory'])->name('unactived-status-category');
    Route::get('/actived-status-category/{category_id}', [CategoryProducts::class, 'ActiveCategory'])->name('actived-status-category');


    //Brand product
    Route::get('/add-brand', [BrandProducts::class, 'AddBrand'])->name('addBrand');
    Route::get('/list-brand', [BrandProducts::class, 'ListBrand'])->name('listBrand');
    Route::get('/delete-brand/{brand_id}', [BrandProducts::class, 'deleteBrand'])->name('deleteBrand');
    Route::get('/edit-brand/{brand_id}', [BrandProducts::class, 'editBrand'])->name('editBrand');



    //save brand product
    Route::post('/save-brand-product', [BrandProducts::class, 'SaveBrand'])->name('SaveBrandProduct');
    //update brand product
    Route::post('/update-brand-product/{brand_id}', [BrandProducts::class, 'updateBrand'])->name('updateBrandProduct');



    //active status brand product
    Route::get('/unactived-status-brand/{brand_id}', [BrandProducts::class, 'Unactivebrand'])->name('unactived-status-brand');
    Route::get('/actived-status-brand/{brand_id}', [BrandProducts::class, 'ActiveBrand'])->name('actived-status-brand');

    //Product
    Route::get('/add-product', [ProductController::class, 'AddProduct'])->name('addProduct');
    Route::get('/delete-product/{product_id}', [ProductController::class, 'deleteProduct'])->name('deleteProduct');



    //save product
    Route::post('/save-product', [ProductController::class, 'SaveProduct'])->name('SaveProduct');
    //update product
    Route::post('/update-product/{product_id}', [ProductController::class, 'updateProduct'])->name('updateProduct');



    //active status product
    Route::get('/unactived-status-product/{product_id}', [ProductController::class, 'UnactiveProduct'])->name('unactived-status-product');
    Route::get('/actived-status-product/{product_id}', [ProductController::class, 'ActiveProduct'])->name('actived-status-product');

    //order
    Route::get('/manage-order', [CheckoutController::class, 'ManageOrder'])->name('manage-order');
    Route::get('/view-order/{order_id}', [CheckoutController::class, 'ViewOrder'])->name('view-order');
    Route::get('/delete-order/{order_id}', [CheckoutController::class, 'DeleteOrder'])->name('delete-order');
});


Route::get('/edit-product/{product_id}', [ProductController::class, 'editProduct'])->name('editProduct');
Route::get('/list-product', [ProductController::class, 'ListProduct'])->name('listProduct');

