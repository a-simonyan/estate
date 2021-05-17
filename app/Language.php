<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    public $timestamps = false;
    protected $table = "languages";
    protected $fillable = ['name','flag_image','code'];

    public function getFlagImageAttribute($value)
    {
        if(is_null($value)){
          return $value;
        } else {
          return url('storage/language/'.$value);
        }
    }

    public function translations(){
        return $this->hasMany('App\Translation','language_id','id');
    }

    public function translate_descriptions(){
        return $this->hasMany('App\TranslateDescription','language_id','id'); 
    }
}
