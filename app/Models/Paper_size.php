<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paper_size extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function vendors(): HasMany
    {
        return $this->hasMany(Vendor::class, 'paper_size_id', 'id');
    }
}
