<?php
namespace App\Rules;

use App\Models\Paper_categories;
use App\Models\Paper_size;
use App\Models\Paper_quality;
use App\Models\Paper_color;
use App\Models\Paper_weights;
use App\Models\PaperTypes;
use Closure;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\ValidationRule;

class PaperTypeUniqueValueCheck implements ValidationRule
{
    protected $column1;
    protected $ignoreId;
    protected $message;

    public function __construct($column1, $ignoreId = null, $message = null)
    {
        $this->column1 = $column1;
        $this->ignoreId = $ignoreId;
        $this->message = $message;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!empty($value)) {
            $query = PaperTypes::where(function ($query) use ($value) {
                $query->where($this->column1, $value);
            });
            if (!empty($this->ignoreId)) {
                $query->where('id', '!=', $this->ignoreId);
            }
            $result = $query->first();
            if (!empty($result)) {
                $fail($this->message ?: 'The name has already been taken.');
            }
        }
    }
}