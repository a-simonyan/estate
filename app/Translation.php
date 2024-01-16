<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    public $timestamps = false;
    protected $table = "translations";
    protected $fillable = ['name','translated_name', 'language_id'];

    public function language(){
        return $this->belongsTo('App\Language','language_id','id');
    }
}
