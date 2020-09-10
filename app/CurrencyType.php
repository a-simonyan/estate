<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CurrencyType extends Model
{
    public $timestamps = false;
    protected $table = "currency_types";
    protected $fillable = ['name','symbol','is_current','value'];


}
