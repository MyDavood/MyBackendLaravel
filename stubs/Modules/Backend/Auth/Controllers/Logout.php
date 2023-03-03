<?php namespace App\Modules\Backend\Auth\Controllers;

use Auth;
use Backend\Laravel\Http\Controllers\BaseController;
use Illuminate\Http\Request;
class Logout extends BaseController
{
    public function __invoke(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
    }
}
