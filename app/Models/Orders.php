<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $table = "orders";

 	public function order_details(){
        return $this->hasMany('App\Models\OrderDetails','order_id','id');
    }

    public function payment_method_name(){
        return $this->hasOne('App\Models\PaymentMethod','id','payment_type');
    }
}
