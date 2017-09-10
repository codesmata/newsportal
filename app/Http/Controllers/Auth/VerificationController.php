<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\CreatePasswordRequest;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VerificationController extends Controller
{

    /**
     * @param Request $request
     * @param $email
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function verify(Request $request, $email)
    {
        $hash = $request->query('hash');
        if ($user = User::where('email', $email)->first()) {
            if ($user->password || ($hash != $user->email_token)) {
                return redirect('/login');
            }
            return view('auth.passwords.create', ['email', $email]);
        }

        return redirect()->route('register');
    }

    /**
     * @param CreatePasswordRequest $request
     * @param $email
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function createPassword(CreatePasswordRequest $request, $email)
    {
        $user = User::where('email', $email);
        $user->password = bcrypt($request['password']);
        $user->save();
        return redirect('home');
    }
}
