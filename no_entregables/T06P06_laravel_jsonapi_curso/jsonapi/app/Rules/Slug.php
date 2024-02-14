<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Slug implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (preg_match('/_/', $value)){
            $fail(__("The field $attribute must not contain underscores"));
        }

        if (preg_match('/^-/', $value)){
            $fail(__("The field $attribute must not start with dashes"));
        }

        if (preg_match('/-$/', $value)){
            $fail(__("The field $attribute mut not end with dashes"));
        }

        if (!preg_match('/[a-zA-Z0-9-]+/', $value)){
            $fail(__("The field $attribute must contain letters, numbers o dashes '-'"));
        }


    }
}