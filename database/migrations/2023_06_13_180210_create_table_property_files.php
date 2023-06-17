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
        Schema::create('procat_properties_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id');
            $table->string('file_url');
            $table->integer('position');
    
            $table->foreign('property_id')
                ->references('id')
                ->on('procat_properties')
                ->onDelete('cascade');
        });
    
        Schema::create('procat_properties_files_translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale')->index();
            $table->foreignId('file_id');
            $table->string('name');
        
            $table->foreign('file_id')
                ->references('id')
                ->on('procat_properties_files')
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
        Schema::dropIfExists('procat_properties_files');
        Schema::dropIfExists('procat_properties_files_translations');
    }
};
