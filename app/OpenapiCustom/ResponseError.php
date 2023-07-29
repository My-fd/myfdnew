<?php
namespace App\OpenapiCustom;

use App\Openapi\Attributes\PropertyObject;
use App\Openapi\Attributes\PropertyString;
use App\Openapi\Attributes\Response;
use Attribute;

/**
 * Ответ с ошибкой
 */
#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class ResponseError extends Response
{
    /**
     * Конструктор
     *
     * @param int         $status
     * @param string      $message
     * @param string      $name
     * @param string|null $ref
     * @param string|null $vRef
     */
    public function __construct(int $status = 500, string $message = 'Ошибка сервера', string $name = 'error', ?string $ref = null, ?string $vRef = null)
    {
        parent::__construct($name, $status, 'Описание ошибки');

        $this->addProperty(new PropertyString('status', 'Статус ответа', 'error'));
        $this->addProperty(new PropertyString('message', 'Текст ошибки', $message));
        $this->addProperty(new PropertyObject('data', 'Дополнительная информация', ref: $ref, vRef: $vRef));
    }

    /**
     * Медиа тип ответа
     *
     * @return string
     */
    public function getType(): string
    {
        return self::TYPE_JSON;
    }
}
