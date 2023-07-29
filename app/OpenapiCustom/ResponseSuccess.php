<?php
namespace App\OpenapiCustom;

use App\Openapi\Attributes\PropertyObject;
use App\Openapi\Attributes\PropertyString;
use App\Openapi\Attributes\Response;
use Attribute;

/**
 * Успешный ответ
 */
#[Attribute(Attribute::TARGET_METHOD)]
class ResponseSuccess extends Response
{
    /**
     * Конструктор
     *
     * @param string      $name
     * @param int         $status
     * @param string|null $ref
     * @param string|null $vRef
     */
    public function __construct(int $status = 200, string $name = 'success', ?string $ref = null, ?string $vRef = null)
    {
        parent::__construct($name, $status, 'Успешный ответ');

        $this->addProperty(new PropertyString('status', 'Статус ответа', 'ok'));
        $this->addProperty(new PropertyObject('data', 'Тело ответа', ref: $ref, vRef: $vRef));
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
