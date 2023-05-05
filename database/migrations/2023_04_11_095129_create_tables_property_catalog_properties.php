<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procat_properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id');
            $table->foreignId('seo_id')->nullable();
            $table->string('price')->nullable();
            $table->string('offer_price')->nullable();
            $table->string('cover');
            $table->boolean('published')->default(true);
            $table->boolean('highlighted')->default(false);
            $table->integer('position');
            $table->timestamps();

            $table->foreign('category_id')
                ->references('id')
                ->on('procat_categories')
                ->onDelete('cascade');
        });

        Schema::create('procat_properties_translations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('summary');
            $table->string('cover_alt');
            $table->text('data_sheet');
            $table->string('locale')->index();

            $table->foreignId('property_id');
            $table->unique(['locale', 'property_id'], 'procat_protra_locale_property_id_unique');

            $table->foreign('property_id')
                ->references('id')
                ->on('procat_properties')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('procat_properties');
        Schema::dropIfExists('procat_properties_translations');
    }
};
