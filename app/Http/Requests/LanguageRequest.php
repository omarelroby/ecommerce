<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LanguageRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'=>'required|string|max:100' ,
            'abbr'=> 'required|string|max:10',
            'active'=>'required|in:0,1' ,
            'direction'=>'required|in:ltr,rtl',

        ];

    }
    public function messages()
    {
        return[
            'required'=>'هذا الحقل مطلوب' ,
            'name.string'=> 'هذا الاسم يجب ان يكون احرف',
            'name.max'=>'اسم اللغة لابد ان لايزيد عن 100 أحرف' ,
            'abr.max'=>'هذا الحقل لابد ان لا يزيد عن 10 أحرف' ,
            'in'=>'القيم المدخلة غير صحيحة',

        ];
    }
}
