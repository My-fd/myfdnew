<?php
namespace App\Openapi\Attributes;

use Attribute;

/**
 * Описание кастомного валидатора
 */
#[Attribute]
class Validator
{
    /**
     * Конструктор
     *
     * @param string $description
     */
    public function __construct(public string $description)
    {
    }
}
