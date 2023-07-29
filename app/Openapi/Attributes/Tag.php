<?php
namespace App\Openapi\Attributes;

use Attribute;

/**
 * Тэг служит для объединения роутов в группу на странице документации
 */
#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_CLASS)]
class Tag
{
    /**
     * Конструктор
     *
     * @param string $name
     * @param string $description
     */
    public function __construct(public string $name, public string $description = '')
    {
    }
}
