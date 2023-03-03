<?php namespace App\Modules\Backend\Auth\Requests;

use App\Models\User;
use Crypt;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use PragmaRX\Google2FA\Google2FA;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => 'required',
            'password' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'username.required' => 'وارد کردن نام کاربری الزامی می باشد.',
            'password.required' => 'وارد کردن رمز عبور الزامی می باشد.',
        ];
    }

    public function authenticate()
    {
        $this->ensureIsNotRateLimited();
        $credentials = $this->only('username', 'password');

        if (Auth::validate($credentials)) {
            $user = User::where('username', $this->username)->firstOrFail();
            if ($user->secret != null) {
                if (empty($this->password2)) {
                    throw ValidationException::withMessages([
                        'needPassword2' => "",
                    ]);
                }
                $google2FA = new Google2FA();

                if ($google2FA->verifyKey(Crypt::decryptString($user->secret), $this->password2)) {
                    $this->login($credentials, $this->boolean('remember'));
                    return;
                }
            } else {
                $this->login($credentials, $this->boolean('remember'));
                return;
            }
        }

        throw ValidationException::withMessages([
            'username' => "نام کاربری و یا کلمه عبور وارد شده معتبر نمی باشد.",
        ]);
    }

    private function login(array $credentials, bool $remember): void
    {
        Auth::attempt($credentials, $remember);
        RateLimiter::hit($this->throttleKey());
    }

    public function ensureIsNotRateLimited()
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'username' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('username')) . '|' . $this->ip());
    }
}
