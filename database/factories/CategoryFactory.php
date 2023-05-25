<?php

namespace Wepa\PropertyCatalog\Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Wepa\Core\Models\Seo;
use Wepa\PropertyCatalog\Http\Controllers\Backend\PropertyController;
use Wepa\PropertyCatalog\Models\Category;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function configure()
    {
        return $this->afterMaking(function (Category $category) {
            $seo = Seo::create([
                'package' => 'property-catalog',
                'controller' => PropertyController::class,
                'action' => 'index',
                'title' => $category->name,
                'slug' => Str::slug($category->name),
                'description' => $category->description,
            ]);
            $category->seo_id = $seo->id;
        })->afterCreating(function (Category $category) {
            $seo = Seo::where(['id' => $category->seo_id])->first();
            $seo->update(['request_params' => ['category_id' => $category->id]]);
            $category->update(['position' => Category::nextPosition()]);
        });
    }

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->sentence,
            'position' => Category::nextPosition(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
