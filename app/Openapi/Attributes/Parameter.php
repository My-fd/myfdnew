<?php
namespace App\Openapi\Attributes;

use App\Openapi\Exceptions\AttributeException;

/**
 * Базовый параметр запроса
 */
abstract class Parameter
{
    /**
     * Секции параметров где они должны быть указаны
     */
    public const IN_QUERY  = 'query';
    public const IN_PATH   = 'path';
    public const IN_HEADER = 'header';
    /**
     * Типы параметров
     */
    protected const TYPE_STRING = 'string';
    protected const TYPE_INT    = 'integer';
    protected const TYPE_BOOL   = 'boolean';

    /**
     * Имя роута к которому относится параметр
     * Данное поле является техническим и в документации эти данные не отображаются
     * Поле нужно лишь для построения правленого дерева роута
     *
     * @var string
     */
    public string $pathName;

    /**
     * Секция в которой параметр должен быть передан
     *
     * @var string
     */
    public string $in;

    /**
     * Имя параметра
     *
     * @var string
     */
    public string $name;

    /**
     * Описание параметра
     *
     * @var string|null
     */
    public string|null $description = null;

    /**
     * Пример значения параметра
     *
     * @var string|null
     */
    public string|null $example = null;

    /**
     * Значение параметра по умолчанию
     *
     * @var string|null
     */
    public string|null $default = null;

    /**
     * Является ли параметр обязательным
     *
     * @var bool
     */
    public bool $required = false;

    /**
     * Имя параметра в которой вложен текущий параметр (Имя родительского параметра)
     * Данное поле является техническим и в документации эти данные не отображаются
     * Поле нужно лишь для построения правленого дерева роута
     *
     * @var string|null
     */
    public string|null $parent = null;

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
     */
    public function __construct(
        string $pathName,
        string $in,
        string $name,
        string|null $description = null,
        string|null $example = null,
        string|null $default = null,
        bool $required = false,
        string|null $parent = null
    ) {
        $this->pathName    = $pathName;
        $this->in          = $in;
        $this->name        = $name;
        $this->description = $description;
        $this->example     = $example;
        $this->default     = $default;
        $this->required    = $required;
        $this->parent      = $parent;
    }

    /**
     * Тип поля
     *
     * @return string
     */
    abstract public function getType(): string;

    /**
     * Имеет ли параметр родителя
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
            'name'        => $this->name,
            'in'          => $this->in,
            'description' => $this->description,
            'required'    => $this->required,
            'schema'      => [
                'type' => $this->getType(),
            ],
        ];

        if ($this->example) {
            $schema['schema']['example'] = $this->example;
        }

        if ($this->default) {
            $schema['schema']['default'] = $this->default;
        }

        return $schema;
    }
}
