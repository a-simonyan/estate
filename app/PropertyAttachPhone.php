<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyAttachPhone extends Model
{
    protected $table = "property_attach_phones";
    protected $fillable = ['code','number','property_id','viber','whatsapp','telegram'];

    public function  property(){
       return $this->belongsTo('App\Property','property_id','id');
    }
}
