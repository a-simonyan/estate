<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FilterGroup extends Model
{
   public $timestamps = false;
   protected $table = 'filter_groups';
   protected $fillable = ['name'];

   public function filters(){
     return $this->hasMany('App\Filter','filter_group_id','id');
   }     

}
