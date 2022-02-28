<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App;


class SpamPoint extends Model
{
    protected $table="spam_points";
    protected $fillable=['name'];

    public function translate_spam_points(){
        return $this->hasMany('App\TranslateSpamPoint','spam_point_id','id'); 
    }

    public function translate_spam_points_by_sel_language(){
       $selLanguage =App::getLocale();
       return $this->hasMany('App\TranslateSpamPoint','spam_point_id','id')->whereHas('language', function($query) use ( $selLanguage ) {
           $query->where('code', $selLanguage);
       });
    }

    public function spam(){
        return $this->belongsToMany('App\Spam','spam_spam_points','spam_point_id','spam_id');
    }
          
}
