<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\SignupRequest;
use App\User;
use App\Events\RegisteredUser;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{

    use RegistersUsers;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * @param SignupRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(SignupRequest $request)
    {
        event(new RegisteredUser($user = $this->create($request->all())));
        return redirect()->route('success')->with('email', $request['email']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function success()
    {
        return view('auth.success', ['email' => session('email')]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email']
        ]);
    }
}
