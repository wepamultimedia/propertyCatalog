<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('procat_types', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('procat_types_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_id')->constrained('procat_types')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('name');
            $table->string('locale')->index();
            $table->unique(['type_id', 'locale'], 'procat_typeid_locale_unique');
        });



        Schema::table('procat_categories', function (Blueprint $table) {
            $table->foreignId('type_id')->nullable()->constrained('procat_types')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('procat_types');
        Schema::drop('procat_types_translations');

        Schema::table('procat_categories', function (Blueprint $table) {
            $table->dropColumn('type_id');
        });
    }
};
