<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vendor_type extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function vendors(): HasMany
    {
        return $this->hasMany(Vendor::class, 'vendor_type_id', 'id');
    }
}
