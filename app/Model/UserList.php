<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\RapidXUser;

class UserList extends Model
{
    protected $table = 'user_lists';
    protected $connection = 'mysql';

    public function rapidx_user_info(){
        return $this->hasOne(RapidXUser::class, 'id', 'rapidx_user_id');
    }            
}
