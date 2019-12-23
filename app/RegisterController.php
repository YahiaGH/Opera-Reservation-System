<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'Username' => ['required', 'string', 'max:20', 'unique:users,username'],
            'Email' => ['required', 'string', 'email', 'max:191', 'unique:users,email'],
            'Password' => ['required', 'string', 'min:8', 'confirmed'],
            'FirstName' => ['required', 'string', 'regex:/^[a-zA-Z]+$/', 'max:50'],
            'LastName' => ['required', 'string', 'regex:/^[a-zA-Z]+$/', 'max:50'],
            'Gender' => ['required', 'string'],
            'City' => ['required', 'string', 'max:100'],
            'Address' => ['string', 'max:100'],
            'BirthDate' => ['required', 'date', 'before: -13 years'],

        ]);
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
            'username' => $data['Username'],
            'email' => $data['Email'],
            'password' => Hash::make($data['Password']),
            'fname' => $data['FirstName'],
            'lname' => $data['LastName'],
            'city' => $data['City'],
            'gender' => $data['Gender'][0],
            'address' => $data['Address'],
            'Bdate' => $data['BirthDate'],
            'privilage' => 'pending', // **** alawys .. admin will approve. 
        ]);
    }
    protected function redirectPath()
    {
        return '/home';
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath())->with('successRegister', 'Account Registered Successfully Wait for Activation');
    }
}
