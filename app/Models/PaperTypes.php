<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaperTypes extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function papercategory(): BelongsTo
    {
        return $this->belongsTo(Paper_categories::class, 'paper_category_id');
    }

    public function papergsm(): BelongsTo
    {
        return $this->belongsTo(Paper_weights::class, 'paper_gsm_id');
    }

    public function paperquality(): BelongsTo
    {
        return $this->belongsTo(Paper_quality::class, 'paper_quality_id');
    }

    public function papercolor(): BelongsTo
    {
        return $this->belongsTo(Paper_color::class, 'paper_color_id');
    }

    public function paperunit(): BelongsTo
    {
        return $this->belongsTo(PaperUnits::class, 'paper_unit_id');
    }

    /**
     * Get the user that owns the PaperTypes
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function papersize(): BelongsTo
    {
        return $this->belongsTo(PaperSize::class, 'paper_size_name');
    }
}
