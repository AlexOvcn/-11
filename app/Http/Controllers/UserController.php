<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Rules\ConfirmPassword;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function registerForm()
    {
        return view('auth.register', [
            'page' => 'Регистрация'
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'pass' => 'required|min:6',
            'confirm_password' => ['required', new ConfirmPassword($request->pass)],
            'avatar' => 'max:600'   // в килобайтах
        ]); // добавление собственного правила ConfirmPassword проверяющий значение с полем password

        if ($request->avatar === null) {
            $avatar = 'assets/img/hasNotAvatar.jpg';
        } else {
            $avatar = self::saveImage($request->avatar);
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->pass),
            'avatar' => $avatar
        ]);

        $user = User::where('email', $request->email)->first();
        $role = Role::where('role', 'Пользователь')->first();
        $user->roles()->attach($role->id);

        return redirect()->route('auth.loginForm');
    }

    public function loginForm()
    {
        return view('auth.login', [
            'page' => 'Авторизация'
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('cars.index');
        }

        return back()->withErrors([
            'loginFail' => 'Проверьте правильность введенных данных'
        ])->withInput();
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('cars.index');
    }
    static function saveImage($file)
    {
        if (! $file) { return; }

        $ext = $file->extension();
        $filename = Str::random(6) . '.' . $ext;

        return $file->storeAs('images', $filename, 'uploads');
    }
}
