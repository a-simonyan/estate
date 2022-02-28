<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TranslateSpamPoint extends Model
{
    protected $table="translate_spam_points";

    protected $fillable = ['spam_point_id','language_id','description'];

    public function  spam_point(){
        return $this->belongsTo('App\SpamPoint','spam_point_id','id');
    }
    public function language(){
        return $this->belongsTo('App\Language','language_id','id');
    }
}
