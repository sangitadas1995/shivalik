<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vendor extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function vendortype(): BelongsTo
    {
        return $this->belongsTo(Vendor_type::class, 'vendor_type_id');
    }

    public function papertype(): BelongsTo
    {
        return $this->belongsTo(Paper_type::class, 'paper_type_id');
    }

    public function papersize(): BelongsTo
    {
        return $this->belongsTo(Paper_size::class, 'paper_size_id');
    }
}
