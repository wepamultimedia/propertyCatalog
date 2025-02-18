<?php

use Illuminate\Support\Facades\Route;
use Wepa\PropertyCatalog\Http\Controllers\Backend\CategoryController;
use Wepa\PropertyCatalog\Http\Controllers\Backend\PropertyController;
use Wepa\PropertyCatalog\Http\Controllers\Backend\PropertyFileController;
use Wepa\PropertyCatalog\Http\Controllers\Backend\PropertyImageController;
use Wepa\PropertyCatalog\Http\Controllers\Backend\PropertyPriceController;

Route::prefix('admin/property-catalog')
    ->middleware(['web', 'auth:sanctum', 'core.backend'])
    ->group(function () {
        // Types
        Route::resource('types', \Wepa\PropertyCatalog\Http\Controllers\Backend\TypeController::class)
            ->names('admin.property_catalog.types');

        // Categories
        Route::put('categories/position/{category}/{position}', [CategoryController::class, 'position'])
            ->name('admin.property_catalog.categories.position');

        Route::put('categories/update/published/{category}/{published}', [CategoryController::class, 'published'])
            ->name('admin.property_catalog.categories.update.published');

        Route::resource('categories', CategoryController::class)
            ->names('admin.property_catalog.categories');

        // Properties
        Route::put('properties/position/{property}/{position}', [PropertyController::class, 'position'])
            ->name('admin.property_catalog.properties.position');

        Route::put('properties/update/published/{property}/{published}', [PropertyController::class, 'published'])
            ->name('admin.property_catalog.properties.update.published');

        Route::put('properties/update/highlighted/{property}/{highlighted}', [PropertyController::class, 'highlighted'])
            ->name('admin.property_catalog.properties.update.highlighted');

        Route::put('properties/update/new/{property}/{new}', [PropertyController::class, 'new'])
            ->name('admin.property_catalog.properties.update.new');

        Route::put('properties/update/latest/{property}/{latest}', [PropertyController::class, 'latest'])
            ->name('admin.property_catalog.properties.update.latest');

        Route::put('properties/update/sold/{property}/{sold}', [PropertyController::class, 'sold'])
            ->name('admin.property_catalog.properties.update.sold');

        Route::resource('properties', PropertyController::class)
            ->names('admin.property_catalog.properties');

        // Properties images
        Route::resource('properties/images', PropertyImageController::class)
            ->names('admin.property_catalog.images');

        Route::put('properties/images/position/{image}/{position}', [PropertyImageController::class, 'position'])
            ->name('admin.property_catalog.images.position');

        // Properties files
        Route::resource('properties/files', PropertyFileController::class)
            ->names('admin.property_catalog.files');

        Route::put('properties/files/position/{file}/{position}', [PropertyFileController::class, 'position'])
            ->name('admin.property_catalog.files.position');

        // Properties prices
        Route::resource('properties/prices', PropertyPriceController::class)
            ->names('admin.property_catalog.prices');

        Route::put('properties/prices/position/{price}/{position}', [PropertyPriceController::class, 'position'])
            ->name('admin.property_catalog.prices.position');
    });
