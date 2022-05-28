<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'uuid',
        'payment_order_id',
        'type',
        'user_id',
        'property_id',
        'status',
        'amount',
        'currency',
        'params'
    ];

    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }

    public function  property(){
        return $this->belongsTo('App\Property','property_id','id');
    }
}
