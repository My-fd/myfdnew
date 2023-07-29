<?php

namespace App\Services\Exceptions;

class BookNotActiveException extends \Exception
{
    protected $message = 'Книга должна быть одобрена и доступна на сайте';
}