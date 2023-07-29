<?php
namespace App\Openapi\Attributes;

use App\Openapi\Exceptions\AttributeException;
use Attribute;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
class PropertyFile extends PropertyString
{
    /**
     * Конструктор
     *
     * @param string      $name
     * @param string      $description
     * @param bool        $isNullable
     * @param string|null $parent
     */
    public function __construct(string $name, string $description = '', bool $isNullable = false, string|null $parent = null)
    {
        parent::__construct($name, $description, null, $isNullable, $parent);
    }

    /**
     * Преобразуется в массив совместимый с форматом OPENAPI
     *
     * @return array
     * @throws AttributeException
     */
    public function toArray(): array
    {
        $scheme           = parent::toArray();
        $scheme['format'] = 'binary';

        unset($scheme['example']);

        return $scheme;
    }
}
