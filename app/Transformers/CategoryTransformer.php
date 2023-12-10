<?php

namespace App\Transformers;

use App\Models\Category;
use App\Openapi\Attributes\Additional\Component;
use App\Openapi\Attributes\PropertyInt;
use App\Openapi\Attributes\PropertyString;

/**
 * Трансформер для категорий
 */
#[Component]
#[PropertyInt('id', 'ID категории', '1')]
#[PropertyString('name', 'Название категории', 'Категория')]
#[PropertyString('image_url', 'Ссылка на изображение', 'https://example.com/image.jpg')]
class CategoryTransformer
{
    use BaseTransformer;
    /**
     * Трансформирует категорию в массив
     *
     * @param Category $category
     * @return array
     */
    public static function toArray(Category $category): array
    {
        return [
            'id'        => $category->id,
            'name'      => $category->name,
            'image_url' => asset($category->image_url),
        ];
    }
}