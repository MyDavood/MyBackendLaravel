<?php namespace App\Modules\Backend\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required',
        ];

        if (!blank($this->current_password) || !blank($this->password)) {
            $rules['current_password'] = 'required|current_password';
            $rules['password'] = 'required|confirmed|min:6';
        }
        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'وارد کردن نام الزامی می باشد .',
            'password.required' => 'وارد کردن رمز عبور جدید الزامی می باشد .',
            'current_password.required' => 'وارد کردن رمز عبور فعلی الزامی می باشد .',
            'current_password.current_password' => 'رمز عبور فعلی نادرست می باشد .',
            'password.min' => 'رمز عبور می بایست حداقل ۶ حرفی باشد.',
            'password.confirmed' => 'رمزهای عبور وارد شده تطابق ندارند.'
        ];
    }
}
