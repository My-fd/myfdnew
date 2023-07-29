<?php

namespace App\Services\Exceptions;

class MergeModificationException extends \Exception
{
    protected $message = 'Не удалось применить изменения к оригинальной книге';
}