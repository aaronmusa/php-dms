<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticker extends Model
{
    protected $fillable = ['message','start_time','end_time'];
    protected $guarded = ['id','created_at', 'updated_at'];
}
