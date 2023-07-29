<?php
namespace App\Openapi\Attributes;

use Attribute;

/**
 * Хосты АПИ сервиса
 */
#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_CLASS)]
class Server
{
    /**
     * Конструктор
     *
     * @param string $url
     * @param string $description
     */
    public function __construct(public string $url, public string $description)
    {
    }
}
