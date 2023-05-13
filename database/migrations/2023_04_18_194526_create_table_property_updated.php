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
        Schema::table('procat_properties', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->dropColumn('offer_price');
            $table->string('video_cover')->nullable();
            $table->boolean('published')->nullable()->default(true)->change();
            $table->boolean('highlighted')->nullable()->default(false)->change();
        });

        Schema::table('procat_properties_translations', function (Blueprint $table) {
            $table->string('delivery')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('procat_properties', function (Blueprint $table) {
            $table->string('price')->nullable();
            $table->string('offer_price')->nullable();
            $table->boolean('published')->nullable(false)->default(true)->change();
            $table->boolean('highlighted')->nullable(false)->default(false)->change();
            $table->dropColumn('video_cover');
        });

        Schema::table('procat_properties_translations', function (Blueprint $table) {
            $table->removeColumn('delivery');
        });
    }
};
