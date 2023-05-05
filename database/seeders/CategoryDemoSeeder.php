<?php

namespace Wepa\PropertyCatalog\Database\seeders;


use Wepa\Core\Models\Menu;
use Wepa\PropertyCatalog\Database\Factories\CategoryFactory;
use Wepa\PropertyCatalog\Models\Category;


class CategoryDemoSeeder extends \Illuminate\Database\Seeder
{
    public function run()
    {
        Category::factory()->count(20)->create();
    }
}
