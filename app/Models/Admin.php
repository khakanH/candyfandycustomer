<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    protected $table = "admin";
    
     public function user_type_name(){
        return $this->hasOne('App\Models\UserType','id','user_type');
    }
}
