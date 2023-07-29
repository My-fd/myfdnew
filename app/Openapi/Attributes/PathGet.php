<?php
namespace App\Openapi\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class PathGet extends Path
{
    /**
     * Возвращает http метод роута
     *
     * @return string
     */
    public function getHttpMethod(): string
    {
        return self::METHOD_GET;
    }
}
