<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\RapidXDepartment;

class RapidXUser extends Model
{
    protected $table = "users";
    protected $connection = "mysql_rapidx";
}
