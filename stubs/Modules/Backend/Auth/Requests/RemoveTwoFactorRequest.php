<?php namespace App\Modules\Backend\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RemoveTwoFactorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'password' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'password.required' => 'وارد کردن رمز یکبار مصرف الزامی می باشد.',
        ];
    }
}
