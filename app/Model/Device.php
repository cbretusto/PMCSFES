<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Checksheet;
use App\Model\CheckList;

class Device extends Model
{
    //
    protected $table = 'tbl_device';
    protected $connection = 'mysql';

    public function device_details(){
    	return $this->hasMany(Checksheet::class, 'device_id', 'device_id');
    }

    public function device_info(){
    	return $this->hasMany(CheckList::class, 'device_id', 'device_id')->where('status', 1)->where('logdel', 0);
    }
}

