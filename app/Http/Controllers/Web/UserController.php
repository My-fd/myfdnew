<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\Exceptions\UserSaveException;
use App\Services\User\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * Страница аккаунта
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function account()
    {
        return view('web.user.account.account');
    }

    /**
     * Страница регистрации
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function register()
    {
        return view('web.user.register');
    }

    /**
     * Страница авторизации
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function login()
    {
        return view('web.user.login');
    }

    /**
     * Форма регистрации
     *
     * @param RegisterRequest $request
     * @param UserService     $service
     * @return RedirectResponse
     */
    public function signup(RegisterRequest $request, UserService $service): RedirectResponse
    {
        $user           = new User();
        $user->nickname = $request->get('nickname');
        $user->email    = $request->get('email');

        try {
            $service->register($user, $request->get('password'));
        } catch (UserSaveException $e) {
            return redirect()->back()->with('error', 'Ошибка сервера. Попробуйте позже.');
        }

        // Перенаправление на страницу успешной регистрации или на страницу аккаунта
        return redirect()->route('web.user.account')->with('success', 'Вы успешно зарегистрированы!');
    }

    /**
     * Форма авторизации
     *
     * @param AuthRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function auth(AuthRequest $request)
    {
        $credentials = $request->only('login', 'password');

        $fieldType = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'nickname';
        if (Auth::guard('web')->attempt([$fieldType => $credentials['login'], 'password' => $credentials['password']])) {
            return redirect()->route('web.home');
        } else {
            return redirect()->back()->withErrors(['auth' => 'Неверный логин или пароль!'])->withInput();
        }
    }

    /**
     * Выход пользователя из системы.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();

        return redirect()->route('web.home');
    }
}
