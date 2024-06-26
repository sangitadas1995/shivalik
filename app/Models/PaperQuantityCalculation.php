<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaperQuantityCalculation extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function unit_type(): BelongsTo
    {
        return $this->belongsTo(PaperunitMeasument::class, 'measurement_type_unit');
    }
}
