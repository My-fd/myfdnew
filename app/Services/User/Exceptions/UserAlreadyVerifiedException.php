<?php
namespace App\Services\User\Exceptions;

use Exception;

class UserAlreadyVerifiedException extends Exception
{
    protected $message = 'Пользователь уже подтвердил емейл';
}
