<?php

namespace Wepa\PropertyCatalog\Database\seeders;

use Wepa\Core\Models\Menu;

class DefaultSeeder extends \Illuminate\Database\Seeder
{
    public function run()
    {
        Menu::loadPackageItems('property-catalog');
    }
}
