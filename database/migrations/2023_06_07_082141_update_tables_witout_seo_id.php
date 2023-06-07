<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Wepa\Core\Models\Seo;
use Wepa\PropertyCatalog\Models\Category;
use Wepa\PropertyCatalog\Models\Property;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $categories = Category::all();
        foreach ($categories as $category) {
            $seo = Seo::find($category->seo_id);
            $seo->update([
                'model_type' => Category::class,
                'model_id' => $category->id,
                'change_freq' => Seo::CHANGE_FREQUENCY_WEEKLY,
                'priority' => '0.8',
            ]);
        }

        Schema::table('procat_categories', function (Blueprint $table) {
            $table->dropColumn('seo_id');
        });

        $properties = Property::all();
        foreach ($properties as $property) {
            $seo = Seo::find($property->seo_id);
            $seo->update([
                'model_type' => Property::class,
                'model_id' => $property->id,
                'change_freq' => Seo::CHANGE_FREQUENCY_YEARLY,
                'priority' => '0.9',
            ]);
        }

        Schema::table('procat_properties', function (Blueprint $table) {
            $table->dropColumn('seo_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
