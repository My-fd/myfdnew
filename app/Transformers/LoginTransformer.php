<?php

declare(strict_types=1);

namespace App\Transformers;

use App\Models\User;
use App\Transformers\UserTransformer;

class LoginTransformer
{
    public static function toArray(User $user, string $token): array
    {
        $userTransformerData = UserTransformer::toArray($user);

        $userTransformerData['token'] = $token;

        return $userTransformerData;
    }
}