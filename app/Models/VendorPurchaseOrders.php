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

    public function po_payment_received_by_vendors()
    {
        return $this->hasMany(PoPaymentReceivedByVendors::class, 'purchase_order_id')->where('status','=', 'A');
    }

    public function payment_terms(): BelongsTo
    {
        return $this->belongsTo(PaymentTermsModel::class, 'po_payment_terms');
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
}
