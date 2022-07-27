<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
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

Route::get('/', function () {
    return view('front-end.welcome');
})->name('frontend.welcome');

/**
 * -------------------------------------------------------------------------
 *  Dashboard route groups.
 * -------------------------------------------------------------------------
 *  This route group is used for all routes which only work for a logged in user
 *  Auth middleware is added to this route.
 */

Route::middleware('auth')->group(function(){

    //route for welcome screen of dashboard
    Route::view('/dashboard', 'dashboard.welcome')->name('dashboard.welcome');
    Route::resource('/dashboard/categories', CategoryController::class);
    Route::resource('/dashboard/subcategories', SubcategoryController::class);
});
