<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpamSpamPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spam_spam_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spam_id');
            $table->foreign('spam_id')->references('id')->on('spam')->onDelete('cascade');
            $table->foreignId('spam_point_id');
            $table->foreign('spam_point_id')->references('id')->on('spam_points')->onDelete('cascade');
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
        Schema::dropIfExists('spam_spam_points');
    }
}
