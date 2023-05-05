<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('procat_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seo_id')->nullable();
            $table->integer('position');
            $table->boolean('published')->default(true);
            $table->timestamps();
        });

        Schema::create('procat_categories_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id');
            $table->string('locale')->index();
            $table->unique(['locale', 'category_id'], 'procat_cattra_locale_category_id_unique');

            $table->string('name');
            $table->string('description');

            $table->foreign('category_id')
                ->references('id')
                ->on('procat_categories')
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
        Schema::dropIfExists('procat_categories');
        Schema::dropIfExists('procat_categories_translations');
    }
};
