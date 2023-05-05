<?php

namespace Wepa\PropertyCatalog\Commands;

use Illuminate\Console\Command;

class PropertyCatalogCommand extends Command
{
    public $signature = 'property-catalog';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
