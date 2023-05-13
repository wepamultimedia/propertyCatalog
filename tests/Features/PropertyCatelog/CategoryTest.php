<?php

namespace Tests\Feature\PropertyCatalog;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Wepa\PropertyCatalog\Models\Category;
use Wepa\PropertyCatalog\Models\CategoryTranslation;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_store()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('admin.property_catalog.categories.store'), [
            'translations' => [
                'en' => [
                    'name' => 'Test Category',
                    'description' => 'Test Category description',
                ],
            ],
            'seo' => (new Category())->seo(),
            'position' => 1,
        ]);

        $this->assertDatabaseHas(Category::class, ['position' => 1, 'published' => true]);
        $this->assertDatabaseHas(CategoryTranslation::class, ['category_id' => 1, 'name' => 'Test Category']);

        $response->assertRedirectToRoute('admin.property_catalog.categories.index');
    }

    //    public function test_update()
    //    {
    //        $user = User::factory()->create();
    //
    //        $category = Category::create([
    //            'name' => 'Test Category',
    //            'position' => 1
    //        ]);
    //
    //        $this->actingAs($user)->put(route('admin.property_catalog.categories.update', ['category' => $category->id]), [
    //            'translations' => [
    //                'name' => 'Test Category update',
    //                'description' => 'Test Category description',
    //            ],
    //        ])->assertRedirectToRoute('admin.property_catalog.categories.index');
    //
    //        $this->assertDatabaseHas(CategoryTranslation::class, ['name' => 'Test Category update']);
    //    }
    //
    //    public function test_destroy()
    //    {
    //        $user = User::factory()->create();
    //
    //        $category = Category::create([
    //            'name' => 'Test Category',
    //            'position' => 1
    //        ]);
    //
    //        $this->actingAs($user)->delete(route('admin.property_catalog.categories.destroy', ['category' => $category->id]))
    //            ->assertRedirectToRoute('admin.property_catalog.categories.index');
    //
    //        $this->assertDatabaseCount(Category::class, 0);
    //    }
}
