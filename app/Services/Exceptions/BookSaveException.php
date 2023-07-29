<?php

namespace App\Services\Exceptions;

class BookSaveException extends \Exception
{
    protected $message = 'Не удалось сохранить книгу';
}