<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
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
            'name' => ['required', 'max:20', 'string'],
            'amount' => ['required', 'numeric'],
            'paid' => ['required', 'boolean'],
            'category_id' => ['required', 'int'],
            'subcategory_id' => ['required', 'int'],
            'user_id' => ['required', 'int'],
            'status' => ['required', 'between:0,1'],
        ];
    }
}
