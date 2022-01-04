<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryProducts;
use App\Http\Controllers\HomeController;
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
Route::get('/home', [HomeController::class, 'index']);

//backend
//dashboard
Route::get('/admin', [AdminController::class, 'index']);
Route::get('/dashboard', [AdminController::class, 'ShowDashboard'])->name('dashboard');

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
Route::get('/unactived-status-category/{category_id}', [CategoryProducts::class, 'UnactiveCategory'])->name('unactived-status');
Route::get('/actived-status-category/{category_id}', [CategoryProducts::class, 'ActiveCategory'])->name('actived-status');
