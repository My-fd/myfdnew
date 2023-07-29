<?php

namespace App\Services\Exceptions;

use Exception;
use Illuminate\Support\MessageBag;

class BookInvalidException extends Exception
{
    protected $message = 'Книга не прошла валидацию';

    protected MessageBag $messageBag;

    public function __construct(MessageBag $messageBag, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($this->message, $code, $previous);

        $this->messageBag = $messageBag;
    }

    /**
     * @return MessageBag
     */
    public function getMessageBag(): MessageBag
    {
        return $this->messageBag;
    }
}