<?php

namespace App\Services\Exceptions;

class PasswordRecoveryException extends \Exception
{
    protected $message = 'Ошибка при восстановление пароля';
}