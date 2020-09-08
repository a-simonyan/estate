<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    public $timestamps = false;
    protected $table = "languages";
    protected $fillable = ['name'];

    public function translations(){
        return $this->hasMany('App\Translation','language_id','id');
    }
}
