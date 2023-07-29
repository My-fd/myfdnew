<?php
namespace App\Openapi\Helpers;

/**
 * Хэлпер для работы со ссылками
 */
class RefHelper
{
    /**
     * Нормализует ссылку
     *
     * @param string|null $ref
     * @return string|null
     */
    public static function normalize(string|null $ref): string|null
    {
        if (str_contains($ref, '\\')) {
            $exploded = explode('\\', $ref);

            return array_pop($exploded);
        }

        return $ref;
    }
}
