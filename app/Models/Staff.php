<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'picture',
        'employment_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function getDisplayNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

}
