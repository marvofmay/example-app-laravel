<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    /**
     * Log out account user.
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function perform(Request $request)
    {
        Session::flush();

        if ($request->wantsJson() || preg_match('/^api\//', $request->path())) {
            Auth()->user()->tokens()->delete();

            return ['isLogged' => false, 'message' => 'Successfully logged out'];
        }

        Auth::logout();

        return redirect()->route('login.perform');
    }
}
