<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TimeTable;
use Carbon\Carbon;
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
            
            // return redirect('/dashboard')->with('success', 'Welcome Back!');
            // return redirect()->intended('/dashboard/' . auth()->user()->id)->with('success', 'Welcome Back!');

            // --------------------- TEST ------------------------------ //

            return redirect()->intended(route('dashboard', [
                'user' => auth()->user()
            ]))->with('success', 'Welcome Back!');

            // --------------------- TEST ------------------------------ //

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
