<?php

namespace App\Transformers;

use App\Openapi\Attributes\Additional\Component;
use App\Openapi\Attributes\PropertyFloat;
use App\Openapi\Attributes\PropertyInt;
use App\Openapi\Attributes\PropertyObject;
use App\Openapi\Attributes\PropertyString;
use App\Models\Listing;

/**
 * Трансформер для объявлений
 */
#[Component]
#[PropertyInt('id', 'ID объявления', '1')]
#[PropertyString('title', 'Название объявления', 'Мой товар')]
#[PropertyString('description', 'Описание объявления', 'Описание товара')]
#[PropertyFloat('price', 'Цена', 100.10)]
#[PropertyObject('category', 'Категория объявления', ref: CategoryTransformer::class)]
#[PropertyObject('user', 'Автор объявления', ref: UserTransformer::class)]
#[PropertyString('created_at', 'Дата создания объявления', '2023-10-07 07:22')]
#[PropertyString('updated_at', 'Дата обновления объявления', '2023-10-07 07:22')]
class ListingTransformer
{
    use BaseTransformer;

    /**
     * Трансформирует объявление в массив
     *
     * @param Listing $listing
     * @return array
     */
    public static function toArray(Listing $listing): array
    {
        $attributes = [];

        foreach ($listing->attributes as $attribute) {
            $attributes[] = [
                'id'    => $attribute['id'],
                'name'  => $attribute['name'],
                'value' => $attribute['pivot']['value'],
            ];
        }

        return [
            'id'          => $listing->id,
            'title'       => $listing->title,
            'description' => $listing->description,
            'price'       => $listing->price,
            'user'        => UserTransformer::toArray($listing->user),
            'category'    => CategoryTransformer::toArray($listing->category),
            'attributes'  => $attributes,
            'deleted_at'  => $listing->deleted_at?->format('Y-m-d h:i'),
            'created_at'  => $listing->created_at?->format('Y-m-d h:i'),
            'updated_at'  => $listing->updated_at?->format('Y-m-d h:i'),
        ];
    }
}
