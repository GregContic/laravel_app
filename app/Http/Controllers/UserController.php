<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    // Show registration form
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Handle registration logic
    public function register(Request $request)
    {
        // Validate user input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create new user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Secure password
        ]);

        // Auto-login after registration
        Auth::attempt($request->only('email', 'password'));

        return redirect()->route('notes')->with('success', 'Registration successful!');
    }
    // Show login form
public function showLoginForm()
{
    return view('auth.login');
}

// Handle login logic
public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($request->only('email', 'password'))) {
        // Redirect to the notes page after successful login
        return redirect()->route('notes/index.blade.php')->with('success', 'Logged in successfully!');
    }

    return back()->with('error', 'Invalid credentials');
}

// Logout the user
public function logout(Request $request)
{
    Auth::logout();
    return redirect()->route('login')->with('success', 'Logged out successfully!');
}


}




