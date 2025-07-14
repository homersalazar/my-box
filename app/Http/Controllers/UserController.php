<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function login(Request $request)
    {
        // Validate the request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Attempt to log the user in
        if (auth()->attempt($request->only('email', 'password'))) {
            return redirect()->route('dashboard.index')->with('message', 'Login successful!');
        }

        // If login fails, redirect back with an error message
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function signup()
    {
        return view('account.signup');
    }

    public function register(Request $request)
    {
        // Validate the request data
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Create the user
        $user = \App\Models\User::create([
            'firstname' => $request->first_name,
            'lastname' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Log the user in
        auth()->login($user);

        return redirect()->route('dashboard.index')->with('message', 'Registration successful!');
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/')->with('message', 'You have been logged out successfully.');
    }
}
