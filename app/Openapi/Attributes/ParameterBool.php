<?php
namespace App\Openapi\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class ParameterBool extends Parameter
{
    /**
     * Тип поля
     *
     * @return string
     */
    public function getType(): string
    {
        return self::TYPE_BOOL;
    }
}
