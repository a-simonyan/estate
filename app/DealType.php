<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DealType extends Model
{
    public $timestamps = false;
    protected $table = "deal_types";
    protected $fillable = ['name'];

    public function properties(){
        return $this->hasMany('App\Property','deal_type_id','id');
    }
    
}
