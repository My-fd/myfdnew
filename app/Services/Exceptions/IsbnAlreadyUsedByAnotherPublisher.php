<?php

namespace App\Services\Exceptions;

class IsbnAlreadyUsedByAnotherPublisher extends \Exception
{
    protected $message = 'ISBN уже используется в книге другого издателя';
}