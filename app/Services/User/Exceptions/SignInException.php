<?php

namespace App\Services\User\Exceptions;

use Exception;

/**
 * Исключение бросаемое если не удалось залогинить пользователя
 *
 * class SignInException
 * @package App\Services\User\Exceptions
 */
class SignInException extends Exception
{
    /**
     * Сообщение
     * @var string
     */
    protected $message = 'Ошибка авторизации пользователя в системе';
}