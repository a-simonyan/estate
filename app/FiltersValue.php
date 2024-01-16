<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FiltersValue extends Model
{
    public $timestamps = false;
    protected $table = "filters_values";
    protected $fillable = ['filter_id','property_id','value'];


    public function filter(){
        return $this->belongsTo('App\Filter','filter_id','id');
    }

    public function property(){
        return $this->belongsTo('App\Property','property_id','id');
    }

   

}
