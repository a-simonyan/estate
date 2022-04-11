<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePriceColumnToPropertyDeals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_deals', function (Blueprint $table) {
            $table->float('price')->nullable()->change();
            $table->foreignId('currency_type_id')->nullable()->change();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('property_deals', function (Blueprint $table) {
            $table->float('price')->change();
            $table->foreignId('currency_type_id')->change();
        });
    }
}
