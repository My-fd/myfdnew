<?php

namespace App\Services\Exceptions;

class ChangeStatusException extends \Exception
{
    protected $message = 'Не удалось изменить статус у книги';
}