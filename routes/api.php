<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BillController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\SubCategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/server', [HomeController::class, 'index']);
Route::get('/dashboard', DashboardController::class);
	Route::middleware('auth:sanctum')->group(function () {
		Route::post('logout', [AuthController::class, 'logout']);

		/* Categories */
		Route::resource('categories', CategoryController::class)->only(['index', 'show']);
		Route::middleware(['admin'])->group(function () {
			Route::resource('categories', CategoryController::class)->except(['index', 'show']);
		});

		/* SubCategories */
		Route::resource('subcategories', SubCategoryController::class)->only(['index', 'show']);
		Route::middleware('admin')->group(function () {
			Route::resource('subcategories', SubCategoryController::class)->except(['index', 'show']);
		});

		/* Bills */
		Route::resource('bills', BillController::class)->only(['index', 'show']);
		Route::middleware('admin')->group(function () {
			Route::resource('bills', BillController::class)->except(['index', 'show']);
		});
	});

	Route::post('login', [AuthController::class, 'login']);
	Route::post('register', [AuthController::class, 'register']);
