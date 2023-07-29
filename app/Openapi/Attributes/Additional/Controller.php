<?php
namespace App\Openapi\Attributes\Additional;

use Attribute;

/**
 * Атрибут указывающий на то что класс является контроллером
 * Контроллер должен содержать описание роутов/ответов/запросов
 */
#[Attribute(Attribute::TARGET_CLASS)]
class Controller
{
}
