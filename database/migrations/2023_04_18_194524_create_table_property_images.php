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
        Schema::create('procat_properties_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id');
            $table->string('image_url');
            $table->integer('position');

            $table->foreign('property_id')
                ->references('id')
                ->on('procat_properties')
                ->onDelete('cascade');
        });

        Schema::create('procat_properties_images_translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale')->index();
            $table->foreignId('image_id');
            $table->string('image_alt');

            $table->foreign('image_id')
                ->references('id')
                ->on('procat_properties_images')
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
        Schema::dropIfExists('table_property_images');
    }
};
