<?php

namespace App\Services;

use App\Models\Manager;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    /**
     * Авторизация в админке
     *
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function authAdm(string $email, string $password): bool
    {
        return Auth::guard('admin')->attempt([
            'email'    => $email,
            'password' => $password,
        ]);
    }

    /**
     * Выход из админки
     *
     * @return void
     */
    public function logoutAdm(): void
    {
        Auth::guard('admin')->logout();
    }
}