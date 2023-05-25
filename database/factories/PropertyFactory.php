<?php

namespace Wepa\PropertyCatalog\Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Wepa\Core\Models\Seo;
use Wepa\PropertyCatalog\Http\Controllers\Frontend\PropertyController;
use Wepa\PropertyCatalog\Models\Category;
use Wepa\PropertyCatalog\Models\Property;
use Wepa\PropertyCatalog\Models\PropertyImage;

class PropertyFactory extends Factory
{
    protected $model = Property::class;

    public function configure()
    {
        return $this->afterMaking(function (Property $property) {
            $category = Category::inRandomOrder()->first();
            $property->category_id = $category->id;

            $seo = Seo::create([
                'package' => 'property-catalog',
                'controller' => PropertyController::class,
                'action' => 'show',
                'title' => $property->name,
                'slug' => Str::slug($property->name),
                'description' => $property->summary,
            ]);
            $property->seo_id = $seo->id;
        })->afterCreating(function (Property $property) {
            $seo = Seo::where(['id' => $property->seo_id])->first();
            $seo->update(['route_params' => ['property' => $property->id]]);

            $property->update(['position' => Property::nextPosition()]);

            PropertyImage::factory(5)->create(['property_id' => $property->id]);
        });
    }

    public function definition()
    {
        $price = rand(100000, 800000);

        return [
            'name' => $name = $this->faker->name,
            'summary' => $this->faker->sentence,
            'data_sheet' => $this->faker->paragraph,
            'price' => $price,
            'cover' => $this->faker->imageUrl,
            'cover_alt' => $name,
            'position' => Category::nextPosition(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
