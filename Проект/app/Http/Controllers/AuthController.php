<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index () {
        return view('auth.login');
    }
    public function login (Request $request) {
        $validated = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);
        if (Auth::attempt(['login' => $validated['login'], 'password' => $validated['password']])) {
            $request->session()->regenerate();
            return redirect()
                ->intended('/')
                ->with('success','Вы успешно вошли');
        }
        return back()->withErrors([
            'login' => 'Неверный логин или пароль',
        ])->withInput();
    }
    public function logout (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')
            ->with('success','Вы успешно вышли из аккаунта');;
    }
}
