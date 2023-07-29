<?php

namespace App\Services\Exceptions;

class UserNotFoundException extends \Exception
{
    protected $message = 'Пользователь не найден';
}