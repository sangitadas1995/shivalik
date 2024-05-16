<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VendorPurchaseOrders extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function po_product_details()
    {
        return $this->hasMany(VendorPurchaseOrderDetails::class, 'purchase_order_id');
    }

    public function payment_terms(): BelongsTo
    {
        return $this->belongsTo(PaymentTermsModel::class, 'po_payment_terms');
    }
}
