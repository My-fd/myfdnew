<?php
namespace App\Openapi\Attributes;

use App\Openapi\Exceptions\AttributeException;
use Attribute;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
class PropertyBool extends Property
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

    /**
     * Преобразуется в массив совместимый с форматом OPENAPI
     *
     * @return array
     * @throws AttributeException
     */
    public function toArray(): array
    {
        $schema = parent::toArray();

        $schema['enum'] = [0, 1];

        return $schema;
    }
}
