<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUuid;
use App\Models\User;

class Remittance extends Model
{
    use HasFactory, HasUuid;

    protected $primaryKey = 'reference_no';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'amount',
        'payer_id',
        'collector_id',
        'remittance_handler_id',
        'status'
    ];

    public function getPayerUserRelation()
    {
        return $this->belongsTo(User::class, 'payer_id', 'id');
    }

    public function getCollectorUserRelation()
    {
        return $this->belongsTo(User::class, 'collector_id', 'id');
    }

    public function getRemittanceHandlerUserRelation()
    {
        return $this->belongsTo(User::class, 'remittance_handler_id', 'id');
    }
}
