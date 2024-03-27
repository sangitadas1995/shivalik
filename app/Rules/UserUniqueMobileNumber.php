<?php
namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\ValidationRule;

class UserUniqueMobileNumber implements ValidationRule
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
            $query = User::where(function ($q) use ($value) {
                $q->where($this->column1, $value);
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
