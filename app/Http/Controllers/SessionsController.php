<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SessionsController extends Controller
{
    public function login() {
        $forminput = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (auth()->attempt($forminput)) {
            session()->regenerate();

            return redirect()->intended(route('dashboard', [
                'user' => auth()->user(),
                'date' => now()
            ]))->with('success', 'Welcome Back!');
        }

        throw ValidationException::withMessages([
            'email' => 'Provided credentials are not valid.'
        ]);

        // return back()->withErrors([
        //     'email' => 'Provided credentials are not valid.'
        // ]);
    }
    
    public function destroy() {
        auth()->logout();

        return redirect('/')->with('success', 'Goodbye');
    }
}
