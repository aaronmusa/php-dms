<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Socket extends Model
{	
    protected $fillable = ['start_time','end_time'];
    protected $guarded = ['id','created_at', 'updated_at'];
}
