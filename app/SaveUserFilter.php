<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaveUserFilter extends Model
{
    protected $table = "save_user_filters";
    protected $fillable = ['properties_filters','user_id'];

    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }
}
