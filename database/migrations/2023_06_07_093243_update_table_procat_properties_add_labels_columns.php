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
            $table->boolean('latest')->default(false);
            $table->boolean('new')->default(false);
            $table->boolean('airbnb')->default(false);
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
            $table->dropColumn('latest');
            $table->dropColumn('new');
            $table->dropColumn('airbnb');
        });
    }
};
