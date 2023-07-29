<?php
namespace App\Openapi\Exceptions;

use Exception;

/**
 * Исключение бросаемое в случае неправильного использования атрибутов
 */
class AttributeException extends Exception
{
    /**
     * Сообщение
     *
     * @var string
     */
    protected $message = 'Некорректно использован атрибут';
}
