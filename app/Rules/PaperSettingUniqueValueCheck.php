<?php
namespace App\Rules;

use App\Models\Paper_categories;
use App\Models\Paper_size;
use App\Models\Paper_quality;
use App\Models\Paper_color;
use Closure;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\ValidationRule;

class PaperSettingUniqueValueCheck implements ValidationRule
{
    protected $column1;
    protected $column2;
    protected $ignoreId;
    protected $message;

    public function __construct($column1, $column2, $ignoreId = null, $message = null)
    {
        $this->column1 = $column1;
        $this->column2 = $column2;
        $this->ignoreId = $ignoreId;
        $this->message = $message;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!empty($value)) {
            if($this->column2 == "paperCategory")
            {
                $query = Paper_categories::where(function ($q) use ($value) {
                    $q->where($this->column1, $value);
                });
            }
            if($this->column2 == "paperSize")
            {
                $query = Paper_size::where(function ($q) use ($value) {
                    $q->where($this->column1, $value);
                });
            }
            if($this->column2 == "paperColor")
            {
                $query = Paper_color::where(function ($q) use ($value) {
                    $q->where($this->column1, $value);
                });
            }
            if($this->column2 == "paperQuality")
            {
                $query = Paper_quality::where(function ($q) use ($value) {
                    $q->where($this->column1, $value);
                });
            }
            
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