<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventory extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function unit_type(): BelongsTo
    {
        return $this->belongsTo(PaperunitMeasument::class, 'measurement_unit_id');
    }

    public function paper_type(): BelongsTo
    {
        return $this->belongsTo(PaperTypes::class, 'papertype_id');
    }

    public function inventory_details()
    {
        return $this->belongsTo(InventoryDetails::class, 'id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'ordered_by');
    }
}


