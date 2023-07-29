<?php

namespace App\Services\Exceptions;

use Exception;

/**
 * Исключение бросаемое если книга не найдена
 *
 * class BookNotFoundException
 * @package App\Services\Exceptions
 */
class BookNotFoundException extends Exception
{
    protected $message = 'Книга не найдена';
}