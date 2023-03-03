<?php namespace App\Modules\Backend\User\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required',
            'username' => 'required|unique:users',
            'isAdmin' => 'present|boolean',
            'permissions' => 'present'
        ];
        if ($this->isMethod("put")) {
            $rules['username'] = "required|unique:users,username," . $this->id;
            if (!empty($this->password)) {
                $rules['password'] = 'confirmed';
            }
        } else {
            $rules['password'] = 'required|confirmed';
        }
        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => "وارد کردن نام و نام خانوادگی الزامی می باشد.",
            'username.required' => "وارد کردن نام کاربری الزامی می باشد.",
            'username.unique' => "نام کاربری وارد شده موجود می باشد، لطفا نام کاربری دیگری انتخاب کنید.",
            "password.required" => "وارد کردن رمز عبور الزامی می باشد.",
            "password.confirmed" => "رمز های عبور وارد شده مطابقت ندارند.",
        ];
    }
}
