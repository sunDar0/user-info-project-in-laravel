<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PasswordVerfiy implements Rule
{

    /**
     * 비밀번호 정규표현식
     * 영문 대문자, 영문 소문자, 특수 문자, 숫자 각 1개 이상씩 포함
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match_all('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])([a-zA-Z\d@#$!%*?&])+/i', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'the :attribute must Must contain at least one uppercase letter, one lowercase letter, one special character, and one number each.';
    }
}
