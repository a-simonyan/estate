<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReverseAddressToTranslatePropertyAddresses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('translate_property_addresses', function (Blueprint $table) {
            $table->text('reverse_address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('translate_property_addresses', function (Blueprint $table) {
            $table->dropColumn('reverse_address');
        });
    }
}
