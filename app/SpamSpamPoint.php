<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpamSpamPoint extends Model
{
    protected $table="spam_points";
    protected $fillable=['spam_id','spam_point_id'];
}
