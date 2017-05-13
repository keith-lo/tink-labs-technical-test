<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SimplyTransactionPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //@TODO User authorization'
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
            'number' => 'required|max:255',
            'amount' => 'required|numeric',
        ];
    }
}
