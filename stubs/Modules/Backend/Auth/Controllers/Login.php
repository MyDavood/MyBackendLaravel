<?php namespace App\Modules\Backend\Auth\Controllers;

use Backend\Laravel\Http\Controllers\BaseController;
use Illuminate\Http\RedirectResponse;
use App\Modules\Backend\Auth\Requests\LoginRequest;
class Login extends BaseController
{
    public function __invoke(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended('/backend');
    }
}
