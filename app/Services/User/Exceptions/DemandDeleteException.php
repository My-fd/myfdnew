<?php
namespace App\Services\User\Exceptions;

use Exception;

/**
 * Исключение бросаемое в случае ошибки удаления запроса на регистрацию из бд
 *
 * Class DemandDeleteException
 * @package App\Services\User\Exceptions
 */
class DemandDeleteException extends Exception
{
    protected $message = 'Не удалось удалить запрос на регистрацию из базы данных';
}
