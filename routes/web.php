<?php

use App\Http\Controllers\ProductController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'products','as'=>'product.'],function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/list', [ProductController::class, 'indexAjax'])->name('index-ajax');//load dữ liệu mới
    Route::post('/add', [ProductController::class, 'addProduct'])->name('add');
    Route::post('/delete/{id}', [ProductController::class, 'deleteProduct'])->name('delete');
    Route::post('/delete', [ProductController::class, 'deleteProduct'])->name('deleteAll');
    Route::get('/update/{id}', [ProductController::class, 'updateProduct'])->name('show');
    Route::post('/update/{id}', [ProductController::class, 'updateProduct'])->name('update');
});
