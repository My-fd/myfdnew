<?php
namespace App\Openapi\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class ResponseJson extends Response
{
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
