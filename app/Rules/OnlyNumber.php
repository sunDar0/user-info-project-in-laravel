<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class OnlyNumber implements Rule
{
    /**
     * 벨리데이션 명세
     * 오로지 숫자만 허용
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {


        return preg_match('/^\d+$/i', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'the :attribute must be number';
    }
}
