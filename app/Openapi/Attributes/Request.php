<?php
namespace App\Openapi\Attributes;

use App\Openapi\Exceptions\AttributeException;

/**
 * Описание тела запроса
 */
abstract class Request
{
    /**
     * Медиа типы запросов
     */
    protected const TYPE_JSON         = 'application/json';
    protected const TYPE_FORM_ENCODED = 'application/x-www-form-urlencoded';

    /**
     * Имя запроса
     * Данное поле является техническим и в документации эти данные не отображаются
     * Поле нужно лишь для построения правленого дерева запроса
     *
     * @var string
     */
    public string $name;

    /**
     * Является ли тело запроса обязательным к заполнению
     *
     * @var bool
     */
    public bool $required = true;

    /**
     * Поля запроса
     *
     * @var Property[]
     */
    protected array $properties = [];

    /**
     * Конструктор
     *
     * @param string $name
     * @param bool   $required
     */
    public function __construct(string $name, bool $required = true)
    {
        $this->name     = $name;
        $this->required = $required;
    }

    /**
     * Медиа тип запроса
     *
     * @return string
     */
    abstract public function getType(): string;

    /**
     * Добавляет поле в запрос
     *
     * @param Property $property
     */
    public function addProperty(Property $property)
    {
        $this->properties[$property->name] = $property;
    }

    /**
     * Возвращает поле запроса по его имени
     *
     * @param string $name
     * @return Property|null
     */
    public function getProperty(string $name): Property|null
    {
        return $this->properties[$name] ?? null;
    }

    /**
     * Возвращает список полей запроса
     *
     * @return Property[]
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * Преобразуется в массив совместимый с форматом OPENAPI
     *
     * @return array
     * @throws AttributeException
     */
    public function toArray(): array
    {
        $properties = [];

        foreach ($this->properties as $property) {
            $properties[$property->name] = $property->toArray();
        }

        return [
            'required' => $this->required,
            'content'  => [
                $this->getType() => [
                    'schema' => [
                        'type'       => 'object',
                        'properties' => $properties,
                    ],
                ],
            ],
        ];
    }
}
