<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TranslatePropertyAddress extends Model
{
    public $timestamps = false;
    protected $table = "translate_property_addresses";
    protected $fillable = ['property_id','language_id','addresse','country','province','locality','street','house','reverse_address'];

    public function  property(){
        return $this->belongsTo('App\Property','property_id','id');
    }
    public function language(){
        return $this->belongsTo('App\Language','language_id','id');
    }
}
