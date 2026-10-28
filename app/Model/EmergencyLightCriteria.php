<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Checksheet;

class EmergencyLightCriteria extends Model
{
    protected $table = 'tbl_emergency_light_criteria';
    protected $connection = 'mysql';
}
