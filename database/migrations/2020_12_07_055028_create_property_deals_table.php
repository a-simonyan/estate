<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyDealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_deals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
            $table->foreignId('deal_type_id');
            $table->foreign('deal_type_id')->references('id')->on('deal_types')->onDelete('cascade');
            $table->float('price');
            $table->foreignId('currency_type_id');
            $table->foreign('currency_type_id')->references('id')->on('currency_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property_deals');
    }
}
