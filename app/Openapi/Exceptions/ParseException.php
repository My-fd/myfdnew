<?php
namespace App\Openapi\Exceptions;

use Exception;

/**
 * Исключение бросаемое в случае когда не удалось распарсить объект
 */
class ParseException extends Exception
{
    protected $message = 'Не удалось распарсить объект';
}
