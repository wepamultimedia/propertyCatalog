<?php

namespace Wepa\PropertyCatalog;

use Database\Seeders\DatabaseSeeder;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Wepa\PropertyCatalog\Commands\PropertyCatalogCommand;
use Wepa\PropertyCatalog\Database\seeders\DefaultSeeder;


class PropertyCatalogServiceProvider extends PackageServiceProvider
{
    public function bootingPackage()
    {
        parent::bootingPackage();
    
        $this->hasSeeders([DefaultSeeder::class]);
    
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    
        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations'),
        ], 'property-catalog-migrations');
    
        // Pages
        $this->publishes([
            __DIR__.'/../resources/js/Pages' => resource_path('js/Pages/Vendor/PropertyCatalog'),
        ], ['blog', 'property-catalog-pages']);
    
        // Components
        $this->publishes([
            __DIR__.'/../resources/js/Components' => resource_path('js/Vendor/PropertyCatalog'),
        ], ['blog', 'property-catalog-components']);
    
        $this->publishes([
            __DIR__.'/../tests/Unit' => base_path('tests/Unit/PropertyCatalog'),
            __DIR__.'/../tests/Feature' => base_path('tests/Feature/PropertyCatalog'),
        ], ['property-catalog-tests']);
    }
    
    protected function hasSeeders(array $seeders): void
    {
        $this->callAfterResolving(DatabaseSeeder::class,
            function ($cb) use ($seeders) {
                $cb->call($seeders);
            });
    }
    
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('property-catalog')
            ->hasConfigFile()
            ->hasViews()
            ->hasRoutes(['web', 'admin', 'api'])
            ->hasTranslations()
            ->hasCommand(PropertyCatalogCommand::class);
    }
}
