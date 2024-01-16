<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\TranslationTrait;

class FilterGroup extends Model
{
   use TranslationTrait;

   public $timestamps = false;
   protected $table = 'filter_groups';
   protected $fillable = ['name'];

   public function getNameAttribute($value)
   {
       return $this->translat($value);
   }

   public function filters(){
     return $this->hasMany('App\Filter','filter_group_id','id');
   }     

}
