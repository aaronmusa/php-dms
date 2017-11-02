<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    protected $fillable = ['socket_id','mac_address','local_time','server_time','status'];
    protected $guarded = ['created_at', 'updated_at'];
}
