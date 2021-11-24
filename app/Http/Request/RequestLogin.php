<?php


namespace App\Http\Request;


use App\Rules\Lowercase;
use App\Rules\OnlyAlphabet;
use App\Rules\OnlyNumber;
use App\Rules\PasswordVerfiy;
use Illuminate\Foundation\Http\FormRequest;
use phpDocumentor\Reflection\PseudoTypes\NumericString;


/**
 * 로그인에 필요한 고객정보
 * @property string nickName
 * @property string password
 */
class RequestLogin extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nickName' => ['bail','required', 'max:30', 'alpha', new Lowercase, new OnlyAlphabet],
            'password' => ['bail','required', 'min:10' ,new PasswordVerfiy],
        ];
    }
}
