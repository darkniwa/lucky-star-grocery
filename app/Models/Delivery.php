<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;


class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'courier_id',
        'order_number',
    ];

    public function getOrderRelation(){
        return $this->belongsTo(Order::class, 'order_number', 'order_number');
    }
}
