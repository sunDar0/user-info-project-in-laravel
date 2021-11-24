<?php


namespace App\Http\Request;


use App\Rules\Lowercase;
use App\Rules\OnlyAlphabet;
use App\Rules\OnlyNumber;
use App\Rules\PasswordVerfiy;
use Illuminate\Foundation\Http\FormRequest;
use phpDocumentor\Reflection\PseudoTypes\NumericString;


/**
 * 회원가입에 필요한 고객 정보
 * @property string name
 * @property string nickName
 * @property string password
 * @property NumericString tel
 * @property string email
 * @property string gender
 */
class RequestJoin extends FormRequest
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
            'name' => ['bail','required', 'max:20', 'alpha'],
            'nickName' => ['bail','required', 'max:30', 'alpha', new Lowercase, new OnlyAlphabet],
            'password' => ['bail','required', 'min:10' ,new PasswordVerfiy],
            'tel' => ['bail','required', "max:20", new OnlyNumber],
            'email' => ['bail','required','max:100', 'email'],
            'gender' => ['nullable', 'string'],
        ];
    }



    public function withValidator($validator)
    {
        if(!$validator->fails()){
            $this->password = bcrypt($this->password);
        }
    }


}
