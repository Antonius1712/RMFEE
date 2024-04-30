<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingUserRequest extends FormRequest
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
            'nik' => 'required',
            'type_of_payment' => 'required',
            'approval_bu' => 'required',
            'approval_finance' => 'required',
            'user_id_epo' => 'required',
            'checker_id_epo' => 'required',
            'approval_id_epo' => 'required'
        ];
    }
}
