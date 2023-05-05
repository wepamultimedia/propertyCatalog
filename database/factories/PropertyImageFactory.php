<?php

namespace Wepa\PropertyCatalog\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Wepa\PropertyCatalog\Models\PropertyImage;

class PropertyImageFactory extends Factory
{
    protected $model = PropertyImage::class;

    public function configure()
    {
        return $this->afterCreating(function (PropertyImage $image) {
            $image->update(['position' => PropertyImage::nextPosition(['property_id' => $image->property_id])]);
        });
    }

    public function definition()
    {
        return [
            'position' => 0,
            'image_url' => $this->faker->imageUrl,
            'image_alt' => $this->faker->name,
        ];
    }
}
