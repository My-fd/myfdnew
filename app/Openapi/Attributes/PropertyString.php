<?php
namespace App\Openapi\Attributes;

use App\Openapi\Exceptions\AttributeException;
use Attribute;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
class PropertyString extends Property
{
    /**
     * Варианты значения
     *
     * @var array|null
     */
    public array|null $enum = null;

    /**
     * Конструктор
     *
     * @param string      $name
     * @param string      $description
     * @param string|null $example
     * @param bool        $isNullable
     * @param string|null $parent
     * @param array|null  $enum
     */
    public function __construct(
        string $name,
        string $description = '',
        string $example = null,
        bool $isNullable = false,
        string|null $parent = null,
        array|null $enum = null
    ) {
        $this->enum = $enum;

        parent::__construct($name, $description, $example, $isNullable, $parent);
    }

    /**
     * Тип поля
     *
     * @return string
     */
    public function getType(): string
    {
        return self::TYPE_STRING;
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

        if ($this->enum && !empty($this->enum)) {
            $schema['enum'] = $this->enum;
        }

        return $schema;
    }
}
