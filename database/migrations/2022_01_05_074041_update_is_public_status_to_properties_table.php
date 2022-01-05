<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateIsPublicStatusToPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('is_public_status');
        });

        Schema::table('properties', function (Blueprint $table) {
            $table->enum('is_public_status',['under_review','published','rejected','canceled'])->default('under_review')->after('review');
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
            $table->dropColumn('is_public_status');
        });

        Schema::table('properties', function (Blueprint $table) {
            $table->enum('is_public_status',['under_review','published','rejected'])->default('under_review')->after('review');
        });
    }
}
