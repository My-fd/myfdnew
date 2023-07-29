<?php
namespace App\Services\User\Exceptions;

use Exception;

/**
 * Исключение бросаемое в случае неверного токена
 *
 * Class InvalidTokenException
 * @package App\Services\User\Exceptions
 */
class InvalidTokenException extends Exception
{
    protected $message = 'Токен не существует';
}
