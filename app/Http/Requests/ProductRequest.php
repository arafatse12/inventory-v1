<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'product_category_id'=>'required',
            'item_code' => 'required',
            'name' => 'required',
            'unit' => 'required',
            'reorder_qty' => 'required|integer',
            'max_discount' => 'required|integer',
            'purchase_price' => 'required|integer',
            'sell_price' => 'required|integer',
            'supplier_id' => 'required|exists:suppliers,id',
            'brand_id' => 'required|exists:brands,id',
            'tax' => 'required|integer',

        ];
    }
}
