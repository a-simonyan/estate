<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddPropertyStateOverhauledEnam extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('properties', function (Blueprint $table) {
            DB::statement("ALTER TABLE properties DROP CONSTRAINT properties_property_state_check");

            $types = ['good','average','poor', 'renovated', 'zero_condition','overhauled','euro_renovated','sufficient'];
            $result = join( ', ', array_map(function ($value){
                return sprintf("'%s'::character varying", $value);
            }, $types));
    
            DB::statement("ALTER TABLE properties ADD CONSTRAINT properties_property_state_check CHECK (property_state::text = ANY (ARRAY[$result]::text[]))");
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
            DB::statement("ALTER TABLE properties DROP CONSTRAINT properties_property_state_check");

            $types = ['good','average','poor', 'renovated', 'zero_condition'];
            $result = join( ', ', array_map(function ($value){
                return sprintf("'%s'::character varying", $value);
            }, $types));
    
            DB::statement("ALTER TABLE properties ADD CONSTRAINT properties_property_state_check CHECK (property_state::text = ANY (ARRAY[$result]::text[]))");
        });
    }
}
