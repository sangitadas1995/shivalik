<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VendorPurchaseOrderDetails extends Model
{
    use HasFactory;

    public function paper_type(): BelongsTo
    {
        return $this->belongsTo(PaperTypes::class, 'product_id');
    }
}
