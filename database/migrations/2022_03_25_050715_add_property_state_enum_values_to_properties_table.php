<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPropertyStateEnumValuesToPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('property_state');
        });
        Schema::table('properties', function (Blueprint $table) {
            $table->enum('property_state',['good','average','poor', 'renovated', 'zero_condition'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('property_state');
        });
        Schema::table('properties', function (Blueprint $table) {
            $table->enum('property_state',['good','average','poor'])->nullable();
        });
    }
}
