<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TranslateDescription extends Model
{
    public $timestamps = false;
    protected $table = "translate_descriptions";
    protected $fillable = ['property_id','language_id','description'];

    public function  property(){
        return $this->belongsTo('App\Property','property_id','id');
    }
    public function language(){
        return $this->belongsTo('App\Language','language_id','id');
    }
 
}
