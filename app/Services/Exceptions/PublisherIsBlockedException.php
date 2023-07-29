<?php

namespace App\Services\Exceptions;

class PublisherIsBlockedException extends \Exception
{
    protected $message = 'Кабинет издателя заблокирован';
}