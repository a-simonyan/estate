<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    public $timestamps = false;
    protected $table = "phones";
    protected $fillable = ['number','user_id','viber','whatsapp','telegram'];

    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }
}
