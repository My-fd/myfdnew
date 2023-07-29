<?php

namespace App\Services\Exceptions;

class ApiAuthException extends \Exception
{
    protected $message = 'Ошибка авторизации пользователя.';
}