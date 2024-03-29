<?php

namespace App\Rules;

use App\Models\Vendor;
use Closure;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\ValidationRule;

class VendorUniqueMobileNumber implements ValidationRule
{
    protected $column1;
    protected $column2;
    protected $column3;
    protected $column4;
    protected $ignoreId;
    protected $message;

    public function __construct($column1, $column2, $column3, $column4, $ignoreId = null, $message = null)
    {
        $this->column1 = $column1;
        $this->column2 = $column2;
        $this->column3 = $column3;
        $this->column4 = $column4;
        $this->ignoreId = $ignoreId;
        $this->message = $message;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!empty($value)) {
            $query = Vendor::where(function ($q) use ($value) {
                $q->where($this->column1, $value)
                    ->orWhere($this->column2, $value)
                    ->orWhere($this->column3, $value)
                    ->orWhere($this->column4, $value);
            });

            if (!empty($this->ignoreId)) {
                $query->where('id', '!=', $this->ignoreId);
            }

            $result = $query->first();
            if (!empty($result)) {
                $fail($this->message ?: 'The mobile number has already been taken.');
            }
        }
    }
}
