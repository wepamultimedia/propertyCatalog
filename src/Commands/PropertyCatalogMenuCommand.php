<?php

namespace Wepa\PropertyCatalog\Commands;

use Illuminate\Console\Command;
use Wepa\Core\Models\Menu;

class PropertyCatalogMenuCommand extends Command
{
    public $signature = 'property-catalog:menu';

    public $description = 'Add property catalog menu';

    public function handle(): int
    {
        Menu::loadPackageItems('property-catalog');

        return self::SUCCESS;
    }
}
