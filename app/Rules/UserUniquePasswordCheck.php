<?php
namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\ValidationRule;

class UserUniquePasswordCheck implements ValidationRule
{
    protected $column1;
    protected $column2;
    protected $message;

    public function __construct($column1, $column2, $message = null)
    {
        $this->column1 = $column1;
        $this->column2 = $column2;
        $this->message = $message;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(!empty($value)) 
        {
            if($this->column1!=$this->column2) 
            {
                $fail($this->message ?: 'Password and Confirm Password does not match.');
            }
        }
    }
}