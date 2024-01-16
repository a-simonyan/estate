<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToFiltersValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('filters_values', function (Blueprint $table) {
            $table->index('filter_id');
            $table->index('property_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('filters_values', function (Blueprint $table) {
            $table->dropIndex(['filter_id']);
            $table->dropIndex(['property_id']);
        });
    }
}
