<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FilterPropertyType extends Model
{
    public $timestamps  = false;
    protected $table    = "filter_property_types";
    protected $fillable = ['filter_id','property_type_id'];
}
