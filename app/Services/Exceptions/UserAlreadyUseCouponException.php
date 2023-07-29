<?php

namespace App\Services\Exceptions;

class UserAlreadyUseCouponException extends \Exception
{
    protected $message = 'Пользователь уже использовал промокод ранее';
}