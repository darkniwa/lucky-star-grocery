<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Wallet;
use App\Models\Remittance;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Models\Activity;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'display_name',
        'email',
        'mobile',
        'password',
        'google_id',
        'email_verified_at',
        'mobile_verified_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getOrderRelation()
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

    public function getCustomerRelation()
    {
        return $this->hasOne(Customer::class, 'user_id', 'id');
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    public function homeAddress()
    {
        return $this->hasOne(UserAddress::class)->where('label', 'Home');
    }

    public function staff()
    {
        return $this->hasOne(Staff::class);
    }

    public function activityLogs()
    {
        return $this->morphMany(Activity::class, 'causer');
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'user_id', 'id');
    }

    public function unreadNotifications()
    {
        return $this->hasMany(Notification::class, 'user_id')->whereNull('read_at');
    }

    public function getCollectedRemittance()
    {
        return $this->hasMany(Remittance::class, 'collector_id', 'id');
    }

    public function getTotalUncollectedAmountAttribute()
    {
        return Remittance::where(function ($query) {
            $query->where('collector_id', $this->id);
        })
            ->whereNull('remittance_handler_id') // Uncollected remittances from Collector
            ->sum('amount');
    }
}
