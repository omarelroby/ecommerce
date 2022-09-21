<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest
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
            'logo'=>'required_without:id|mimes:jpg,jpeg,png',
            'name'=>'required|string|max:150',
            'mobile'=>'required|max:100|unique:vendors,mobile,'.$this->id,
            'email'=>'sometimes|nullable|unique:vendors,email,'.$this->id,
            'category_id'=>'required|exists:main_categories,id',
            'address'=>'required|string|max:500',
            'password'=>'required_without:id|string|min:6'
        ];
    }
    public function messages()
    {
        return [
            'required'=>'هذا الحقل مطلوب',
            'max'=>'هذا الحقل طويل',
            'category_id.exists'=>'القسم غير موجود',
            'email.email'=>'صيغة البريد الالكتروني غير صحيحة',
            'address.string'=>'العنوان لابد أن يكون حروف أو حروف وأرقام',
            'logo.required_without'=>'الصورة مطلوبة',
            'email.unique'=>'هذا الميل مستخدم من قبل',
            'mobile.unique'=>'هذا الموبايل مستخدم من قبل'
        ];
    }
}
