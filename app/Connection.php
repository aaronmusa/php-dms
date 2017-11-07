<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
	protected $primaryKey = 'mac_address'; // or null

    public $incrementing = false;
    protected $fillable = ['socket_id','mac_address','local_time','server_time','status','name'];
    protected $guarded = ['created_at', 'updated_at'];
}
