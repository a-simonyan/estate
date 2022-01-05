<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNoteToSuggestsPriceProperties extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('suggests_price_properties', function (Blueprint $table) {
            $table->text('note')->nullable();
            $table->dropColumn('is_delete');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('suggests_price_properties', function (Blueprint $table) {
            $table->dropColumn('note');
            $table->boolean('is_delete')->default(false);
        });
    }
}
