<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhoneLoginToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('users_email_unique');
            $table->dropForeign('users_user_type_id_foreign');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->string('login_phone')->unique()->nullable();
            $table->string('email')->unique()->nullable()->change();
            $table->string('full_name')->nullable()->change();
            $table->foreignId('user_type_id')->nullable()->change();
            $table->foreign('user_type_id')->references('id')->on('user_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('login_phone');
        });
    }
}
