<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function showRegisterForm(){
        return view('register');
    }

    public function store(Request $request){
        $formFields = $request->validate([
            'name' => 'required',
            'email' => ['required', Rule::unique('users', 'email')],
            'password' => 'required|confirmed|min:6'
        ]);
        $formFields['password'] = bcrypt($formFields['password']);
        $user = User::create($formFields);
        return redirect('/login');
    }

    public function logout(Request $request){
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerate();
        return redirect('/');
    }
    public function showLoginForm(){
        return view('login');
    }
    public function authenticate(Request $request){
        $formFields = $request->validate([
            'email' => ['required' , 'email'],
            'password' => 'required'
        ]);
        if (auth()->attempt($formFields)) {
            $request->session()->regenerate();
                
            $role = Auth()->user()->role;
            
            if ($role == 0) {
                return redirect('/');
            }else {
                return view('admin');
            } 
        }
        return back()->withErrors(['email'=>'invalid credentials'])->onlyInput('email');
    }


}

