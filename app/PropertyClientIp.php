<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyClientIp extends Model
{
    protected $table = 'property_client_ips';
    protected $fillable = [
        'property_id',
        'client_ip'
    ];

    public function  property(){
        return $this->belongsTo('App\Property','property_id','id');
    }

}
