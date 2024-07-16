<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Delivery;


class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_id',
        'sender_id',
        'receiver_id',
        'type',
        'amount_received',
    ];

    public function getDeliveryRelation(){
        return $this->belongsTo(Delivery::class, 'delivery_id', 'id');
    }
}
