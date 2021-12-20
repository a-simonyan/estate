<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLastUpdateAndNextUpdateAndIsBidsAndIsArchiveToPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->integer('update_count')->default(0);
            $table->timestamp('next_update')->nullable()->after('review');
            $table->timestamp('last_update')->nullable()->after('review');
            $table->boolean('is_archive')->default(false)->after('review');
            $table->boolean('is_bids')->default(false)->after('review');
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
            $table->dropColumn(['update_count','next_update','last_update','is_archive','is_bids']);
        });
    }
}
