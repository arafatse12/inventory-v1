<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StockRequest extends FormRequest
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
        $id = !empty($this->id) ? $this->id : null;
        $rules = [

            'posting_date_time'=> 'required|date',
            'stock_date' => 'required|date',
        ];

        if(is_null($id) === true){
            $rules['product_id'] = 'required';
            $rules['purchase_price'] = 'required';
            $rules['sell_price'] = 'required';
        }

        return $rules;
    }
}
