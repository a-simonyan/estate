<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyDeal extends Model
{
    public $timestamps = false;
    protected $table ="property_deals";
    protected $fillable= ['property_id','deal_type_id','price'];

    public function property(){
        return $this->belongsTo('App\Property','property_id','id');
    }
    public function deal_type(){
        return $this->belongsTo('App\DealType','deal_type_id','id');
    }
}
