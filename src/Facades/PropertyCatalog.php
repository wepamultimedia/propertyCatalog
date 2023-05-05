<?php

namespace Wepa\PropertyCatalog\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Wepa\PropertyCatalog\PropertyCatalog
 */
class PropertyCatalog extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Wepa\PropertyCatalog\PropertyCatalog::class;
    }
}
