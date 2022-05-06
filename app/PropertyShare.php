<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyShare extends Model
{
    protected $table = 'property_shares';
    protected $fillable = [
        'property_id',
    ];

    public function  property(){
        return $this->belongsTo('App\Property','property_id','id');
    }
}
