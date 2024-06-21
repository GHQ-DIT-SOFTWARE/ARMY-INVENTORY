<?php

use App\Http\Controllers\Api\Logistics\AggregatedIssueItemController;
use App\Http\Controllers\Api\Logistics\IssuedOutItemController;
use App\Http\Controllers\Api\Logistics\LogisticsController;
use App\Http\Controllers\Api\Logistics\RestockItemController;
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
    Route::post('/restocks-items', [RestockItemController::class, 'index'])->name('api-restocks-items');
    Route::post('/issued-out-items', [IssuedOutItemController::class, 'index'])->name('api-issued-out');
    Route::post('/aggregated-issue-items', [AggregatedIssueItemController::class, 'index'])->name('aggregated-issue-items');
    Route::post('/items-issued-aggregated', [AggregatedIssueItemController::class, 'item_issued'])->name('items-issued-aggregated');
});
