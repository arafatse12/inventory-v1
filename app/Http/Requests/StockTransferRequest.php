<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockTransferRequest extends FormRequest
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
            'posting_date_time'=>'required|date',
            'stock_date' => 'required|date',
            'office_id_to' => 'required|exists:offices,id',
            'office_id_from' => 'required|exists:offices,id',
        ];
    }
}
