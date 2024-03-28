<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor_type extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function vendors(): HasMany
    {
        return $this->hasMany(Vendor::class, 'vendor_type_id', 'id');
    }
}
