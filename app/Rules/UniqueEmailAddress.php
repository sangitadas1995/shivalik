<?php

namespace App\Rules;

use App\Models\Customer;
use Closure;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueEmailAddress implements ValidationRule
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
            $query = Customer::where(function ($query) use ($value) {
                $query->where($this->column1, $value)
                    ->orWhere($this->column2, $value);
            });
            if (!empty($this->ignoreId)) {
                $query->where('id', '!=', $this->ignoreId);
            }
            $result = $query->first();
            if (!empty($result)) {
                $fail($this->message ?: 'The email has already been taken.');
            }
        }
    }
}
