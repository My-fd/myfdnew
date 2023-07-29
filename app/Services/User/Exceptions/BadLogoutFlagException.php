<?php
namespace App\Services\User\Exceptions;

use Exception;

/**
 * Исключение бросаемое в случае ошибки при неверно указанном методе выхода из системы
 *
 * Class BadLogoutFlagException
 * @package App\Services\User\Exceptions
 */
class BadLogoutFlagException extends Exception
{
    protected $message = 'Неверный флаг выхода из системы';
}
