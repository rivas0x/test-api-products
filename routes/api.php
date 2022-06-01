<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Without Auth
Route::resource('/categories', CategoryController::class, ['except' => 'create, edit']);
Route::resource('/products', ProductController::class, ['except' => 'create, edit']);




/*
//With Auth
Route::group(['prefix' => 'admin', 'middleware' => 'auth:sanctum'], function () {
    Route::resource('/categories', CategoryController::class, ['except' => 'create,edit']);
    Route::resource('/products', ProductController::class, ['except' => 'create,edit']);
});
 */
