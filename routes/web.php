<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MetricsHistoryRunController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StrategyController;
use App\Http\Controllers\GoogleServiceController;


Route::get('/', [MetricsHistoryRunController::class, 'showMetricsForm'])->name('home');
Route::post('/store-metrics', [MetricsHistoryRunController::class, 'storeMetrics'])->name('store-metrics');
Route::get('/metricshistory', [MetricsHistoryRunController::class, 'showSavedMetrics'])->name('metricshistory');

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/strategies', [StrategyController::class, 'index']);

Route::post('/request-google', [GoogleServiceController::class, 'requestGoogle'])->name('request-google');