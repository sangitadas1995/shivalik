<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu_permissions extends Model
{
     use HasFactory;

    protected $guarded = ['id'];

    // public function submenupermission(): HasMany
    // {
    //     return $this->hasMany(Menu_permissions::class);
    // }
}