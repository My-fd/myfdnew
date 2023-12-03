<?php

namespace App\Http\Controllers\Admin;

use App\Services\AuthService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AuthController extends BaseAdminController
{
    public function loginPage(): Factory|View|Application
    {
        return view('admin.login');
    }

    public function login(Request $request, AuthService $authService): RedirectResponse
    {
        if (!$request->get('password')) {
            $this->flushError('Неверный логин или пароль');

            return redirect()->back();
        }

        if ($authService->authAdm($request->get('email'), $request->get('password', ''))) {
            return redirect()->intended('/');
        }

        $this->flushError('Неверный логин или пароль');

        return redirect()->back();
    }

    public function logout(AuthService $authService): RedirectResponse
    {
        $authService->logoutAdm();

        return redirect()->route('admin.auth');
    }
}