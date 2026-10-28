<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Checksheet;
use App\Model\GeneralArea;

class Criteria extends Model
{
    protected $table = 'tbl_criteria';
    protected $connection = 'mysql';

    protected $fillable = [
    	'criteria_id',
    	'checklist',
    	'requirement',
    	'status',
    	'remarks',
    	'checksheet_id',
    	'general_area',
    	'control_no',
    	'location',
    	'classification',
    	'created_by',
    	'last_updated_by',
    	'created_at',
    	'updated_at'
    ];      

	public function checksheet_general_area_info(){
    	return $this->hasOne(GeneralArea::class, 'id', 'general_area');
    } 
}
