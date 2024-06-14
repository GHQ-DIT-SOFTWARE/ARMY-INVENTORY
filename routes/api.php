<?php

use App\Http\Controllers\Api\Logistics\LogisticsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::prefix('logistics')->group(function () {
    Route::post('/api-view-items', [LogisticsController::class, 'index'])->name('api-logistics-itemx');
    Route::post('/filter-items', [LogisticsController::class, 'filter_item'])->name('filter-items');
    Route::get('/api-view-serviceable', [LogisticsController::class, 'serviceable_items'])->name('api-logistics-serviceable');
    Route::get('/api-view-un-serviceable', [LogisticsController::class, 'unserviceable_items'])->name('api-logistics-un-serviceable');
    Route::prefix('items')->group(function () {
        Route::post('/with-quantities', [ItemsWithQuantityController::class, 'index'])->name('api-item-with-quantity');
    });
});
