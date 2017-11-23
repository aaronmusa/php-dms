<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimeScheduler extends Model
{
    protected $fillable = ['start_time','end_time','mac_address'];
    protected $guarded = ['id','created_at', 'updated_at'];
}
