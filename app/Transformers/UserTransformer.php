<?php

namespace App\Transformers;

use App\Models\User;
use App\Openapi\Attributes\Additional\Component;
use App\Openapi\Attributes\PropertyInt;
use App\Openapi\Attributes\PropertyObject;
use App\Openapi\Attributes\PropertyString;

/**
 * Трансформер пользователей
 */
#[Component]
#[PropertyInt('id', 'ID пользователя', '1')]
#[PropertyString('nickname', 'Никнейм', 'nickname_example')]
#[PropertyString('name', 'Имя', 'John')]
#[PropertyString('surname', 'Фамилия', 'Doe')]
#[PropertyString('patronymic', 'Отчество', 'Patrick', isNullable: true)]
#[PropertyString('about', 'Раздел "О себе"', 'Some information about the user', isNullable: true)]
#[PropertyString('email', 'Почта', 'john.doe@example.com')]
#[PropertyString('phone', 'Телефон', '+1234567890')]
#[PropertyString('country_code', 'Код страны', 'US', isNullable: true)]
#[PropertyString('remember_token', 'Токен авторизации', 'remember_token_example', isNullable: true)]
#[PropertyObject('email_verified_at', 'Когда подтвердил почту')]
#[PropertyObject('created_at', 'Когда создан')]
#[PropertyObject('updated_at', 'Когда обновлён')]
class UserTransformer
{
    /**
     * Трансформирует пользователя в массив
     *
     * @param User $user
     * @return array
     */
    public static function toArray(User $user): array
    {
        return [
            'id'                => $user->id,
            'nickname'          => $user->nickname,
            'name'              => $user->name,
            'surname'           => $user->surname,
            'patronymic'        => $user->patronymic,
            'about'             => $user->about,
            'email'             => $user->email,
            'phone'             => $user->phone,
            'country_code'      => $user->country_code,
            'remember_token'    => $user->remember_token,
            'email_verified_at' => $user->email_verified_at,
            'created_at'        => $user->created_at?->format('Y-m-d h:i'),
            'updated_at'        => $user->updated_at?->format('Y-m-d h:i'),
        ];
    }
}
