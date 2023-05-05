<?php


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Wepa\PropertyCatalog\Models\Category;


class CategoryTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_create()
    {
        $this->post(route('admin.property_catalog.categories.store'), [
            'name' => 'Test Category',
            'position' => Category::nextPosition(),
        ]);
    }
}
