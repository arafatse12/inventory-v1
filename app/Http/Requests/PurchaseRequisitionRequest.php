<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PurchaseRequisitionRequest extends FormRequest
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

    public function rules()
    {
        $id = $this->id ? $this->id : null;
        $rules = [
            'remark'=> 'required',
            'date' => 'required|date',
        ];
        if(is_null($id) === true){
            $rules['product_id'] = 'required|exists:products,id';
            $rules['quantity'] = 'required';
            $rules['amount'] = 'required';
        }

        return $rules;
    }
}
