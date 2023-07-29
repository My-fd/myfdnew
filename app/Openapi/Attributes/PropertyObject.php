<?php
namespace App\Openapi\Attributes;

use App\Openapi\Exceptions\AttributeException;
use App\Openapi\Helpers\RefHelper;
use Attribute;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
class PropertyObject extends Property
{
    /**
     * Ссылка на другой объект
     *
     * @var string|null
     */
    public string|null $ref = null;

    /**
     * Виртуальная ссылка на другой объект
     *
     * @var string|null
     */
    public string|null $vRef = null;

    /**
     * Поля объекта
     *
     * @var Property[]
     */
    protected array $properties = [];

    /**
     * Конструктор
     *
     * @param string      $name
     * @param string      $description
     * @param bool        $isNullable
     * @param string|null $parent
     * @param string|null $ref  Использование ссылки по правилам Open API спецификации ($ref)
     * @param string|null $vRef Виртуальная ссылка, подтянет объект на этапе сборки спецификации
     */
    public function __construct(
        string $name,
        string $description = '',
        bool $isNullable = false,
        string|null $parent = null,
        string|null $ref = null,
        string|null $vRef = null,
    ) {
        $this->ref  = RefHelper::normalize($ref);
        $this->vRef = RefHelper::normalize($vRef);

        parent::__construct($name, $description, null, $isNullable, $parent);
    }

    /**
     * Тип поля
     *
     * @return string
     */
    public function getType(): string
    {
        return self::TYPE_OBJECT;
    }

    /**
     * Преобразуется в массив совместимый с форматом OPENAPI
     *
     * @return array
     * @throws AttributeException
     */
    public function toArray(): array
    {
        if ($this->ref) {
            return ['$ref' => '#/components/schemas/' . $this->ref];
        }

        $scheme = parent::toArray();

        unset($scheme['example']);

        foreach ($this->properties as $property) {
            $scheme['properties'][$property->name] = $property->toArray();
        }

        return $scheme;
    }

    /**
     * Добавляет дочернее поле
     *
     * @param Property $property
     */
    public function addProperty(Property $property)
    {
        $this->properties[$property->name] = $property;
    }

    /**
     * Возвращает дочернее поле по имени
     *
     * @param string $name
     * @return Property|null
     */
    public function getProperty(string $name): Property|null
    {
        return $this->properties[$name] ?? null;
    }

    /**
     * Возвращает список дочерних полей
     *
     * @return Property[]
     */
    public function getProperties(): array
    {
        return $this->properties;
    }
}
