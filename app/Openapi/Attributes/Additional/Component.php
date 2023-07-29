<?php
namespace App\Openapi\Attributes\Additional;

use Attribute;

/**
 * Атрибут указывающий на то что класс является компонентом
 * Компонент должен содержать описание объектов на которые может ссылаться остальная часть документации
 */
#[Attribute(Attribute::TARGET_CLASS)]
class Component
{
}
