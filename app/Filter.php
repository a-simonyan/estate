<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    public $timestamps = false;
    protected $table = "filters";
    protected $fillable = ['name','filter_type'];

 public function filters_values(){
        return $this->hasMany('App\FiltersValue','filter_id','id');
    }
    
}
