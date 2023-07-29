<?php
namespace App\Openapi\Elements;

/**
 * Элемент валидации
 */
class Validation
{
    public function __construct(public string $name, public array $descriptions)
    {
    }
}
