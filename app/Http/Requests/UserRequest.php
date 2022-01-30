<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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

        $id = $this->id ? $this->id : null;
        $rules = [
            'name' => 'required',
            'email'=>'required',
            'username'=>'required',
            'office_id'=>'required|exists:offices,id'
        ];
        if(is_null($id) === true){
            $rules['password'] = 'required';
        }

        return $rules;
    }
}
