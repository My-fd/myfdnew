<?php
namespace App\Openapi\Attributes;

use App\Openapi\Exceptions\AttributeException;
use App\Openapi\Helpers\RefHelper;

/**
 * Ответ роута
 */
abstract class Response
{
    /**
     * Медиа типы ответов
     */
    protected const TYPE_JSON         = 'application/json';
    protected const TYPE_FORM_ENCODED = 'application/x-www-form-urlencoded';

    /**
     * Имя ответа
     * Данное поле является техническим и в документации эти данные не отображаются
     * Поле нужно лишь для построения правленого дерева запроса
     *
     * @var string
     */
    public string $name;

    /**
     * Http статус ответа
     *
     * @var int
     */
    public int $status;

    /**
     * Описание ответа
     *
     * @var string|null
     */
    public string|null $description = null;

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
     * Поля ответа
     *
     * @var Property[]
     */
    protected array $properties = [];

    /**
     * Конструктор
     *
     * @param string      $name
     * @param int         $status
     * @param string|null $description
     * @param string|null $ref
     * @param string|null $vRef
     */
    public function __construct(string $name, int $status, string|null $description = null, string|null $ref = null, string|null $vRef = null)
    {
        $this->name        = $name;
        $this->status      = $status;
        $this->description = $description;
        $this->ref         = RefHelper::normalize($ref);
        $this->vRef        = RefHelper::normalize($vRef);
    }

    /**
     * Медиа тип ответа
     *
     * @return string
     */
    abstract public function getType(): string;

    /**
     * Добавляет поле ответа
     *
     * @param Property $property
     */
    public function addProperty(Property $property)
    {
        $this->properties[$property->name] = $property;
    }

    /**
     * Возвращает поле ответа по его имени
     *
     * @param string $name
     * @return Property|null
     */
    public function getProperty(string $name): Property|null
    {
        return $this->properties[$name] ?? null;
    }

    /**
     * Возвращает список полей ответа
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

        if (!empty($this->properties) && $this->ref !== null) {
            throw new AttributeException(
                sprintf(
                    'Ответ %s должен содержать или поля объекта или ссылку, объявлены оба варианта',
                    $this->name,
                )
            );
        }

        if ($this->ref) {
            $schema = ['$ref' => '#/components/schemas/' . $this->ref];
        } else {
            $schema = [
                'type'       => 'object',
                'properties' => $properties,
            ];
        }

        return [
            'description' => $this->description,
            'content'     => [
                $this->getType() => [
                    'schema' => $schema,
                ],
            ],
        ];
    }
}
