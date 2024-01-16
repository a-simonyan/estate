<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DealType extends Model
{
    public $timestamps = false;
    protected $table = "deal_types";
    protected $fillable = ['name'];

    public function property_deals(){
        return $this->hasMany('App\PropertyDeal','deal_type_id','id'); 
    }

    public function properties(){
        return $this->belongsToMany('App\Property','property_deals','deal_type_id','property_id');
    }
    
}
