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
        if ($this->hasUnderscores($value)){
            $fail(trans("The field $attribute must not contain underscores"));
        }

        if ($this->startsWithDashes($value)){
            $fail(trans("The field $attribute must not start with dashes"));
        }

        if ($this->endsWithDashes($value)){
            $fail(trans("The field $attribute must not end with dashes"));
        }

        if (!$this->mustContainLetterNumbersOrDashes($value)){
            $fail(trans("The field $attribute must contain letters, numbers or dashes '-'"));
        }
    }

    protected function hasUnderscores($value)
    {
        return preg_match('/_/', $value);
    }

    protected function startsWithDashes($value)
    {
        return preg_match('/^-/', $value);
    }

    protected function endsWithDashes($value)
    {
        return preg_match('/-$/', $value);
    }

    protected function mustContainLetterNumbersOrDashes($value)
    {
        return preg_match('/[a-zA-Z0-9-]+/', $value);
    }
}