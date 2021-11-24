<?php

namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;
use phpDocumentor\Reflection\PseudoTypes\NumericString;

/**
 * @property integer page
 * @property string name
 * @property string email
 */
class RequestGetUserList extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'page' => $this->input('page') ?? 1
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'page'=> ['required','integer'],
            'name' => ['nullable', 'string'],
            'email' => ['nullable', 'string'],
        ];
    }
}
