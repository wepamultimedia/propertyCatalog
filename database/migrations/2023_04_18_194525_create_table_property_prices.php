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
        Schema::create('procat_properties_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id');
            
            $table->string('price');
            $table->integer('position');

            $table->foreign('property_id')
                ->references('id')
                ->on('procat_properties')
                ->onDelete('cascade');
        });

        Schema::create('procat_properties_prices_translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale')->index();
            $table->foreignId('price_id');
            $table->unique(['locale', 'price_id'], 'procat_protra_locale_prices_id_unique');
            
            $table->string('name');
    
            $table->foreign('price_id')
                ->references('id')
                ->on('procat_properties_prices')
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
        Schema::dropIfExists('procat_properties_prices');
        Schema::dropIfExists('procat_properties_prices_translations');
    }
};
