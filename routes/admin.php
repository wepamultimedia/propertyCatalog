<?php


use Illuminate\Support\Facades\Route;
use Wepa\PropertyCatalog\Http\Controllers\Backend\CategoryController;
use Wepa\PropertyCatalog\Http\Controllers\Backend\PropertyController;
use Wepa\PropertyCatalog\Http\Controllers\Backend\PropertyImageController;


Route::get('/test', [CategoryController::class, 'test'])->name('test');
Route::prefix('admin/property-catalog')
    ->middleware(['web', 'auth:sanctum', 'core.backend'])
    ->group(function () {
        // Categories
        Route::put('categories/position/{category}/{position}', [CategoryController::class, 'position'])
            ->name('admin.property_catalog.categories.position');
    
        Route::put('categories/publish/{category}/{published}', [CategoryController::class, 'publish'])
            ->name('admin.property_catalog.categories.publish');
        
        Route::resource('categories', CategoryController::class)
            ->names('admin.property_catalog.categories');
        
        // Properties
        Route::put('properties/position/{property}/{position}', [PropertyController::class, 'position'])
            ->name('admin.property_catalog.properties.position');
    
        Route::put('properties/publish/{property}/{published}', [PropertyController::class, 'publish'])
            ->name('admin.property_catalog.properties.publish');
        
        Route::resource('properties', PropertyController::class)
            ->names('admin.property_catalog.properties');
    
        // Properties images
        Route::resource('properties/images', PropertyImageController::class)
            ->names('admin.property_catalog.images');
    
        Route::put('properties/images/position/{image}/{position}', [PropertyImageController::class, 'position'])
            ->name('admin.property_catalog.images.position');
    });
