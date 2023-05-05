<?php

namespace Wepa\PropertyCatalog\Database\seeders;

use Wepa\PropertyCatalog\Models\Property;

class PropertyDemoSeeder extends \Illuminate\Database\Seeder
{
    public function run()
    {
        Property::factory()->count(20)->create();
    }
}
