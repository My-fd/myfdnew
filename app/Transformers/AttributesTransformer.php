<?php

namespace App\Transformers;

use App\Models\Attribute;
use App\Openapi\Attributes\Additional\Component;
use App\Openapi\Attributes\PropertyArray;
use App\Openapi\Attributes\PropertyInt;
use App\Openapi\Attributes\PropertyString;

/**
 * Трансформер для атрибутов
 */
#[Component]
#[PropertyInt('id', 'ID атрибута', '1')]
#[PropertyString('name', 'Название атрибута', 'Атрибут')]
#[PropertyString('type', 'Тип атрибута', 'Radio')]
#[PropertyArray('options', 'Варианты атрибута')]
#[PropertyString('optionsElement', 'Элемент опций', 'Цветное', false, 'options')]
#[PropertyString('comment', 'Комментарий к атрибуту', 'Комментарий')]
class AttributesTransformer
{
    use BaseTransformer;

    public static function toArray(Attribute $attribute): array
    {
        return [
            'id'      => $attribute->id,
            'name'    => $attribute->name,
            'type'    => $attribute->type,
            'options' => $attribute->options,
            'comment' => $attribute->comment,
        ];
    }
}