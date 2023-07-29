<?php
namespace App\Openapi\Attributes;

use App\Openapi\Exceptions\AttributeException;
use App\Openapi\Helpers\RefHelper;
use Attribute;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
class PropertyArray extends Property
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
     * Схема описания контента массива
     *
     * @var Property|null
     */
    private Property|null $item = null;

    /**
     * Конструктор
     *
     * @param string      $name
     * @param string      $description
     * @param bool        $isNullable
     * @param string|null $parent
     * @param string|null $ref
     * @param string|null $vRef
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
        return self::TYPE_ARRAY;
    }

    /**
     * Преобразуется в массив совместимый с форматом OPENAPI
     *
     * @return array
     * @throws AttributeException
     */
    public function toArray(): array
    {
        $scheme = parent::toArray();
        unset($scheme['example']);

        if ($this->item === null && $this->ref === null) {
            throw new AttributeException(sprintf('Массив %s не имеет описание элементов', $this->name));
        }

        if ($this->item !== null && $this->ref !== null) {
            throw new AttributeException(sprintf('Массив %s имеет и описание элемента и ссылку, должно быть что то одно', $this->name));
        }

        if ($this->ref) {
            $scheme['items'] = ['$ref' => '#/components/schemas/' . $this->ref];
        } else {
            $scheme['items'] = $this->item->toArray();
        }

        return $scheme;
    }

    /**
     * Возвращает поле элемента массива
     *
     * @return Property
     */
    public function getItem(): Property
    {
        return $this->item;
    }

    /**
     * Устанавливает поле описывающее элемент массива
     *
     * @param Property $item
     * @throws AttributeException
     */
    public function setItem(Property $item): void
    {
        if ($this->item !== null) {
            throw new AttributeException(
                sprintf(
                    'Элемент массива %s уже содержит объект %s (%s)',
                    $this->name,
                    $this->item->name,
                    $this->item->getType()
                )
            );
        }

        $this->item = $item;
    }
}
