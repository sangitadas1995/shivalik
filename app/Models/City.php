<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class, 'city_id', 'id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'city_id', 'id');
    }
}
