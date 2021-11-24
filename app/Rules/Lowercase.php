<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Lowercase implements Rule
{

    /**
     * 벨리데이션 룰 명세
     * 소문자만 허용
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return strtolower($value) === $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'the :attribute must be lowercase';
    }
}
