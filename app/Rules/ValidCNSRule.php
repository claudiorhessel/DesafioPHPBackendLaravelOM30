<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidCNSRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (mb_strlen($value) < 15) {
            $fail('Invalid CNS');
            return;
        }

        if (preg_match("/[1-2][0-9]{10}00[0-1][0-9]/", $value) || preg_match("/[7-9][0-9]{14}/", $value)) {
            if(!$this->somaPonderadaCns($value)) {
                $fail('Invalid CNS');
            }
            return;
        }

        $fail('Invalid CNS');
    }

    private function somaPonderadaCns($value): int
    {
        $sum = 0;

        for ($i = 0; $i < mb_strlen($value); $i++) {
            $sum += $value[$i] * (15 - $i);
        }

        return $sum % 11 == 0;
    }
}
