<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoPaymentReceivedByVendors extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function payment_mode_name(): BelongsTo
    {
        return $this->belongsTo(PoPaymentModes::class, 'payment_mode_id');
    }
}
