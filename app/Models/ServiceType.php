<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceType extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    /**
     * Get the user that owns the ServiceType
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vendor_type(): BelongsTo
    {
        return $this->belongsTo(Vendor_type::class, 'vendor_type_id', 'id');
    }
}
