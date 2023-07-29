<?php

namespace App\Services\Exceptions;

class UserSaveException extends \Exception
{
    protected $message = 'Не удалось сохранить пользователя.';
}