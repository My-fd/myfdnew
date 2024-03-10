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
#[PropertyObject('created_at', 'Когда создан')]
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
            'id'         => $user->id,
            'nickname'   => $user->nickname,
            'created_at' => $user->created_at?->format('Y-m-d h:i'),
        ];
    }
}
