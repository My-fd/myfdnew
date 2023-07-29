<?php
namespace App\Openapi\Attributes;

use App\Openapi\Exceptions\AttributeException;
use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class ParameterString extends Parameter
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
     * @param string      $pathName
     * @param string      $in
     * @param string      $name
     * @param string|null $description
     * @param string|null $example
     * @param string|null $default
     * @param bool        $required
     * @param string|null $parent
     * @param array|null  $enum
     */
    public function __construct(
        string $pathName,
        string $in,
        string $name,
        string|null $description = null,
        string|null $example = null,
        string|null $default = null,
        bool $required = false,
        string|null $parent = null,
        array|null $enum = null
    ) {
        $this->enum = $enum;

        parent::__construct($pathName, $in, $name, $description, $example, $default, $required, $parent);
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

        if ($this->enum) {
            $schema['schema']['enum'] = $this->enum;
        }

        return $schema;
    }
}
