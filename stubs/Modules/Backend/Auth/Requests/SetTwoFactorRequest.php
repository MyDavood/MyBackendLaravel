<?php namespace App\Modules\Backend\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetTwoFactorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'secret' => 'required',
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
