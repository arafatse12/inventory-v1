<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseOrderRequest extends FormRequest
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
            'supplier_id' => 'required|exists:suppliers,id|max:5',
            'date' => 'required|date',
            'tax' => 'required|integer',
            'products' => 'required',
            'total_amount' => 'nullable|integer',
        ];
    }
}
