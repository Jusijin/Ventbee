<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    function login(){
        return view('page.login');
    }

    function signin(Request $request){
        $remember = $request->has('remember');

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // --- PERBAIKAN DI SINI ---
            // Cek Role User
            if(auth()->user()->role === 'admin'){
                return redirect()->route('admin.dashboard');
            }
            // -------------------------

            return redirect()->route('user.dashboard');
        }
        return back()->with('error', 'Login tidak sesuai')->onlyInput('email');
    }

    function register(){
        return view('page.register');
    }

    function createUser(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        //Auth::login($user);

        return redirect()->route('user.login')->with('success', 'Register berhasil, silakan login');
    }

    function forgotPassword(){
        return view('page.password');
    }

    function checkEmail(Request $request){
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        $user = User::where('email', $request->email)->first();

        return redirect()->route('user.password.reset', $user->id);
    }

    function resetPassword(User $user){
        return view('page.resetpassword', compact('user'));
    }

    function updatePassword(Request $request, User $user){
        $request->validate([
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('user.login')->with('success', 'Password berhasil diubah, silakan login');    
    }

    function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('user.login')->with('success', 'Logout berhasil');
    }
}
