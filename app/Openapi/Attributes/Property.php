<?php
namespace App\Openapi\Attributes;

use App\Openapi\Exceptions\AttributeException;

/**
 * Объект "Поле", используется для описания полей объектов или ответов
 */
abstract class Property
{
    /**
     * Типы полей
     */
    protected const TYPE_STRING = 'string';
    protected const TYPE_OBJECT = 'object';
    protected const TYPE_ARRAY  = 'array';
    protected const TYPE_INT    = 'integer';
    protected const TYPE_BOOL   = 'bool';

    /**
     * Имя поля
     *
     * @var string
     */
    public string $name;

    /**
     * Описание поля
     *
     * @var string
     */
    public string $description = '';

    /**
     * Пример значения поля
     *
     * @var string|null
     */
    public string|null $example = null;

    /**
     * Может ли поле принимать значение = null
     *
     * @var bool
     */
    public bool $isNullable = false;

    /**
     * Имя поля в которое вложено текущее поле (Имя родительского поля)
     * Данное поле является техническим и в документации эти данные не отображаются
     * Поле нужно лишь для построения правленого дерева объекта
     *
     * @var string|null
     */
    public string|null $parent = null;

    /**
     * Конструктор
     *
     * @param string      $name
     * @param string      $description
     * @param string|null $example
     * @param bool        $isNullable
     * @param string|null $parent
     */
    public function __construct(string $name, string $description = '', string $example = null, bool $isNullable = false, string|null $parent = null)
    {
        $this->name        = $name;
        $this->description = $description;
        $this->example     = $example;
        $this->isNullable  = $isNullable;
        $this->parent      = $parent;
    }

    /**
     * Тип поля
     *
     * @return string
     */
    abstract public function getType(): string;

    /**
     * Имеет ли поле родителя
     *
     * @return bool
     */
    public function hasParent(): bool
    {
        return null !== $this->parent;
    }

    /**
     * Преобразуется в массив совместимый с форматом OPENAPI
     *
     * @return array
     * @throws AttributeException
     */
    public function toArray(): array
    {
        $schema = [
            'type'        => $this->getType(),
            'description' => $this->description,
            'nullable'    => $this->isNullable,
        ];

        if ($this->example) {
            $schema['example'] = $this->example;
        }

        return $schema;
    }
}
