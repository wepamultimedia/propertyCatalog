<?php

namespace Tests\Feature\PropertyCatalog;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;
use Wepa\PropertyCatalog\Models\Category;
use Wepa\PropertyCatalog\Models\Property;
use Wepa\PropertyCatalog\Models\PropertyTranslation;

class PropertyTest extends TestCase
{
    use RefreshDatabase;

    public function test_create()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.property_catalog.properties.create'))
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Vendor/PropertyCatalog/Backend/Property/Create')
            );
    }

    public function test_edit()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.property_catalog.properties.create'))
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Vendor/PropertyCatalog/Backend/Property/Edit')
            );
    }

    public function test_destroy()
    {
        $user = User::factory()->create();

        $category = Category::create([
            'name' => 'Test Category',
            'position' => 1,
        ]);

        $property = Property::create([
            'category_id' => $category->id,
            'name' => 'Test property',
            'summary' => 'Summary property',
            'data_sheet' => 'Dada sheet property',
            'price' => 100.000,
            'offer_price' => 90.000,
            'position' => 1,
        ]);

        $this->actingAs($user)->delete(route('admin.property_catalog.properties.destroy',
            ['property' => $property->id]))
            ->assertRedirectToRoute('admin.property_catalog.properties.index');

        $this->assertDatabaseCount(Property::class, 0);
    }

    public function test_store()
    {
        $user = User::factory()->create();

        $category = Category::create(['name' => 'Test category', 'position' => 1]);

        $response = $this->actingAs($user)->post(route('admin.property_catalog.properties.store'), [
            'category_id' => $category->id,
            'name' => 'Test property',
            'summary' => 'Summary property',
            'data_sheet' => 'Dada sheet property',
            'price' => '100.000,00',
            'offer_price' => '90.000,00',
            'published' => true,
            'position' => 1,
        ]);

        $this->assertDatabaseHas(Property::class, [
            'price' => '100.000,00',
            'offer_price' => '90.000,00',
            'position' => 1,
            'published' => true,
        ]);
        $this->assertDatabaseHas(PropertyTranslation::class, [
            'name' => 'Test property',
            'summary' => 'Summary property',
            'data_sheet' => 'Dada sheet property',
        ]);

        $response->assertRedirectToRoute('admin.property_catalog.properties.index');
    }

    public function test_update()
    {
        $user = User::factory()->create();

        $category = Category::create([
            'name' => 'Test Category',
            'position' => 1,
        ]);

        $property = Property::create([
            'category_id' => $category->id,
            'name' => 'Test property',
            'summary' => 'Summary property',
            'data_sheet' => 'Dada sheet property',
            'price' => '100.000,00',
            'offer_price' => '90.000,00',
            'position' => 1,
        ]);

        $this->actingAs($user)->put(route('admin.property_catalog.properties.update', ['property' => $property->id]), [
            'category_id' => $category->id,
            'published' => true,
            'name' => 'Test property update',
            'summary' => 'Summary property update',
            'data_sheet' => 'Dada sheet property update',
            'price' => '200.000,00',
            'offer_price' => '190.000,00',
        ])->assertRedirectToRoute('admin.property_catalog.properties.index');

        $this->assertDatabaseHas(Property::class, [
            'price' => '200.000,00',
            'offer_price' => '190.000,00',
        ]);

        $this->assertDatabaseHas(PropertyTranslation::class, [
            'name' => 'Test property update',
            'summary' => 'Summary property update',
            'data_sheet' => 'Dada sheet property update',
        ]);
    }
}
