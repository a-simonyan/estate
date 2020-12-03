<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('property_key')->nullable();
            $table->foreignId('property_type_id')->nullable();
            $table->foreign('property_type_id')->references('id')->on('property_types')->onDelete('cascade');
            $table->foreignId('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('bulding_type_id')->nullable();
            $table->foreign('bulding_type_id')->references('id')->on('bulding_types')->onDelete('cascade');
            $table->float('latitude')->nullable();
            $table->float('longitude')->nullable();
            $table->string('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->enum('property_state',['good','average','poor'])->nullable();
            $table->text('review')->nullable();
            $table->enum('is_public_status',['under_review','published','rejected'])->default('under_review');
            $table->boolean('is_save')->default(false);
            $table->boolean('is_delete')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('properties');
    }
}
