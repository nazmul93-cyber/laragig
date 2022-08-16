<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // show register create form
    public function create() {
        return view('users.create'); 
    }

    public function store() {
        $formFields = request()->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users','email')],
            'password' => ['required', 'confirmed', 'min:3'],
           
        ]);

        // hash password 
        $formFields['password'] = bcrypt($formFields['password']); 

        // create user
        $user = User::create($formFields);

        // login 
        auth()->login($user); 

        return redirect('/')->with('message', 'User created and Logged In');
    }

    public function logout() {
        auth()->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/')->with('message', 'You have been Logged Out');
    }

    public function login() {
        return view('users.login');
    }

    public function authenticate() {
        $formFields = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:3'],
        ]);

       if(auth()->attempt($formFields)) {
            request()->session()->regenerate();

            return redirect('/')->with('message', 'User Now Logged In');
       }

       return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');   // custom error message for email and only email input get all the error. to secure against email vulnerability
    
    }
}
