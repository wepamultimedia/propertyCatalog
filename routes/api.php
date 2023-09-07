<?php

use Illuminate\Support\Facades\Route;
use Wepa\PropertyCatalog\Http\Controllers\Api\CategoryController;
use Wepa\PropertyCatalog\Http\Controllers\Api\PropertyController;

Route::prefix('api/property-catalog')->middleware(['api'])->group(function () {
    Route::get('categories/{locale?}', [CategoryController::class, 'index'])->name('api.property_catalog.categories');
    Route::get('properties/highlights/{locale?}', [PropertyController::class, 'highlights'])->name('api.property_catalog.highlights');
    Route::get('properties/{locale?}', [PropertyController::class, 'index'])->name('api.property_catalog.properties');
});
