<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display login page.
     *
     * @return Renderable
     */
    public function show()
    {
        return view('auth.login');
    }

    public function csrftoken()
    {
        return json_encode(['csrftoken' => csrf_token()]);
    }

    /**
     * Handle account login request
     *
     * @param LoginRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->getCredentials();
        //dd('s0');
        if (!Auth::validate($credentials)) :
            return redirect()->to('login')
                ->withErrors(trans('auth.failed'));
        endif;
        //dd('s1');
        $user = Auth::getProvider()->retrieveByCredentials($credentials);
        if ($request->wantsJson() || preg_match('/^api\//', $request->path())) {
            return [
                'isLogged' => true,
                'message' => 'wlecome',
                'username' => $user->username,
                'token' => $user->createToken('auth_token')->plainTextToken
            ];
        }
        //dd('s3');

        //dd($user);
        Auth::login($user);

        return $this->authenticated($request, $user);
    }

    /**
     * Handle response after user authenticated
     *
     * @param Request $request
     * @param Auth    $user
     *
     * @return \Illuminate\Http\Response
     */
    protected function authenticated(Request $request, $user)
    {
        //return redirect()->intended();
        return redirect()->route('home_index');
    }
}
