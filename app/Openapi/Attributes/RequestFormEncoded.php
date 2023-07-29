<?php
namespace App\Openapi\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class RequestFormEncoded extends Request
{
    /**
     * Медиа тип запроса
     *
     * @return string
     */
    public function getType(): string
    {
        return self::TYPE_FORM_ENCODED;
    }
}
