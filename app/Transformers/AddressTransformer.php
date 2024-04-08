<?php

namespace App\Transformers;

use App\Models\Address;
use App\Openapi\Attributes\Additional\Component;
use App\Openapi\Attributes\PropertyInt;
use App\Openapi\Attributes\PropertyObject;
use App\Openapi\Attributes\PropertyString;

#[Component]
#[PropertyInt('id', 'ID адреса', '1')]
#[PropertyInt('user_id', 'ID пользователя', '1')]
#[PropertyString('country', 'Страна', 'Russia')]
#[PropertyString('city', 'Город', 'Moscow')]
#[PropertyString('street', 'Улица', 'Tverskaya')]
#[PropertyString('house_number', 'Номер дома', '1')]
#[PropertyString('floor', 'Этаж', '5', isNullable: true)]
#[PropertyInt('zip', 'Почтовый индекс', '101000', isNullable: true)]
#[PropertyString('additional_info', 'Дополнительная информация', 'Near the Kremlin', isNullable: true)]
#[PropertyObject('created_at', 'Дата создания')]
#[PropertyObject('updated_at', 'Дата обновления')]
class AddressTransformer
{
    use BaseTransformer;

    /**
     * Трансформирует адрес в массив
     *
     * @param Address $address
     * @return array
     */
    public static function toArray(Address $address): array
    {
        return [
            'id'              => $address->id,
            'user_id'         => $address->user_id,
            'country'         => $address->country,
            'city'            => $address->city,
            'street'          => $address->street,
            'house_number'    => $address->house_number,
            'floor'           => $address->floor,
            'zip'             => $address->zip,
            'additional_info' => $address->additional_info,
            'created_at'      => $address->created_at?->format('Y-m-d H:i:s'),
            'updated_at'      => $address->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
