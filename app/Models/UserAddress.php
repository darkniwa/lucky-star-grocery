<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'label',
        'street',
        'barangay',
        'city',
        'province',
        'postal_code',
        'latitude',
        'longitude',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function getFormattedAddress() {
        return "{$this->street}, {$this->barangay}, {$this->city}, {$this->province}, {$this->postal_code}";
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'delivery_address_id');
    }
}
