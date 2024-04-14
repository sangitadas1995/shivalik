<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaperSize extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function vendors(): HasMany
    {
        return $this->hasMany(Vendor::class, 'paper_size_id', 'id');
    }

    public function paperunit(): BelongsTo
    {
        return $this->belongsTo(PaperUnits::class, 'unit_id');
    }
}
