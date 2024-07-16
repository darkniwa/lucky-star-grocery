<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Payment extends Model
{
    use HasFactory;
    
    // Status ['Completed', 'Pending', 'Refunded', 'Revoked', 'Failed']
    protected $fillable = ['order_number', 'total_cost', 'shipping_fee', 'mode_of_payment', 'status'];

    public function getOrderRelation(){
        return $this->belongsTo(Order::class, 'order_number', 'order_number');
    }

}
