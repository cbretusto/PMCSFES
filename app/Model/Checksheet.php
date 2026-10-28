<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Device;
use App\Model\Equipment;
use App\Model\Criteria;
use App\Model\EmergencyLightCriteria;
use App\Model\ExitLightCriteria;
use App\Model\FireExtinguisherCriteria;
use App\Model\FireHoseCriteria;
use App\Model\RapidXUser;

class Checksheet extends Model
{
    protected $table = 'tbl_checksheets';
    protected $connection = 'mysql';

    public function criteria_details(){
    	return $this->hasMany(Criteria::class, 'checksheet_id', 'checksheet_id');
    }
    public function criteria_details_el(){
        return $this->hasMany(EmergencyLightCriteria::class, 'checksheet_id', 'checksheet_id');
    }

    public function criteria_details_exl(){
        return $this->hasMany(ExitLightCriteria::class, 'checksheet_id', 'checksheet_id');
    }

    public function criteria_details_fe(){
        return $this->hasMany(FireExtinguisherCriteria::class, 'checksheet_id', 'checksheet_id');
    }

    public function criteria_details_fh(){
        return $this->hasMany(FireHoseCriteria::class, 'checksheet_id', 'checksheet_id');
    }

    public function inspector_details(){
    	return $this->hasOne(RapidXUser::class, 'id', 'checked_by');
    }    

    public function supervisor_details(){
    	return $this->hasOne(RapidXUser::class, 'id', 'noted_by_supervisor');
    }    

    public function manager_details(){
    	return $this->hasOne(RapidXUser::class, 'id', 'noted_by_manager');
    }    
    
    public function checksheet_device_info(){
    	return $this->hasOne(Device::class, 'device_id', 'device_id');
    }  
}
