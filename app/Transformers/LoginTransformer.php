<?php

declare(strict_types=1);

namespace App\Transformers;

use App\Models\User;
use App\Openapi\Attributes\Additional\Component;
use App\Openapi\Attributes\PropertyObject;
use App\Openapi\Attributes\PropertyString;
use App\Transformers\UserTransformer;

class LoginTransformer
{
    public static function toArray(User $user, string $token): array
    {
        $userTransformerData = UserProfileTransformer::toArray($user);

        $userTransformerData['token'] = $token;

        return $userTransformerData;
    }
}