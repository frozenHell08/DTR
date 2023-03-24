<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TimeTable;
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

            if (auth()->user()->is_admin) {
                return redirect()->intended(route('admindash', [
                    'timetable' => TimeTable::all()
                ]))->with('success', 'Admin!');
            }

            return redirect()->intended(route('dashboard', [
                'user' => auth()->user()
            ]))->with('success', 'Welcome Back!');
        }

        throw ValidationException::withMessages([
            'email' => 'Provided credentials are not valid.'
        ]);
    }
    
    public function destroy() {
        auth()->logout();

        return redirect('/')->with('success', 'Goodbye');
    }
}
