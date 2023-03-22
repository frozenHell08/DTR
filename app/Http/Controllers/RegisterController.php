<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register() {
        $forminput = request()->validate([
            'firstName' => ['required', 'max:255'],
            'lastName' => ['required', 'max:255'],
            'mobileno' => ['required', 'min:10', 'max:10', 'unique:users,mobileno'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'min:8', 'max:255'],
        ]);

        $user = User::create($forminput);
      
        auth()->login($user);



        return redirect()->intended(route('dashboard', [
            'user' => auth()->user()
        ]))->with('success', 'Account has been created.');
    }

        // return redirect ('/')->with('success', 'Account has been created.');

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
